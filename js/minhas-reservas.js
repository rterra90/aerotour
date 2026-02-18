// Script para validar o formulário de solicitação de troca de embarque
// document.querySelectorAll('.form-solicitar-embarque').forEach(form => {
//   const selectPonto = form.querySelector('.select-novo-ponto');
//     const checkboxes = form.querySelectorAll('.check-passageiro');
//     const btnEnviar = form.querySelector('button[type="submit"]');
//     btnEnviar.disabled = true
    
//     function validarFormulario() {
//         const pontoSelecionado = selectPonto.value !== "";
//         const algumPassageiroCheck = Array.from(checkboxes).some(cb => cb.checked);

//         // Habilita o botão apenas se ambos os critérios forem atendidos
//         btnEnviar.disabled = !(pontoSelecionado && algumPassageiroCheck);
//     }

//     selectPonto.addEventListener('change', validarFormulario);
//     checkboxes.forEach(cb => cb.addEventListener('change', validarFormulario));
//     form.addEventListener('submit', function(e) {
//         e.preventDefault();
        
//         const passageirosSelecionados = Array.from(this.querySelectorAll('input[name="passageiros[]"]:checked'));
        
//         if (passageirosSelecionados.length === 0) {
//             alert("Por favor, selecione pelo menos um passageiro.");
//             return;
//         }

//         const btn = this.querySelector('button[type="submit"]');
//         btn.disabled = true;
//         btn.innerHTML = 'Enviando...';

//         const formData = new FormData(this);
//         formData.append('action', 'solicitar_alteracao_embarque');
//         fetch(themeLinks.ajaxUrk, {
//             method: 'POST',
//             body: formData
//         })
//         .then(res => res.json())
//         .then(data => {
//             if(data.success) {
//                 // Encontra o modal atual
//                 const modalElement = form.closest('.modal-content');
                
//                 // Esconde todos os elementos do formulário e o título original
//                 modalElement.querySelectorAll('.secao-form').forEach(el => el.classList.add('d-none'));
                
//                 // Mostra a seção de sucesso
//                 modalElement.querySelector('.secao-sucesso').classList.remove('d-none');
//             } else {
//                 alert("Erro ao enviar: " + data.data);
//                 btn.disabled = false;
//                 btn.innerText = 'Enviar Solicitação';
//             }
//             btn.disabled = false;
//             btn.innerText = 'Enviar Solicitação';
//         });
//     });
// });
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
                console.log(data)
                if (data.success) {
                    // Esconde o formulário e mostra a seção de sucesso
                    modalContent.querySelectorAll('.secao-form').forEach(el => el.classList.add('d-none'));
                    modalContent.querySelector('.secao-sucesso').classList.remove('d-none');
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
});
