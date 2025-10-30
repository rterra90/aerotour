<?php
function check_in_widget(){
  // global $wpdb;
  // $excursoes = wc_get_products(array(
  //   'status' => 'publish',
  //   'limit' => -1,
  // ));
  // $proximas_excursoes = aer_proximas_excursoes($excursoes, 'variacoes');
  ?>

  <!-- CHECK IN APP - REACT  -->
  <div id="checkInWidget" data-ajax-url="<?= admin_url( 'admin-ajax.php' ); ?>"></div>
  

  <?php
}

?>