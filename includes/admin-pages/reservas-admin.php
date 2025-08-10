<?php
function reservas_admin_page(){
// $excursoes = wc_get_products(array('include' => ['610']));
  ?>
    <section id="admin-reservas">
      <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

      <h1>Reservas</h1>
      <p>Visualize e gerencie as reservas nas excursões.</p>

      <!-- ADMIN RESERVAS APP - REACT  -->
      <div id="adminReservasApp" data-ajax-url="<?= admin_url( 'admin-ajax.php' ); ?>"></div>




    </section>


  <?php
}

?>