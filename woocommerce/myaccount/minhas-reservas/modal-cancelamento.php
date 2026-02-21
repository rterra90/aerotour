<?php $res = $args['res'];
$show_placeholder = false; ?>
<div class="modal fade" id="modal-cancelar-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">

      <?php
      if ($show_placeholder) {
      ?>
        <div class="modal-header border-0 pb-0">
          <h5 class="fw-bold m-0 text-danger">Solicitar Cancelamento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4 text-center">
          <div class="mb-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle" style="width: 80px; height: 80px;">
              <i class="bi bi-tools" style="font-size: 2.5rem;"></i>
            </div>
          </div>

          <h4 class="fw-bold">Funcionalidade em Manutenção</h4>
          <p class="text-muted mb-4">
            Estamos atualizando nosso sistema de cancelamentos.
            Por enquanto, você pode fazer sua solicitação pelo nosso WhatsApp ou enviando para o nosso email contato@aerotour.com.br.
          </p>

          <div class="bg-light p-3 rounded-3 mb-4 text-start">
            <small class="text-dark d-block mb-1 fw-bold"><i class="bi bi-info-circle me-1"></i> Como proceder:</small>
            <small class="text-muted">
              Clique no botão abaixo para falar com um atendente. Informe o número do seu pedido <strong>#<?= $res['order_id']; ?></strong> e os nomes dos passageiros que deseja cancelar.
            </small>
          </div>

          <div class="d-grid">
            <a href="https://wa.me/5519997477465?text=Olá! Gostaria de solicitar o cancelamento de passageiros no pedido #<?= $res['order_id']; ?> (Excursão: <?= $res['nome']; ?>)"
              target="_blank"
              class="btn btn-success py-3 rounded-pill fw-bold shadow-sm mb-2">
              <i class="bi bi-whatsapp me-2"></i> Chamar no WhatsApp
            </a>
            <button type="button" class="btn btn-link text-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
          </div>

        </div>
      <?php
      } else {
      ?>
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

              <div class="aviso">
                <small class="text-muted d-block">
                  <i class="bi bi-info-circle me-1"></i> As solicitações de cancelamento serão processadas conforme os <a href="<?= get_privacy_policy_url() ?>" target="_blank">Termos e Condições</a> vigentes.
                </small>
              </div>

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
          <p class="text-muted">Sua solicitação de cancelamento foi registrada. O prazo para conclusão e estorno, quando elegível, é de até 10 dias.<br /></p>

          <div class="alert alert-light border-0 small">
            <i class="bi bi-clock-history me-1"></i>
            Prazo para conclusão do pedido: <strong class="data-limite-cancelamento">--/--/----</strong>
          </div>

          <button type="button" class="btn btn-outline-secondary rounded-pill px-4 mt-2" data-bs-dismiss="modal">Fechar</button>
        </div>


      <?php
      }
      ?>
    </div>

  </div>
</div>