<div class="sugestao-final-container">
  <h3 class="modal-title">Quase lá! 🚀</h3>
  <p>Parece que ainda não temos uma excursão para <strong>"{{termo}}"</strong>. Deixe seus dados e nossa equipe verificará a disponibilidade!</p>

  <form id="form-sugestao-nativa" class="modal-form">
    <input type="hidden" name="sugestao_nome" value="{{termo}}">

    <div class="form-group">
      <input type="text" name="usuario_nome" placeholder="Seu nome completo" required>
    </div>

    <div class="form-group">
      <input type="email" name="usuario_email" placeholder="Seu melhor e-mail" required>
    </div>

    <div class="form-group">
      <input type="tel" name="usuario_tel" id="campo-tel" placeholder="Tel WhatsApp (opcional)">
    </div>

    <div class="modal-actions">
      <button type="submit" class="btn-enviar-modal">Enviar Sugestão</button>
    </div>
  </form>
</div>

<script>
  // Esta lógica agora está ISOLADA e só existe quando este modal abre
  (function() {
    const form = document.querySelector('#form-sugestao-nativa');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = form.querySelector('button');
      btn.innerText = "Enviando...";
      btn.disabled = true;

      const formData = new FormData(form);
      formData.append('action', 'processar_sugestao');


      try {
        const response = await fetch(themeLinks.adminAjaxUrl, {
          method: 'POST',
          body: formData
        });
        const result = await response.json();

        if (result.success) {
          form.parentElement.innerHTML = "<h3>✓ Sugestão enviada com sucesso!</h3><p>Avisaremos a você se tivermos novidades sobre excursão para o seu evento. Obrigado pelo contato!</p><button type='button' class='btn-fechar-sucesso' id='btn-close-modal-success'>Fechar Janela</button>";

          // Lógica para o botão fechar funcionar
          document.getElementById('btn-close-modal-success').addEventListener('click', () => {
            // Opção 1: Se o seu botão de fechar padrão do modal tem a classe .close-button
            const mainCloseBtn = document.querySelector('#generalModal .close-button');
            if (mainCloseBtn) {
              mainCloseBtn.click();
            } else {
              // Opção 2: Forçar a remoção das classes caso não encontre o botão
              document.getElementById('generalModal').classList.remove('open');
              document.body.classList.remove('modal-open');
            }
          });
        }
      } catch (err) {
        alert("Erro ao enviar. Tente novamente.");
        btn.disabled = false;
        btn.innerText = "Enviar Sugestão";
      }
    });
  })();
</script>