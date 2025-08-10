<?php
// Template Name: Contato
?>
<?php get_header(); ?>
<section id="contato" class="py-md-4 py-5">
  
  <div class="container">
    <h1>Contato</h1>
    <div class="contato-inner my-4 row">


      <div class="wpp-redes text-center col-md-6">
        <div class="wpp">
          <div>
            <p>Você pode entrar em contato por meio do WhatsApp da Aerotour!</p>
            <a href="https://api.whatsapp.com/send?phone=5519997477465"><div class="contato-btn my-4">
              <?= aer_icons('whatsapp', 30, 30)?> <span>19 99747-7465</span>
            </div></a>
            
          </div>
          
        </div>
        <div class="redes mt-5">
          <p>Siga-nos nas nossas redes sociais</p>
          <div class="icons-wrapper">
            <a href="https://www.instagram.com/aerotour_excursoes/" target="_blank"><?= aer_icons('instagram', 30, 30)?></a>
            <a target="_blank" href="https://www.facebook.com/aerotourcampinas/"><?= aer_icons('facebook', 30, 30)?></a>    
          </div>
        </div>
      </div>

      <div class="email text-center col-md-6">
        <p>Se preferir, envie-nos um email que retornaremos o mais breve possível!</p>
        <a href="mailto:contato@aerotour.com.br"><div class="contato-btn"><?= aer_icons('email', 30, 30); ?>contato@aerotour.com.br</div></a>
      </div>

    </div>
    
    <div id="social-footer" class="d-flex">
      <div class="instagram-feed col-md-6">
        <?php
        echo do_shortcode( '[instagram feed="4017"]' );
        ?>
      </div>
      <div class="social-cta col-md-6">
      </div>
    </div>
  </div>
  


</section>
<?php get_footer(); ?>