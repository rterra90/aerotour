<?php
defined('ABSPATH') || exit;
global $wpdb;
$current_user_id = wp_get_current_user()->ID;

// 1. Busca simplificada: Pega tudo onde o usuário é o dono ou o passageiro
$reservas_db = $wpdb->get_results($wpdb->prepare(
  "SELECT * FROM `aer_reservas` WHERE user_id = %d OR order_user_id = %d",
  $current_user_id,
  $current_user_id
), ARRAY_A);

$ativas_agrupadas = [];
$canceladas_agrupadas = [];

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
    'nome' => $reg['p_nome'] ?: 'Não informado',
    'doc'  => $reg['p_cpf'] ?: '',
    'telefone' => $reg['p_telefone'] ?: '',
    'is_me' => ($reg['user_id'] == $current_user_id)
  ];

  // --- FILTRO 1: SE ESTIVER CANCELADA ---
  // Apenas se o usuário atual for o dono do pedido (para gerenciar cancelamentos)
  if (strpos($status, 'cancel') !== false && $reg['order_user_id'] == $current_user_id) {
    if (!isset($canceladas_agrupadas[$chave_cancelada])) {
      $canceladas_agrupadas[$chave_cancelada] = [
        'id' => $v_id,
        'nome' => substr($variacao->get_title(), 0, -5),
        'data' => $data_pt,
        'local_evento' => get_post_meta($variacao->get_parent_id(), 'local_evento', true),
        'passageiros' => []
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
  } else {
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
        <?php foreach ($futuras as $res):
          $product_id = $variacao->get_parent_id();
          $meta_embarques = get_post_meta($product_id, 'embarques', true);
          $meta_embarques = json_decode($meta_embarques, true);

          if (!empty($meta_embarques) && is_array($meta_embarques)) {
            foreach ($meta_embarques as $key => $emb) {
              $emb_id = $emb['embarqueId']; // ID para consulta

              // Consulta a tabela aer_embarques para obter os detalhes estáticos
              $detalhes_estaticos = $wpdb->get_row($wpdb->prepare(
                "SELECT nome, endereco, obs, link_mapa FROM `aer_embarques` WHERE id = %d",
                $emb_id
              ), ARRAY_A);

              if ($detalhes_estaticos) {
                // Mescla os detalhes do banco de dados com as informações de horários/taxas
                $meta_embarques[$key] = array_merge($meta_embarques[$key], $detalhes_estaticos);
              }
            }
          }

          // Agora passamos o objeto completo para o array da reserva
          $ativas_agrupadas[$chave_ativa]['meta_embarques'] = $meta_embarques;
        ?>




          <div class="card-wrapper col-md-4">

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
              </div>

              <div class="card-body">
                <h5 class="card-title fw-bold mb-1"><?= $res['nome']; ?></h5>
                <p class="text-muted small mb-3">
                  <i class="bi bi-geo-alt"></i> <?= $res['local_evento']; ?>
                </p>

                <div class="info-grid d-flex justify-content-between border-top border-bottom py-3 mb-3">
                  <div>
                    <small class="d-block text-uppercase text-muted fw-bold">Horário</small>
                    <span><?= $res['horario']; ?></span>
                  </div>
                  <div class="text-end">
                    <small class="d-block text-uppercase text-muted fw-bold">Embarque</small>
                    <span class="text-truncate d-inline-block" style="max-width: 150px;">
                      <?= $res['local_embarque']; ?>
                    </span>
                  </div>
                </div>

                <div class="d-grid gap-2">
                  <button class="btn btn-outline-dark btn-sm rounded-pill py-2"
                    data-bs-toggle="modal"
                    data-bs-target="#modal-<?= $res['chave']; ?>">
                    <i class="bi bi-people-fill me-2"></i>
                    Passageiros (<?= count($res['passageiros']); ?>)
                  </button>

                  <?php if ($res['wpp_link']): ?>
                    <a href="<?= $res['wpp_link']; ?>" target="_blank" class="btn btn-success btn-sm rounded-pill py-2">
                      <i class="bi bi-whatsapp me-2"></i> Grupo da Viagem
                    </a>
                  <?php endif; ?>
                </div>
              </div>
              <div class="action-bar d-flex justify-content-around align-items-center py-2 mb-1 border-top border-bottom border-light mx-n4 bg-light-subtle">

                <a href="<?= wc_get_endpoint_url('view-order', $res['order_id'], wc_get_page_permalink('myaccount')); ?>"
                  class="action-item text-secondary">
                  <i class="bi bi-receipt mb-1" style="font-size: 1.1rem;"></i>
                  <span>Ver pedido</span>
                </a>

                <a href="#"
                  class="action-item text-secondary"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-embarque-<?= $res['chave']; ?>">
                  <i class="bi bi-geo-fill mb-1" style="font-size: 1.1rem;"></i>
                  <span>Alterar embarque</span>
                </a>

                <a href="#"
                  class="action-item cancelar-option"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-cancelar-<?= $res['chave']; ?>">
                  <i class="bi bi-trash3 mb-1" style="font-size: 1.1rem;"></i>
                  <span>Cancelar reserva</span>
                </a>
              </div>
              <div class="card-footer bg-white border-0 p-3 text-center border-top-0">
                <a href="<?= $res['url']; ?>" class="text-decoration-none small fw-bold">
                  Ver página da excursão →
                </a>
              </div>
            </div>
          </div>

          <!-- Modal de visualização dos passageiros -->
          <div class="modal fade" id="modal-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
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
                      <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <div>
                          <span class="fw-bold d-block"><?= $p['nome']; ?></span>
                          <small class="text-muted d-block">Documento: <?= $p['doc']; ?></small>
                          <small class="text-muted d-block">Telefone: <?= $p['telefone']; ?></small>
                        </div>
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

          <!-- Modal de alteração de embarque -->
          <div class="modal fade" id="modal-embarque-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
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
                            <label class="list-group-item d-flex align-items-center py-3">
                              <input class="form-check-input check-passageiro me-3" type="checkbox" name="passageiros[]" value="<?= $p['nome']; ?>">
                              <div>
                                <span class="fw-bold d-block"><?= $p['nome']; ?></span>
                                <small class="text-muted">CPF: <?= $p['doc']; ?></small>
                              </div>
                            </label>
                          <?php endforeach; ?>
                        </div>
                      </div>

                      <div class="aviso-troca-embarque">
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
                    </form>
                  </div>
                </div>
                <div class="secao-sucesso d-none p-5 text-center">
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
      </div>
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