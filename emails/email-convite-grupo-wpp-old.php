<body>
  <section id="email-body" style="font-family: Arial, Helvetica, sans-serif;color: #2f3831;font-size: 15px;line-height: 1.55;max-width: 600px;margin: 0 auto;padding: 20px 24px;background: #f6f6f6;border-radius: 14px;">
    <img class="main-logo" style="width: 160px;display: block;margin: 0 auto 24px;" src="https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/aerotour-logo.svg" alt="Aerotour Excursões" />
    <p>Olá! Você está recebendo esse email porque tem uma reserva na nossa excursão <?= $nome_exc; ?>, no dia <?= $dia_exc ?></p>
    <p>Viemos para te informar que o <b style="color: #400f0f;">grupo de WhatsApp da excursão já está disponível!</b></p>
    <p> Por lá, você acompanha as informações importantes da organização e pode interagir com os outros participantes que vão no mesmo evento que você.</p>
    <div class="wpp-container" style="background: #cfdbcf;padding: 14px 16px;border-radius: 10px;margin: 18px 0;"><span class="wpp-title" style="font-size: 15px;font-weight: 700;text-transform: uppercase;letter-spacing: .04rem;display: block;margin-bottom: 6px;color: #2f3831;text-align: center;">Acesse o grupo no WhatsApp</span>

      <div>
        <a style="text-align:center; display:block" href="<?= $link ?>" target="_blank"><?= $link ?></a>
      </div>
      <div class="link-btns-container" style="display: flex; justify-content: center; margin: 10px 0; font-size: 11px; justify-content:center; gap: 20px">
        <a class="btn-copy" style="color: #400f0f;font-weight: bold;word-break: break-all;text-decoration: underline;" href="copy:<?= $link ?>">Copiar link</a>
        <a class="btn-share" style="color: #400f0f;font-weight: bold;word-break: break-all;text-decoration: underline;" href="https://api.whatsapp.com/send?text=<?= urlencode($link) ?>" target="_blank">Compartilhar</a>
      </div>

      <p>Caso haja outros passageiros em sua reserva, compartilhe esse link. As solicitações serão avaliadas conforme os dados informados no momento da reserva.</p>
    </div>
    <div class="redes-footer-container" style="text-align: center;margin-top: 24px;padding-top: 16px;border-top: 1px solid #d9d9d9;">
      <p style="margin-bottom: 6px;font-weight: bold;color: #414e46;">Siga-nos nas redes sociais!</p><a href="https://www.instagram.com/aerotour_excursoes/" target="_blank" style="color: #400f0f; text-decoration: underline; font-weight: 600;">Instagram</a> | <a href="https://www.facebook.com/aerotourcampinas/" target="_blank">Facebook</a>
    </div>
    <div class="site-footer" style="margin-top: 26px; text-align: center;font-size: 13px;color: #555;"><span style="display: block; margin-bottom: 2px; font-weight: bold; color: #414e46;">Aerotour Excursões</span><a href="https://www.aerotour.com.br" target="_blank" style="color: #400f0f; text-decoration: underline; font-weight: 600;">www.aerotour.com.br</a></div>
  </section>
</body>