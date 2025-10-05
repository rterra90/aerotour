<?php 
$local_evento = get_post_meta($excursao -> get_id(), 'local_evento', true);
$img = wp_get_attachment_image_src(get_post_thumbnail_id( $excursao -> get_id() ), 'medium');

$datas_array = '';
if (isset($excursao->attributes['dia'])) {
  $meses = [
    '01' => 'JAN', '02' => 'FEV', '03' => 'MAR', '04' => 'ABR',
    '05' => 'MAI', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO',
    '09' => 'SET', '10' => 'OUT', '11' => 'NOV', '12' => 'DEZ'
  ];

  // Extrai e converte as datas
  $datas_array = array_map(function($_data) use ($meses) {
    $data = substr($_data, 0, -5); // "dd/mm"
    list($dia, $mes) = explode('/', $data);
    return $dia . '/' . $meses[$mes];
  }, $excursao->attributes['dia']['options']);

  // Ordena as datas pela ordem cronológica
  usort($datas_array, function($a, $b) use ($meses) {
    // Reverte a abreviação para número para comparar
    $mes_num = array_flip($meses);

    list($diaA, $mesA) = explode('/', $a);
    list($diaB, $mesB) = explode('/', $b);

    $dataA = sprintf('%02d%02d', $mes_num[$mesA], $diaA);
    $dataB = sprintf('%02d%02d', $mes_num[$mesB], $diaB);

    return strcmp($dataA, $dataB);
  });
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
<div class="col-lg-3 col-md-4 col-sm-5 col-8 display-flex-child" data-nome="<?= $excursao -> name; ?>" data-id="<?= $excursao -> get_id(); ?>">

  <div class="excursion-card <?= isset($color_scheme) ? $color_scheme : 'dark' ?>">
    <div class="image-container">
      <a href="<?= $excursao->get_permalink(); ?>"><img loading="lazy" src="<?= $img[0]; ?>" alt="<?= $excursao -> name; ?>"></a>
      
      <!-- <div class="badge">Últimas vagas</div> -->

    </div>
    <div class="info">
      <!-- Título  -->
      <div class="title"><span>Excursão</span><?= $excursao -> name; ?></div>

      <!-- Datas -->
      <?php
        if (!empty($datas_array)) {
          $count = count($datas_array);
          echo '<p class="dates">';
          if ($count === 1) {
            echo $datas_array[0];
          } elseif ($count === 2) {
            echo "{$datas_array[0]} e {$datas_array[1]}";
          } else {
            echo "De {$datas_array[0]} até {$datas_array[$count - 1]}";
          }
          echo '</p>';
        }
      ?>

      <!-- Local -->
      <div class="location">
        <p><?= explode('/', $local_evento)[0]; ?></p>
        <span><?= isset(explode('/', $local_evento)[1]) ? explode('/', $local_evento)[1] : ''; ?></span>
      </div>

      <!-- Botão -->
      <button class="cta"><a href="<?= $excursao->get_permalink(); ?>" aria-label="Botão para saber mais sobre a excursão">+ infos e reservas</a></button>
    </div>
  </div>
</div> 