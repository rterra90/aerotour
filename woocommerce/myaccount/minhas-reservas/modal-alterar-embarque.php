<?php
$res = $args['res'];
global $wpdb;

// Lógica de busca de embarques (Refatorada para dentro do modal)
$product_id = wc_get_product($res['id'])->get_parent_id();
$meta_embarques = json_decode(get_post_meta($product_id, 'embarques', true), true);

if ($meta_embarques) {
  foreach ($meta_embarques as $key => $emb) {
    $detalhes = $wpdb->get_row($wpdb->prepare("SELECT nome, endereco, obs, link_mapa FROM `aer_embarques` WHERE id = %d", $emb['embarqueId']), ARRAY_A);
    if ($detalhes) $meta_embarques[$key] = array_merge($meta_embarques[$key], $detalhes);
  }
}
?>
<div class="modal fade modal-opcoes-reserva" id="modal-embarque-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="fw-bold m-0">Solicitar Troca de Embarque</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="secao-form">
          <form class="form-solicitar-embarque">
            <div class="mb-4">
              <label class="form-label small fw-bold text-muted text-uppercase">1. Novo Local Desejado</label>
              <select class="form-select select-novo-ponto" name="novo_ponto" required>
                <option value="" selected disabled>Selecione...</option>
                <?php foreach ($meta_embarques as $emb):
                  $is_atual = ($emb['nome'] == $res['local_embarque']);
                  $disponivel = false;

                  // Valida disponibilidade na data da viagem
                  foreach ($emb['horarios'] as $h) {
                    foreach ($h['disponibilidade'] as $disp) {
                      if ($disp['disp_dia'] == $res['data'] && $disp['status'] == 'disponivel') {
                        $disponivel = true;
                      }
                    }
                  }
                ?>
                  <option value="<?= $emb['nome']; ?>"
                    <?= (!$disponivel || $is_atual) ? 'disabled' : ''; ?>>
                    <?= $emb['nome']; ?>
                    <?= $is_atual ? '(Atual)' : (!$disponivel ? '(Esgotado)' : ''); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="secao-passageiros-troca mt-4">
              <label class="form-label small fw-bold text-muted text-uppercase">2. Selecione os Passageiros</label>
              <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                <?php foreach ($res['passageiros'] as $index => $p): ?>
                  <label class="list-group-item d-flex align-items-center py-3 <?= ($p['status'] === 'pending_cancel') ? 'bg-light opacity-75' : ''; ?>">
                    <input class="form-check-input check-passageiro me-3" type="checkbox" name="passageiros[]" value="<?= $p['nome']; ?>" <?= ($p['status'] === 'pending_cancel') ? 'disabled' : ''; ?>>
                    <div class="flex-grow-1">
                      <span class="fw-bold d-block"><?= $p['nome']; ?></span>
                      <small class="text-muted">CPF: <?= $p['doc']; ?></small>
                    </div>
                    <?php if ($p['status'] === 'pending_cancel'): ?>
                      <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle">
                        <span class="badge bg-warning-subtle text-warning small">Cancelamento pendente</span>
                      </span>
                    <?php endif; ?>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="aviso">
              <small class="text-muted d-block">
                <i class="bi bi-info-circle me-1"></i> A solicitação de troca de embarque está sujeita à disponibilidade e aprovação da equipe <?= bloginfo('name'); ?>.
              </small>
            </div>

            <input type="hidden" name="excursao" value="<?= $res['nome']; ?>">
            <input type="hidden" name="data_viagem" value="<?= $res['data']; ?>">
            <input type="hidden" name="ponto_atual" value="<?= $res['local_embarque']; ?>">
            <input type="hidden" name="order_id" value="<?= $res['order_id']; ?>">

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                Enviar Solicitação
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="secao-sucesso d-none p-5 text-cminhas-reservas.phpenter">
        <div class="mb-4">
          <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
        </div>
        <h4 class="fw-bold">Solicitação Enviada!</h4>
        <p class="text-muted">Recebemos seu pedido de alteração. Nossa equipe analisará a disponibilidade e você receberá uma confirmação por e-mail em breve.</p>
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 mt-3" data-bs-dismiss="modal">Entendido</button>
      </div>
    </div>


  </div>
</div>