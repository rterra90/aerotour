<?php
$img_url = wp_get_attachment_image_src(
  get_post_thumbnail_id($excursao->get_id()),
  'medium'
);
$local_evento = get_post_meta($excursao->get_id(), 'local_evento', true);
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
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-12 display-flex-child reveal-card" style="--card-delay: <?= $card_index ?? 0 ?>;">
  <div class="excursion-card-modern">

    <div class="card-header">
      <?php if (!empty($datas_array)):
        $parts = explode('/', $datas_array[0]);
        $dia = $parts[0];
        // Simulação simples de mês, ajuste conforme sua lógica de tradução
        $meses = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];
        $mes_index = intval($parts[1] ?? 1) - 1;
        $mes = $meses[$mes_index] ?? '---';
      ?>
        <div class="date-badge-overlay">
          <span class="day"><?= $dia ?></span>
          <span class="month"><?= $mes ?></span>
        </div>
      <?php endif; ?>

      <a href="<?= $excursao->get_permalink() ?>" class="image-link">
        <img loading="lazy" src="<?= $img_url[0] ?>" alt="<?= $excursao->name ?>">
      </a>

      <?php if (isset($badge_label)): ?>
        <div class="status-badge <?= $badge_class ?>"><?= $badge_label ?></div>
      <?php endif; ?>
    </div>

    <div class="card-body">
      <h3 class="event-title">
        <a href="<?= $excursao->get_permalink() ?>"><?= $excursao->name ?></a>
      </h3>

      <div class="event-location">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
          <circle cx="12" cy="10" r="3"></circle>
        </svg>
        <span><?= explode('/', $local_evento)[0] ?> / <?= explode('/', $local_evento)[1] ?? '' ?></span>
      </div>

      <div class="card-footer-action">
        <a href="<?= $excursao->get_permalink() ?>" class="cta-button">
          <?= $badge_class === 'disponivel' ? '+ infos e reservas' : 'Ver detalhes' ?>
        </a>
      </div>
    </div>
  </div>
</div>