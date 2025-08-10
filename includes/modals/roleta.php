<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/includes/modals/roleta.css?ver=<?= time(); ?>">



<div id="modal" class="modal roleta-modal <?= is_user_logged_in() ? 'logged-in' : 'not-logged-in'?>" data-user="<?= get_current_user_id(); ?>" data-campanha="<?= $campanha_atual -> id; ?>">
  <div class="modal-content">
    <p class="modal-title blink">Gire e ganhe desconto!</p>
    <div class="roleta-wrapper">
      <div class="roleta">
        <!-- Seta indicadora -->
        <div class="seta"></div>
        <div class="roda" id="roda">
        
          <!-- Cada fatia -->
          <div class="slice"><span data-premio="5off">Cupom 5%</span></div>
          <div class="slice"><span data-premio="10off">Cupom 10%</span></div>
          <div class="slice"><span data-premio="5off">Cupom 5%</span></div>
          <div class="slice"><span data-premio="15off">Cupom 15%</span></div>
          <div class="slice"><span data-premio="5off">Cupom 5%</span></div>
          <div class="slice"><span data-premio="10off">Cupom 10%</span></div>
          <div class="slice"><span data-premio="5off">Cupom 5%</span></div>
          <div class="slice"><span data-premio="20off">Cupom 20%</span></div>
          <div class="slice"><span data-premio="5off">Cupom 5%</span></div>
        </div>
      </div>
      <div class="roleta-info">
        <p>Ganhe um cupom de 5%, 10%, 15% ou até 20% de desconto para utilizar em sua próxima reserva!</p>
        <p class="cupom-validade">Promoção válida até dia 05/06.</p>

        <?php
          if(!is_user_logged_in()){
            ?>
              <div class="modal-login">
                <p><a id="modal-minha-conta-btn" href="<?= wc_get_page_permalink('myaccount'); ?>"><b>Faça login</b> ou <b>cadastre-se</b> para girar! ></a></p>
              </div>
            <?php
          }
        ?>

      </div>
    </div>
  
      <button id="fechar-modal" data-status="1">Não quero, obrigado.</button>
  </div>
</div>


<script src="<?php echo get_stylesheet_directory_uri() ?>/js/roleta.js?ver=<?= time(); ?>"></script>