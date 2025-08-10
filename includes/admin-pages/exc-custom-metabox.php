<?php
add_action( 'add_meta_boxes', 'aer_exc_meta_boxes' );
function aer_exc_meta_boxes(){
  add_meta_box('variations_passageiros_json', 'Listas de passageiros (JSON)', 'custom_metabox_variations_passageiros_json', 'product');
}

function custom_metabox_variations_passageiros_json($post){
  ?>
    <div>
      <?php


        if($post -> post_title === '')echo '<p>Lista de passageiros ainda não disponível. Termine de configurar a nova excursão!</p>';
        else{
          $exc_variations = wc_get_product($post -> ID) -> get_available_variations();
          foreach($exc_variations as $variation){
            $passageiros_var_str = get_post_meta($variation['variation_id'], 'passageiros', true);
            $_data = $variation['attributes']['attribute_dia'];
            ?>
              <div>
                <?php
                        print_r(wc_get_product($post -> ID));
                        echo '<br /><br /><br />';
                        print_r(wc_get_product($post -> ID) -> get_available_variations());
                ?>
                <p>Dia: <?= $_data; ?></p>
                <textarea name="passageiros_var_<?= $variation['variation_id']; ?>" cols="30" rows="6"><?= $passageiros_var_str; ?></textarea>
              </div>
            <?php
          }
        }
        
      ?>

    </div>
  <?php
};
?>
