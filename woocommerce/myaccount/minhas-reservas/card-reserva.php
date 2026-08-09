<?php $res = $args['res'];
$pedido_de_terceiro = false;
if (count($res['passageiros']) === 1) {
  if ((int)$res['passageiros'][0]['order_user_id'] !== (int)wp_get_current_user()->ID) {
    $pedido_de_terceiro = true;
  }
}

?>
<div class="card-wrapper col-md-4" data-chave="<?= $res['chave']; ?>">

  <div class="booking-card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">

    <div class="card-img-wrapper position-relative">
      <?= $res['img']; ?>
      <div class="date-badge">
        <span class="day"><?= explode('/', $res['data'])[0]; ?></span>
        <span class="month">
          <?php
          // Converte data para exibir o mês abreviado
          $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
          echo $meses[intval(explode('/', $res['data'])[1]) - 1];
          ?>
        </span>
      </div>
      <?php
      if ($pedido_de_terceiro) {
      ?>
        <div class="terceiros-badge">
          <i class="bi bi-person-bounding-box"></i>
        </div>
      <?php
      }
      ?>
    </div>
    <?php if (in_array('pending_cancel', array_column($res['passageiros'], 'status'))): ?>
      <div class="alert alert-warning py-2 mb-2" style="font-size: 0.75rem;">
        <i class="bi bi-hourglass-split me-1"></i> Há uma solicitação de cancelamento aberta para esta reserva.
      </div>
    <?php endif; ?>
    <div class="card-body">
      <h5 class="card-title fw-bold mb-1"><?= $res['nome']; ?></h5>
      <p class="text-muted small mb-3">
        <i class="bi bi-geo-alt"></i> <?= $res['local_evento']; ?>
      </p>

      <div class="info-grid d-flex justify-content-between border-top border-bottom mb-3">
        <div class="area-horario">
          <small class="d-block text-uppercase text-muted fw-bold">Horário</small>
          <span><?= $res['horario']; ?></span>
        </div>
        <div class="area-embarque text-end">
          <small class="d-block text-uppercase text-muted fw-bold">Embarque</small>
          <a href="#"
            class="text-decoration-none fw-bold text-dark d-flex align-items-center"
            data-bs-toggle="modal"
            data-bs-target="#modal-info-embarque-<?= $res['chave']; ?>"
            style="cursor: pointer;">
            <div>
              <span><?= $res['local_embarque']; ?></span>
            </div>
            <i class="bi bi-info-circle ms-2 text-muted" style="font-size: 0.8rem;"></i>
          </a>


        </div>
      </div>

      <div class="d-grid gap-2">
        <button class="btn btn-outline-dark btn-sm rounded-pill py-2"
          data-bs-toggle="modal"
          data-bs-target="#modal-passageiros-<?= $res['chave']; ?>">
          <i class="bi bi-people-fill me-2"></i>
          Passageiros (<?= count($res['passageiros']); ?>)
        </button>

        <?php if ($res['wpp_link']): ?>
          <a href="<?= $res['wpp_link']; ?>" target="_blank" class="btn btn-success btn-sm rounded-pill py-2">
            <i class="bi bi-whatsapp me-2"></i> Grupo de WhatsApp
          </a>
        <?php endif; ?>
      </div>
    </div>
    <div class="action-bar d-flex justify-content-around align-items-center py-2 mb-1 border-top border-bottom border-light mx-n4 bg-light-subtle">

      <?php
      if (!$pedido_de_terceiro) {
      ?>
        <a href="<?= wc_get_endpoint_url('view-order', $res['order_id'], wc_get_page_permalink('myaccount')); ?>"
          class="action-item text-secondary">
          <i class="bi bi-receipt mb-1" style="font-size: 1.1rem;"></i>
          <span>Ver pedido</span>
        </a>
      <?php
      }
      ?>


      <a href="#"
        class="action-item text-secondary"
        data-bs-toggle="modal"
        data-bs-target="#modal-embarque-<?= $res['chave']; ?>">
        <i class="bi bi-geo-fill mb-1" style="font-size: 1.1rem;"></i>
        <span>Alterar embarque</span>
      </a>

      <!-- Ação de cancelamento de reserva (somente se a reserva não estiver em processo de cancelamento e se faltarem 7 dias ou mais para a data do evento) -->
      <?php if (!in_array('pending_cancel', array_column($res['passageiros'], 'status'))): 

        // Timestamp dia da excursão
        $data_excursao_iso = DateTimeImmutable::createFromFormat('d/m/Y', $res['data'])->setTime(0, 0);
        $data_excursao_timestamp = $data_excursao_iso->getTimestamp();

        // Timestamp atual
        $current_date = new DateTimeImmutable('now');
        $current_timestamp = $current_date->getTimestamp();


        // Exibir botão de cancelamento apenas se faltarem 7 dias ou mais para a data do evento
         if (($data_excursao_timestamp - $current_timestamp) >= (7 * 24 * 60 * 60)) :
          ?>
          <a href="#"
            class="action-item cancelar-option"
            data-bs-toggle="modal"
            data-bs-target="#modal-cancelar-<?= $res['chave']; ?>">
            <i class="bi bi-x-circle mb-1" style="font-size: 1.1rem;"></i>
            <span>Cancelar reserva</span>
          </a>
        <?php endif; ?>
      <?php endif; ?>


    </div>
    <div class="card-footer bg-white border-0 p-3 text-center border-top-0">
      <a href="<?= $res['url']; ?>" class="text-decoration-none small fw-bold">
        Ver página da excursão →
      </a>
    </div>
  </div>
</div>