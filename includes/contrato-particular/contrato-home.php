<?php


?>

<div id="contratoHome" class="container">
  <div class="row">
    <div class="opcoes col-md-6">
      <h1>Solicitações de Contrato</h1>
      <button class="btn-nova" onclick="rotasContrato('novo')">+ Nova solicitação</button>
    </div>

    <div class="consulta col-md-6">

      <!-- Mensagem de erro -->
      <?php if (isset($_GET['erro'])) : ?>
        <p style="color:red;">❌ Número ou senha incorretos. Tente novamente.</p>
      <?php endif; ?>

      <form action="<?php echo get_template_directory_uri(); ?>/includes/contrato-particular/contrato-auth-handler.php" method="post" autocomplete="off">

        <label for="numeroContrato">Consultar nº do contrato</label>
        <input autocomplete="off" type="text" id="numeroContrato" name="numeroContrato" placeholder="Digite o número do contrato" inputmode="numeric" pattern="[0-9]*" value="" />

        <div class="senha-input" id="senhaContainer">
          <label for="senhaContrato">Senha</label>
          <input type="password" id="senhaContrato" name="senhaContrato" placeholder="Digite a senha" />
        </div>

        <button type="submit">Enviar</button>
      </form>
      
    </div>
  </div>
    
  <?php if (current_user_can('administrator')): ?>
  <div class="admin-options">
    <table>
      <thead>
        <tr>
          <th>Nº Contrato</th>
          <th>Nome do Contratante</th>
          <th>Destino</th>
          <th>Data de Saída</th>
          <th>Data de Retorno</th>
          <th>Valor</th>
          <th>Detalhes</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>10234</td>
          <td>João Silva</td>
          <td>Rio de Janeiro</td>
          <td>10/10/2025</td>
          <td>15/10/2025</td>
          <td>R$ 5.200,00</td>
          <td><button class="icon-btn" onclick="abrirModal()">🔍</button></td>
        </tr>
        <!-- Adicione mais linhas conforme necessário -->
      </tbody>
    </table>

    <!-- Modal -->
    <div class="modal" id="modalContrato">
      <div class="modal-content">
        <button class="close-btn" onclick="fecharModal()">✖</button>
        <h2>Detalhes do Contrato</h2>

        <label>Nome Completo</label>
        <input type="text" value="João Silva" readonly />

        <label>CPF</label>
        <input type="text" value="123.456.789-00" readonly />

        <label>Email</label>
        <input type="email" value="joao@email.com" readonly />

        <label>Telefone 1</label>
        <input type="tel" value="(11) 91234-5678" readonly />

        <label>Telefone 2</label>
        <input type="tel" value="(11) 99876-5432" readonly />

        <label>Endereço</label>
        <input type="text" value="Rua das Flores, 123" readonly />

        <label>Cidade</label>
        <input type="text" value="São Paulo" readonly />

        <label>Data de Saída</label>
        <input type="date" value="2025-10-10" readonly />

        <label>Horário de Saída</label>
        <input type="time" value="08:00" readonly />

        <label>Local de Saída</label>
        <input type="text" value="Terminal Rodoviário Tietê" readonly />

        <label>Destino</label>
        <input type="text" value="Rio de Janeiro" readonly />

        <label>Data de Retorno</label>
        <input type="date" value="2025-10-15" readonly />

        <label>Horário de Retorno</label>
        <input type="time" value="18:00" readonly />
        <label class="valor">Valor do Contrato (R$)</label>
        <input type="number" id="valorContrato" placeholder="Informe o valor" />

        <div class="checkbox-area">
          <label>
            <input type="checkbox" id="confirmarCheckbox" />
            Confirmar informações e assinar documento
          </label>
        </div>

        <button class="btn-enviar" id="btnEnviar" disabled>Enviar</button>
      </div>
    </div>


  </div>
  <?php endif; ?>

</div>
  <script>
    const numeroContratoInput = document.getElementById('numeroContrato');
    const senhaContainer = document.getElementById('senhaContainer');

    numeroContratoInput.addEventListener('change', () => {
      if (numeroContratoInput.value.trim() !== '') {
        senhaContainer.classList.add('visible');
      } else {
        senhaContainer.classList.remove('visible');
      }
    });

    // Modal logic
    const modal = document.getElementById('modalContrato');
    const valorInput = document.getElementById('valorContrato');
    const checkbox = document.getElementById('confirmarCheckbox');
    const btnEnviar = document.getElementById('btnEnviar');

    function abrirModal() {
      modal.style.display = 'flex';
      valorInput.value = '';
      checkbox.checked = false;
      btnEnviar.disabled = true;
    }

    function fecharModal() {
      modal.style.display = 'none';
    }

    function validarEnvio() {
      const valorPreenchido = valorInput.value.trim() !== '';
      const confirmado = checkbox.checked;
      btnEnviar.disabled = !(valorPreenchido && confirmado);
    }

    valorInput.addEventListener('input', validarEnvio);
    checkbox.addEventListener('change', validarEnvio);



    const rotasContrato = (param) => {
      window.location.href = `<?= site_url(); ?>/contrato/${param}`;
    };
  </script>
