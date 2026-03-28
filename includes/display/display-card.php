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

$disponibilidades = [];
foreach ($variacoes as $v) {
  if (get_post_meta($v['variation_id'], 'encerrar_vendas', true) !== 'yes') {
    if (isset($v['max_qty'])) {
      $disponibilidades[] = empty($v['max_qty']) ? 0 : $v['max_qty'];
    }
  }
}

$ultimos = array_filter($disponibilidades, function ($d) {
  $r = $d < 10 && $d > 0;
  return $r;
});

$esgotado = count(array_filter($disponibilidades, function ($v) {
  return $v !== 0;
})) === 0;

$show_badge = false;
$disponivel = true;
$badge_class = '';
$badge_label = '';
if (empty($variacoes)) {
  $badge_label = 'Em breve...';
  $badge_class = 'em-breve';
} elseif (empty($disponibilidades)) {
  $badge_label = 'Vendas encerradas';
  $badge_class = 'encerrado';
  $disponivel = false;
  $show_badge = true;
} elseif (!empty($ultimos)) {
  $badge_label = 'Últimas vagas!';
  $badge_class = 'ultimas-vagas';
  $show_badge = true;
} elseif ($esgotado) {
  $badge_label = 'Esgotado';
  $badge_class = 'esgotado';
  $disponivel = false;
  $show_badge = true;
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
<div class="col-lg-3 col-md-4 col-sm-5 col-9 display-flex-child reveal-card"
  style="--card-delay: <?= $card_index ?? 0 ?>;"
  data-nome="<?= esc_attr($excursao->get_name()) ?>"
  data-id="<?= $excursao->get_id() ?>">

  <div class="default-card excursion-card <?= isset($color_scheme)
                                            ? $color_scheme
                                            : 'dark' ?>">
    <div class="image-container">
      <a href="<?= $excursao->get_permalink() ?>">
        <img loading="lazy" class="<?= $badge_class ?>" src="<?= $img_url[0] ?>" alt="<?= $excursao->name ?>">


        <div class="date-badge">

          <?php
          if (count($datas_array) === 1) {
            $dia = explode('/', $datas_array[0])[0];
            $mes = explode('/', $datas_array[0])[1];
          ?>
            <span class="day"><?= $dia ?></span>
            <span class="month"> <?= $mes ?> </span>
          <?php
          } elseif (count($datas_array) > 1) {
            $dia_inicial = explode('/', $datas_array[0])[0];
            $mes_inicial = explode('/', $datas_array[0])[1];
            $dia_final = explode('/', end($datas_array))[0];
            $mes_final = explode('/', end($datas_array))[1];

            if ($mes_inicial === $mes_final) {
              $termo = count($datas_array) === 2 ? 'e' : 'a';
              echo "<div class='date-range'>";
              echo "<span class='day'>{$dia_inicial} <span> {$termo} </span> {$dia_final}</span>";
              echo "<span class='month'>{$mes_inicial}</span>";
              echo "</div>";
            } else {
              echo "<div class='date-range-multi'>";
              echo '<div class="first-date">';
              echo "<span class='day'>{$dia_inicial}</span>";
              echo "<span class='month'>{$mes_inicial}</span>";
              echo "</div>";
              echo "<hr />";
              echo '<div class="second-date">';
              echo "<span class='day'>{$dia_final}</span>";
              echo "<span class='month'>{$mes_final}</span>";
              echo "</div>";
              echo "</div>";
            }
          }
          ?>

        </div>
        <?php if ($show_badge): ?>
          <div class="badge card-disp-badge badge-<?= $badge_class ?>"><?= $badge_label ?></div>
        <?php endif; ?>
      </a>





    </div>
    <div class="info">
      <!-- Título  -->
      <div class="title">
        <span>Excursão</span>
        <a href="<?= $excursao->get_permalink() ?>" alt="<?= $excursao->name ?>"><?= $excursao->name ?></a>
      </div>

      <!-- Local -->
      <div class="location">
        <?php
        $nome_local = explode('/', $local_evento)[0] ?? '';
        $cidade_local = explode('/', $local_evento)[1] ?? '';
        ?>
        <div class="location-inner">
          <div class="location-icon">
            <i class="bi bi-geo-alt-fill"></i>
          </div>
          <div class="location-text">
            <p><?= $nome_local; ?></p>
            <span><?= $cidade_local; ?></span>
          </div>
        </div>


      </div>

      <!-- Features list -->
      <div class="features">
        <ul>
          <li><i class="bi bi-bus-front me-2"></i> Transporte executivo</li>
          <li><i class="bi bi-fan me-2"></i>Ar condicionado</li>
          <li><i class="bi bi-whatsapp me-2"></i>Grupo exclusivo</li>
        </ul>
      </div>


      <!-- Botão -->
      <button class="cta">
        <a href="<?= $excursao->get_permalink() ?>" aria-label="Ver detalhes de <?= $excursao->get_name() ?>">
          <?= $disponivel ? '+ infos e reservas' : 'Ver detalhes' ?>
        </a>
      </button>
    </div>
  </div>
</div>