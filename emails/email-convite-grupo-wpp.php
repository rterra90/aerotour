<style>
#email-body {
  font-family: Arial, Helvetica, sans-serif;
  color: #2f3831;
  font-size: 15px;
  line-height: 1.55;
  max-width: 600px;
  margin: 0 auto;
  padding: 20px 24px;
  background: #f6f6f6;
  border-radius: 14px;
}

#email-body .main-logo {
  width: 160px;
  display: block;
  margin: 0 auto 24px;
}

#email-body p {
  margin: 0 0 14px;
}
#email-body p b{
  color: #400f0f;

}

#email-body .wpp-container {
  background: #cfdbcf;
  padding: 14px 16px;
  border-radius: 10px;
  margin: 18px 0;
}

#email-body .wpp-container .wpp-title {
  font-size: 15px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .04rem;
  display: block;
  margin-bottom: 6px;
  color: #2f3831;
  text-align: center;
}

#email-body .wpp-container a {
  color: #400f0f;
  font-weight: bold;
  word-break: break-all;
  text-decoration: underline;
}

/* === NOVAS AÇÕES === */
#email-body .wpp-actions {
  margin-top: 12px;
  display: flex;
  gap: 10px;
}

#email-body .wpp-actions a {
  padding: 8px 12px;
  background: #414e46;
  color: #ffffff !important;
  text-decoration: none;
  border-radius: 6px;
  font-size: 14px;
  font-weight: 600;
  display: inline-block;
  text-align: center;
}


#email-body .redes-footer-container {
  text-align: center;
  margin-top: 24px;
  padding-top: 16px;
  border-top: 1px solid #d9d9d9;
}

#email-body .redes-footer-container p {
  margin-bottom: 6px;
  font-weight: bold;
  color: #414e46;
}

#email-body .redes-footer-container a {
  color: #400f0f;;
  text-decoration: underline;
  font-weight: 600;
}

#email-body .site-footer {
  margin-top: 26px;
  text-align: center;
  font-size: 13px;
  color: #555;
}

#email-body .site-footer span {
  display: block;
  margin-bottom: 2px;
  font-weight: bold;
  color: #414e46;
}

#email-body .site-footer a {
  color: #400f0f;;
  text-decoration: underline;
  font-weight: 600;
}
#email-body .link-btns-container{
  display:flex; justify-content:center; gap: 20px;
  margin: 10px 0;
  font-size: 11px
}
</style>
<body>
  <section id="email-body">
    <img class="main-logo" src="https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/aerotour-logo.svg" alt="Aerotour Excursões" />
    <p>Olá! Você está recebendo esse email porque tem uma reserva na nossa excursão <?= $email_params[
      'nome_exc'
    ] ?>, no dia <?= $email_params['dia_exc'] ?></p>
    <p>Viemos para te informar que o <b>grupo de WhatsApp da excursão já está disponível!</b></p>
    <p> Por lá, você acompanha as informações importantes da organização e pode interagir com os outros participantes que vão no mesmo evento que você.</p>
    <div class="wpp-container"><span class="wpp-title">Acesse o grupo no WhatsApp</span>
    
      <div>
        <a style="text-align:center; display:block" href="<?= $email_params[
          'link'
        ] ?>" target="_blank"><?= $email_params['link'] ?></a>
      </div>
      <div class="link-btns-container" style="display:flex; justify-content:center; gap: 20px">
      <a class="btn-copy" href="copy:<?= $email_params[
        'link'
      ] ?>">Copiar link</a>
  <a class="btn-share" href="https://api.whatsapp.com/send?text=<?= urlencode(
    $email_params['link']
  ) ?>" target="_blank">Compartilhar</a>    
    </div>

      <p>Caso haja outros passageiros em sua reserva, compartilhe esse link. As solicitações serão avaliadas conforme os dados informados no momento da reserva.</p>
    </div>
    <div class="redes-footer-container">
      <p>Siga-nos nas redes sociais!</p><a href="https://www.instagram.com/aerotour_excursoes/" target="_blank">Instagram</a> | <a href="https://www.facebook.com/aerotourcampinas/" target="_blank">Facebook</a>
    </div>
    <div class="site-footer"><span>Aerotour Excursões</span><a href="https://www.aerotour.com.br" target="_blank style=" display: block; text-decoration: underline">www.aerotour.com.br</a></div>
  </section>
</body>