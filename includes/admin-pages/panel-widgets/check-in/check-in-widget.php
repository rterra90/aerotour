<?php
function check_in_widget(){
  global $wpdb;
  $excursoes = wc_get_products(array(
    'status' => 'publish',
    'limit' => -1,
  ));
  ?>
  <div id="checkInWidget">
    <ul id="listaExcursoesCheckIn">
      <li><span class="exc_name">Excursão</span><span class="exc_total_passageiros">Passageiros</span><span class="icone">Check-in</span></li>
      <?php
        $proximas_excursoes = aer_proximas_excursoes($excursoes, 'variacoes');
        foreach($proximas_excursoes as $variacao){
          $variation_id = $variacao -> get_id();
          $passageiros_var_qty = $wpdb->get_var("SELECT COUNT(*) FROM aer_reservas WHERE variation_id = $variation_id AND status = 'normal'");
          $parent_id = wp_get_post_parent_id($variacao -> get_id());

          ?>
            <li>
              <span class="exc_name">
                <a href="<?= current_user_can('edit_posts') ? get_edit_post_link($parent_id) : '#'; ?>"><?= $variacao -> name; ?></a>
              </span>
              <span class="exc_total_passageiros"><?= $passageiros_var_qty; ?></span>
              <span class="icone dashicons dashicons-clipboard" data-variation-id=<?= $variacao -> get_id(); ?>></span>
            </li>
          <?php
        }

      ?>
    </ul>

    <script>
      document.querySelectorAll('#listaExcursoesCheckIn .icone').forEach(icon => icon.addEventListener('click', () => {
        console.log('clicked');
        const checkInModal = new CheckInModal(icon.dataset.variationId);
        checkInModal.open();
      }));
      
    </script>
  </div>
  <?php
}

?>