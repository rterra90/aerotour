<?php $res = $args['res']; ?>
<div class="modal fade" id="modal-passageiros-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="fw-bold m-0">Passageiros nesta reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="small text-muted mb-3">Embarque: <strong><?= $res['local_embarque']; ?></strong></p>
        <ul class="list-group list-group-flush">
          <?php foreach ($res['passageiros'] as $p): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3" data-res-id="<?= $p['res_id'] ?>">
              <div>
                <span class="fw-bold d-block"><?= $p['nome']; ?></span>
                <small class="text-muted d-block">Documento: <?= cpf_mask($p['doc']); ?></small>
                <small class="text-muted d-block">Telefone: <?= $p['telefone']; ?></small>
              </div>
              <?php if ($p['status'] === 'pending_cancel'): ?>
                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle">
                  <span class="badge bg-warning-subtle text-warning small">Cancelamento pendente</span>
                </span>
              <?php endif; ?>
              <?php if ($p['is_me']): ?>
                <span class="badge rounded-pill bg-primary-subtle text-primary">Você</span>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>