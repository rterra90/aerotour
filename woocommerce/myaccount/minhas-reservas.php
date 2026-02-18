<?php
defined('ABSPATH') || exit;
global $wpdb;
$current_user_id = wp_get_current_user()->ID;
$ativas_agrupadas = [];
$canceladas_agrupadas = [];



// 1. Busca de dados: obtém todas as reservas associadas ao usuário (tanto como comprador quanto como passageiro)
$reservas_db = $wpdb->get_results($wpdb->prepare(
  "SELECT * FROM `aer_reservas` WHERE user_id = %d OR order_user_id = %d",
  $current_user_id,
  $current_user_id
), ARRAY_A);



foreach ($reservas_db as $reg) {
  $v_id = $reg['variation_id'];
  $local_embarque = $reg['embarque'] ?: 'A definir';
  $status = $reg['status'];


  // Chave para agrupar reservas ATIVAS (Variação + Local)
  $chave_ativa = $v_id . '_' . sanitize_title($local_embarque);
  // Chave para agrupar CANCELADAS (Apenas Variação, pois o embarque não importa mais para o cancelado)
  $chave_cancelada = $v_id;

  $variacao = wc_get_product($v_id);
  if (!$variacao) continue;

  $data_pt = $variacao->get_attribute('dia'); // "dd/mm/aaaa"
  $data_iso = implode('-', array_reverse(explode('/', $data_pt))); // "aaaa-mm-dd"

  // Dados do passageiro
  $passageiro = [
    'res_id' => $reg['ID'],
    'nome' => $reg['p_nome'] ?: 'Não informado',
    'doc'  => $reg['p_cpf'] ?: '',
    'telefone' => $reg['p_telefone'] ?: '',
    'status' => $reg['status'],
    'is_me' => ($reg['user_id'] == $current_user_id)
  ];

  // --- FILTRO 1: SE ESTIVER CANCELADA ---
  // Apenas se o usuário atual for o dono do pedido (para gerenciar cancelamentos)
  if ($status == 'cancel' && $reg['order_user_id'] == $current_user_id) {
    if (!isset($canceladas_agrupadas[$chave_cancelada])) {
      $canceladas_agrupadas[$chave_cancelada] = [
        'id' => $v_id,
        'nome' => substr($variacao->get_title(), 0, -5),
        'data' => $data_pt,
        'local_evento' => get_post_meta($variacao->get_parent_id(), 'local_evento', true),
        'passageiros' => [],



      ];
    }
    $canceladas_agrupadas[$chave_cancelada]['passageiros'][] = $passageiro;
    continue; // Sai deste loop, não entra nas listas de ativas/passadas
  }

  // --- FILTRO 2: SE ESTIVER ATIVA (E NÃO PASSADA) ---
  if (!isset($ativas_agrupadas[$chave_ativa])) {
    $ativas_agrupadas[$chave_ativa] = [
      'id' => $v_id,
      'order_id' => $reg['order_id'],
      'chave' => $chave_ativa,
      'nome' => substr($variacao->get_title(), 0, -5),
      'data' => $data_pt,
      'data_std' => $data_iso,
      'local_evento' => get_post_meta($variacao->get_parent_id(), 'local_evento', true),
      'local_embarque' => $local_embarque,
      'horario' => substr($reg['horario'], 0, -3) ?: '00:00',
      'img' => $variacao->get_image('medium'),
      'url' => get_permalink($variacao->get_parent_id()),
      'wpp_link' => get_post_meta($v_id, 'link_wpp', true),
      'passageiros' => []
    ];
  }
  $ativas_agrupadas[$chave_ativa]['passageiros'][] = $passageiro;
}

// 2. Ordenação Cronológica (Mais próxima primeiro)
usort($ativas_agrupadas, function ($a, $b) {
  return strtotime($a['data_std']) - strtotime($b['data_std']);
});

// 3. Separação por Status
$futuras = [];
$passadas = [];

foreach ($ativas_agrupadas as $reserva_ativa) {
  $time_reserva = strtotime($reserva_ativa['data_std']);
  if (($time_reserva + 86400) < time()) {
    $passadas[] = $reserva_ativa;
  } //inclui em 'passadas' após 24h do dia da excursão
  else {
    $futuras[] = $reserva_ativa;
  }
}


?>
<section id="minhas-reservas" class="container">
  <div class="page-header mb-3">
    <h1 class="fw-bold">Minhas Reservas</h1>
    <p class="text-muted">Gerencie suas próximas viagens com a Aerotour.</p>
  </div>
  <div class="reservas-wrapper py-3">
    <h2 class="mb-4 fw-bold">Próximas Excursões</h2>

    <?php if (count($futuras) > 0): ?>
      <div class="row overflow-auto g-4">
        <!-- Prepara as variáveis que serão usadas no contexto dos cards e modais de cada reserva -->
        <?php foreach ($futuras as $res):
          $product_id = $variacao->get_parent_id();

          // Card principal da reserva
          get_template_part('woocommerce/myaccount/minhas-reservas/card', 'reserva', ['res' => $res]);
        ?>
        <?php endforeach; ?>
      </div>

      <div class="modais-container">
        <?php foreach ($futuras as $res): ?>
          <?php
          get_template_part('woocommerce/myaccount/minhas-reservas/modal', 'passageiros', ['res' => $res]);
          get_template_part('woocommerce/myaccount/minhas-reservas/modal', 'alterar-embarque', ['res' => $res]);
          get_template_part('woocommerce/myaccount/minhas-reservas/modal', 'cancelamento', ['res' => $res]);
          get_template_part('woocommerce/myaccount/minhas-reservas/modal', 'info-embarque', ['res' => $res]);
          ?>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-muted">Nada aqui por enquanto...</p>
    <?php endif; ?>
  </div>

  <?php if (count($passadas) > 0): ?>
    <div id="reservas_passadas_container" class="pt-4">
      <h2 class="mb-4 fw-bold text-muted">Viagens Anteriores</h2>
      <div class="row g-3 pb-2">
        <?php foreach (array_reverse($passadas) as $res_p): ?>
          <div class="col-12">
            <div class="past-booking-item py-3 px-2 rounded-4">
              <div class="p_imagem flex-shrink-0">
                <?= str_replace('thumb', '60x60', $res_p['img']); ?>
              </div>

              <div class="p_info flex-grow-1 ms-3">
                <h6 class="fw-bold mb-0 text-dark"><?= $res_p['nome']; ?></h6>
                <div class="d-flex flex-column flex-wrap mt-1">
                  <span class="small text-muted d-block span-data">
                    <i class="bi bi-calendar3"></i> <?= $res_p['data']; ?>
                  </span>
                  <span class="small text-muted d-block">
                    <i class="bi bi-geo-alt"></i> <?= $res_p['local_evento']; ?>
                  </span>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if (count($canceladas_agrupadas) > 0): ?>
    <section id="secao-cancelados" class="mt-5 pb-5">
      <div class="d-flex justify-content-between align-items-center accordion-header-custom"
        data-bs-toggle="collapse"
        data-bs-target="#collapseCancelados"
        role="button"
        aria-expanded="false">

        <h2 class="h5 fw-bold text-muted mb-0">
          Reservas canceladas (<?= count($canceladas_agrupadas); ?>)
        </h2>

        <i class="transition-icon">
          < </i>
      </div>

      <div class="collapse" id="collapseCancelados">
        <div class="row g-3">
          <?php foreach ($canceladas_agrupadas as $cancel): ?>
            <div class="col-12">
              <div class="cancel-booking-item d-flex align-items-center p-3 border-bottom">
                <div class="flex-grow-1">
                  <h6 class="fw-bold mb-0 text-secondary"><?= $cancel['nome']; ?></h6>
                  <small class="text-muted opacity-75">
                    <?= $cancel['data']; ?> <span>• <?= count($cancel['passageiros']); ?> passageiro(s)</span>
                  </small>
                </div>
                <div class="text-end">
                  <span class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                    data-bs-toggle="modal"
                    data-role="button"
                    data-bs-target="#modal-cancel-<?= $cancel['id']; ?>">
                    Ver detalhes
                  </span>
                </div>
              </div>
            </div>
            <div class="modal fade" id="modal-cancel-<?= $cancel['id']; ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0">
                  <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0 text-danger">Detalhes do Cancelamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <p class="small text-muted mb-3">Excursão: <strong><?= $cancel['nome']; ?></strong></p>
                    <ul class="list-group list-group-flush">
                      <?php foreach ($cancel['passageiros'] as $r): ?>
                        <li class="list-group-item px-0 py-3">
                          <span class="fw-bold d-block text-dark"><?= $r['nome']; ?></span>
                          <div class="d-flex justify-content-between">
                            <small class="text-muted">Doc: <?= $r['doc']; ?></small>
                            <span class="badge bg-danger-subtle text-danger rounded-pill">Cancelado</span>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                    <div class="mt-4 p-3 bg-light rounded-3">
                      <small class="text-muted d-block">
                        <i class="bi bi-info-circle me-1"></i> Reservas canceladas podem levar alguns dias para o estorno ser processado, dependendo do método de pagamento.
                      </small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</section>
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/minhas-reservas.js"></script>