<?php
$res = $args['res'];
global $wpdb;

// Busca as informações completas do ponto de embarque atual pelo nome
$info_ponto = $wpdb->get_row($wpdb->prepare(
  "SELECT * FROM `aer_embarques` WHERE nome = %s",
  $res['local_embarque']
), ARRAY_A);
?>

<div class="modal fade" id="modal-info-embarque-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="fw-bold m-0"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Detalhes do Embarque</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <?php if ($info_ponto): ?>
          <div class="mb-4 text-center">
            <h4 class="fw-bold mb-1"><?= $info_ponto['nome']; ?></h4>
            <p class="mb-0 mt-3 small fw-bold">Endereço</p>
            <p><?= $info_ponto['endereco']; ?></p>
            <?php if (!empty($info_ponto['obs'])): ?>
              <p class="mb-0 mt-3 small fw-bold">Referência para embarque</p>
              <p class="mb-0 small"><?= $info_ponto['obs']; ?></p>
            <?php endif; ?>

          </div>

          <div class="d-grid gap-2">
            <?php if (!empty($info_ponto['link_mapa'])): ?>
              <a class="text-center text-decoration-underline" href="<?= $info_ponto['link_mapa']; ?>" target="_blank">
                <i class="bi bi-map me-2"></i> Abrir no Google Maps
              </a>
            <?php endif; ?>
            <button type="button" class="btn btn-link text-secondary btn-sm" data-bs-dismiss="modal">Fechar</button>
          </div>
        <?php else: ?>
          <div class="text-center py-4">
            <i class="bi bi-exclamation-triangle text-warning display-4"></i>
            <p class="mt-3">Informações detalhadas não encontradas para este ponto.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>