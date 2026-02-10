<div class="sugestao-final-container">
  <h3 class="modal-title">Quase lá! 🚀</h3>
  <p>Não encontramos a excursão para <strong>"{{termo}}"</strong>. Deixe seus dados e nossa equipe verificará a disponibilidade!</p>

  <form id="form-sugestao-nativa" class="modal-form">
    <input type="hidden" name="sugestao_nome" value="{{termo}}">

    <div class="form-group">
      <input type="text" name="usuario_nome" placeholder="Seu nome completo" required>
    </div>

    <div class="form-group">
      <input type="email" name="usuario_email" placeholder="Seu melhor e-mail" required>
    </div>

    <div class="form-group">
      <input type="tel" name="usuario_tel" id="campo-tel" placeholder="WhatsApp (DDD + Número)" required>
    </div>

    <div class="modal-actions">
      <button type="submit" class="btn-enviar-modal">Enviar Sugestão</button>
    </div>
  </form>
</div>