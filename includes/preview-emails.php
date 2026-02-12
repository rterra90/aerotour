<?php

add_action('init', function () {
  if (isset($_GET['email_preview'])) {
    if (!current_user_can('manage_options')) {
      wp_die('Acesso restrito.');
    }

    //Define o conteúdo
    $email_preview = sanitize_text_field($_GET['email_preview']);
    switch ($email_preview) {
      case 'venda-pdv':
        $dados_teste = [
          'nome_comercial' => 'Loja Exemplo',
          'order_id' => 1234,
          'valor_total' => 458.75,
          'comissao_percentual' => 10,
          'valor_comissao' => 45.88
        ];
        $html = montar_email_venda_parceiro($dados_teste);
        break;

      case 'convite-grupo-wpp':
        $template_email = __DIR__ . '/../emails/email-convite-grupo-wpp.php';

        $email_params = [
          'nome_exc' => 'Excursão teste e-mail',
          'dia_exc' => '15/11/2025',
          'link' => 'httsp://linkteste'
        ];

        if (file_exists($template_email)) {
          ob_start(); // Inicia o buffer para capturar a saída do arquivo
          include $template_email;
          $html = ob_get_clean(); // Retorna o conteúdo como string e limpa o buffer
        } else {
          return 'Template não encontrado.';
        }

        break;

      default:
        wp_die('Algo deu errado...');
        break;
    }

    //Renderiza o email
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Prévia do E-mail</title></head><body>';
    echo $html;
    echo '</body></html>';
    exit();
  }
});
