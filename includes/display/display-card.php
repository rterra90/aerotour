<?php 
$local_evento = get_post_meta($excursao -> get_id(), 'local_evento', true);
$img = wp_get_attachment_image_src(get_post_thumbnail_id( $excursao -> get_id() ), 'medium');

$datas_array = '';
if(isset($excursao -> attributes['dia'])){
  $datas_array = array_map(function($_data){
    return substr($_data, 0, -5);
  }, $excursao -> attributes['dia']['options']);
}

$exc_variacoes = $excursao -> get_available_variations();
if(count($exc_variacoes) > 0){
  $status_variacoes = array_map(function($_var){
    $vagas_disponiveis = trim(str_replace('</p>', '', substr($_var['availability_html'], 29)));
    $_label = (int)$vagas_disponiveis > 0 ? (int)$vagas_disponiveis > 9 ? 'disponivel' : 'ultimos': 'esgotado';
    $meta_encerrar_vendas = get_post_meta($_var['variation_id'], 'encerrar_vendas', true);
    $_label = $meta_encerrar_vendas === 'yes' ? 'encerrado' : $_label;
  
    return array(
      'dia' =>   substr($_var['attributes']['attribute_dia'], 0, -5),
      'label' => $_label,
    );
  }, $exc_variacoes);
}



?>
<div class="col-lg-3 col-7 display-flex-child" data-nome="<?= $excursao -> name; ?>" data-id="<?= $excursao -> get_id(); ?>">
  <div class="display-card dark">
    <div class="display-card-header">
      <a href="<?= $excursao->get_permalink(); ?>" aria-label="Botão para saber mais sobre a excursão">
        <img class="main-img" loading="lazy" src="<?= $img[0]; ?>" alt="<?= $excursao -> name; ?>">
      </a>
      

    </div>
    <div class="display-card-body">
      <h3 class="mt-2 mb-1">
        <p classs="card-title"><?= $excursao -> name; ?></p>
      </h3>
      <div class="date-place">
        <div class="date">
          <div class="date-icon"><?php echo aer_icons("calendar", 13, 13); ?></div>
          <div class="date-badges<?= $datas_array !== '' && sizeof($datas_array) > 2 ? ' multi3' : ''; ?> <?= $datas_array !== '' && sizeof($datas_array) == 2 ? ' multi2' : '' ?>">

          <?php
          if($datas_array !== ''){
            foreach($datas_array as $_i => $_data){
              ?>
                <span data-status="<?= $status_variacoes[$_i]['label']; ?>"><?= $_data; ?></span>
              <?php
            } 
          }else{
            ?>  
            <div class="a-definir">A definir</div>
            <?php
          }
            
          ?>

          </div>
        </div>
        <div class="place">
          <div class="place-icon"><?php echo aer_icons("pin", 13, 13); ?></div>
          <div>
            <p><?= explode('/', $local_evento)[0]; ?></p>
            <span><?= isset(explode('/', $local_evento)[1]) ? explode('/', $local_evento)[1] : ''; ?></span>
          </div>
        </div>
      </div>
    </div>
    <div class="display-card-footer">
      <button class="button" data-btn-reactive><a href="<?= $excursao->get_permalink(); ?>" aria-label="Botão para saber mais sobre a excursão">+ infos e reservas</a></button>
    </div>
  </div>
</div> 