<?php

/**
 * Template Part: Seção de Configurações Gerais da Excursão
 * Path: includes/admin-pages/theme-settings/excursao/section-geral-excursao.php
 */

// Recupera as opções necessárias
$whatsapp_cadastrado = get_option('contato_whatsapp', '');
$exibir_botao_wpp   = get_option('exibir_botao_whatsapp_excursao', '1'); // '1' por padrão
$texto_padrao       = "Olá, quero informações sobre a excursão [NOME_EXCURSAO].";
$texto_whatsapp     = get_option('texto_whatsapp_excursao', $texto_padrao);
?>

<div class="settings-section">
  <h3>Configurações Gerais de Exibição</h3>

  <div class="exibicao-controle-wrapper" style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ccd0d4; margin-bottom: 20px;">

    <label for="exibir_botao_whatsapp_excursao" style="display: flex; align-items: center; cursor: pointer; font-weight: 600; font-size: 14px;">
      <input type="checkbox"
        name="exibir_botao_whatsapp_excursao"
        id="exibir_botao_whatsapp_excursao"
        value="1"
        <?php checked('1', $exibir_botao_wpp); ?>
        style="margin-right: 12px; width: 20px; height: 20px;">
      Ativar botão de WhatsApp na página de produto
    </label>

    <div id="wpp-config-accordion" style="<?php echo ($exibir_botao_wpp !== '1') ? 'display: none;' : ''; ?> margin-top: 20px;">
      <?php if (empty($whatsapp_cadastrado)) : ?>
        <div class="notice notice-warning inline" style="margin: 20px 0 0 0; border-left-color: #ffb900; background: #fffcf5;">
          <p style="display: flex; align-items: center; gap: 8px;">
            <span class="dashicons dashicons-warning" style="color: #f59e0b;"></span>
            <span>
              <strong>Atenção:</strong> Nenhum número de WhatsApp configurado.
              O botão <strong>não aparecerá</strong> na página enquanto isso.
              <a href="<?php echo admin_url('admin.php?page=config-contatos'); ?>" style="text-decoration: none; font-weight: 600; margin-left: 5px;">
                Configurar número agora →
              </a>
            </span>
          </p>
        </div>
      <?php endif; ?>

      <div class="whatsapp-text-config" style="padding-top: 20px; border-top: 1px solid #f0f0f1;">
        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Mensagem Padrão do WhatsApp:</label>
        <textarea name="texto_whatsapp_excursao" rows="1" class="large-text" placeholder="Digite a frase que o cliente enviará..."><?php echo esc_textarea($texto_whatsapp); ?></textarea>

        <div style="margin-top: 10px; background: #f9f9f9; padding: 12px; border-radius: 6px; border: 1px dashed #ccd0d4;">
          <p style="margin: 0; font-size: 13px; color: #50575e;">
            <strong>💡 Como inserir o nome da excursão:</strong><br>
            Utilize a tag <code>[NOME_EXCURSAO]</code> no local onde deseja que o nome apareça. <br>
            <em>Exemplo: "Olá, quero informações sobre a excursão [NOME_EXCURSAO]."</em>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* Ajuste para alinhar o aviso inline dentro da nossa estrutura customizada */
  .settings-section .notice.inline {
    padding: 10px 15px;
    border: 1px solid #ccd0d4;
    border-left-width: 4px;
    box-shadow: none;
  }
</style>
<script>
  jQuery(document).ready(function($) {
    $('#exibir_botao_whatsapp_excursao').on('change', function() {
      if ($(this).is(':checked')) {
        $('#wpp-config-accordion').slideDown();
      } else {
        $('#wpp-config-accordion').slideUp();
      }
    });
  });
</script>