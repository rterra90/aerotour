<?php
// Evita processar se o objeto não existir
if (!$excursao) {
  return;
}

$ex_id = $excursao->get_id();
$local_evento = get_post_meta($excursao->get_id(), 'local_evento', true);
$img_url = wp_get_attachment_image_src(
  get_post_thumbnail_id($excursao->get_id()),
  'medium'
);

// 1. Lógica de Status e Badges
$variacoes = $excursao->get_available_variations();
$status_final = 'disponivel'; // Default
$tem_vagas = false;
$vendas_encerradas = true;

foreach ($variacoes as $var) {
  $vagas = $var['max_qty'] > 0 ? $var['max_qty'] : 0; // Verifica estoque da variação
  $encerrado =
    get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes';

  if (!$encerrado) {
    $vendas_encerradas = false;
    if ($var['is_in_stock']) {
      $tem_vagas = true;
    }
  }
}

// Definição da Badge
if ($vendas_encerradas) {
  $badge_class = 'encerrado';
  $badge_label = 'Vendas Encerradas';
} elseif (!$tem_vagas) {
  $badge_class = 'esgotado';
  $badge_label = 'Esgotado';
} else {
  // Aqui você pode adicionar lógica para "Últimas Vagas" se o estoque for baixo
  $badge_class = '';
  $badge_label = 'Reservas disponíveis';
}

$datas_array = '';
if (isset($excursao->attributes['dia'])) {
  $meses = [
    '01' => 'JAN',
    '02' => 'FEV',
    '03' => 'MAR',
    '04' => 'ABR',
    '05' => 'MAI',
    '06' => 'JUN',
    '07' => 'JUL',
    '08' => 'AGO',
    '09' => 'SET',
    '10' => 'OUT',
    '11' => 'NOV',
    '12' => 'DEZ'
  ];

  // Extrai e converte as datas
  $datas_array = array_map(function ($_data) use ($meses) {
    $data = substr($_data, 0, -5); // "dd/mm"
    [$dia, $mes] = explode('/', $data);
    return $dia . '/' . $meses[$mes];
  }, $excursao->attributes['dia']['options']);

  // Ordena as datas pela ordem cronológica
  usort($datas_array, function ($a, $b) use ($meses) {
    // Reverte a abreviação para número para comparar
    $mes_num = array_flip($meses);

    [$diaA, $mesA] = explode('/', $a);
    [$diaB, $mesB] = explode('/', $b);

    $dataA = sprintf('%02d%02d', $mes_num[$mesA], $diaA);
    $dataB = sprintf('%02d%02d', $mes_num[$mesB], $diaB);

    return strcmp($dataA, $dataB);
  });
}
?>
<div class="col-lg-3 col-md-4 col-sm-5 col-8 display-flex-child" data-nome="<?= $excursao->name ?>" data-id="<?= $excursao->get_id() ?>">

  <div class="excursion-card <?= isset($color_scheme)
    ? $color_scheme
    : 'dark' ?>">
    <div class="image-container">
      <a href="<?= $excursao->get_permalink() ?>"><img loading="lazy" class="<?= $badge_class ?>"src="<?= $img_url[0] ?>" alt="<?= $excursao->name ?>"></a>
      
        <?php if ($badge_label): ?>
            <div class="badge badge-<?= $badge_class ?>"><?= $badge_label ?></div>
        <?php endif; ?>

    </div>
    <div class="info">
      <!-- Título  -->
      <div class="title"><span>Excursão</span><?= $excursao->name ?></div>

      <!-- Datas -->
      <?php if (!empty($datas_array)) {
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
      } ?>

      <!-- Local -->
      <div class="location">
        <p><?= explode('/', $local_evento)[0] ?></p>
        <span><?= isset(explode('/', $local_evento)[1])
          ? explode('/', $local_evento)[1]
          : '' ?></span>
      </div>

      <!-- Botão -->
      <button class="cta">
          <a href="<?= $excursao->get_permalink() ?>" aria-label="Ver detalhes de <?= $excursao->get_name() ?>">
              <?= $badge_class === 'disponivel'
                ? '+ infos e reservas'
                : 'Ver detalhes' ?>
          </a>
      </button>
    </div>
  </div>
</div> 