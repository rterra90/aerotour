<?php $res = $args['res']; ?>
<div class="modal fade" id="modal-cancelar-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">

      <div class="secao-form">
        <div class="modal-header border-0 pb-0">
          <h5 class="fw-bold m-0 text-danger">Solicitar Cancelamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <p class="small text-muted mb-4">Selecione para quais passageiros deseja cancelar a reserva.</p>

          <form class="form-solicitar-cancelamento">
            <div class="list-group list-group-flush border rounded-3 overflow-hidden mb-2">
              <?php foreach ($res['passageiros'] as $p): ?>
                <label class="list-group-item d-flex align-items-center py-3 <?= ($p['status'] === 'pending_cancel') ? 'bg-light opacity-75' : ''; ?>">
                  <input class="form-check-input check-cancelar me-3" type="checkbox" name="passageiros[]" value="<?= $p['res_id']; ?>" <?= ($p['status'] === 'pending_cancel') ? 'disabled' : ''; ?>>
                  <div class="flex-grow-1">
                    <span class="fw-bold d-block"><?= $p['nome']; ?></span>
                    <small class="text-muted">CPF: <?= $p['doc']; ?></small>
                  </div>

                  <?php if ($p['status'] === 'pending_cancel'): ?>
                    <span class="badge bg-warning-subtle text-warning small">Pendente</span>
                  <?php endif; ?>
                </label>
              <?php endforeach; ?>
            </div>

            <!-- <div class="mb-4">
              <label class="form-label small fw-bold text-muted text-uppercase">Motivo (Opcional)</label>
              <textarea class="form-control" name="motivo_cancelamento" rows="2" placeholder="Conte-nos o motivo..."></textarea>
            </div> -->

            <input type="hidden" name="order_id" value="<?= $res['order_id']; ?>">
            <input type="hidden" name="variation_id" value="<?= $res['id']; ?>">

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-confirmar-cancelamento" disabled>
                Enviar Pedido de Cancelamento
              </button>
            </div>

          </form>
        </div>
      </div>

      <div class="secao-sucesso d-none p-5 text-center">
        <i class="bi bi-info-circle-fill text-warning" style="font-size: 4rem;"></i>
        <h4 class="fw-bold mt-3">Solicitação recebida</h4>
        <p class="text-muted">Sua solicitação de cancelamento foi registrada. O prazo para conclusão é de estorno, quando elegível, é de até 5 dias úteis.<br /> Você pode acompanhar o andamento da solicitação aqui mesmo na página Minhas reservas.</p>
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 mt-2" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>