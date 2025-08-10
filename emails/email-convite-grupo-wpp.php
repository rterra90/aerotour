<style>
  #email-body {
    padding: 20px 32px;
    max-width: 700px;
    width: 90%;
    border: 2px solid black;
    font-family: "Raleway", "Verdana", "sans-serif"
  }
  .main-logo {
    width: 180px
  }
  .wpp-container {
    border-radius: 1rem;
    padding: 16px 20px;
    margin: 24px 0;
    background-color: #e8ffe8;
    box-shadow: 2px 2px 7px #9fb39f;
  }
  .wpp-title {
    display: block;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: .05rem;
    margin-bottom: 10px
  }
  .wpp-container a {
    font-weight: 600;
    font-size: 14px;
    text-decoration: underline;
    display: block
  }
  .wpp-container p {
    font-size: 14px;
    opacity: .8;
    margin-bottom: 0px
  }
  .redes-footer-container {
    margin: 24px 0;
  }
  .redes-footer-container p {
    margin-bottom: 2px
  }
  .redes-footer-container a,
  .site-footer a {
    font-size: 15px;
    color: unset;
    font-weight: 500
  }
  .site-footer span {
    display: block;
    font-size: 1.15rem;
  }
  @media (prefers-color-scheme: dark) {
    .wpp-container {
    border-radius: 1rem;
    padding: 16px 20px;
    margin: 24px 0;
    background-color: #e8ffe8;
    box-shadow: 2px 2px 7px #9fb39f;
    }
    .wpp-title {
      display: block;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: .05rem;
      margin-bottom: 10px
    }
    .wpp-container a {
      font-weight: 600;
      font-size: 14px;
      text-decoration: underline;
      display: block
    }
    .wpp-container p {
      font-size: 14px;
      opacity: .8;
      margin-bottom: 0px
    }
  }
</style>
<body>
  <section id="email-body">
    <img class="main-logo" src="https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/aerotour-logo.svg" alt="Aerotour Excursões" />
    <p>Olá! Você está recebendo esse email porque tem uma reserva na nossa excursão <?= $email_params['nome_exc']; ?>, no dia <?= $email_params['dia_exc']; ?></p>
    <p>Viemos para te informar que o <b>grupo de WhatsApp da excursão já está disponível!</b></p>
    <p> Por lá, você acompanha as informações importantes da organização e pode interagir com os outros participantes que vão no mesmo evento que você.</p>
    <div class="wpp-container"><span class="wpp-title">Acesse o grupo no WhatsApp</span><a href="<?= $email_params['link']; ?>" target="_blank"><?= $email_params['link']; ?></a>
      <p>Caso haja outros passageiros em sua reserva, compartilhe esse link. As solicitações serão avaliadas conforme os dados informados no momento da reserva.</p>
    </div>
    <div class="redes-footer-container">
      <p>Siga-nos nas redes sociais!</p><a href="https://www.instagram.com/aerotour_excursoes/" target="_blank">Instagram</a> | <a href="https://www.facebook.com/aerotourcampinas/" target="_blank">Facebook</a>
    </div>
    <div class="site-footer"><span>Aerotour Excursões</span><a href="https://www.aerotour.com.br" target="_blank style=" display: block; text-decoration: underline">www.aerotour.com.br</a></div>
  </section>
</body>