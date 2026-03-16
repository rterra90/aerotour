<style>
  /* Estilos específicos para o convite de WhatsApp */
  .button-whatsapp:hover {
    background-color: #128c7e !important;
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
      <div class="logo-container">
        <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/logo-padrao.png"
          alt="Aerotour Excursões"
          class="light-img"
          width="180"
          style="display: block; max-width: 180px; margin: 0 auto">

        <div class="dark-img-wrapper" style="display:none; overflow:hidden; width:0px; max-height:0px;">
          <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/logo-dark-mode.png"
            alt="Aerotour Excursões"
            class="dark-img"
            width="180"
            style="display: block; max-width: 180px; margin: 0 auto">
        </div>
      </div>

    </div>

    <div class="content">
      <p>Olá!</p>
      <p>Você está recebendo este e-mail porque tem uma reserva confirmada para a nossa excursão <strong><?php echo esc_html($nome_exc); ?></strong>, no dia <strong><?php echo esc_html($dia_exc); ?></strong>.</p>

      <p style="font-size: 18px; color: #400f0f; text-align: center; margin: 25px 0;">
        <strong>O grupo de WhatsApp da excursão já está disponível!</strong>
      </p>

      <p>Por lá, você acompanha informações importantes da organização e pode interagir com os outros passageiros que vão ao mesmo evento que você.</p>

      <div style="background-color: #e8f0e8; border-radius: 8px; padding: 25px; text-align: center; margin: 30px 0; border: 1px solid #d0ddd0;">
        <h3 style="margin-top: 0; color: #2e5c2e; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">Acesse o Grupo no WhatsApp</h3>

        <a href="<?php echo esc_url($link); ?>" class="button-whatsapp" style="display: inline-block; background-color: #25d366; color: #fff; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-weight: bold; margin: 15px 0; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
          SOLICITAR ACESSO AO GRUPO
        </a>

        <div style="margin-top: 10px; font-size: 13px;">
          <a href="https://api.whatsapp.com/send?text=Link%20do%20Grupo:%20<?php echo urlencode($link); ?>" style="color: #666; text-decoration: underline;">Compartilhar</a>
        </div>

        <p style="font-size: 12px; color: #777; margin-top: 20px; line-height: 1.4;">
          Caso haja outros passageiros em sua reserva, compartilhe este link com eles. As solicitações de entrada serão validadas com base nos dados informados na reserva.
        </p>
      </div>

      <div style="margin-top: 25px; padding: 20px; border: 1px solid #e0e0e0; border-left: 5px solid #400f0f; background-color: #fff9f9; border-radius: 4px; font-family: Arial, sans-serif;">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
          <span style="font-size: 20px; margin-right: 10px;">⚠️</span>
          <strong style="color: #400f0f; font-size: 16px; text-transform: uppercase;">Aviso Importante</strong>
        </div>
        <p style="margin: 0; color: #333; font-size: 14px; line-height: 1.6;">
          Aconselhamos o acesso ao grupo, uma vez que informes em tempo real e eventuais ajustes de rota ou horário são divulgados <strong>exclusivamente neste canal</strong>.
        </p>
        <p style="margin: 10px 0 0 0; color: #555; font-size: 13px; font-style: italic; line-height: 1.5;">
          Devido à logística operacional, não realizamos contatos individuais para estas atualizações, sendo o grupo o nosso meio oficial e único de comunicação rápida.
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