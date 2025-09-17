<?php
$card_excursao = isset($excursao) ? $excursao : $excursao_arquivo;
$local_evento = get_post_meta($card_excursao -> get_id(), 'local_evento', true);
$img = wp_get_attachment_image_src(get_post_thumbnail_id( $card_excursao -> get_id() ), 'medium');
$datas_array = $card_excursao -> attributes['dia']['options'];
$exc_variacoes = $excursao -> get_available_variations();
$tem_variacao = count($exc_variacoes) > 1;
?>
<div class="<?= isset($is_slider) && $is_slider ? 'col-lg-3 col-5 ' : 'col-6 '; ?>col-md-4 mb-3" data-id="<?= $card_excursao -> get_id(); ?>">
  <div class="card aer-card" data-id="<?= $card_excursao -> get_id(); ?>">
    <div class="card-header d-flex gap-2 align-items-center"><?php
      echo aer_icons("calendar", 12, 12) . card_datas($datas_array);
      ?>
    </div>
    <!-- IMAGEM DO CARD -->
    <a href="<?= $card_excursao->get_permalink(); ?>">
      <img loading="lazy" src="<?= $img[0]; ?>?w=100" class="card-img-top" alt="<?= $card_excursao -> name; ?>">
    </a>
    
    <div class="card-body d-flex flex-column justify-content-between">
      <div>
        <span class="card-body-data gap-2 align-items-center"><?php
      echo aer_icons("calendar", 12, 12) . card_datas($datas_array);
      ?></span>
      <div class="card-alerts-wrapper mb-1">
        <?php 
          if(!$tem_variacao){
            $v_disponiveis = trim(str_replace('</p>', '', substr($exc_variacoes[0]['availability_html'], 29)));
            $data_evento = count(explode('/', $datas_array[0])) == 3 ? $datas_array[0] : $datas_array[0] . "/" .date("Y");

            if(strtotime("now") > strtotime(data_to_iso($data_evento)) + 10800)echo '<span class="card-alert card-alert-red">Vendas encerradas!</span>';
            else{
                if($v_disponiveis === '')echo '<span class="card-alert card-alert-red">Esgotado!</span>';
                else if(is_numeric($v_disponiveis) && $v_disponiveis <= 10) echo '<span class="card-alert">Últimos lugares!</span>';
            }
          }else{
            $dias_lugares = array();
            foreach($datas_array as $key => $data){
              $dias_lugares[$data] = trim(str_replace('</p>', '', substr($exc_variacoes[$key]['availability_html'], 29)));

              $meta_encerrar_vendas = get_post_meta($exc_variacoes[$key]['variation_id'], 'encerrar_vendas', true);
              if($meta_encerrar_vendas === 'yes') $dias_lugares[$data] = 'encerrada';
            };

            foreach($dias_lugares as $_dia => $_lugares){
              $status_vendas_var = (int)strtotime('now') >= ((int)strtotime(data_to_iso($_dia)) + (3600 * 10)) ? 'encerrada' : 'ativa';

              if($status_vendas_var === 'encerrada' || $_lugares === 'encerrada'){
                echo '<span class="card-alert card-alert-red"><b>' . substr($_dia, 0, -5) . '</b>Vendas encerradas!</span>';
              }else{
                if($_lugares === '' || $_lugares === 0)echo '<span class="card-alert card-alert-red"><b>' . substr($_dia, 0, -5) . '</b>Esgotado!</span>';
                else if(is_numeric($_lugares) && $_lugares <= 10) echo '<span class="card-alert"><b>' . substr($_dia, 0, -5) . '</b><b>Últimos lugares!</b></span>';
              }
            }
          }
        ?>
      </div>
      
      
        <h3 class="card-title mb-2"><?= $card_excursao -> name; ?></h3>
        <span class="card-local-evento"><?= aer_icons("pin", 12, 12); ?> <?= $local_evento; ?></span>
      </div>
      
      <a href="<?= $card_excursao->get_permalink(); ?>" class="btn btn-dark" data-btn-reactive>Saiba mais</a>
    </div>
  </div>
</div>
<script>
cardAlertsSlider("<?= $slider_ref; ?>", <?= $card_excursao -> get_id(); ?> )
</script>