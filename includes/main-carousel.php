<div id="main-banner" class="d-flex justify-content-center mb-3">
  <div id="hero" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <?php
        $i_button = 0;
        foreach(aer_proximas_excursoes($excursoes, 'destaque') as $excursao){
          if(get_post_meta($excursao -> get_id())['destaque'][0] === 'yes'){
            ?>
            <button type="button" data-bs-target="#hero" data-bs-slide-to="<?= $i_button; ?>" class="<?= $i_button === 0 ? 'active' : ''; ?>" aria-current="<?= $i_button === 0 ? 'true' : ''; ?>" aria-label="<?= $excursao -> get_name(); ?>"></button>
            <?php
            $i_button++;
          }
        }
      ?>
    </div>

    <div class="carousel-inner h-100">
      <?php
      $i_main = 0;
        // foreach(aer_proximas_excursoes($excursoes, 'destaque') as $excursao){
        foreach(aer_proximas_excursoes($excursoes, 'destaque') as $_i => $excursao){
          $datas_array = $excursao -> attributes['dia']['options'];

          $img = wp_get_attachment_image_src(get_post_thumbnail_id( $excursao -> get_id() ), 'single-post-thumbnail');

          $background_img = wp_get_attachment_image_src(get_post_meta( $excursao -> get_id(), 'dest_img_1_id', true ), 'single-post-thumbnail')[0];
          $focus_img = wp_get_attachment_image_src(get_post_meta( $excursao -> get_id(), 'dest_img_2_id', true ), 'large')[0];



          if(get_post_meta($excursao -> get_id())['destaque'][0] === 'yes'){
            $exc_variacoes = $excursao -> get_available_variations();
            $tem_variacao = count($exc_variacoes) > 1;
            if(!$tem_variacao){
              $v_disponiveis = trim(str_replace('</p>', '', substr($excursao -> get_available_variations()[0]['availability_html'], 29)));
            }else {
            $dias_lugares = array();
            foreach($datas_array as $key => $data){
              $dias_lugares[$data] = trim(str_replace('</p>', '', substr($exc_variacoes[$key]['availability_html'], 29)));

              $meta_encerrar_vendas = get_post_meta($exc_variacoes[$key]['variation_id'], 'encerrar_vendas', true);
              if($meta_encerrar_vendas === 'yes') $dias_lugares[$data] = 'encerrada';
            };
          };
          ?>
          <div class="carousel-item<?= $i_main === 0 ? ' active' : ''; ?>" style="background-image: url('<?= $background_img; ?>')">

            <div class="carousel-item-flex d-flex hero-container">
              <div class="carousel-info">
                <span data-animate class="pre-title" style="animation-delay:.5s">Excursão</span>
                <h3 data-animate style="animation-delay:.8s"><a href="<?= get_permalink($excursao -> get_id()); ?>"><?= $excursao -> get_name(); ?></a></h3>

                <div class="d-flex">
                  <div class="carousel-img mobile">
                    <?php
                    if($i_main == 0){ 
                      ?>
                      <img data-animate style="animation-delay:1.5s" src="<?= $focus_img; ?>" alt="<?= $excursao -> get_name(); ?>">
                      <?php
                    } else {
                      ?>
                      <img loading="lazy" data-animate style="animation-delay:1.5s" src="<?= $focus_img; ?>" alt="<?= $excursao -> get_name(); ?>">
                      <?php
                    }
                    ?>
                  </div>
                  <div>
                    <div class="data-local" data-animate style="animation-delay:1s">
                      <div><?= aer_icons('calendar', 18, 18)?><span><?php
                          $datas_array = $excursao -> attributes['dia']['options'];
                          foreach($excursao -> attributes['dia']['options'] as $i => $data) {
                            if($i===0){
                              echo substr($data, 0, 5);
                            } elseif($i === sizeof($datas_array) - 1){
                              echo ' e ' . substr($data, 0, 5);
                            } else{
                              echo ', ' . substr($data, 0, 5);
                            }
                          } ?></span>
                      </div>
                      <div><?= aer_icons('pin', 18, 18)?><span><?= get_post_meta($excursao -> get_id(), 'local_evento', true); ?></span></div>

                    </div>
                  </div>  
                </div>
                
                <div class="carousel-buttons" data-animate style="animation-delay:1.5s">
                    <a data-btn-reactive aria-label="Informações e reservas" href="<?= get_permalink($excursao -> get_id()); ?>">Informações e reservas</a>
                  </div> 
              </div>
              <div class="carousel-img desktop">
                <a href="<?= get_permalink($excursao -> get_id()); ?>">
                  <?php
                    if($i_main == 0){ 
                      ?>
                      <img data-animate style="animation-delay:1.5s" src="<?= $focus_img; ?>" alt="<?= $excursao -> get_name(); ?>">
                      <?php
                    } else {
                      ?>
                      <img loading="lazy" data-animate style="animation-delay:1.5s" src="<?= $focus_img; ?>" alt="<?= $excursao -> get_name(); ?>">
                      <?php
                    }
                  ?>
                  
                </a>
              </div>
            </div>
          </div>
            <?php
            $i_main++;
          }
        }
      ?>
    </div>
  </div>
</div>