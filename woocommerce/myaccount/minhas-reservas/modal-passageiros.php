<?php $res = $args['res']; ?>
<div class="modal fade" id="modal-passageiros-<?= $res['chave']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="fw-bold m-0" id="modal-title-<?= $res['chave']; ?>">Passageiros nesta reserva</h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Usamos a nossa classe customizada aqui -->
      <div class="modal-body modal-body-slider">
        
        <!-- WRAPPER DO SLIDER -->
        <div class="slider-wrapper" id="slider-wrapper-<?= $res['chave']; ?>">
            
          <!-- =============================== -->
          <!-- TELA 1: LISTA DE PASSAGEIROS    -->
          <!-- =============================== -->
          <div class="slider-pane" id="body-lista-passageiros">
            <p class="small text-muted mb-3">Embarque: <strong><?= $res['local_embarque']; ?></strong></p>
            <ul class="list-group list-group-flush">
              <?php foreach ($res['passageiros'] as $p): ?>
                <li class="list-group-item d-flex justify-content-between align-items-end px-0 py-3" data-res-id="<?= $p['res_id'] ?>">
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
                              onclick="openEditScreen(this, '<?= $res['chave']; ?>')"> <!-- Passando a chave para o JS saber qual wrapper deslizar -->
                          <i class="bi bi-pencil-square"></i> Editar dados
                      </button>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- =============================== -->
          <!-- TELA 2: FORMULÁRIO DE EDIÇÃO    -->
          <!-- =============================== -->
          <div class="slider-pane faded" id="body-edit-passageiro">
            <div id="solic-edit-container">
              <!-- Botão extra para voltar (opcional, mas bom para UX) -->
              <button type="button" class="btn btn-link text-decoration-none p-0 mb-3" onclick="closeEditScreen('<?= $res['chave']; ?>')">
                  <i class="bi bi-arrow-left"></i> Voltar para lista
              </button>

              <form data-parent-wrapper-key="<?= $res['chave']; ?>" id="form-solicitar-edicao" action="/api/solicitar-edicao-passageiro" data-res-id=<?= $p['res_id']; ?> method="POST">
                <div class="alert alert-info small">
                    Altere apenas os dados que deseja atualizar. As solicitações serão analisadas antes de serem aplicadas à reserva.
                </div>
                
                <input type="hidden" name="pax_id" id="edit-passageiro-id">
    
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Nome Completo</label>
                    <input type="text" class="form-control edit-pax-input" name="novo_nome" id="edit-nome" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">CPF</label>
                    <input type="text" class="form-control edit-pax-input" name="novo_doc" id="edit-doc" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Celular (WhatsApp)</label>
                    <input type="text" class="form-control edit-pax-input" name="novo_telefone" id="edit-telefone" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-1">Data de nascimento</label>
                    <input type="text" class="form-control edit-pax-input" name="nova_data_nascimento" id="edit-data-nasc" required>
                </div>
    
                <!-- Container de resumo das alterações de dados -->
                <div id="resumo-edit" class="bg-light p-2 rounded mb-3 border">
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
                  <!-- Mudei para onclick chamar o fechar tela, ao invés de fechar o modal inteiro -->
                  <button type="button" class="btn btn-light" onclick="closeEditScreen('<?= $res['chave']; ?>')">Cancelar</button>
                  <button id="edit-pax-enviar-btn" type="submit" class="btn btn-primary">Enviar Solicitação</button>
                </div>
              </form>
            </div>
            
          </div>
          
        </div> <!-- Fim slider-wrapper -->
      </div> <!-- Fim modal-body -->
    </div>
  </div>
</div>

<script>

  // function validaCamposEdicaoPax(inputElement){

  //   let isValid = false;
  //     if (inputElement.id === 'edit-nome') {
  //       isValid = validarNomeCompleto(inputElement.value);

  //     }else if(inputElement.id === 'edit-doc'){
  //       isValid = validarCPF(inputElement.value);

  //     }else if(inputElement.id === 'edit-telefone'){
  //       isValid = inputElement.value.length >= 14;

  //     }else if(inputElement.id === 'edit-data-nasc'){
  //       isValid = inputElement.value.length === 10;
  //     }

  // }

  // Aplica as máscaras nos inputs
  const editPaxInputs = document.querySelectorAll('.edit-pax-input');
  editPaxInputs.forEach(input => {
    input.addEventListener('input', function(e) {
      e.target.classList.remove('has-error');
      switch (e.target.id) {
        case 'edit-doc':
          e.target.value = applyMask(e.target.value, 'cpf')
          break;

        case 'edit-telefone':
          e.target.value = applyMask(e.target.value, 'phone')
          break;

        case 'edit-data-nasc':
          e.target.value = applyMask(e.target.value, 'data')
          break;
      
        default:
          break;
      }
    });

    input.addEventListener('blur', function(e) {
      let isValid = false;
      if (e.target.id === 'edit-nome') {
        isValid = validarNomeCompleto(e.target.value);
        if (!isValid && e.target.value.length != 0) {
          alert('Por favor, insira um nome completo válido.');
        }
      }else if(e.target.id === 'edit-doc'){
        isValid = validarCPF(e.target.value);
        if (!isValid && e.target.value.length != 0) {
          alert('Por favor, insira um CPF válido.');
        }
      }else if(e.target.id === 'edit-telefone'){
        isValid = e.target.value.length >= 14;
        if (!isValid && e.target.value.length != 0) {
          alert('Por favor, insira um telefone válido.');
        }
      }else if(e.target.id === 'edit-data-nasc'){
        isValid = e.target.value.length === 10; // dd/mm/yyyy
        if (!isValid && e.target.value.length != 0) {
          alert('Por favor, insira uma data de nascimento válida.');
        }
      }

      // Condição para adicionar ou remover a classe de erro
      if(isValid || e.target.value.length == 0){
        e.target.classList.remove('has-error')
      } else {
        e.target.classList.add('has-error');
      }

      const resumoBadge = document.querySelector('#resumo-edit li[data-field="'+ e.target.name +'"]');
      if(isValid && e.target.value !== e.target.dataset.initialValue){
        resumoBadge.classList.remove('invisible');
      }else{
        resumoBadge.classList.add('invisible');
      }
      //contar quantos itens visíveis existem
      const resumoList = document.querySelector('#resumo-edit ul');
      const placeholderItem = resumoList.querySelector('.placeholder');
      const visibleItems = resumoList.querySelectorAll('li:not(.placeholder):not(.invisible)');
      if(visibleItems.length > 0){
        placeholderItem.classList.add('invisible');
      }else{
        placeholderItem.classList.remove('invisible');
      }
    })
  });


function openEditScreen(button) {
    // Pega os dados dos atributos do botão
    const resChave = button.getAttribute('data-res-chave');
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');
    const doc = CPFMask(button.getAttribute('data-doc'));
    const telefone = celularMask(button.getAttribute('data-telefone'));
    const data_nasc = isoToDmy(button.getAttribute('data-data-nasc'));

    // Preenche os campos do formulário
    document.getElementById('edit-passageiro-id').value = id;
    document.getElementById('edit-nome').value = nome;
    document.getElementById('edit-doc').value = doc;
    document.getElementById('edit-telefone').value = telefone;
    document.getElementById('edit-data-nasc').value = data_nasc;

    // Armazena o valor inicial para comparação futura
    document.getElementById('edit-nome').dataset.initialValue = nome; 
    document.getElementById('edit-doc').dataset.initialValue = doc;
    document.getElementById('edit-telefone').dataset.initialValue = telefone;
    document.getElementById('edit-data-nasc').dataset.initialValue = data_nasc;

    //Reseta as badges de resumo
    const resumoList = document.querySelector('#resumo-edit ul');
    const visibleItems = resumoList.querySelectorAll('li');
    visibleItems.forEach(item => {
      if(item.classList.contains('placeholder')){
        item.classList.remove('invisible');
      }else{
        item.classList.add('invisible');
      }
    });

    // 5. Altera o título do modal dinamicamente (Opcional, mas melhora a UX)
    document.getElementById('modal-title-' + resChave).innerText = "Editar Passageiro";

    // 6. EXECUTA A ANIMAÇÃO DE DESLIZE!
    document.getElementById('slider-wrapper-' + resChave).classList.add('show-edit-screen');

    // alterna a classe 'faded' para a tela de edição e a lista de passageiros
    document.getElementById('body-lista-passageiros').classList.add('faded');
    document.getElementById('body-edit-passageiro').classList.remove('faded');

    // adiciona o listener de submit no formulário de edição
    document.getElementById('form-solicitar-edicao').addEventListener('submit', (e) => submitSolicitacaoEditPax(e));

}

function closeEditScreen(resChave) {
    // 1. REVERTE A ANIMAÇÃO DE DESLIZE!
    document.getElementById('slider-wrapper-' + resChave).classList.remove('show-edit-screen');
    
    // 2. Restaura o título do modal após um pequeno delay (tempo da animação)
    setTimeout(() => {
        document.getElementById('modal-title-' + resChave).innerText = "Passageiros nesta reserva";
    }, 300);

    // 3. Restaura a classe 'faded' para a lista de passageiros e oculta a tela de edição
    document.getElementById('body-lista-passageiros').classList.remove('faded');
    document.getElementById('body-edit-passageiro').classList.add('faded');
}

// restaurar a exibição da lista de passageiros quando o modal for fechado
const modalElement = document.getElementById('modal-passageiros-<?= $res['chave']; ?>');
modalElement.addEventListener('hidden.bs.modal', function () {
    // Restaura a tela de lista de passageiros
    document.getElementById('slider-wrapper-<?= $res['chave']; ?>').classList.remove('show-edit-screen');
    document.getElementById('body-lista-passageiros').classList.remove('faded');
    document.getElementById('body-edit-passageiro').classList.add('faded');

    // Restaura o título do modal
    document.getElementById('modal-title-<?= $res['chave']; ?>').innerText = "Passageiros nesta reserva";
});

async function submitSolicitacaoEditPax(event){
  event.preventDefault()

  // desabilitar botão de envio e escrever "Enviando..." para feedback visual
  const submitButton = document.getElementById('edit-pax-enviar-btn');
  submitButton.disabled = true;
  submitButton.textContent = "Enviando...";

  //verifica se todos os dados passam na validação
  const editPaxInputs = Array.from(document.querySelectorAll('.edit-pax-input'));

  const validations = editPaxInputs.map(input => {
    if(input.id === 'edit-nome'){
      return validarNomeCompleto(input.value);
    }else if(input.id === 'edit-doc'){
      return validarCPF(input.value);
    }else if(input.id === 'edit-telefone'){
      return input.value.length >= 14;
    }else if(input.id === 'edit-data-nasc'){
      return input.value.length === 10;
    }
  })

  const alteracoes = editPaxInputs.map(input => input.value !== input.dataset.initialValue);

  if(validations.some(v => v === false)){
    alert('Por favor, verifique os dados informados.');
    return;
  } else if (alteracoes.every(a => a === false)){
    alert('Por favor, altere algum dado para enviar.');
    return;
  }

  // prepara os dados para envio
  const formData = new FormData(event.target);
  payload = Object.fromEntries(formData.entries());

  payload.action_from = 'user';

  const fieldMap = {
    'edit-nome': 'status_nome',
    'edit-doc': 'status_doc',
    'edit-telefone': 'status_telefone',
    'edit-data-nasc': 'status_data_nasc'
  };

  editPaxInputs.forEach(input => {
    if (input.value !== input.dataset.initialValue && fieldMap[input.id]) {
      payload[fieldMap[input.id]] = 'pendente';
    }
  });

console.log(payload)

  try{
    const apiUrl = window.themeLinks.siteUrl + '/wp-json/api/v1/edit-reserva';
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });
    const data = await response.json();

    // Se o status HTTP for diferente de 2xx (ex: 500 do WP_Error)
    if (!response.ok) {
      throw new Error(data.message || 'Erro desconhecido no servidor.');
    }

    // SUCESSO (200 OK)

      // substituir o formulário de edicao por um container de confirmação
    const editContainer = document.getElementById('solic-edit-container');
    editContainer.innerHTML = `
      <div class="mt-3 mb-4 alert alert-success small animate-from-top">
        Sua solicitação de edição foi enviada com sucesso! Ela será analisada antes de ser aplicada à reserva.
      </div>
      <button type="button" class="main-btn d-block mx-auto btn" onclick="closeEditScreen('${event.target.dataset.parentWrapperKey}')">Voltar para lista de passageiros</button>
    `;

    setTimeout(() => {
    editContainer.querySelector('.alert').classList.add('show-animated');
    }, 150);

  } catch (error) {
    console.error('Falha na requisição:', error.message);

  }




}

</script>