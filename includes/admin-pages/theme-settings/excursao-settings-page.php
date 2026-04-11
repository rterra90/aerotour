<?php

/**
 * Renderiza a página de personalização da excursão
 */
function render_excursao_settings_page()
{
  // Agora pegamos os grupos (se não existir, inicia array vazio)
  $grupos_instrucoes = get_option('como_funciona_sets', []);
  $set_padrao = get_option('como_funciona_set_padrao', ''); // Armazena o ID do set padrão
?>
  <div class="wrap aerotour-admin-wrapper">
    <?php render_settings_header('excursao-geral'); ?>
    <div class="aerotour-settings-content">
      <h2>Configurações Gerais da Excursão</h2>
      <p>Nesta seção você poderá configurar elementos globais, como cores das tabs, layouts de cards, etc.</p>
      <div class="notice notice-info inline">
        <p>Em desenvolvimento.</p>
      </div>
    </div>
  </div>
<?php
  wp_enqueue_script('jquery-ui-sortable');
}
