<?php
        $user = get_current_user();
?>
<div class="modal fade" id="qr-event-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="qr-event-modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <img class="qr-modal-aer-logo"src="<?= get_stylesheet_directory_uri(); ?>/assets/images/main.png" alt="Aerotour Excursões">
        <span>no</span>
        <img class="srs-logo"src="<?= get_stylesheet_directory_uri(); ?>/assets/images/sundayrock.jpg" alt="Sunday Rock Sunday">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php
          if(is_user_logged_in()) echo '<p class="text-center">Olá, ' . $current_user -> display_name;
      ?>
        <p class="text-center">Está curtindo o evento? Então, que tal ganhar 10% de desconto na sua próxima reserva na Aerotour e ainda concorrer a um par de reservas para qualquer excursão?</p>
        <?php

          if(is_user_logged_in()){
            ?>
              <script>window.localStorage.setItem('aer_sorteio', JSON.stringify(['srs2023', false, 1698634800000]));</script>
            <?php
            $customer_coupons = get_user_meta(get_current_user_id(), 'cupons', true) !== '' ?json_decode(get_user_meta(get_current_user_id(), 'cupons', true)) : null;
            
            if($customer_coupons && in_array(strtoupper($_GET['qr_event']), $customer_coupons)){
              ?>
                <p>Parece que você já resgatou esse cupom!</p>

              <?php
            }else{
              ?>
                <div class="modal-footer">
                  <form action="<?= wc_get_page_permalink('myaccount'); ?>" method="POST">
                    <input type="hidden" id="qr_event_coupon_control" name="qr_event_coupon_control" value="<?= get_option('qr_code_coupon_status')['code']; ?>" />
                    <input type="hidden" name="logged_in_no_coupon" value="true" />
                    <input type="submit" class="btn btn-lg" id="modal-accept-btn" value="Eu quero!"/>
                    <span data-bs-dismiss="modal" aria-label="Close">Não, obrigado.</span>
                  </form>
                  
                </div>
              <?php
            }
            

          }else{
            ?>
            <p class="text-center mb-0">É só se cadastrar ou fazer seu login agora mesmo para resgatar o cupom!</p>
            <!-- <label><input type="checkbox" name="qr_event_sorteio"/>Quero concorrer a uma reserva grátis!</label> -->
            <div class="modal-footer">   
              <button class="btn btn-lg" id="modal-accept-btn" onclick="qrEventAccept()">Eu quero!</button>
              <span data-bs-dismiss="modal" aria-label="Close">Não, obrigado.</span>
            </div>
           <?php
          }
        ?>
      </div>

    </div>
  </div>
</div>

<script>
  function qrEventAccept(){
    const requestTime = new Date().getTime();
    // const _sorteio = document.querySelector('input[type="checkbox"][name="qr_event_sorteio"]').checked ? 'true' : 'false';

    window.localStorage.setItem("aer_qr_event", JSON.stringify({event: 'Sunday Rock Sunday', coupon: "<?= get_option('qr_code_coupon_status')['code']; ?>", sorteio: 'true', request_time: requestTime, status: 'pending'}));
 
    if(window.localStorage.getItem("aer_qr_event")) window.location.href = "<?= wc_get_page_permalink('myaccount'); ?>"
  }
</script>