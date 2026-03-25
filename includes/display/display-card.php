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
} elseif ($tem_vagas) {
  $badge_class = 'disponivel';
  $badge_label = 'Vagas disponíveis';
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
<div class="col-lg-3 col-md-4 col-sm-5 col-8 display-flex-child reveal-card"
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
            <span class="day">16</span>
            <span class="month"> Mai </span>
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
      </a>



      <?php if ($badge_label): ?>
        <div class="badge badge-<?= $badge_class ?>"><?= $badge_label ?></div>
      <?php endif; ?>

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
          <?= $badge_class === 'disponivel'
            ? '+ infos e reservas'
            : 'Ver detalhes' ?>
        </a>
      </button>
    </div>
  </div>
</div>