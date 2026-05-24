<?php

use Pelago\Emogrifier\CssInliner;

$root_url = get_stylesheet_directory_uri();

// ENDPOINTS PARA CONSUMIR A REST API
require_once get_template_directory() . '/endpoints/cupom_update.php';
require_once get_template_directory() . '/endpoints/cupom_update.php';
require_once get_template_directory() . '/endpoints/api_campanhas_get.php';
require_once get_template_directory() . '/endpoints/api_google_login.php';
require_once get_template_directory() .
  '/endpoints/participantes_roleta_put.php';
require_once get_template_directory() . '/endpoints/api_user_get.php';
require_once get_template_directory() . '/endpoints/api_leads_reserva.php';
// require_once(get_template_directory() . '/endpoints/api_contratos_post.php');

// Adiciona um tamanho focado em mobile (proporção vertical/centralizada)
add_image_size('hero_mobile', 600, 900, true); // O 'true' força o corte (crop) central

// 1. Criar o Widget de inserção de reservas em massa no Dashboard
add_action('wp_dashboard_setup', 'aer_add_csv_import_widget');

function aer_add_csv_import_widget()
{
  wp_add_dashboard_widget(
    'aer_reserva_import_box',         // ID do Widget
    'Importar Passageiros (CSV)',     // Título
    'aer_reserva_import_display'      // Função de exibição
  );
}

// 2. Interface do Widget
function aer_reserva_import_display()
{
  // Verificar se o formulário foi enviado
  if (isset($_POST['aer_import_nonce']) && wp_verify_nonce($_POST['aer_import_nonce'], 'aer_csv_upload')) {
    aer_handle_csv_upload();
  }
?>
  <form method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('aer_csv_upload', 'aer_import_nonce'); ?>
    <p>Selecione o arquivo .csv com os passageiros:</p>
    <input type="file" name="aer_csv_file" accept=".csv" required />
    <p style="font-size: 11px; color: #666;">
      Formato esperado: Nome Completo, CPF, Telefone, Embarque
    </p>
    <?php submit_button('Importar Passageiros'); ?>
  </form>
  <?php
}

// 3. Processamento do CSV e Inserção no Banco
function aer_handle_csv_upload()
{
  global $wpdb;
  $table_name = 'aer_reservas'; // Ajuste se o prefixo for diferente

  if (!empty($_FILES['aer_csv_file']['tmp_name'])) {
    $file = fopen($_FILES['aer_csv_file']['tmp_name'], 'r');
    $count = 0;

    // Ignorar o cabeçalho se o seu CSV tiver um
    // fgetcsv($file); 

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
      // $data[0] = Nome, $data[1] = CPF, $data[2] = Telefone, $data[3] = Embarque

      $wpdb->insert(
        $table_name,
        array(
          'user_id'       => 0,
          'order_user_id' => 0,
          'variation_id'  => 5572,
          'order_id'      => 0,
          'status'        => 'normal',
          'p_nome'        => sanitize_text_field($data[0]),
          'p_cpf'         => sanitize_text_field($data[1]),
          'p_telefone'    => sanitize_text_field($data[2]),
          'embarque'      => sanitize_text_field($data[3]),
          'horario'       => '00:00', // Valor padrão caso a coluna exija
          'saida'         => 0,
          'volta'         => 0,
          'data_nasc'     => null,
          'rota'          => 1
        )
      );
      $count++;
    }
    fclose($file);
    echo "<div class='updated'><p>Sucesso! $count passageiros importados.</p></div>";
  }
}

// Localize script com URLs do site para uso em JS
wp_enqueue_script('theme-links', get_template_directory_uri() . '/js/main.js', array(), '1.0', true);
wp_localize_script('theme-links', 'themeLinks', [
  'adminUrl' => admin_url(),
  'ajaxUrl' => admin_url('admin-ajax.php'),
  'siteUrl' => get_site_url(),
  'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : null,
  'stylesheetUrl' => get_stylesheet_directory_uri(),
  'gLoginClientId' => get_option('google_client_id') ?: null,
]);



// ÁREA DE INCLUDES
require_once get_template_directory() . '/includes/theme-setup.php';
require_once get_template_directory() . '/includes/header-functions.php';
require_once get_template_directory() . '/includes/woocommerce-functions.php';
require_once get_template_directory() . '/includes/utilities.php';
require_once get_template_directory() . '/includes/functions/ajax-hooks.php';
require_once get_template_directory() . '/includes/functions/usuarios-functions.php';
require_once get_template_directory() . '/includes/footer-scripts.php';


require_once get_template_directory() . '/admin-head-scripts.php';
require_once get_template_directory() . '/admin-footer-scripts.php';
require_once get_template_directory() . '/email-hooks.php';
require_once get_template_directory() . '/exc-passageiros-admin.php';
require_once get_template_directory() . '/includes/preview-emails.php';
require_once get_template_directory() . '/includes/functions/login-functions.php';
require_once get_template_directory() . '/includes/functions/refunds-functions.php';
require_once get_template_directory() . '/includes/cards-slider.php';
require_once get_template_directory() . '/includes/functions/sort-excursoes.php';
require_once get_template_directory() . '/includes/functions/coupons-functions.php';
require_once get_template_directory() . '/includes/functions/blog.php';
require_once get_template_directory() . '/includes/functions/general-customize.php';
require_once get_template_directory() . '/includes/afiliados/pdv-functions.php';
require_once get_template_directory() . '/includes/admin-pages/leads-reservas/leads-reservas-functions.php';

// require_once get_template_directory() . '/includes/functions/contrato.php';


// FUNÇÃO GLOBAL PARA RENDERIZAR E-MAILS
function aer_render_email($template_name, $args = [])
{
  // Define o caminho para a pasta de emails
  $template_path = __DIR__ . "/emails/email-{$template_name}.php";
  $css_path = __DIR__ . "/emails/emails-estilos.css";

  if (!file_exists($template_path)) {
    return 'Template não encontrado.';
  }

  // Extrai o array $args para variáveis individuais (ex: $args['nome'] vira $nome)
  extract($args);

  ob_start();
  include $template_path;
  $html = ob_get_clean();
  // return ob_get_clean();

  // Se existir um arquivo CSS, injetamos ele para o processamento


  if (file_exists($css_path)) {

    $css = file_get_contents($css_path);

    // Se você não usa Composer, uma alternativa é injetar o <style> 
    // temporariamente para o cliente, ou usar um conversor.
    // Aqui, vamos envolver o HTML com o estilo para garantir a leitura.
    $html = "<html><meta name='color-scheme' content='light dark'><meta name='supported-color-schemes' content='light dark'><head><style>{$css}</style></head><body>{$html}</body></html>";
    $html_com_estilo = CssInliner::fromHtml($html)->inlineCss($css)->render();
  }

  return $html_com_estilo;
}

// FUNÇÃO GLOBAL DE ENVIO DE E-MAILS
function aer_send_email($to, $subject, $template_name, $args = [])
{
  // Definição de body e headers
  $body = aer_render_email($template_name, $args);
  $headers = [
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
  ];

  // Disparo do e-mail
  return wp_mail($to, $subject, $body, $headers);
}

// FUNÇÃO QUE ESTILIZA OS EMAILS PADRÃO DO WOOCOMMERCE
add_filter('woocommerce_email_styles', 'custom_woocommerce_email_styles', 999, 2);
function custom_woocommerce_email_styles($css, $email)
{
  $custom_css = "
        .email-box { background-color: #ffffff !important; }
        h1 { font-family: Raleway, Arial, sans-serif; }
        a { color: #400f0f; text-decoration: underline; }
        
        
        /* Proteção Dark Mode que definimos antes */
        @media (prefers-color-scheme: dark) {
            .email-container { background-color: #1a1a1a !important; }
            .email-box { background-color: #ffffff !important; }
            .light-img { display: none !important; }
            .dark-img-wrapper { display: block !important; width: auto !important; max-height: none !important; }
        }
    ";
  return $css . $custom_css;
}




/* Adiciona campos ao formulário de registro */
function campos_registro()
{
  $campos = [
    ['Primeiro nome', 'billing_first_name'],
    ['Sobrenome', 'billing_last_name']
  ];

  foreach ($campos as $campo) { ?>
    <p class="form-row">
      <label for=<?= $campo[1] ?>><?php _e(
                                    $campo[0],
                                    'text_domain'
                                  ); ?><span class="required">*</span></label>
      <input type="text" class="input-text" name=<?= $campo[1] ?> id=<?= $campo[1] ?> value=<?php if (
                                                                                              !empty($_POST[$campo[1]])
                                                                                            ) {
                                                                                              esc_attr_e($_POST[$campo[1]]);
                                                                                            } ?>>
    </p>
  <?php }
}
function salva_campos($customer_id)
{
  $campos = [
    ['Primeiro nome', 'billing_first_name'],
    ['Sobrenome', 'billing_last_name']
  ];

  foreach ($campos as $campo) {
    if ($campo[0] === 'Primeiro nome' && isset($_POST[$campo[1]])) {
      update_user_meta(
        $customer_id,
        $campo[1],
        sanitize_text_field($_POST[$campo[1]])
      );
      wp_update_user(['ID' => $customer_id, 'first_name' => $_POST[$campo[1]]]);
      wp_update_user([
        'ID' => $customer_id,
        'display_name' => $_POST[$campo[1]]
      ]);
    } elseif ($campo[0] === 'Sobrenome' && isset($_POST[$campo[1]])) {
      update_user_meta(
        $customer_id,
        $campo[1],
        sanitize_text_field($_POST[$campo[1]])
      );
      wp_update_user(['ID' => $customer_id, 'last_name' => $_POST[$campo[1]]]);
    } elseif ($campo[0] === 'Telefone' && isset($_POST[$campo[1]])) {
      update_user_meta(
        $customer_id,
        $campo[1],
        sanitize_text_field($_POST[$campo[1]])
      );
    }
  }

  if (isset($_POST['register_method'])) {
    update_user_meta(
      $customer_id,
      'register_method',
      $_POST['register_method']
    );
    // if($_POST['register_method'] === '_google_register'){
    // wp_new_user_notification( $customer_id, null,'user');
    // }
  }

  update_user_meta($customer_id, 'billing_city', '');
  update_user_meta($customer_id, 'data_nasc', '');
  update_user_meta($customer_id, 'rg', '');
  update_user_meta($customer_id, 'rg_orgao_exp', '');
  update_user_meta($customer_id, 'cupons', '');

  if (isset($_POST['qr_event_coupon_control'])) {
    update_user_meta(
      $customer_id,
      'qr_event_coupon_control',
      $_POST['qr_event_coupon_control']
    );
  } elseif (isset($_POST['new_register_coupon_control'])) {
    update_user_meta(
      $customer_id,
      'new_register_coupon_control',
      $_POST['new_register_coupon_control']
    );
  }
}

add_action('woocommerce_register_form_start', 'campos_registro');
// add_action('woocommerce_register_form', 'avisos_registro');
add_action('woocommerce_created_customer', 'salva_campos');
/* Fim Adiciona campos ao formulário de registro */

/* Formulário de alteração de dados pessoais */
function add_fields_to_edit_account_form()
{
  $campos = [
    ['Telefone', 'billing_phone'],
    ['Data de nascimento', 'data_nasc'],
    ['Cidade', 'billing_city']
  ];
  foreach ($campos as $campo) {
    $value = isset(get_user_meta(get_current_user_id())[$campo[1]][0])
      ? esc_attr(get_user_meta(get_current_user_id())[$campo[1]][0])
      : ''; ?>
    <div>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
        <label for="<?= $campo[1] ?>"><?= $campo[0] ?></label>
        <?php if ($campo[0] == 'CPF' && $value !== '') { ?>
          <input disabled type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" id="<?= $campo[1] ?>" value="<?php echo cpf_mask($value); ?>" />
        <?php } else { ?>
          <input type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" name="<?= $campo[1] ?>" id="<?= $campo[1] ?>" value="<?php echo $value; ?>" />
        <?php } ?>

      </p>
    </div>
  <?php
  } ?>
<?php
}

function save_account_details_form($customer_id)
{
  $campos = [
    ['billing_phone'],
    ['cpf'], // Onde salvamos CPF ou RNE
    ['data_nasc'],
    ['billing_city']
  ];

  foreach ($campos as $campo) {
    $meta_key = $campo[0];

    if (isset($_POST[$meta_key])) {
      $value = sanitize_text_field($_POST[$meta_key]);

      // Se for o campo de documento, removemos pontuação e traços
      if ($meta_key === 'cpf') {
        // Remove tudo que não for letra ou número
        $value = preg_replace('/[^A-Za-z0-9]/', '', $value);
        // Garante que letras fiquem em maiúsculo (padrão RNE)
        $value = strtoupper($value);
      }

      update_user_meta($customer_id, $meta_key, $value);
    }
  }
}

add_action('woocommerce_edit_account_form', 'add_fields_to_edit_account_form');
add_action('woocommerce_save_account_details', 'save_account_details_form');


/**
 * 1. Validação dos documentos (CPF/RNE) antes de salvar
 */
add_action('woocommerce_save_account_details_errors', 'validar_documentos_aerotour', 10, 1);
function validar_documentos_aerotour($errors)
{
  if (isset($_POST['cpf']) && !empty($_POST['cpf'])) {
    $current_user_id = get_current_user_id();
    $doc = sanitize_text_field($_POST['cpf']);
    $tipo = isset($_POST['doc_type']) ? $_POST['doc_type'] : 'cpf';

    // 1. Limpa o documento para comparação (apenas alfanumérico)
    $clean_doc = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $doc));

    // 2. Validação de Formato
    if ($tipo === 'cpf') {
      // Validação de CPF (Formato e Dígitos)
      if (!validaCPF($doc)) {
        $errors->add('error', 'O <strong>CPF</strong> informado é inválido. Por favor, verifique os números.');
      }
    } else {
      // Validação de RNE (Formato: Letra + 6 ou 7 números + dígito/letra)
      // Regex: Inicia com letra, segue com números, hífen e termina com letra ou número
      if (!preg_match('/^[A-Z]\d{6,7}-[A-Z0-9]$/i', $doc)) {
        $errors->add('error', 'O <strong>RNE/RNM</strong> informado não está no formato correto (Ex: V123456-7).');
      }
    }



    // 3. Verificação de Unicidade no Banco de Dados
    $user_query = new WP_User_Query(array(
      'meta_key'     => 'cpf',
      'meta_value'   => $clean_doc,
      'exclude'      => array($current_user_id), // Ignora o próprio usuário atual
      'number'       => 1,
      'fields'       => 'ID'
    ));

    if (!empty($user_query->get_results())) {
      $errors->add('error', 'Este <strong>CPF/RNE</strong> já está cadastrado em outra conta. Caso precise de ajuda, entre em contato.');
    }
  }
}
/* Fim Formulário de alteração de dados pessoais */

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

/* Ações após adicionar item ao carrinho */
// add_action('woocommerce_add_to_cart', 'minha_acao_apos_adicionar', 10, 6);
// function minha_acao_apos_adicionar($cart_item_key, $product_id, $quantity, $variation_id, $variation, mixed $cart_item_data)
// {
//   if (! isset($cart_item_data['passageiros']) || empty($cart_item_data['passageiros'])) {
//     return;
//   }
//   $passageiros = wc_clean($cart_item_data['passageiros']);
//   $passageiros = $cart_item_data['passageiros'];
//   update_lead_reserva($passageiros, 'carrinho');
// }

/* Insere dados do passageiro como meta da order */
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


  // update_lead_reserva('convertido', $passageiros, $order_id);
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

    $email_to = 'renatobancadorock@gmail.com';
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

// Adicionar campo personalizado ao checkout
add_filter('woocommerce_checkout_fields', 'add_cpf_checkout_field');

function add_cpf_checkout_field($fields)
{
  $cpf_meta_atual = get_user_meta(get_current_user_id(), 'cpf', true);
  $fields['billing']['cpf'] = [
    'label' => 'CPF',
    'placeholder' => 'CPF',
    'required' => true,
    'class' => ['form-row-wide'],
    'priority' => 25,
    'default' => strlen($cpf_meta_atual) != 11 ? '' : cpf_mask($cpf_meta_atual),
    'maxlength' => 14
  ];
  return $fields;
}

// Adicionar validação ao campo personalizado
add_action('woocommerce_checkout_process', 'custom_checkout_field_validation');
function custom_checkout_field_validation()
{
  function validar_cpf($cpf)
  {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
      return false;
    }

    // Verifica se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
      return false;
    }

    // Calcula o primeiro dígito verificador
    for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
        $d += $cpf[$c] * ($t + 1 - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
        return false;
      }
    }
    return true;
  }

  if (empty($_POST['cpf'])) {
    wc_add_notice(
      'Por favor, informe o CPF nos dados de faturamento.',
      'error'
    );
  } else {
    $checkout_cpf = $_POST['cpf'];
    if (validar_cpf($checkout_cpf)) {
      $cpf_meta_atual = get_user_meta(get_current_user_id(), 'cpf', true);
      if ($cpf_meta_atual == '') {
        update_user_meta(
          get_current_user_id(),
          'cpf',
          str_replace('.', '', str_replace('-', '', $checkout_cpf))
        );
      }
    } else {
      wc_add_notice(
        'Por favor, verifique o CPF informado nos Detalhes de cobrança.',
        'error'
      );
    }
  }
}

add_filter('wc_add_to_cart_message', 'add_to_cart_message', 10, 2);
function add_to_cart_message($message, $product_id)
{
  $produto = wc_get_product($product_id);
  return "<div class='aer-notices-cart'><p class='aer-notices-cart-title'>Adicionado ao carrinho com sucesso: <span>" .
    $produto->name .
    '</span></p><p>Confira os detalhes de sua solicitação abaixo e continue para o pagamento para confirmar sua reserva!</p><p>Você também pode continuar comprando para reservar seu lugar em outras de nossas excursões no mesmo pedido.</p></div>';
}

add_filter('gettext', 'cant_add_more_message', 10, 3);
add_filter('ngettext', 'cant_add_more_message', 10, 3);
function cant_add_more_message($translated, $text, $domain)
{
  if (
    str_starts_with($text, 'You cannot add another') &&
    $domain === 'woocommerce'
  ) {
    // Replacement text (where "%s" is the dynamic product name)
    $translated = __(
      '<p>Você já tem uma solicitação de reserva para essa excursão em seu carrinho.</p>',
      $domain
    );
  }
  return $translated;
}

add_filter('woocommerce_get_availability', 'change_availability_text', 10, 2);
function change_availability_text($args, $product)
{
  if ($product->managing_stock() && $product->is_type('variation')) {
    $args['availability'] = $product->get_stock_quantity();
    $args['class'] = 'stock-count';
  }
  return $args;
}

/* Termos e condições */
add_action(
  'woocommerce_register_form',
  'add_terms_and_conditions_to_registration',
  20
);
function add_terms_and_conditions_to_registration()
{
?>
  <p class="form-row terms wc-terms-and-conditions">
    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
      <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked(
                                                                                                                            apply_filters(
                                                                                                                              'woocommerce_terms_is_checked_default',
                                                                                                                              isset($_POST['terms'])
                                                                                                                            ),
                                                                                                                            true
                                                                                                                          ); ?> id="terms" /> <span class="small">Concordo com os <b><a href="<?= get_privacy_policy_url() ?>" target="_blank">termos de uso</b> e com a <b>política de privacidade.</b></a></span>
    </label>
    <input type="hidden" name="terms-field" value="1" />
  </p>
<?php
}

// Validate required term and conditions check box
add_action(
  'woocommerce_register_post',
  'terms_and_conditions_validation',
  20,
  3
);
function terms_and_conditions_validation($username, $email, $validation_errors)
{
  // if(strlen($_POST['username']) !== 14 || !validaCPF($_POST['username'])) $validation_errors->add( 'cpf_error', __( 'Por favor, informe um CPF válido.', 'woocommerce' ) );
  if (!isset($_POST['terms'])) {
    $validation_errors->add(
      'terms_error',
      __(
        'É obrigatório concordar com a política de privacidade.',
        'woocommerce'
      )
    );
  }

  return $validation_errors;
}
/* Fim Termos e condições */



/* Valida adição ao carrinho */
add_filter(
  'woocommerce_add_to_cart_validation',
  'filter_add_to_cart_validation',
  10,
  5
);

function filter_add_to_cart_validation(
  $passed,
  $product_id,
  $quantity,
  $variation_id,
  $variations
) {
  // Dados do novo passageiro
  $novo_passageiros = !empty($_POST['passageiros'])
    ? json_decode(stripslashes($_POST['passageiros']))
    : [];

  foreach (WC()->cart->get_cart() as $cart_item) {
    // Se for variação, compara variation_id
    if ($variation_id > 0 && $cart_item['variation_id'] == $variation_id) {
      $passed = false;
    }

    // Se não for variação, compara product_id
    if ($variation_id == 0 && $cart_item['product_id'] == $product_id) {
      $passed = false;
    }

    if (!$passed) {
      break;
    } // interrompe o loop




  }

  return $passed;
}
/* Fim Valida adição ao carrinho */

add_filter(
  'woocommerce_checkout_must_be_logged_in_message',
  'custom_checkout_must_be_logged_in_message',
  10,
  1
);
function custom_checkout_must_be_logged_in_message()
{
?>
  <script>
    if (window.location.href === '<?= wc_get_checkout_url() ?>') {
      window.sessionStorage.setItem('aer_redirect_after_login', JSON.stringify({
        page: "checkout",
        url: "<?= wc_get_cart_url() ?>"
      }))
      window.location.href = '<?= get_permalink(
                                wc_get_page_id('myaccount')
                              ) ?>'
    }
  </script>
  <?php
}

//ANTES DE CALCULAR O TOTAL DO CARRINHO
add_action('woocommerce_before_calculate_totals', 'aer_fees');
function aer_fees($cart_items)
{
  foreach ($cart_items->get_cart() as $item) {
    $item_fee =
      isset($item['taxa']) && $item['taxa'] !== 'unset' && $item['taxa'] != 0
      ? (int) $item['taxa']
      : 0;
    $final_price = $item['data']->regular_price + $item_fee;

    // Verifica se há desconto antecipado quando foi adicionado ao carrinho (1ª verificação)
    $desconto_antecipado = $item['desconto_antecipado'];
    if ($desconto_antecipado !== false && $desconto_antecipado !== 'false') {
      $data_evento = new DateTime($desconto_antecipado); //yyyy-mm-dd
      $hoje = new DateTime(); // data e hora atuais

      // calcula a diferença de dias
      $intervalo = $hoje->diff($data_evento);
      $dias_ate_evento = (int) $intervalo->format('%r%a'); // %r mantém o sinal

      // data quando faltarão 30 dias para exibir no aviso
      $data_limite_desconto = (clone $data_evento)->modify('-30 days');

      $item['data']->update_meta_data(
        'data_limite_desconto',
        $data_limite_desconto->format('Y-m-d')
      );
      $item['data']->update_meta_data('preco_original', $final_price);

      if ($dias_ate_evento >= 29) {
        //30 dias ou mais, concede o desconto
        $final_price = $final_price * 0.95;
        $item['data']->update_meta_data('desconto_antecipado_rev', true);
      } else {
        $item['data']->update_meta_data('desconto_antecipado_rev', false);
      }
    }

    //Define o preço do item
    $item['data']->set_price($final_price);
  }
}

add_filter('wp_title', 'filter_function_name', 10, 3);

function filter_function_name($title, $sep, $seplocation)
{
  if (str_starts_with($title, 'Loja')) {
    return 'Todas as excursões | ';
  } elseif (str_contains($title, 'Categorias de produto | ')) {
    return str_replace('Categorias de produto | ', '', $title);
  }
  return $title;
}



// Função para atualizar a data limite do produto pai baseada nas variações (utilities)
function aer_atualizar_data_limite_produto($product_id)
{
  $product = wc_get_product($product_id);
  if (!$product || !$product->is_type('variable')) {
    return;
  }

  $maior_timestamp = 0;
  $variations = $product->get_available_variations();

  foreach ($variations as $variation) {
    // Extrai a data do nome da variação (ex: "Show - 25/12/2024")
    if (
      preg_match(
        '/(\d{2})\/(\d{2})\/(\d{4})/',
        $variation['attributes']['attribute_dia'] ?? '',
        $matches
      )
    ) {
      $timestamp = strtotime("{$matches[3]}-{$matches[2]}-{$matches[1]}");
      if ($timestamp > $maior_timestamp) {
        $maior_timestamp = $timestamp;
      }
    }
  }

  if ($maior_timestamp > 0) {
    // Salva no formato YYYYMMDD para busca rápida no banco
    update_post_meta(
      $product_id,
      'data_limite_excursao',
      date('Ymd', $maior_timestamp)
    );
  }
}

// Executa sempre que um produto for salvo/atualizado
add_action('woocommerce_update_product', 'aer_atualizar_data_limite_produto');



//FUNÇÕES QUE CARREGAM APENAS NO PAINEL ADMIN
if (is_admin()) {

  // CONFIGURAÇÕES DO TEMA
  require_once get_template_directory() .
    '/includes/admin-pages/theme-settings.php';

  // CUSTOMIZAÇÕES EM CREATE/EDIT PRODUCT PAGE
  require_once get_template_directory() . '/includes/functions/create-edit-product-functions.php';

  require_once get_template_directory() .
    '/includes/admin-pages/panel-widgets/check-in/check-in-widget.php'; // widget check-in
  require_once get_template_directory() .
    '/includes/admin-pages/reservas-admin.php'; //página Reservas
  require_once get_template_directory() .
    '/includes/admin-pages/embarques/embarques-admin.php'; //página Embarques
  require_once get_template_directory() .
    '/includes/admin-pages/panel-widgets/home-cards-widget.php'; // widget home cards
  require_once get_template_directory() .
    '/includes/admin-pages/panel-widgets/campanhas_cupons_widget.php'; // widget campanhas cupons
  require_once get_template_directory() .
    '/includes/admin-pages/cancelamentos-admin.php';
  require_once get_template_directory() .
    '/includes/admin-pages/exc-embarques-admin.php';

  //   require_once get_template_directory() .
  // '/includes/admin-pages/fluxo-adicionar-excursao.php'; // widget check-in

  /**
   * Renderiza o input (Helper)
   */
  // function admin_render_input_field($args)
  // {
  //   $option = get_option($args['label_for']);
  //   $type = isset($args['type']) ? $args['type'] : 'text';
  //   echo '<input type="' . esc_attr($type) . '" name="' . esc_attr($args['label_for']) . '" value="' . esc_attr($option) . '" class="regular-text">';
  // }



  //ADMIN CUSTOM SCRIPTS
  function admin_custom_scripts()
  {
    wp_enqueue_style(
      'admin-style',
      get_template_directory_uri() . '/css/admin-style.css',
      false,
      '1.0.0'
    );
    wp_enqueue_script(
      'react',
      'https://unpkg.com/react@18/umd/react.development.js'
    );
    wp_enqueue_script(
      'react-dom',
      'https://unpkg.com/react-dom@18/umd/react-dom.development.js'
    );
    wp_enqueue_script(
      'media-selector',
      get_template_directory_uri() . '/js/media-selector.js',
      ['jquery'],
      null,
      true
    );
    wp_enqueue_script(
      'fetch-admin-api',
      get_template_directory_uri() . '/js/fetch-admin-api.js',
      ['jquery'],
      null,
      true
    );
    wp_localize_script('fetch-admin-api', 'theme_links', [
      'adminUrl' => admin_url(),
      'adminAjaxUrl' => admin_url('admin-ajax.php')
    ]);
    wp_enqueue_script(
      'sortable-js',
      'https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js',
      [],
      '1.14.0',
      true
    );

    wp_enqueue_script(
      'home-galerias-widget',
      get_template_directory_uri() .
        '/js/admin-panel-widgets/home-galerias-widget/home-galerias-widget.js',
      ['jquery'],
      null,
      true
    );
  }
  add_action('admin_enqueue_scripts', 'admin_custom_scripts');

  // ADMIN MENU
  add_action('admin_menu', 'admin_menu_custom_options');
  function admin_menu_custom_options()
  {
    add_menu_page(
      'Embarques',
      'Embarques',
      'manage_options',
      'embarques',
      'embarques_admin_page',
      'dashicons-location',
      25
    );
    add_menu_page(
      'Cancelamentos',
      'Cancelamentos',
      'manage_options',
      'cancelamentos',
      'cancelamentos_admin_page',
      'dashicons-money-alt',
      25
    );
    add_menu_page(
      'Reservas',
      'Reservas',
      'manage_options',
      'reservas',
      'reservas_admin_page',
      'dashicons-money-alt',
      25
    );
  }

  // WIDGETS PAINEL ADMIN
  add_action('wp_dashboard_setup', 'aer_dashboard_widgets');
  function aer_dashboard_widgets()
  {
    wp_add_dashboard_widget(
      'manage_coupons',
      'Gerenciar cupons',
      'manage_coupons_widget'
    );
    // wp_add_dashboard_widget('aer_check_in', 'Check-in', 'aer_check_in_widget');
    wp_add_dashboard_widget('check_in', 'Novo Check-in', 'check_in_widget');
    wp_add_dashboard_widget(
      'cards_home',
      'Excursões da página inicial',
      'home_cards_widget'
    );
    wp_add_dashboard_widget(
      'campanhas_cupons_widget',
      'Campanhas de cupons',
      'campanhas_cupons_widget'
    );
  }

  // REMOVE OPÇÕES AVANÇADAS PADRÃO DO WOOCOMMERCE NÃO UTILIZADAS
  /* Adiciona tab 'Passageiros' e 'Embarques' no painel - produto */
  add_filter('woocommerce_product_data_tabs', 'adiciona_passageiros_painel');
  function adiciona_passageiros_painel($tabs)
  {
    unset($tabs['shipping']);
    unset($tabs['inventory']);

    $tabs['Passageiros'] = [
      'label' => 'Passageiros',
      'target' => 'passageiros_meta',
      'priority' => 10
    ];
    $tabs['Embarques'] = [
      'label' => 'Pontos de embarque',
      'target' => 'exc_embarques_meta',
      'priority' => 11
    ];
    return $tabs;
  }
  /* Fim Adiciona tab 'Passageiros' e 'Embarques' no painel - produto */

  add_action('admin_footer', 'carregar_js_personalizado_para_abas');
  function carregar_js_personalizado_para_abas()
  {
  ?>
    <script>
      jQuery(function($) {
        // Ao clicar na aba personalizada
        $('body').on('click', '.wc-tabs li a', function() {
          var target = $(this).attr('href');
          if (target === '#exc_embarques_meta') { // Verifique se a aba personalizada foi selecionada
            const _allVar = document.querySelectorAll('#variable_product_options .woocommerce_variations .woocommerce_variation');
            const _datas = Array.from(_allVar).map((_d) => {
              return _d.querySelector('h3 > select').value
            })
            const _wrapper = document.querySelector('#exc_embarques_meta.panel.woocommerce_options_panel');
            if (_datas.length < 1) {
              _wrapper.querySelector('.section-show').style.display = 'none';
              _wrapper.querySelector('.section-hide').style.display = 'block';
            } else {

              _wrapper.querySelector('.section-show').style.display = 'block';
              _wrapper.querySelector('.section-hide').style.display = 'none';

              _wrapper.querySelector('.section-show').dataset.dias = JSON.stringify(_datas)
            }
          }
        });
      });
    </script>
<?php
  }

  // Permitir upload de SVG
  add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  });

  // Corrigir exibição do SVG na biblioteca de mídia
  add_filter('wp_prepare_attachment_for_js', function ($response, $attachment, $meta) {
    if ($response['mime'] === 'image/svg+xml' && empty($response['sizes'])) {
      $response['sizes'] = [
        'full' => [
          'url' => $response['url'],
          'width' => 100,
          'height' => 100,
          'orientation' => 'portrait',
        ]
      ];
    }
    return $response;
  }, 10, 3);
}


?>