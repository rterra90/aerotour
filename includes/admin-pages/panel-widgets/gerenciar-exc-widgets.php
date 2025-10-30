<?php
function aer_check_in_widget(){
  global $wpdb;
  $excursoes = wc_get_products(array(
    'status' => 'publish',
    'limit' => -1,
  ));

  ?>

  <div>
    <ul id="manage_exc_widget_list">
      <li><span class="exc_name">Excursão</span><span class="exc_total_passageiros">Passageiros</span><span class="icone">Check-in</span></li>
      <?php 
        foreach(aer_proximas_excursoes($excursoes, 'variacoes') as $variacao){

          // $passageiros_var = json_decode(get_post_meta($variacao -> get_id(), 'passageiros', true));
          // $passageiros_var_qty = $passageiros_var === '' || $passageiros_var === NULL ? 0 : sizeof($passageiros_var);
          $variation_id = $variacao -> get_id();
          $passageiros_var = $wpdb->get_results("SELECT * FROM aer_reservas WHERE variation_id = $variation_id AND status = 'normal'");
          $passageiros_var_qty = sizeof($passageiros_var);
          $exc_parent_id = wp_get_post_parent_id($variacao -> get_id());
          ?>
            <li><span class="exc_name"><a href="<?= current_user_can('edit_posts') ? get_edit_post_link($exc_parent_id) : '#'; ?>"><?= $variacao -> name; ?></a></span><span class="exc_total_passageiros"><?= $passageiros_var_qty; ?></span><span class="icone dashicons dashicons-clipboard" data-variation-id=<?= $variacao -> get_id(); ?>></span></li>
          <?php
        }
      ?>
    </ul>
    

    <script>
      window.onload = () => document.querySelectorAll('#manage_exc_widget_list .dashicons-clipboard').forEach(icon => icon.addEventListener('click', openCheckInModal));
      

      function closeCheckInModal(){
        document.querySelector('#check-in-modal').remove();
      }

      function openCheckInModal({target}){

      const check_in_variation_id = target.dataset.variationId;
      const modalElement = document.createElement('div');
      modalElement.id = 'check-in-modal';

        modalElement.innerHTML = `<div class="check-in-modal-inner">
                                    <span class="close" onclick="closeCheckInModal()">Fechar</span>
                                    <h1>Check-in</h1>
                                    <h2>${target.parentElement.children[0].innerText}</h2>
                                    <div class="check_in_lista_wrapper">
                                      <div class="check_in_filters">
                                        <span class='dashicons dashicons-filter'></span>
                                        <div class="filter_options_wrapper">
                                          <span class="active" data-filter="alfa" onclick="aerCheckIn(${check_in_variation_id}, null, null, null, this)">Ordem alfabética</span>
                                          <span data-filter='embarque' onclick="aerCheckIn(${check_in_variation_id}, null, null, null, this)">Embarque</span>
                                        </div>
                                      </div>
                                      <ul data-react="lista_passageiros" class="lista-check-in">
                                        
                                      </ul>
                                    </div>
                                  </div>`;

        document.querySelector('#wpwrap').insertBefore(modalElement, document.querySelector('#adminmenumain'));
        window.scrollTo(0, 0)

        const opcoesFiltro = document.querySelectorAll(`.check_in_filters span[data-filter]`);
          opcoesFiltro.forEach(option => option.addEventListener('click', (e) => {
            const filterType = e.target.dataset.filter;
            opcoesFiltro.forEach(op => op.dataset.filter === filterType ? op.classList.add('active') : op.classList.remove('active'));
          }))

      //   //Busca passageiros da excursão
        // aerCheckIn(check_in_variation_id);

      }
    </script>
  </div>
<?php
}
?>
