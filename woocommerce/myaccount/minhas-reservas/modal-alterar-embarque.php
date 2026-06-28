<?php
// CONTROLADORES / CONFIGURAÇÕES
$exibe_horarios_inativos = true; // Controle manual inicial (true para listar inativos como disabled)

$res = $args['res'];
global $wpdb;

// O id do produto na reserva agora é a nossa Variação
$variation_id = $res['id'];
$nome_tabela = $wpdb->prefix . 'embarques';

// Consome a nova estrutura de metadados da variação
$meta_embarques = json_decode(get_post_meta($variation_id, '_embarques_config', true), true);
$opcoes_embarque = [];

if ($meta_embarques) {
    foreach ($meta_embarques as $emb) {
        // Busca os detalhes no banco
        $detalhes = $wpdb->get_row($wpdb->prepare("SELECT nome, endereco, obs, link_mapa FROM `$nome_tabela` WHERE id = %d", $emb['embarque_id']), ARRAY_A);
        if ($detalhes) {
            $horarios_disponiveis = [];

            // Mapeia os horários considerando a flag de exibição de inativos
            foreach ($emb['horarios'] as $h) {
                $is_ativo = (isset($h['disponivel']) && $h['disponivel'] === true);
                
                if ($is_ativo || $exibe_horarios_inativos) {
                    $horarios_disponiveis[] = [
                        'horario'   => $h['horario'],
                        'disponivel' => $is_ativo
                    ];
                }
            }

            // Só adiciona o ponto se houver algum horário para mostrar
            if (!empty($horarios_disponiveis)) {
                $opcoes_embarque[] = [
                    'id'       => $emb['embarque_id'],
                    'nome'     => $detalhes['nome'],
                    'horarios' => $horarios_disponiveis,
                    'is_atual' => ($detalhes['nome'] === $res['local_embarque'])
                ];
            }
        }
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
              <select class="form-select select-novo-ponto" name="novo_ponto" required data-embarques="<?= htmlspecialchars(json_encode($opcoes_embarque), ENT_QUOTES, 'UTF-8'); ?>">
                <option value="" selected disabled>Selecione...</option>
                <?php foreach ($opcoes_embarque as $emb): 
                  // Verifica se tem ao menos um horário ativo utilizável
                  $tem_ativos = false;
                  foreach ($emb['horarios'] as $h) {
                      if ($h['disponivel']) { $tem_ativos = true; break; }
                  }
                  
                  $disabled = (!$tem_ativos || $emb['is_atual']) ? 'disabled' : '';
                  $sufixo = $emb['is_atual'] ? '(Atual)' : (!$tem_ativos ? '(Indisponível)' : '');
                ?>
                  <option value="<?= esc_attr($emb['nome']); ?>" <?= $disabled; ?>>
                    <?= esc_html($emb['nome']); ?> <?= $sufixo; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-4 container-horarios" style="display: none;">
                <label class="form-label small fw-bold text-muted text-uppercase">Horário de Embarque</label>
                <div class="opcoes-horarios"></div>
            </div>

            <div class="secao-passageiros-troca mt-4">
              <label class="form-label small fw-bold text-muted text-uppercase">2. Selecione os Passageiros</label>
              <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                <?php foreach ($res['passageiros'] as $index => $p): ?>
                  <label class="list-group-item d-flex align-items-center py-3 <?= ($p['status'] === 'pending_cancel') ? 'bg-light opacity-75' : ''; ?>">
                    <input class="form-check-input check-passageiro me-3" type="checkbox" name="passageiros[]" value="<?= esc_attr($p['nome']); ?>" <?= ($p['status'] === 'pending_cancel') ? 'disabled' : ''; ?>>
                    <div class="flex-grow-1">
                      <span class="fw-bold d-block"><?= esc_html($p['nome']); ?></span>
                      <small class="text-muted">CPF: <?= esc_html($p['doc']); ?></small>
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

            <input type="hidden" name="excursao" value="<?= esc_attr($res['nome']); ?>">
            <input type="hidden" name="data_viagem" value="<?= esc_attr($res['data']); ?>">
            <input type="hidden" name="ponto_atual" value="<?= esc_attr($res['local_embarque']); ?>">
            <input type="hidden" name="order_id" value="<?= esc_attr($res['order_id']); ?>">

            <div class="modal-footer mt-4 px-0 pb-0">
               <button type="submit" class="btn btn-primary w-100 btn-enviar-solicitacao">
                Enviar Solicitação
              </button>
            </div>
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

<script>
(function() {
    const modalId = 'modal-embarque-<?= $res['chave']; ?>';
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;
    
    const selectPonto = modalEl.querySelector('.select-novo-ponto');
    const containerHorarios = modalEl.querySelector('.container-horarios');
    const opcoesHorarios = modalEl.querySelector('.opcoes-horarios');
    const btnSubmit = modalEl.querySelector('.btn-enviar-solicitacao');
    
    // Função auxiliar para validar se o botão deve estar ativo
    function alternarEstilosRadios(clickedElement) {
        const radios = opcoesHorarios.querySelectorAll('input[type="radio"]');

        if(clickedElement && clickedElement.type === 'radio'){
          const _parent = clickedElement.parentElement
          const isAtivo = _parent.classList.contains('ativo');
          if(!isAtivo){
            radios.forEach(_radio => {
              _radio.parentElement.classList.remove('ativo')
            })
            _parent.classList.add('ativo');
          }
        }
    }
    
    selectPonto.addEventListener('change', function() {
        const embarquesData = JSON.parse(this.dataset.embarques || '[]');
        const selectedName = this.value;
        const embarque = embarquesData.find(e => e.nome === selectedName);
        opcoesHorarios.innerHTML = '';
        
        if (embarque && embarque.horarios.length > 0) {
            containerHorarios.style.display = 'block';
            
            // Filtra os ativos para lógica de contagem
            const horariosAtivos = embarque.horarios.filter(h => h.disponivel);
            
            if (embarque.horarios.length === 1 && horariosAtivos.length === 1) {
                // Apenas um horário total e ele está ativo
                opcoesHorarios.innerHTML = `
                    <div class="alert alert-light border p-2 mb-0 d-inline-block">
                        <i class="bi bi-clock me-1"></i> <strong>${embarque.horarios[0].horario}</strong>
                    </div>
                    <input type="hidden" name="novo_horario" value="${embarque.horarios[0].horario}">
                `;
            } else {
                // Múltiplos horários ou cenário com inativos listados: renderiza os radios
                let html = '<div class="d-flex flex-wrap gap-3 mt-2">';
                
                embarque.horarios.forEach((h, index) => {
                    const idRadio = `hora_${modalId}_${index}`;
                    const isDisabled = !h.disponivel ? 'disabled' : '';
                    const opacityClass = !h.disponivel ? 'opacity-50 text-decoration-line-through' : '';
                    const labelSufixo = !h.disponivel ? ' (Esgotado)' : '';
                    
                    html += `
                        <div class="form-check border rounded px-3 py-2 bg-light ${opacityClass}">
                            <input class="form-check-input mt-1 radio-horario" type="radio" name="novo_horario" id="${idRadio}" value="${h.horario}" ${isDisabled} required>
                            <label class="form-check-label ms-1" style="cursor:${h.disponivel ? 'pointer' : 'not-allowed'};" for="${idRadio}">${h.horario}<small style="font-size: .6rem; text-transform: uppercase; font-weight: 500;">${labelSufixo}</small></label>
                        </div>
                    `;
                });
                html += '</div>';
                opcoesHorarios.innerHTML = html;
                
                // Adiciona ouvinte para validar quando o cliente escolher o rádio
                opcoesHorarios.querySelectorAll('.radio-horario').forEach(radio => {
                    radio.addEventListener('change', (_e) => alternarEstilosRadios(_e.target));
                });
            }
        } else {
            containerHorarios.style.display = 'none';
        }
        
        // Executa a validação inicial do estado ao mudar de ponto
        // validarFormulario();
    });
})();
</script>