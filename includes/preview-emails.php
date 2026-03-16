<?php

add_action('init', function () {
  if (isset($_GET['email_preview']) && current_user_can('manage_options')) {
    $email_slug = sanitize_text_field($_GET['email_preview']);
    $html = '';

    switch ($email_slug) {
      case 'venda-pdv':
        $html = aer_render_email('email-venda-parceiro', [
          'nome_comercial' => 'Loja Exemplo 2',
          'order_id'       => 1234,
          'valor_total'    => 458.75,
          'valor_comissao' => 45.88,
          'comissao_percentual' => 10
        ]);
        break;

      case 'convite-grupo-wpp':
        $html = aer_render_email('convite-grupo-wpp', [
          'nome_exc' => 'Rock in River 2026',
          'dia_exc'  => '15/11/2025',
          'link'     => 'https://linkteste'
        ]);
        break;
    }

    if ($html) {
      echo '<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>' . $html . '</body></html>';
      exit;
    }
  }
});
