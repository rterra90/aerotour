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

      case 'novo-usuario':
        // Instancia a classe do e-mail do WooCommerce
        $wc_email = WC()->mailer()->emails['WC_Email_Customer_New_Account'];

        // Dados fictícios para o preview
        $user_id = get_current_user_id();
        $user = get_userdata($user_id);

        // Gera o heading e o conteúdo
        $email_heading = $wc_email->get_heading();

        // Captura o buffer do template original do WC (ou seu override)
        ob_start();
        wc_get_template('emails/customer-new-account.php', array(
          'user_login'    => $user->user_login,
          'user_pass'     => '********',
          'blogname'      => get_bloginfo('name'),
          'email_heading' => $email_heading,
          'sent_to_admin' => false,
          'plain_text'    => false,
          'email'         => $wc_email,
        ));
        $html = ob_get_clean();
        break;

      case 'novo-pedido':
        // 1. Instancia a classe de e-mail do WooCommerce
        $wc_emails = WC()->mailer()->get_emails();
        $email_obj = $wc_emails['WC_Email_Customer_Completed_Order'];

        // 2. Busca o último pedido real do site para usar como base no preview
        // Se não houver pedidos, você pode precisar criar um pedido de teste manual
        $customer_orders = wc_get_orders(array('limit' => 1, 'status' => 'completed'));

        if (! empty($customer_orders)) {
          $order = $customer_orders[0];
        } else {
          echo "Nenhum pedido concluído encontrado para gerar o preview.";
          break;
        }

        // 3. Define o cabeçalho (puxando das configurações do WC ou fixo)
        $email_heading = $email_obj->get_heading();
        $email_obj->object = $order; // Vincula o pedido ao objeto de e-mail

        // Captura o buffer do template original do WC (ou seu override)
        ob_start();
        wc_get_template('emails/customer-completed-order.php', array(
          'order'              => $order,
          'email_heading'      => $email_heading,
          'sent_to_admin'      => false,
          'plain_text'         => false,
          'email'              => $email_obj,
          'additional_content' => $email_obj->get_additional_content(),

        ));
        $html = ob_get_clean();
        break;
    }

    if ($html) {
      echo '<!DOCTYPE html><html><head><meta charset="utf-8"></head><body>' . $html . '</body></html>';
      exit;
    }
  }
});
