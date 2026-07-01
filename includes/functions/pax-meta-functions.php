<?php
/* Insere os dados do passageiro como meta do item do carrinho */
add_filter(
  'woocommerce_add_cart_item_data',
  'insere_dados_passageiro_pedido',
  9,
  6
);
function insere_dados_passageiro_pedido(
  $cart_item_data,
  $product_id,
  $variation_id,
  $quantity
) {
  $cart_item_data['embarque'] = $_POST['embarque'];
  $cart_item_data['horario'] = $_POST['horario'];
  $cart_item_data['passageiros'] = $_POST['passageiros'];
  $cart_item_data['taxa'] = $_POST['taxa'];

  return $cart_item_data;
}
/* Fim Insere os dados do passageiro como meta do item do carrinho */

/* Insere dados do passageiro como meta da order global e por line item */
// GLOBAL
add_action(
  'woocommerce_checkout_update_order_meta',
  'insere_passageiro_order_pendente',
  10,
  3
);
function insere_passageiro_order_pendente($order_id, $data)
{
  global $wpdb;
  $leads_table_name = $wpdb->prefix . 'reserva_leads';
  $order_meta = [];

  //ajustar pdv
  // if(!empty($_POST['pdv'])) update_post_meta($order_id, 'pdv', $_POST['pdv']);
  // if(!empty($_POST['pdv'])) $passageiro_a['pdv'] = $_POST['pdv'];
  //   $passageiro = json_encode($passageiro_a, JSON_UNESCAPED_UNICODE);

  foreach (WC()->cart->get_cart() as $cart_item) {
    $passageiros = json_decode(
      str_replace('\"', '"', $cart_item['passageiros'])
    );
    $order_item_meta = [
      'passageiros' => $passageiros,
      'embarque' => $cart_item['embarque'],
      'horario' => $cart_item['horario'],
      'variation_id' => $cart_item['variation_id'],
      'order_id' => $order_id
    ];
    array_push($order_meta, $order_item_meta);
  }
  update_post_meta($order_id, 'passageiros_items', $order_meta);

  $order_meta = json_encode($order_meta, JSON_UNESCAPED_UNICODE);
  update_post_meta($order_id, 'passageiros_items_str', $order_meta);
}

// LINE ITEM
add_action( 'woocommerce_checkout_create_order_line_item', 'salvar_passageiros_no_item', 10, 4 );
function salvar_passageiros_no_item( $item, $cart_item_key, $values, $order ) {
    if ( isset( $values['passageiros'] ) ) {
        $item->add_meta_data( 
            'Passageiros',
            $values['passageiros'], 
            true 
        );
    }
    if ( isset( $values['embarque'] ) ) {
        $item->add_meta_data( 
            'Embarque',
            $values['embarque'], 
            true 
        );
    }
    if ( isset( $values['horario'] ) ) {
        $item->add_meta_data( 
            'Horário',
            $values['horario'], 
            true 
        );
    }
}
/* Fim Insere dados do passageiro como meta da order */

/* Insere passageiro na lista após o pagamento */
add_action('woocommerce_order_status_processing', 'pagamento_processing');
function pagamento_processing($order_id)
{
  $order = wc_get_order($order_id);
  if ($order->get_status() === 'processing') {
    $order->update_status('completed');
  }
}
add_action('woocommerce_order_status_completed', 'pagamento_completed_otimizado');

function pagamento_completed_otimizado($order_id)
{
  global $wpdb;
  $order = wc_get_order($order_id);
  $order_user_id = $order->get_customer_id(); // ID de quem comprou
  $passageiros_items = get_post_meta($order_id, 'passageiros_items', true);

  if (empty($passageiros_items)) return;

  // Atualiza os leads para convertidos
  foreach ($passageiros_items as $order_item) {
    $passageiros = $order_item['passageiros'];
    update_lead_reserva($passageiros, 'convertido', $order_id);
  };

  $p_index = 0;
  foreach ($order->get_items() as $order_item) {
    $item_data = $passageiros_items[$p_index] ?? null;
    if (!$item_data) continue;

    $passageiros  = $item_data['passageiros'] ?? [];
    $embarque_id  = $item_data['embarque'] ?? 0;
    $horario      = $item_data['horario'] ?? '';
    $variation_id = $item_data['variation_id'] ?? 0;
    $p_index++;

    // Obtém o nome do embarque uma única vez por item do pedido 
    $nome_embarque = $wpdb->get_var($wpdb->prepare(
      "SELECT nome FROM aer_embarques WHERE id = %d",
      $embarque_id
    ));

    foreach ($passageiros as $passageiro) {
      // Sanitização do CPF do passageiro 
      $cpf_limpo = preg_replace('/\D/', '', $passageiro->cpf);
      $reserva_user_id = null; // Padrão: nulo se não encontrar conta

      // Lógica Unificada: Busca se o passageiro já tem conta no site
      if (!empty($cpf_limpo)) {
        // 1. Tenta pelo username (logins antigos com CPF) 
        $user_by_login = get_user_by('login', $cpf_limpo);

        if ($user_by_login) {
          $reserva_user_id = $user_by_login->ID;
        } else {
          // 2. Tenta pelo Meta CPF (logins novos)
          $user_query = new WP_User_Query([
            'meta_key'    => 'cpf',
            'meta_value'  => $cpf_limpo,
            'number'      => 1,
            'fields'      => 'ID',
          ]);
          $results = $user_query->get_results();
          if (!empty($results)) {
            $reserva_user_id = $results[0];
          }
        }
      }

      // Mapeamento de Rota
      $mapaRota = ['ida-e-volta' => 1, 'ida' => 2, 'volta' => 3];
      $rota = $mapaRota[$passageiro->tripType] ?? null;

      // Inserção Segura no Banco 
      $wpdb->insert(
        "aer_reservas",
        array(
          'user_id'       => $reserva_user_id, // ID do passageiro ou NULL
          'order_user_id' => $order_user_id,   // ID do comprador
          'variation_id'  => $variation_id,
          'order_id'      => $order_id,
          'status'        => 'normal',
          'p_nome'        => sanitize_text_field($passageiro->nome_completo),
          'p_cpf'         => $cpf_limpo,
          'p_telefone'    => sanitize_text_field($passageiro->celular),
          'embarque'      => $nome_embarque,
          'horario'       => $horario,
          'data_nasc'     => $passageiro->data_nascimento,
          'rota'          => $rota
        ),
        array('%d', '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d')
      );
    }
  }
}

add_action('woocommerce_order_status_completed', 'pagamento_completo');
function pagamento_completo($order_id)
{
  $order = wc_get_order($order_id);
  $order_items = $order->get_items(
    apply_filters('woocommerce_purchase_order_item_types', 'line_item')
  );

  $passageiro_string = $order->get_meta('passageiro');
  $passageiro = json_decode($passageiro_string, true);

  //Envia email para pdv que fez a venda
  if (isset($passageiro['pdv'])) {
    $exc_vendidas = [];
    foreach ($order_items as $item) {
      $product = $item->get_product();
      $nome_excursao = $product->get_title();
      array_push($exc_vendidas, $nome_excursao);
    }

    function email_excursoes($excs)
    {
      if (sizeof($excs) === 1) {
        return $excs[0];
      } else {
        return implode(', ', $excs);
      }
    }

    $email_to = 'dev@aerotour.com.br';
    $email_subject = 'Nova reserva Aerotour em seu ponto de venda!';
    $email_message =
      "<html>
      <head>
        <title>Nova reserva Aerotour em seu ponto de venda!</title>
      </head>
      <body>
        <p>Uma nova reserva nas excursões da Aerotour foi registrada junto ao seu ponto de venda. Confira os detalhes abaixo:</p>
        <div>
          <p>Ponto de venda: " .
      str_replace('_', ' ', strtoupper($passageiro['pdv'])) .
      "</p>
          <p>Pedido: " .
      $order_id .
      "</p>
          <p>Excursão: " .
      email_excursoes($exc_vendidas) .
      "</p>
          <p>Cliente: " .
      $passageiro['nome_completo'] .
      "</p>
        </div>
        <br/>
        <p>Guarde este e-mail para futuras conferências.</p>
      </body>
    </html>";
    $email_headers =
      'From: Aerotour Excursões <contato@aerotour.com.br>' . "\r\n";
    $email_headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
    $email_headers .= 'MIME-Version: 1.0' . "\r\n";
    mail($email_to, $email_subject, $email_message, $email_headers);
  }

  $_i = 0;
  foreach ($order->get_items() as $item) {
    $passageiros =
      get_post_meta($item->get_variation_id(), 'passageiros', true) !== ''
      ? json_decode(
        get_post_meta($item->get_variation_id(), 'passageiros')[0],
        true
      )
      : [];

    /* formata o valor de 'embarque' - pode ser array ou string */
    if (gettype($passageiro['embarque']) !== 'string') {
      $passageiro_a = $passageiro;
      $passageiro_a['embarque'] = $passageiro['embarque'][$_i];
      array_push($passageiros, $passageiro_a);
    } else {
      array_push($passageiros, $passageiro);
    }

    $_i++;
    $passageiros_array = json_encode($passageiros, JSON_UNESCAPED_UNICODE);
    update_post_meta(
      $item->get_variation_id(),
      'passageiros',
      $passageiros_array
    );
  }
}
/* Fim Insere passageiro na lista após o pagamento */