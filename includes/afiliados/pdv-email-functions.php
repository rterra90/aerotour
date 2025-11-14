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

  // Recupera dados do parceiro
  $email = get_post_meta($pdv->ID, 'pdv_email', true);
  $nome_contato = get_post_meta($pdv->ID, 'pdv_nome_contato', true);
  $nome_comercial = get_the_title($pdv->ID);
  $comissao_percentual = floatval(
    get_post_meta($pdv->ID, 'pdv_comissao', true) ?: 0
  );

  // Calcula comissão
  $valor_total = $order->get_total();
  $valor_comissao = ($valor_total * $comissao_percentual) / 100;

  // Caminho do template do email
  $template_path = locate_template('woocommerce/emails/email-pdv-venda.php');
  if (!$template_path) {
    // fallback: se o template não existir, aborta
    return;
  }

  // Buffer de saída para capturar o HTML do template
  // ob_start();
  // include $template_path;
  // $mensagem = ob_get_clean();
  $assunto = 'Nova venda em seu PDV (#' . $order_id . ') - Aerotour';
  $mensagem = montar_email_venda_parceiro([
    'nome_contato' => $nome_contato,
    'codigo_pdv' => $codigo_pdv,
    'nome_comercial' => $nome_comercial,
    'order_id' => $order_id,
    'valor_total' => $valor_total,
    'comissao_percentual' => $comissao_percentual,
    'valor_comissao' => $valor_comissao
  ]);

  // Cabeçalhos do e-mail
  $headers = [
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
  ];

  // Envia o e-mail
  if ($email) {
    // wp_mail($email, $assunto, $mensagem, $headers);
  }
}

function montar_email_venda_parceiro($dados)
{
  ob_start(); ?>
    <div style="font-family:Arial,sans-serif;background:#f7f7f7;padding:20px;">
      <div style="max-width:640px;margin:auto;background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e0e0e0;">
        <div style="background:#400f0f;color:#fff;padding:16px 24px;">
          <h2 style="margin:0;">🎉 Nova venda em seu PDV, <?php echo esc_html(
            $dados['nome_comercial']
          ); ?>!</h2>
        </div>
        <div style="padding:24px;color:#333;">
          <p>Um novo pedido de reservas no site da Aerotour foi registrado a partir do seu link de ponto de venda!</p>
          
          <table style="width:100%;border-collapse:collapse;margin-top:16px;">
            <tr><td style="padding:8px;border-bottom:1px solid #eee;">🧾 <strong>Pedido:</strong></td><td style="padding:8px;border-bottom:1px solid #eee;">#<?php echo esc_html(
              $dados['order_id']
            ); ?></td></tr>
            <tr><td style="padding:8px;border-bottom:1px solid #eee;">💰 <strong>Valor total:</strong></td><td style="padding:8px;border-bottom:1px solid #eee;">R$ <?php echo number_format(
              $dados['valor_total'],
              2,
              ',',
              '.'
            ); ?></td></tr>
            <tr><td style="padding:8px;border-bottom:1px solid #eee;">🏷️ <strong>Comissão (%):</strong></td><td style="padding:8px;border-bottom:1px solid #eee;"><?php echo number_format(
              $dados['comissao_percentual'],
              2,
              ',',
              '.'
            ); ?>%</td></tr>
            <tr><td style="padding:8px;border-bottom:1px solid #eee;">💸 <strong>Valor da comissão:</strong></td><td style="padding:8px;border-bottom:1px solid #eee;">R$ <?php echo number_format(
              $dados['valor_comissao'],
              2,
              ',',
              '.'
            ); ?></td></tr>
            <tr>
              <td style="padding:8px;border-bottom:1px solid #eee;">🚍 <strong>Excursão:</strong></td><td  style="padding:8px;border-bottom:1px solid #eee;"><div style="display:flex; flex-direction:column;gap:4px"><p style="margin:0">Oasis em SP (23/11) x 2</p></div></td>
            </tr>
          </table>

          <p style="margin-top:20px;color:#555;font-size:13px;">
          Recomendamos que guarde este e-mail até o recebimento da comissão.
        </p>

          <p style="margin-top:24px;">Continue divulgando e boas vendas! 🚀</p>
        </div>
        <div style="background:#f0f0f0;padding:12px 24px;text-align:center;font-size:13px;color:#666;">
          Este é um e-mail automático da Aerotour Excursões.
        </div>
      </div>
    </div>
    <?php return ob_get_clean();
}

//PREVIEW EMAIL

add_action('init', function () {
  if (isset($_GET['email_preview'])) {
    if (!current_user_can('manage_options')) {
      wp_die('Acesso restrito.');
    }

    $dados_teste = [
      'nome_comercial' => 'Loja Exemplo',
      'order_id' => 1234,

      'valor_total' => 458.75,
      'comissao_percentual' => 10,
      'valor_comissao' => 45.88
    ];

    // require_once plugin_dir_path(__FILE__) . 'email-venda-parceiro.php';
    $html = montar_email_venda_parceiro($dados_teste);

    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Prévia do E-mail</title></head><body>';
    echo $html;
    echo '</body></html>';
    exit();
  }
});
?>
