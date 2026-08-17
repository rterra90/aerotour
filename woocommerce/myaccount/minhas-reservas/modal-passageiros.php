<?php $res = $args['res']; ?>
<div class="modal fade" id="modal-passageiros-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true" data-res-chave="<?= $res['chave']; ?>">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="fw-bold m-0" id="modal-title-<?= $res['chave']; ?>">Passageiros nesta reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body modal-body-slider">
        
        <!-- WRAPPER DO SLIDER -->
        <div class="slider-wrapper" id="slider-wrapper-<?= $res['chave']; ?>">
            
          <!-- TELA 1: LISTA DE PASSAGEIROS -->
          <div class="slider-pane lista-pane" id="body-lista-passageiros-<?= $res['chave']; ?>">
            <p class="small text-muted mb-3">Embarque: <strong><?= $res['local_embarque']; ?></strong></p>
            <ul class="list-group list-group-flush">
              <?php foreach ($res['passageiros'] as $p): ?>
                <li class="list-group-item d-flex justify-content-between align-items-end px-0 py-3">
                  <div>
                    <span class="fw-bold d-block"><?= $p['nome']; ?></span>
                    <small class="text-muted d-block" style="font-size:smaller;font-family: monospace;line-height: 1.2;">Documento: <?= cpf_mask($p['doc']); ?></small>
                    <small class="text-muted d-block" style="font-size:smaller;font-family: monospace;line-height: 1.2;">Telefone: <?= $p['telefone']; ?></small>
                    <small class="text-muted d-block" style="font-size:smaller;font-family: monospace;line-height: 1.2;">Data de nascimento: <?= data_to_dmy($p['data_nasc']); ?></small>
                  </div>
                  
                  <div class="d-flex flex-column align-items-end gap-2">
                      <div class="d-flex gap-2 align-items-center">
                        <?php if ($p['status'] === 'pending_cancel'): ?>
                            <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle small">Cancelamento pendente</span>
                        <?php endif; ?>
                        <?php if ($p['is_me']): ?>
                            <span class="badge rounded-pill bg-primary-subtle accent-color-text">Você</span>
                        <?php endif; ?>
                      </div>
                      
                      <button type="button" 
                              class="btn btn-sm btn-outline-secondary mt-1 edit-pax-btn"
                              data-id="<?= $p['res_id'] ?? ''; ?>"
                              data-res-chave="<?= $res['chave']; ?>"
                              data-nome="<?= $p['nome']; ?>"
                              data-doc="<?= $p['doc']; ?>"
                              data-telefone="<?= $p['telefone']; ?>"
                              data-data-nasc="<?= $p['data_nasc']; ?>"
                              onclick="openEditScreen(this, '<?= $res['chave']; ?>')"> 
                          <i class="bi bi-pencil-square"></i> Editar dados
                      </button>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- TELA 2: FORMULÁRIO DE EDIÇÃO -->
          <div class="slider-pane edit-form-pane faded" id="body-edit-passageiro-<?= $res['chave']; ?>">
            <div id="solic-edit-container-<?= $res['chave']; ?>">
              <button type="button" class="btn btn-link text-decoration-none p-0 mb-3" onclick="closeEditScreen('<?= $res['chave']; ?>')">
                  <i class="bi bi-arrow-left"></i> Voltar para lista
              </button>

              <!-- Adicionado onsubmit e sufixo no ID -->
              <form id="form-solicitar-edicao-<?= $res['chave']; ?>" data-res-chave="<?= $res['chave']; ?>" action="/api/solicitar-edicao-passageiro" method="POST" onsubmit="submitSolicitacaoEditPax(event, '<?= $res['chave']; ?>')">
                <div class="alert alert-info small">
                    Altere apenas os dados que deseja atualizar. As solicitações serão analisadas antes de serem aplicadas à reserva.
                </div>
                
                <input type="hidden" name="pax_id" id="edit-passageiro-id-<?= $res['chave']; ?>">
    
                <!-- Adicionado data-res-chave e data-type nos inputs para facilitar a delegação no JS -->
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Nome Completo</label>
                    <input type="text" class="form-control edit-pax-input" name="novo_nome" id="edit-nome-<?= $res['chave']; ?>" data-res-chave="<?= $res['chave']; ?>" data-type="nome" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">CPF</label>
                    <input type="text" class="form-control edit-pax-input" name="novo_doc" id="edit-doc-<?= $res['chave']; ?>" data-res-chave="<?= $res['chave']; ?>" data-type="doc" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Celular (WhatsApp)</label>
                    <input type="text" class="form-control edit-pax-input" name="novo_telefone" id="edit-telefone-<?= $res['chave']; ?>" data-res-chave="<?= $res['chave']; ?>" data-type="telefone" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Data de nascimento</label>
                    <input type="text" class="form-control edit-pax-input" name="nova_data_nascimento" id="edit-data-nasc-<?= $res['chave']; ?>" data-res-chave="<?= $res['chave']; ?>" data-type="data-nasc" required>
                </div>
    
                <!-- Resumo com ID único -->
                <div id="resumo-edit-<?= $res['chave']; ?>" class="resumo-edit-box bg-light p-2 rounded mb-3 border">
                  <span class="d-block small fw-bold mb-1">Dados atualizados:</span>
                  <ul class="mb-0 small">
                    <li class="placeholder text-muted"><i>Nenhum dado alterado ainda</i></li>
                    <li class="invisible" data-field="novo_nome">Nome completo</li>
                    <li class="invisible" data-field="novo_doc">CPF</li>
                    <li class="invisible" data-field="novo_telefone">Celular</li>
                    <li class="invisible" data-field="nova_data_nascimento">Data de nascimento</li>
                  </ul>
                </div>
    
                <div class="d-flex justify-content-end gap-2 mt-4">
                  <button type="button" class="btn btn-light" onclick="closeEditScreen('<?= $res['chave']; ?>')">Cancelar</button>
                  <button id="edit-pax-enviar-btn-<?= $res['chave']; ?>" type="submit" class="btn btn-primary">Enviar Solicitação</button>
                </div>
              </form>
            </div>
          </div>
          
        </div> 
      </div> 
    </div>
  </div>
</div>
