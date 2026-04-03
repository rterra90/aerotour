<?php
defined('ABSPATH') || exit;

$user_id = get_current_user_id();
$documento_salvo = get_user_meta($user_id, 'cpf', true); // O meta 'cpf' armazena ambos 
$possui_valor = !empty($documento_salvo);
$tipo_documento = null;
if ($possui_valor) {
  $doc_sanitizado = str_replace('-', '', str_replace('.', '', $documento_salvo));
  $tipo_documento = strlen($doc_sanitizado) === 11 ? 'CPF' : 'RNE';
  if ($tipo_documento === 'CPF') {
    $documento_salvo = cpf_mask($doc_sanitizado);
  } else {
    $documento_salvo = rne_mask($doc_sanitizado);
  }
}

// Identifica se o valor salvo tem formato de RNE ou CPF para marcar o rádio correto
$tipo_inicial = (strlen(preg_replace('/\D/', '', $documento_salvo)) > 11 || preg_match('/[A-Z]/i', $documento_salvo)) ? 'rne' : 'cpf';

do_action('woocommerce_before_edit_account_form');
?>
<h2>Detalhes da conta</h2>
<form class="woocommerce-EditAccountForm edit-account modern-form" action="" method="post" id="aerotour-edit-account">

  <div class="form-grid">
    <div class="form-section-card">
      <h3><i class="bi bi-person-vcard me-2"></i>Dados pessoais</h3>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="account_first_name">Nome *</label>
          <input type="text" class="aer-text-input" name="account_first_name" id="account_first_name" value="<?php echo esc_attr($user->first_name); ?>" required />
        </div>
        <div class="col-md-6 mb-3">
          <label for="account_last_name">Sobrenome *</label>
          <input type="text" class="aer-text-input" name="account_last_name" id="account_last_name" value="<?php echo esc_attr($user->last_name); ?>" required />
        </div>
      </div>

      <div class="d-none">
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide d-none">
          <label for="account_display_name"><?php esc_html_e('Display name', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
          <input type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr($user->display_name); ?>" /> <span><em><?php esc_html_e('This will be how your name will be displayed in the account section and in reviews', 'woocommerce'); ?></em></span>

        </p>
      </div>

      <div class="document-selector mb-3">
        <label class="d-block mb-2">Documento de Identificação</label>
        <div class="d-flex gap-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="doc_type" id="type_cpf" value="cpf"
              <?php echo ($tipo_inicial === 'cpf') ? 'checked' : ''; ?>
              <?php echo $possui_valor ? 'disabled' : ''; ?>>
            <label class="form-check-label" for="type_cpf">CPF</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="doc_type" id="type_rne" value="rne"
              <?php echo ($tipo_inicial === 'rne') ? 'checked' : ''; ?>
              <?php echo $possui_valor ? 'disabled' : ''; ?>>
            <label class="form-check-label" for="type_rne">RNE/RNM (Estrangeiros)</label>
          </div>
        </div>

        <input type="text"
          data-status="<?= $possui_valor ? 'disabled'  : 'enabled'; ?>"
          name="cpf"
          id="doc_field"
          class="aer-text-input <?php echo $possui_valor ? 'locked-field' : ''; ?>"
          value="<?php echo esc_attr($documento_salvo); ?>"
          placeholder=000.000.000-00"
          <?php echo $possui_valor ? 'readonly' : ''; ?>
          required />

        <?php if ($possui_valor): ?>
          <small class="text-muted d-block mt-1">
            <i class="bi bi-info-circle me-1"></i>Para alterar seu documento, entre em contato com o suporte.
          </small>
          <input type="hidden" name="doc_type" value="<?php echo esc_attr($tipo_inicial); ?>">
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="account_email">E-mail *</label>
        <input type="email" class="aer-text-input" name="account_email" id="account_email" value="<?php echo esc_attr($user->user_email); ?>" required />
      </div>

      <div class="custom-fields-wrapper">
        <?php do_action('woocommerce_edit_account_form'); ?>
      </div>
    </div>

    <div class="form-section-card security-section">
      <div class="d-flex mb-3">
        <h3 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Segurança</h3>
        <button type="button" class="btn-toggle-password" onclick="togglePasswordFields()">
          Alterar Senha <i class="bi bi-chevron-down ms-1"></i>
        </button>
      </div>

      <div id="password-change-fields" style="display: none;">
        <p class="text-muted small mb-3">Deixe em branco para manter a senha atual.</p>
        <div class="mb-3">
          <label for="password_current">Senha atual</label>
          <input type="password" class="aer-text-input" name="password_current" id="password_current" />
        </div>
        <div class="mb-3">
          <label for="password_1">Nova senha</label>
          <input type="password" class="aer-text-input" name="password_1" id="password_1" />
        </div>
        <div class="mb-3">
          <label for="password_2">Confirmar nova senha</label>
          <input type="password" class="aer-text-input" name="password_2" id="password_2" />
        </div>
      </div>
    </div>
  </div>

  <div class="form-actions mt-4 text-end">
    <?php wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
    <button type="submit" class="ae-btn-primary px-5" name="save_account_details">Salvar Alterações</button>
    <input type="hidden" name="action" value="save_account_details" />
  </div>

  <?php do_action('woocommerce_edit_account_form_end'); ?>
</form>

<script>
  function togglePasswordFields() {
    const fields = document.getElementById('password-change-fields');
    const btn = document.querySelector('.btn-toggle-password i');
    if (fields.style.display === "none") {
      fields.style.display = "block";
      btn.classList.replace('bi-chevron-down', 'bi-chevron-up');
    } else {
      fields.style.display = "none";
      btn.classList.replace('bi-chevron-up', 'bi-chevron-down');
    }
  }
  document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('billing_phone');
    const dnInput = document.getElementById('data_nasc');
    const docInput = document.getElementById('doc_field');
    const radioCpf = document.getElementById('type_cpf');
    const radioRne = document.getElementById('type_rne');
    const form = document.getElementById('aerotour-edit-account');

    // Listeners para aplicação de máscaras ao digitar nos inputs de doc, telefone e data
    docInput.addEventListener('input', function(e) {
      const type = radioCpf.checked ? 'cpf' : 'rne';
      e.target.value = applyMask(e.target.value, type);
    });

    phoneInput.addEventListener('input', (e) => {
      e.target.value = applyMask(e.target.value, 'phone');
    })

    dnInput.addEventListener('input', (e) => {
      e.target.value = applyMask(e.target.value, 'data');
    })

    // Remove atributo 'name' do input de doc caso já exista documento salvo, impedindo alteração
    if (docInput.dataset.status === 'disabled') docInput.removeAttribute('name');

    // Função de validação rápida para o Front
    function isDocValid() {
      if (docInput.dataset.status === 'disabled') return true

      const val = docInput.value;
      const isCpf = radioCpf.checked;

      if (isCpf) {
        // Valida apenas formato básico no front para não ser pesado
        return /^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(val);
      } else {
        // Valida formato RNE (Letra + números + hífen + dígito/letra)
        return /^[A-Z]\d{6,7}-[A-Z0-9]$/i.test(val);
      }
    }

    function validateDoc(value, type) {
      if (type === 'cpf') {
        return /^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(value);
      } else {
        return /^[A-Z]\d{6}-[A-Z0-9]$/.test(value);
      }
    }



    // Limpa campo ao trocar tipo (se não estiver bloqueado)
    [radioCpf, radioRne].forEach(radio => {
      radio.addEventListener('change', function() {
        if (!docInput.readOnly) {
          docInput.value = '';
          docInput.placeholder = this.value === 'cpf' ? '000.000.000-00' : 'X123456-7';
        }
      });
    });

    // Bloqueio de envio com dados incorretos
    form.addEventListener('submit', function(e) {
      // Se o campo estiver vazio ou inválido
      if (docInput.value !== "" && !isDocValid()) {
        e.preventDefault(); // Trava o envio

        // Feedback visual
        docInput.style.borderColor = "#e74c3c";
        docInput.style.boxShadow = "0 0 0 3px rgba(231, 76, 60, 0.2)";

        alert('Atenção: O formato do documento informado é inválido. Verifique e tente novamente.');
        docInput.focus();
      }
    });

    // Remove o erro visual ao começar a digitar novamente
    docInput.addEventListener('input', function() {
      this.style.borderColor = "";
      this.style.boxShadow = "";
    });
  });
</script>