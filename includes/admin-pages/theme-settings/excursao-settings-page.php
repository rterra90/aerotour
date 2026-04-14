<?php

/**
 * Renderiza a página de personalização da excursão
 */

add_action('admin_init', function () {
  register_setting('opt_excursao_geral', 'galeria_excursao');
  register_setting('opt_excursao_geral', 'exibir_galeria_excursao');
  register_setting('opt_excursao_geral', 'exibir_botao_whatsapp_excursao');
  register_setting('opt_excursao_geral', 'texto_whatsapp_excursao');
});

function render_excursao_settings_page()
{
  $galeria = get_option('galeria_excursao', []);
  $galeria = array_values($galeria);
  // wp_enqueue_media(); // Garante o seletor de mídia do WP
?>
  <div class="wrap aerotour-admin-wrapper">

    <!-- Adiciona o cabeçalho de navegação das configurações do tema -->
    <?php render_settings_header('excursao-geral'); ?>

    <div class="settings-page-content">

      <div class="content-header">
        <h2>Configurações Gerais da Excursão</h2>
        <p>Nesta seção você poderá configurar elementos globais, como cores das tabs, layouts de cards, etc.</p>
      </div>

      <form method="post" action="options.php">
        <?php
        // Deve corresponder ao grupo registrado no register_setting
        settings_fields('opt_excursao_geral');
        ?>
        <div class="notice notice-info inline">
          <p>Em desenvolvimento.</p>
        </div>

        <!-- Submenu para opções da excursão (Como Funciona e FAQ) -->
        <div class="admin-sub-nav">
          <a href="admin.php?page=config-excursao-como-funciona" class="sub-nav-card">
            <span class="dashicons dashicons-format-aside"></span>
            <div>
              <strong>Como Funciona</strong>
              <small>Gerencie os conjuntos de instruções</small>
            </div>
          </a>
          <a href="admin.php?page=config-excursao-faq" class="sub-nav-card">
            <span class="dashicons dashicons-editor-help"></span>
            <div>
              <strong>FAQ</strong>
              <small>Perguntas e respostas frequentes</small>
            </div>
          </a>
        </div>

        <!-- Seção Geral -->
        <?php get_template_part('includes/admin-pages/theme-settings/excursao/section', 'geral-excursao', []); ?>

        <!-- Seção Galeria de Fotos -->
        <?php get_template_part('includes/admin-pages/theme-settings/excursao/section', 'galeria-excursao', ['galeria' => $galeria]); ?>

        <div class="form-footer" style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #f0f0f1;">
          <?php submit_button('Salvar Todas as Configurações'); ?>
        </div>
      </form>
    </div>
  </div>

  <style>
    /* Estilos do Menu de Sub-navegação */
    .admin-sub-nav {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin-bottom: 40px;
    }

    .sub-nav-card {
      background: #fff;
      border: 1px solid #ccd0d4;
      padding: 15px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 15px;
      text-decoration: none;
      color: #2c3338;
      transition: all 0.2s;
    }

    .sub-nav-card:hover {
      border-color: #dc3545;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      transform: translateY(-2px);
    }

    .sub-nav-card .dashicons {
      font-size: 30px;
      width: 30px;
      height: 30px;
      color: #dc3545;
    }

    .sub-nav-card small {
      display: block;
      color: #646970;
    }
  </style>
<?php
  wp_enqueue_script('jquery-ui-sortable');
}
