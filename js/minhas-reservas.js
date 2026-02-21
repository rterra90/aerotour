// Script para validar o formulário de solicitação de troca de embarque
document.addEventListener('DOMContentLoaded', function() {

    // --- 1. VALIDAÇÃO DE BOTÕES ---
    function gerenciarValidacao() {
        console.log('gerenciarValidacao chamada');
        // Seleciona todos os formulários de solicitação (embarque e cancelamento)
        const formularios = document.querySelectorAll('.form-solicitar-embarque, .form-solicitar-cancelamento');

        formularios.forEach(form => {
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            const selectPonto = form.querySelector('.select-novo-ponto'); // Apenas para embarque
            const btnSubmit = form.querySelector('button[type="submit"]');

            const validar = () => {
                const algumCheckado = Array.from(checkboxes).some(cb => cb.checked);
                
                // Se for formulário de embarque, precisa de ponto + passageiro
                if (form.classList.contains('form-solicitar-embarque')) {
                    const pontoSelecionado = selectPonto && selectPonto.value !== "";
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
