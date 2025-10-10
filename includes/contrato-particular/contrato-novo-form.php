<script>
  /**
 * Classe ContratoForm
 * Gerencia o formulário de contrato, incluindo a montagem inicial,
 * a lógica de abas (Pessoa Física/Jurídica), a submissão assíncrona
 * e a exibição da tela de sucesso.
 */
class ContratoForm {
    /**
     * @param {string} containerId O ID do elemento DIV principal que conterá o formulário.
     * @param {string} apiUrl A URL para onde os dados do formulário serão enviados via POST.
     */
    constructor(containerId, apiUrl) {
        // Propriedades da instância
        this.containerElement = document.getElementById(containerId);
        this.apiUrl = apiUrl;
        this.activeTab = 'pf';
        // HTML do formulário (mantido para o método init)
        this.formHTML = `
        <div id="novoContratoForm">    
        <h1>Formulário de Contrato de Viagem</h1>

            <h2>Dados do Contratante</h2>
            <form>
                <div class="tabs">
                    <button data-tipo="pf" class="tab-button active">Pessoa Física</button>
                    <button data-tipo="pj" class="tab-button">Pessoa Jurídica</button>
                </div>

                <div id="pf" class="tab-content active">
                    <div class="row">
                        <div class="form-group"><label>Nome Completo</label><input type="text" name="nome_pf"></div>
                        <div class="form-group col-sm-6"><label>CPF</label><input type="text" name="cpf"></div>
                        <div class="form-group col-sm-6"><label>E-mail</label><input type="email" name="email_pf"></div>
                        <div class="form-group col-sm-6"><label>Telefone 1</label><input type="text" name="tel1_pf"></div>
                        <div class="form-group col-sm-6"><label>Telefone 2</label><input type="text" name="tel2_pf"></div>
                        <div class="form-group"><label>Endereço</label><input type="text" name="endereco_pf"></div>
                        <div class="form-group"><label>Cidade/Estado</label><input type="text" name="cidade_pf"></div>
                    </div>
                </div>

                <div id="pj" class="tab-content">
                    <div class="row">
                        <div class="form-group"><label>Nome da Empresa</label><input type="text" name="nome_pj"></div>
                        <div class="form-group col-sm-6"><label>CNPJ</label><input type="text" name="cnpj"></div>
                        <div class="form-group col-sm-6"><label>E-mail</label><input type="email" name="email_pj"></div>
                        <div class="form-group col-sm-6"><label>Telefone 1</label><input type="text" name="tel1_pj"></div>
                        <div class="form-group col-sm-6"><label>Telefone 2</label><input type="text" name="tel2_pj"></div>
                        <div class="form-group"><label>Endereço</label><input type="text" name="endereco_pj"></div>
                        <div class="form-group"><label>Cidade</label><input type="text" name="cidade_pj"></div>
                        <div class="form-group"><label>Inscrição Estadual</label><input type="text" name="insc_est_pj"></div>
                    </div>
                </div>

                <div class="section">
                    <h2>Dados da Viagem</h2>
                    <div class="row">
                        <div class="form-group col-sm-6"><label>Data de Saída</label><input type="date" name="data_saida"></div>
                        <div class="form-group col-sm-6"><label>Horário de Saída</label><input type="time" name="hora_saida"></div>
                        <div class="form-group"><label>Local de Saída</label><input type="text" name="local_saida"></div>
                        <div class="form-group"><label>Destino</label><input type="text" name="destino"></div>
                        <div class="form-group col-sm-6"><label>Data de Retorno</label><input type="date" name="data_retorno"></div>
                        <div class="form-group col-sm-6"><label>Horário de Retorno</label><input type="time" name="hora_retorno"></div>
                    </div>
                </div>

                <div class="section">
                    <h2>Dados da Contratada</h2>
                    <div class="readonly-group">
                        <p><strong>Nome:</strong> Viagens & Turismo Brasil Ltda</p>
                        <p><strong>CNPJ:</strong> 12.345.678/0001-99</p>
                        <p><strong>E-mail:</strong> contato@viagensbrasil.com</p>
                        <p><strong>Endereço:</strong> Rua das Palmeiras, 123 - Centro, São Paulo/SP</p>
                        <p><strong>Telefone:</strong> (11) 4002-8922</p>
                    </div>
                </div>

                <button class="btn-nova" id="formNovoEnviar">Enviar dados para contrato</button>
            </form>
          </div>
        `;

        // Verifica se o elemento container existe
        if (!this.containerElement) {
            console.error(`O elemento com ID ${containerId} não foi encontrado.`);
        }
    }

    // ---

    /**
     * Gerencia o estado visual e interativo do botão de submissão (loading).
     * @param {boolean} isSending Se true, desabilita e mostra o spinner. Se false, restaura.
     * @private
     */
    _toggleSendingState(isSending) {
        const button = this.containerElement.querySelector('#formNovoEnviar');
        if (!button) return;

        if (isSending) {
            // Desabilita o botão e muda o visual
            button.disabled = true;
            button.classList.add('btn-loading');
            // Altera o conteúdo para o texto e o ícone animado
            button.innerHTML = '<span class="spinner"></span> Enviando...';
        } else {
            // Habilita o botão e restaura o visual
            button.disabled = false;
            button.classList.remove('btn-loading');
            // Restaura o texto original
            button.textContent = 'Enviar dados para contrato'; 
        }
    }

    /**
     * Aplica as máscaras de CPF/CNPJ e Telefone aos campos relevantes.
     * @private
     */
    _applyMasks() {
        if (!this.containerElement) return;

        // Máscara para CPF/CNPJ
        const cpfField = this.containerElement.querySelectorAll('input[name="cpf"]');
        cpfField.forEach(input => {
            input.addEventListener('input', (e) => {
                e.target.value = CPFMask(e.target.value);
            });
            input.setAttribute('maxlength', 14);
        });
        const cnpjField = this.containerElement.querySelectorAll('input[name="cnpj"]');
        cnpjField.forEach(input => {
            input.addEventListener('input', (e) => {
                e.target.value = CNPJMask(e.target.value);
            });
            input.setAttribute('maxlength', 18);
        });

        // Máscara para Telefones "(19) 99999-2222"
        const phoneFields = this.containerElement.querySelectorAll(
            'input[name^="tel1_"], input[name^="tel2_"]'
        );
        phoneFields.forEach(input => {
            input.addEventListener('input', (e) => celularMask(e));
            input.setAttribute('maxlength', 15);
        });
    }

    
    /**
     * Método init: Monta o formulário na página e anexa os ouvintes de eventos.
     */
    init() {
        if (!this.containerElement) return;

        // 1. Monta o formulário no container
        this.containerElement.innerHTML = this.formHTML;

        // 2. Anexa ouvintes de eventos
        this.attachEventListeners();

        // 3. NOVO: Aplica as máscaras aos campos
        this._applyMasks(); 
    }

    /**
     * Anexa os ouvintes de eventos para as abas e a submissão do formulário.
     * Este é um método auxiliar interno.
     */
    attachEventListeners() {
        // Ouvintes para as abas
        const formTabs = this.containerElement.querySelectorAll('.tab-button');
        formTabs.forEach(tab => tab.addEventListener('click', (e) => this.toggleTab(e, tab.dataset.tipo)));

        // Ouvinte para a submissão do formulário
        const formNovoEnviarBtn = this.containerElement.querySelector('#formNovoEnviar');
        if (formNovoEnviarBtn) {
            // Usa o método de submissão da classe
            formNovoEnviarBtn.addEventListener('click', (e) => this.submitForm(e));
        }
    }

    /**
     * Lógica para trocar entre as abas Pessoa Física (pf) e Pessoa Jurídica (pj).
     * @param {Event} _e O evento de clique.
     * @param {string} tabId O ID da aba a ser ativada ('pf' ou 'pj').
     */
    toggleTab(_e, tabId) {
        _e.preventDefault();
        // Remove 'active' de todos os botões e conteúdos
        this.containerElement.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        this.containerElement.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));

        // Adiciona 'active' ao botão e conteúdo corretos
        _e.currentTarget.classList.add('active');
        this.containerElement.querySelector(`#${tabId}`).classList.add('active');
        this.activeTab = tabId; // Atualiza a propriedade da classe
    }

    // ---

    /**
     * Prepara o payload de dados a ser enviado para a API.
     * @param {HTMLFormElement} form O elemento FORM do DOM.
     * @returns {Object} O objeto de dados para a requisição.
     * @private
     */
    _preparePayload(form) {
        const isPF = this.activeTab === "pf";

        return {
            c_tipo: isPF ? "pf" : "pj",
            c_nome: isPF ? form.nome_pf.value : form.nome_pj.value,
            c_doc: isPF ? cleanMask(form.cpf.value) : cleanMask(form.cnpj.value),
            c_tel1: isPF ? cleanMask(form.tel1_pf.value) : cleanMask(form.tel1_pj.value),
            c_tel2: isPF ? cleanMask(form.tel2_pf.value) : cleanMask(form.tel2_pj.value),
            c_email: isPF ? form.email_pf.value : form.email_pj.value,
            c_endereco: isPF ? form.endereco_pf.value : form.endereco_pj.value,
            c_cidade: isPF ? form.cidade_pf.value : form.cidade_pj.value,
            c_insc_est: isPF ? null : form.insc_est_pj.value,
            v_data_saida: form.data_saida.value,
            v_hora_saida: form.hora_saida.value,
            v_local_saida: form.local_saida.value,
            v_destino: form.destino.value,
            v_data_retorno: form.data_retorno.value,
            v_hora_retorno: form.hora_retorno.value
        };
    }

        /**
     * Define os campos obrigatórios com base na aba ativa (Pessoa Física ou Jurídica).
     * @returns {Array<string>} Lista de nomes dos campos (name attributes) a serem validados.
     * @private
     */
    _getFieldsToValidate() {
        // Campos obrigatórios de Viagem
        const sharedFields = [
            'data_saida', 'hora_saida', 'local_saida', 'destino', 
            'data_retorno', 'hora_retorno'
        ];

        let specificFields = [];
        if (this.activeTab === 'pf') {
            specificFields = [
                'nome_pf', 'cpf', 'email_pf', 'tel1_pf', 
                'endereco_pf', 'cidade_pf'
            ];
        } else { // 'pj'
            specificFields = [
                'nome_pj', 'cnpj', 'email_pj', 'tel1_pj', 
                'endereco_pj', 'cidade_pj'
                // 'insc_est_pj' não é obrigatório no seu payload original, por isso foi omitido
            ];
        }

        return [...specificFields, ...sharedFields];
    }

     /**
     * Valida todos os campos obrigatórios do formulário.
     * Exibe um alerta e foca no primeiro campo inválido.
     * @param {HTMLFormElement} form O elemento FORM.
     * @returns {boolean} True se a validação for bem-sucedida, false caso contrário.
     * @private
     */
    _validateForm(form) {
        const fields = this._getFieldsToValidate();

        for (const fieldName of fields) {
            const input = form.elements[fieldName];
            
            // 1. Verifica se o campo existe (para evitar erros)
            if (!input) {
                console.warn(`Campo '${fieldName}' não encontrado no formulário.`);
                continue;
            }

            // 2. Validação simples de preenchimento
            if (!input.value.trim()) {
                const label = input.closest('.form-group').querySelector('label')?.textContent || fieldName;
                
                alert(`Por favor, preencha o campo obrigatório: ${label}`);
                input.focus();
                return false; // Falha na validação
            }
            
            // 3. (OPCIONAL) Adicionar validações mais complexas, como formato de e-mail ou CPF/CNPJ.
            // Exemplo simples de validação de e-mail:
            if (fieldName.includes('email') && !/\S+@\S+\.\S+/.test(input.value)) {
                 alert(`Por favor, insira um e-mail válido.`);
                 input.focus();
                 return false;
            }

                    // --- NOVAS VALIDAÇÕES DE DATA ---

        const dataSaidaValue = form.data_saida.value;
        const dataRetornoValue = form.data_retorno.value;
        
        // É importante garantir que as datas estejam preenchidas antes de tentar criar o Date object
        if (!dataSaidaValue || !dataRetornoValue) {
             // Esta checagem é redundante se a validação de preenchimento acima funcionar, 
             // mas é uma salvaguarda para a lógica de datas.
             return true; 
        }

        const dataSaida = new Date(dataSaidaValue);
        const dataRetorno = new Date(dataRetornoValue);
        
        // Para a comparação de "Data Atual", usamos apenas a data de hoje (meia-noite)
        const hoje = new Date();
        hoje.setHours(0, 0, 0, 0); 
        
        // Adicionamos 1 dia à data de saída para comparação.
        // Se a data de saída for igual a "hoje", consideramos válido (permitindo viagens para o mesmo dia).
        const dataSaidaMidnight = new Date(dataSaidaValue);
        dataSaidaMidnight.setHours(0, 0, 0, 0);

        // REGRA 1: Data de saída não pode ser antes da data atual (Hoje)
        // Se dataSaidaMidnight < hoje, significa que é uma data passada.
        if (dataSaidaMidnight < hoje) {
            alert('A Data de Saída não pode ser anterior à data de hoje.');
            form.data_saida.focus();
            return false;
        }

        // REGRA 2: Data de retorno não pode ser menor do que a data de saída
        // Comparamos as datas no formato Date, ignorando o horário (usando os valores puros do input type="date")
        if (dataRetorno < dataSaida) {
            alert('A Data de Retorno não pode ser anterior à Data de Saída.');
            form.data_retorno.focus();
            return false;
        }

        // --- FIM NOVAS VALIDAÇÕES DE DATA ---
        }

        return true; // Validação bem-sucedida
    }

   /**
     * Método para fazer a requisição assíncrona (submitForm).
     * Inclui a chamada ao novo método de validação.
     * @param {Event} _event O evento de clique ou submissão.
     */
    async submitForm(_event) {
        _event.preventDefault();

        const form = this.containerElement.querySelector("form");
        if (!form) {
            console.error("Elemento FORM não encontrado.");
            return;
        }
        
        // Chama o método de validação
        if (!this._validateForm(form)) {
            // Se a validação falhar, o método exibe o alerta e retorna false,
            // então paramos a submissão aqui.
            return; 
        }

        // INÍCIO DO FEEDBACK VISUAL: Ativa o estado de loading
        this._toggleSendingState(true);

        const payload = this._preparePayload(form);

        try {
            // Faz a requisição POST
            const response = await fetch(this.apiUrl, {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status} ${response.statusText}`);
            }

            const result = await response.json();
            
            this.setSuccessScreen(result.novo_id);

        } catch (error) {
            console.error('Erro ao submeter o formulário:', error);
            alert('Ocorreu um erro ao enviar a solicitação. Por favor, tente novamente.');
        } finally {
            // FIM DO FEEDBACK VISUAL: Restaura o botão de envio
            this._toggleSendingState(false); 
        }
    }

    // ---

    /**
     * Método para exibir a tela de sucesso no envio (setSuccessScreen).
     * @param {string} newId O número/ID da solicitação de contrato gerada.
     */
    setSuccessScreen(newId) {
        if (!this.containerElement) return;

        // 1. Altera o conteúdo do container principal para exibir a tela de sucesso
        this.containerElement.innerHTML = `
            <h1>Sua solicitação foi aberta com sucesso</h1>
            <div class="contrato-novo-success">
                <div class="novo-contrato-id">Número da solicitação: <strong>${newId}</strong></div>
                <p>Você receberá uma notificação por e-mail quando o contrato estiver disponível para assinatura.</p>
                <p>Você também pode visualizar os seus contratos acessando aerotour.com.br/contrato</p>
                <div class="botoes-footer">
                    <button onclick="window.location.reload()">Fazer nova solicitação</button>
                    <button onclick="window.location.href='https://aerotour.com.br/contrato'">Voltar para o início</button>
                </div>
            </div>
        `;

        // 2. Rola a página para o topo do container
        this.containerElement.scrollIntoView({ 
            behavior: 'smooth', // Rolagem suave
            block: 'start'      // Alinha o topo do elemento ao topo da viewport
        });
    }
}

// ---

// Inicialização da Classe

const CONTAINER_ID = 'contratoInner';
// Substitua pela URL da sua API real
const API_URL = '<?= get_site_url(); ?>' +'/wp-json/api/contrato'; 

// 1. Cria uma instância da classe
const contratoApp = new ContratoForm(CONTAINER_ID, API_URL);

// 2. Chama o método init para montar o formulário e configurar os eventos
if (contratoApp.containerElement) {
    contratoApp.init();
}
</script>