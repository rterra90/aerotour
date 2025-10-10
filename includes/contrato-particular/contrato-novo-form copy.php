<div id="novoContratoForm">
  <h1>Formulário de Contrato de Viagem</h1>

  <!-- Seção 1: Dados do Contratante -->
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

    <!-- Seção 2: Dados da Viagem -->
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

    <!-- Seção 3: Dados da Contratada -->
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

<script>
  let activeTab = 'pf';

  const formTabs = document.querySelectorAll('.tab-button');
  formTabs.forEach(_tab => _tab.addEventListener('click', (_e) => toggleTab(_e, _tab.dataset.tipo)))

  function setSuccessScreen(newId){
    const formMain = document.getElementById('novoContratoForm');
    formMain.innerHTML = `<h1>Sua solicitação foi aberta com sucesso</h1><div class="contrato-novo-success"><div class="novo-contrato-id">Número da solicitação: ${newId}</div><p>Você receberá uma notificação por e-mail quando o contrato estiver disponível para assinatura.</p><p>Você também pode visualizar os seus contratos acessando aerotour.com.br/contratos</p><div class="botoes-footer"><button>Voltar para o início</button><button>Fazer nova solicitação</button></div></div>`;
  }

  function toggleTab(_e, tabId) {
    _e.preventDefault();
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    _e.currentTarget.classList.add('active');
    document.getElementById(tabId).classList.add('active');
    activeTab = tabId;
  }

  async function submitForm(_event){
    _event.preventDefault()

    // Prepara objeto com os dados
    const form = document.querySelector("#novoContratoForm form")
    const payload = {
      c_tipo: activeTab === "pf" ? "pf" : "pj",
      c_nome: activeTab === "pf" ? form.nome_pf.value : form.nome_pj.value,
      c_doc: activeTab === "pf" ? form.cpf.value : form.cnpj.value,
      c_tel1: activeTab === "pf" ? form.tel1_pf.value : form.tel1_pj.value,
      c_tel2: activeTab === "pf" ? form.tel2_pf.value : form.tel2_pj.value,
      c_email: activeTab === "pf" ? form.email_pf.value : form.email_pj.value,
      c_endereco: activeTab === "pf" ? form.endereco_pf.value : form.endereco_pj.value,
      c_cidade: activeTab === "pf" ? form.cidade_pf.value : form.cidade_pj.value,
      c_insc_est: activeTab === "pf" ? null : form.insc_est_pj.value,
      v_data_saida: form.data_saida.value,
      v_hora_saida: form.hora_saida.value,
      v_local_saida: form.local_saida.value,
      v_destino: form.destino.value,
      v_data_retorno: form.data_retorno.value,
      v_hora_retorno: form.hora_retorno.value
    };

    if(form.data_saida.value){
      // Faz a requisição POST
      const fetchUrl = '<?= get_site_url(); ?>/wp-json/api/contrato';
      const response = await fetch(fetchUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(payload)
      });
      if (!response.ok) {
        console.error('Erro:', response.statusText);
      } else {
        const result = await response.json();
        setSuccessScreen(result.novo_id)
      }
    }else{
      console.log('não chamou');
    }
  }

  const formNovoEnviarBtn = document.getElementById('formNovoEnviar');
  formNovoEnviarBtn.addEventListener('click', (e) => submitForm(e));
</script>