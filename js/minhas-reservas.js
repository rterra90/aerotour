// Script para validar o formulário de solicitação de troca de embarque
document.querySelectorAll('.form-solicitar-embarque').forEach(form => {
  const selectPonto = form.querySelector('.select-novo-ponto');
    const checkboxes = form.querySelectorAll('.check-passageiro');
    const btnEnviar = form.querySelector('button[type="submit"]');
    btnEnviar.disabled = true
    
    function validarFormulario() {
        const pontoSelecionado = selectPonto.value !== "";
        const algumPassageiroCheck = Array.from(checkboxes).some(cb => cb.checked);
        console.log(algumPassageiroCheck)
        // Habilita o botão apenas se ambos os critérios forem atendidos
        btnEnviar.disabled = !(pontoSelecionado && algumPassageiroCheck);
    }

    selectPonto.addEventListener('change', validarFormulario);
    checkboxes.forEach(cb => cb.addEventListener('change', validarFormulario));
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const passageirosSelecionados = Array.from(this.querySelectorAll('input[name="passageiros[]"]:checked'));
        
        if (passageirosSelecionados.length === 0) {
            alert("Por favor, selecione pelo menos um passageiro.");
            return;
        }

        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = 'Enviando...';

        const formData = new FormData(this);
        formData.append('action', 'solicitar_alteracao_embarque');
        console.log(themeLinks.adminAjaxUrl)
        fetch(themeLinks.adminAjaxUrl, {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Encontra o modal atual
                const modalElement = form.closest('.modal-content');
                
                // Esconde todos os elementos do formulário e o título original
                modalElement.querySelectorAll('.secao-form').forEach(el => el.classList.add('d-none'));
                
                // Mostra a seção de sucesso
                modalElement.querySelector('.secao-sucesso').classList.remove('d-none');
            } else {
                alert("Erro ao enviar: " + data.data);
                btn.disabled = false;
                btn.innerText = 'Enviar Solicitação';
            }
            btn.disabled = false;
            btn.innerText = 'Enviar Solicitação';
        });
    });
});