<body>
  <section id="email-body">
    <div style="font-family:Arial,sans-serif;background:#f7f7f7;padding:20px;">
      <div style="max-width:640px;margin:auto;background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e0e0e0;">
        <div style="background:#400f0f;color:#fff;padding:16px 24px;">
          <h2 style="margin:0;">🎉 Nova venda em seu PDV, <?php echo esc_html($nome_comercial); ?>!</h2>
        </div>
        <div style="padding:24px;color:#333;">
          <p>Um novo pedido de reservas no site da Aerotour foi registrado a partir do seu link de ponto de venda!</p>

          <table style="width:100%;border-collapse:collapse;margin-top:16px;">
            <tr>
              <td style="padding:8px;border-bottom:1px solid #eee;">🧾 <strong>Pedido:</strong></td>
              <td style="padding:8px;border-bottom:1px solid #eee;">#<?php echo esc_html($order_id); ?></td>
            </tr>
            <tr>
              <td style="padding:8px;border-bottom:1px solid #eee;">💰 <strong>Valor total:</strong></td>
              <td style="padding:8px;border-bottom:1px solid #eee;">R$ <?php echo number_format($valor_total, 2, ',', '.'); ?></td>
            </tr>
            <tr>
              <td style="padding:8px;border-bottom:1px solid #eee;">🏷️ <strong>Comissão (%):</strong></td>
              <td style="padding:8px;border-bottom:1px solid #eee;"><?php echo number_format($comissao_percentual, 2, ',', '.'); ?>%</td>
            </tr>
            <tr>
              <td style="padding:8px;border-bottom:1px solid #eee;">💸 <strong>Valor da comissão:</strong></td>
              <td style="padding:8px;border-bottom:1px solid #eee;">R$ <?php echo number_format($valor_comissao, 2, ',', '.'); ?></td>
            </tr>
            <tr>
              <td style="padding:8px;border-bottom:1px solid #eee;">🚍 <strong>Excursão:</strong></td>
              <td style="padding:8px;border-bottom:1px solid #eee;">
                <div style="display:flex; flex-direction:column;gap:4px">
                  <p style="margin:0">Oasis em SP (23/11) x 2</p>
                </div>
              </td>
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
  </section>
</body>