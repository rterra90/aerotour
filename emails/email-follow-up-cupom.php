<style>
  #email-body {
    padding: 20px 32px;
    max-width: 700px;
    width: 90%;
    border: 2px solid black;
    font-family: "Raleway", "Verdana", "sans-serif"
  }
  #email-body a{
    color: unset!important;
  }
  .main-logo {
    width: 180px
  }
  .cupom-container > p{
    margin-bottom: 0px
  }
  .email-cupom-icone{
    width: fit-content;
    padding: 4px 8px;
    text-align: center;
    font-weight: 600;
    letter-spacing: .05rem;
    border: 2px dotted darkgrey;
    margin-top: 10px;
    font-size: 1.125rem;
    cursor: pointer;
  }
  .cupom-container a{
    color: unset!important;
  }
  .cupom-container .roleta5{
    background-color: #99baf0;

  }
  .cupom-container .roleta10{
  background-color: #ffde92;
    
  }
  .cupom-container .roleta15{
  background-color: #e6c2ea;
    
  }
  .cupom-container .roleta20{
  background-color: #aad6a3;
    
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
  .email-link-todas-excursoes{
    letter-spacing: .05rem;
    font-weight: 600;
    color: unset!important
  }

</style>

<body>
  <section id="email-body">
    <img class="main-logo" src="https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/aerotour-logo.svg" alt="Aerotour Excursões" />
    <p>Olá, <?= $email_params['nome_cliente'] ?></p>
    <p>Queremos lembrar que você tem um desconto esperando por você em nosso site! Utilize o cupom obtido ao girar a roleta e tenha desconto ao reserva o seu lugar em nossas excursões.

    <div class="cupom-container">
      <p>Seu cupom:</p>
      <a class="email-link-cupom" target="_blank" href="https://aerotour.com.br/minha-conta">
        <div class="email-cupom-icone <?= $email_params['cupom_cliente']; ?>">
          <?= strtoupper($email_params['cupom_cliente']); ?>
        </div>
      </a>

    </div>

    <p>O cupom é válido para qualquer excursão disponível em nosso site! Basta adicionar ao carrinho para receber o desconto.</p>

    <p><a class="email-link-todas-excursoes" href="https://aerotour.com.br/excursoes" target="_blank">CONFIRA TODAS AS EXCURSÕES</a></p>

    <p>Ah, e estendemos o prazo de validade dos cupons, que agora podem ser utilizado até o dia 05/04/2025.</p>

    <p>Acesse nosso site e aproveite!</p>

    <div class="redes-footer-container">
      <p>Siga-nos nas redes sociais!</p><a href="https://www.instagram.com/aerotour_excursoes/" target="_blank">Instagram</a> | <a href="https://www.facebook.com/aerotourcampinas/" target="_blank">Facebook</a>
    </div>
    <div class="site-footer"><span>Aerotour Excursões</span><a href="https://www.aerotour.com.br" target="_blank style=" display: block; text-decoration: underline">www.aerotour.com.br</a></div>
  </section>
</body>