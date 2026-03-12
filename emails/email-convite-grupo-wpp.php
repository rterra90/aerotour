<style>
  .email-container {
    font-family: Arial, sans-serif;
    background: #f7f7f7;
    padding: 20px;
  }

  .email-box {
    max-width: 640px;
    margin: auto;
    background: #fff;
    border-radius: 10px;
    border: 1px solid #e0e0e0;
  }

  .header {
    background: #400f0f;
    color: #fff;
    padding: 16px 24px;
  }

  .content {
    padding: 24px;
    color: #333;
  }

  .table-data {
    width: 100%;
    border-collapse: collapse;
    margin-top: 16px;
  }

  .table-data td {
    padding: 8px;
    border-bottom: 1px solid #eee;
  }

  .footer {
    background: #f0f0f0;
    padding: 12px 24px;
    text-align: center;
    font-size: 13px;
    color: #666;
  }

  /* Estilos específicos para o convite de WhatsApp */
  .button-whatsapp:hover {
    background-color: #128c7e !important;
  }

  .email-box {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  }

  /* Garante que o texto seja legível em dispositivos móveis */
  @media only screen and (max-width: 480px) {
    .content {
      padding: 15px !important;
    }

    .button-whatsapp {
      width: 100%;
      box-sizing: border-box;
    }
  }
</style>
<div class="email-container">
  <div class="email-box">
    <div style="text-align: center; padding: 30px 0 20px;">
      <img src="https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/aerotour-logo.svg" alt="Aerotour Excursões" style="max-width: 180px;">
    </div>

    <div class="content">
      <p>Olá!</p>
      <p>Você está recebendo este e-mail porque tem uma reserva confirmada para a nossa excursão <strong><?php echo esc_html($nome_exc); ?></strong>, no dia <strong><?php echo esc_html($dia_exc); ?></strong>.</p>

      <p style="font-size: 18px; color: #400f0f; text-align: center; margin: 25px 0;">
        <strong>O grupo de WhatsApp da excursão já está disponível! 🚀</strong>
      </p>

      <p>Por lá, você acompanha informações cruciais da organização, horários de embarque em tempo real e pode interagir com os outros passageiros que vão ao mesmo evento que você.</p>

      <div style="background-color: #e8f0e8; border-radius: 8px; padding: 25px; text-align: center; margin: 30px 0; border: 1px solid #d0ddd0;">
        <h3 style="margin-top: 0; color: #2e5c2e; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Acesse o Grupo no WhatsApp</h3>

        <a href="<?php echo esc_url($link); ?>" class="button-whatsapp" style="display: inline-block; background-color: #25d366; color: #fff; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: bold; margin: 15px 0; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
          ENTRAR NO GRUPO AGORA
        </a>

        <div style="margin-top: 10px; font-size: 13px;">
          <a href="https://api.whatsapp.com/send?text=Link%20do%20Grupo:%20<?php echo urlencode($link); ?>" style="color: #666; text-decoration: underline;">Compartilhar</a>
        </div>

        <p style="font-size: 12px; color: #777; margin-top: 20px; line-height: 1.4;">
          Caso haja outros passageiros em sua reserva, compartilhe este link com eles. As solicitações de entrada serão validadas com base nos dados informados na reserva.
        </p>
      </div>

      <div style="border-top: 1px solid #eee; margin-top: 30px; padding-top: 20px; text-align: center;">
        <p style="font-weight: bold; margin-bottom: 10px;">Siga-nos nas redes sociais!</p>
        <a href="https://instagram.com/aerotourexcursoes" style="color: #400f0f; text-decoration: none; font-weight: bold;">Instagram</a>
        <span style="color: #ccc; margin: 0 10px;">|</span>
        <a href="https://facebook.com/aerotourexcursoes" style="color: #400f0f; text-decoration: none; font-weight: bold;">Facebook</a>
      </div>
    </div>

    <div class="footer">
      <strong>Aerotour Excursões</strong><br>
      <a href="https://www.aerotour.com.br" style="color: #666;">www.aerotour.com.br</a>
    </div>
  </div>
</div>