<?php

//Enviar e-mail ao PDV após venda
add_action('woocommerce_thankyou', 'enviar_email_venda_parceiro', 20, 1);
function enviar_email_venda_parceiro($order_id)
{
  if (!$order_id) {
    return;
  }

  $order = wc_get_order($order_id);
  if (!$order) {
    return;
  }

  // Recupera o código do parceiro (meta armazenado nos pedidos)
  $codigo_pdv = get_post_meta($order_id, '_parceiro_ref', true);
  if (!$codigo_pdv) {
    return;
  }

  // Busca o post do parceiro
  $pdv = obter_post_pdv_por_codigo($codigo_pdv);
  if (!$pdv) {
    return;
  }

  // Recupera dados do parceiro e calcula comissão
  $email_pdv = get_post_meta($pdv->ID, 'pdv_email', true);
  $nome_contato = get_post_meta($pdv->ID, 'pdv_nome_contato', true);
  $nome_comercial = get_the_title($pdv->ID);
  $comissao_percentual = floatval(
    get_post_meta($pdv->ID, 'pdv_comissao', true) ?: 0
  );
  $valor_total = $order->get_total();
  $valor_comissao = ($valor_total * $comissao_percentual) / 100;

  // Define os argumentos
  $args = [
    'nome_contato' => $nome_contato,
    'codigo_pdv' => $codigo_pdv,
    'nome_comercial' => $nome_comercial,
    'order_id' => $order_id,
    'valor_total' => $valor_total,
    'comissao_percentual' => $comissao_percentual,
    'valor_comissao' => $valor_comissao
  ];

  //Define o Assunto do e-mail
  $assunto = 'Nova venda em seu PDV (#' . $order_id . ') - Aerotour';

  // Envia o e-mail
  if ($email_pdv) {
    aer_send_email($email_pdv, $assunto, 'email-venda-parceiro', $args);
  }

  // $mensagem = montar_email_venda_parceiro($args);

  // Cabeçalhos do e-mail
  // $headers = [
  //   'Content-Type: text/html; charset=UTF-8',
  //   'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
  // ];

  // 
  // if ($email) {
  //   wp_mail($email_pdv, $assunto, $mensagem, $headers);
  // }
}
