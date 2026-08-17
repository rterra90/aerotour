// Script para validar o formulário de solicitação de troca de embarque
document.addEventListener('DOMContentLoaded', function() {

    // --- 1. VALIDAÇÃO DE BOTÕES ---
    function gerenciarValidacao() {
        // Seleciona todos os formulários de solicitação (embarque e cancelamento)
        const formularios = document.querySelectorAll('.form-solicitar-embarque, .form-solicitar-cancelamento');

        formularios.forEach(form => {
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            const selectPonto = form.querySelector('.select-novo-ponto'); // Apenas para embarque
            const btnSubmit = form.querySelector('button[type="submit"]');

            const validar = () => {
                const radios = document.querySelectorAll('.modal-dialog input[type="radio"]');
                const algumCheckado = Array.from(checkboxes).some(cb => cb.checked);

                if(radios.length > 0) {
                    radios.forEach(radio => {
                        radio.addEventListener('change', () => {
                            validar(); // Revalida quando um rádio é selecionado
                        });
                    });
                }
                
                // Se for formulário de embarque, precisa de ponto + passageiro
                if (form.classList.contains('form-solicitar-embarque')) {
                    const pontoSelecionado = selectPonto && selectPonto.value !== "";

                    if(radios.length > 0) {
                        console.log('caiu aqui')
                        const algumRadioSelecionado = Array.from(radios).some(radio => radio.checked);
                        console.log('algumRadioSelecionado', algumRadioSelecionado)
                        console.log('algumCheckado', algumCheckado)
                        console.log('pontoSelecionado', pontoSelecionado)
                        btnSubmit.disabled = !(algumCheckado && algumRadioSelecionado && pontoSelecionado);
                        return;
                    }

                    btnSubmit.disabled = !(algumCheckado && pontoSelecionado);
                } else {
                    // Se for cancelamento, basta ter passageiro selecionado
                    btnSubmit.disabled = !algumCheckado;
                }
            };

            // Escuta mudanças nos inputs
            checkboxes.forEach(cb => cb.addEventListener('change', validar));
            if (selectPonto) selectPonto.addEventListener('change', validar);

            validar(); // Valida inicialmente para garantir estado correto do botão
        });
    }

    // --- 2. ENVIO AJAX ---
    function configurarEnvios() {
        const tratarEnvio = (e, action) => {
            e.preventDefault();
            const form = e.target;
            const btn = form.querySelector('button[type="submit"]');
            const modalContent = form.closest('.modal-content');

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enviando...';

            const formData = new FormData(form);
            formData.append('action', action);
            fetch(themeLinks.ajaxUrl, { // ajaxurl é definido pelo WordPress
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Esconde o formulário e mostra a seção de sucesso
                    modalContent.querySelectorAll('.secao-form').forEach(el => el.classList.add('d-none'));
                    modalContent.querySelector('.secao-sucesso').classList.remove('d-none');

                    if(action == 'solicitar_cancelamento_reserva'){
                        // 1. Calcula data limite para conclusão
                        const dataHoje = new Date();
                        dataHoje.setDate(dataHoje.getDate() + 10);
                        // Formata para o padrão brasileiro dd/mm/aaaa
                        const dataFormatada = dataHoje.toLocaleDateString('pt-BR', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        })
                        // Injeta a data no campo do modal
                        const displayData = modalContent.querySelector('.data-limite-cancelamento');
                        if (displayData) {
                            displayData.innerText = dataFormatada;
                        }

                        // 2. Captura os dados para atualizar o Card e os outros Modais
                        const idsCancelados = Array.from(form.querySelectorAll('input[name="passageiros[]"]:checked')).map(cb => cb.value);
                        const cardChave = form.closest('.modal').id.replace('modal-cancelar-', ''); // Pega a chave da reserva do ID do modal

                        atualizarInterfacePosCancelamento(cardChave, idsCancelados);
                    }
                    
                } else {
                    alert('Erro: ' + (data.data || 'Falha na requisição'));
                    btn.disabled = false;
                    btn.innerText = 'Tentar Novamente';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Erro de conexão ao servidor.');
                btn.disabled = false;
            });
        };

        // Delegar eventos de submit
        document.addEventListener('submit', function(e) {
            if (e.target.classList.contains('form-solicitar-embarque')) {
                tratarEnvio(e, 'solicitar_alteracao_embarque');
            }
            if (e.target.classList.contains('form-solicitar-cancelamento')) {
                tratarEnvio(e, 'solicitar_cancelamento_reserva');
            }
        });
    }

    // Inicializa as funções
    gerenciarValidacao();
    configurarEnvios();

    
    function atualizarInterfacePosCancelamento(chave, idsCancelados) {
    // 1. Localiza o Card e os Modais específicos dessa reserva
    const card = document.querySelector(`.card-wrapper[data-chave="${chave}"]`);
    const modalPassageiros = document.getElementById(`modal-passageiros-${chave}`);
        console.log(modalPassageiros);

    // 2. Adiciona o Alerta no Card (se ainda não existir)
    if (card && !card.querySelector('.alert-warning')) {
        const alertaHTML = `
            <div class="alert alert-warning py-2 mb-2" style="font-size: 0.75rem;">
                <i class="bi bi-hourglass-split me-1"></i>Há uma solicitação de cancelamento aberta para esta reserva.
            </div>`;
        card.querySelector('.card-body').insertAdjacentHTML('beforebegin', alertaHTML);
    }

    // 3. Atualiza os passageiros em TODOS os modais
    idsCancelados.forEach(id => {
        // Seleciona as linhas/inputs referentes a este passageiro específico em todos os modais
        const seletores = [modalPassageiros];
        
        seletores.forEach(modal => {
            if (!modal) return;
            const container = modal.querySelector(`li[data-res-id="${id}"]`)
            if (container) {
                // Aplica estilo visual de desabilitado
                container.classList.add('bg-light', 'opacity-75');

                // Adiciona a Badge de Pendente (se não existir)
                if (!container.querySelector('.badge-warning') && !container.querySelector('.bi-hourglass-split')) {
                    const badge = '<span class="badge bg-warning-subtle text-warning small ms-2">Cancelamento pendente</span>';
                    // Insere na div de conteúdo do passageiro
                    container.insertAdjacentHTML('beforeend', badge);
                }
            }
        });
    });
}
});

// FLUXO DE EDIÇÃO DE DADOS DO PASSAGEIRO

// ==========================================
// 1. EVENT DELEGATION PARA MÁSCARAS E VALIDAÇÕES
// Como temos vários modais, usamos o evento no 'document' e checamos quem o disparou
// ==========================================

document.addEventListener('input', function(e) {
  if (!e.target.classList.contains('edit-pax-input')) return;
  
  e.target.classList.remove('has-error');
  const type = e.target.getAttribute('data-type');

  switch (type) {
    case 'doc':
      e.target.value = applyMask(e.target.value, 'cpf');
      break;
    case 'telefone':
      e.target.value = applyMask(e.target.value, 'phone');
      break;
    case 'data-nasc':
      e.target.value = applyMask(e.target.value, 'data');
      break;
  }
});

// focusout funciona como o 'blur', mas "borbulha" pelo DOM, permitindo a delegação global
document.addEventListener('focusout', function(e) {
  if (!e.target.classList.contains('edit-pax-input')) return;

  const type = e.target.getAttribute('data-type');
  const resChave = e.target.getAttribute('data-res-chave');
  let isValid = false;

  if (type === 'nome') {
    isValid = validarNomeCompleto(e.target.value);
    if (!isValid && e.target.value.length !== 0) alert('Por favor, insira um nome completo válido.');
  } else if (type === 'doc') {
    isValid = validarCPF(e.target.value);
    if (!isValid && e.target.value.length !== 0) alert('Por favor, insira um CPF válido.');
  } else if (type === 'telefone') {
    isValid = e.target.value.length >= 14;
    if (!isValid && e.target.value.length !== 0) alert('Por favor, insira um telefone válido.');
  } else if (type === 'data-nasc') {
    isValid = e.target.value.length === 10;
    if (!isValid && e.target.value.length !== 0) alert('Por favor, insira uma data de nascimento válida.');
  }

  if (isValid || e.target.value.length === 0) {
    e.target.classList.remove('has-error');
  } else {
    e.target.classList.add('has-error');
  }

  // Atualiza as badges de resumo APENAS do modal atual
  const resumoBadge = document.querySelector(`#resumo-edit-${resChave} li[data-field="${e.target.name}"]`);
  if (isValid && e.target.value !== e.target.dataset.initialValue) {
    resumoBadge.classList.remove('invisible');
  } else {
    resumoBadge.classList.add('invisible');
  }

  // Controle do placeholder
  const resumoList = document.querySelector(`#resumo-edit-${resChave} ul`);
  const placeholderItem = resumoList.querySelector('.placeholder');
  const visibleItems = resumoList.querySelectorAll('li:not(.placeholder):not(.invisible)');
  
  if (visibleItems.length > 0) {
    placeholderItem.classList.add('invisible');
  } else {
    placeholderItem.classList.remove('invisible');
  }
});


// ==========================================
// 2. FUNÇÕES DE ABERTURA E FECHAMENTO
// ==========================================

function openEditScreen(button, resChave) {
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');
    const doc = CPFMask(button.getAttribute('data-doc'));
    const telefone = celularMask(button.getAttribute('data-telefone'));
    const data_nasc = isoToDmy(button.getAttribute('data-data-nasc'));

    // Pega os inputs corretos usando a chave da reserva
    const inputId = document.getElementById(`edit-passageiro-id-${resChave}`);
    const inputNome = document.getElementById(`edit-nome-${resChave}`);
    const inputDoc = document.getElementById(`edit-doc-${resChave}`);
    const inputTel = document.getElementById(`edit-telefone-${resChave}`);
    const inputDataNasc = document.getElementById(`edit-data-nasc-${resChave}`);

    inputId.value = id;
    
    inputNome.value = nome;
    inputNome.dataset.initialValue = nome; 
    
    inputDoc.value = doc;
    inputDoc.dataset.initialValue = doc;
    
    inputTel.value = telefone;
    inputTel.dataset.initialValue = telefone;
    
    inputDataNasc.value = data_nasc;
    inputDataNasc.dataset.initialValue = data_nasc;

    // Reseta badges deste modal
    const resumoList = document.querySelector(`#resumo-edit-${resChave} ul`);
    resumoList.querySelectorAll('li').forEach(item => {
      if(item.classList.contains('placeholder')) item.classList.remove('invisible');
      else item.classList.add('invisible');
    });

    document.getElementById(`modal-title-${resChave}`).innerText = "Editar Passageiro";
    document.getElementById(`slider-wrapper-${resChave}`).classList.add('show-edit-screen');
    document.getElementById(`body-lista-passageiros-${resChave}`).classList.add('faded');
    document.getElementById(`body-edit-passageiro-${resChave}`).classList.remove('faded');
}

function closeEditScreen(resChave) {
    document.getElementById(`slider-wrapper-${resChave}`).classList.remove('show-edit-screen');
    
    setTimeout(() => {
        document.getElementById(`modal-title-${resChave}`).innerText = "Passageiros nesta reserva";
    }, 300);

    document.getElementById(`body-lista-passageiros-${resChave}`).classList.remove('faded');
    document.getElementById(`body-edit-passageiro-${resChave}`).classList.add('faded');
}

// ==========================================
// 3. RESTAURAR MODAL AO FECHAR (DELEGAÇÃO GLOBAL)
// Intercepta qualquer modal do Bootstrap fechando
// ==========================================

document.addEventListener('hidden.bs.modal', function (event) {
    // Verifica se o elemento que disparou o evento é o nosso modal de passageiros
    if (!event.target.id.startsWith('modal-passageiros-')) return;
    
    const resChave = event.target.getAttribute('data-res-chave');
    
    document.getElementById(`slider-wrapper-${resChave}`).classList.remove('show-edit-screen');
    document.getElementById(`body-lista-passageiros-${resChave}`).classList.remove('faded');
    document.getElementById(`body-edit-passageiro-${resChave}`).classList.add('faded');
    document.getElementById(`modal-title-${resChave}`).innerText = "Passageiros nesta reserva";
});


// ==========================================
// 4. ENVIO DO FORMULÁRIO (AJAX)
// ==========================================

async function submitSolicitacaoEditPax(event, resChave){
  event.preventDefault();

  const form = event.target;
  const submitButton = document.getElementById(`edit-pax-enviar-btn-${resChave}`);
  submitButton.disabled = true;
  submitButton.textContent = "Enviando...";

  // Busca os inputs apenas DESTE formulário ativo
  const formInputs = Array.from(form.querySelectorAll('.edit-pax-input'));

  const validations = formInputs.map(input => {
    const type = input.getAttribute('data-type');
    if(type === 'nome') return validarNomeCompleto(input.value);
    if(type === 'doc') return validarCPF(input.value);
    if(type === 'telefone') return input.value.length >= 14;
    if(type === 'data-nasc') return input.value.length === 10;
  });

  const alteracoes = formInputs.map(input => input.value !== input.dataset.initialValue);

  if(validations.some(v => v === false)){
    alert('Por favor, verifique os dados informados.');
    submitButton.disabled = false;
    submitButton.textContent = "Enviar Solicitação";
    return;
  } else if (alteracoes.every(a => a === false)){
    alert('Por favor, altere algum dado para enviar.');
    submitButton.disabled = false;
    submitButton.textContent = "Enviar Solicitação";
    return;
  }

  const formData = new FormData(form);
  let payload = Object.fromEntries(formData.entries());
  payload.action_from = 'user';

  const fieldMap = {
    'nome': 'status_nome',
    'doc': 'status_doc',
    'telefone': 'status_telefone',
    'data-nasc': 'status_data_nasc'
  };

  formInputs.forEach(input => {
    if (input.value !== input.dataset.initialValue) {
      const type = input.getAttribute('data-type');
      payload[fieldMap[type]] = 'pendente';
    }
  });

  try {
    const apiUrl = window.themeLinks.siteUrl + '/wp-json/api/v1/edit-reserva';
    const response = await fetch(apiUrl, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });
    const data = await response.json();

    if (!response.ok) throw new Error(data.message || 'Erro desconhecido no servidor.');

    // SUCESSO - Substitui interface
    const editContainer = document.getElementById(`solic-edit-container-${resChave}`);
    editContainer.innerHTML = `
      <div class="mt-3 mb-4 alert alert-success small animate-from-top">
        Sua solicitação de edição foi enviada com sucesso! Ela será analisada antes de ser aplicada à reserva.
      </div>
      <button type="button" class="main-btn d-block mx-auto btn" onclick="closeEditScreen('${resChave}')">Voltar para lista de passageiros</button>
    `;

    setTimeout(() => {
        const alertEl = editContainer.querySelector('.alert');
        if(alertEl) alertEl.classList.add('show-animated');
    }, 150);

  } catch (error) {
    console.error('Falha na requisição:', error.message);
    alert('Ocorreu um erro: ' + error.message);
    submitButton.disabled = false;
    submitButton.textContent = "Enviar Solicitação";
  }
}