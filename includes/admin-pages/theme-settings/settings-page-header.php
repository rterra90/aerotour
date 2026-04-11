<?php

/**
 * Renderiza o cabeçalho de navegação das configurações do tema
 * css: css/admin/theme-settings.css
 */
function render_settings_header($current_page = '')
{
?>
  <div class="theme-admin-header">
    <div class="theme-brand">
      <span class="dashicons dashicons-admin-generic"></span>
      <h1>Themes <small>Configurações do Tema</small></h1>
    </div>

    <nav class="theme-nav-tabs">
      <a href="admin.php?page=tema-geral-settings" class="nav-tab <?php echo $current_page == 'dashboard' ? 'nav-tab-active' : ''; ?>">
        Dashboard
      </a>
      <!-- <div class="nav-tab-separator"></div> -->

      <div class="nav-tab-dropdown">
        <a href="admin.php?page=config-excursao" class="nav-tab <?php echo in_array($current_page, ['excursao-geral', 'excursao-como-funciona', 'excursao-faq']) ? 'nav-tab-active' : ''; ?>">
          Página Produto (Geral) <span class="dashicons dashicons-arrow-down-alt2" style="font-size: 14px; vertical-align: middle; padding-left: 4px;"></span>
        </a>

        <div class="dropdown-content">
          <a href="admin.php?page=config-excursao-como-funciona" class="dropdown-link <?php echo $current_page == 'excursao-como-funciona' ? 'active' : ''; ?>">
            Como Funciona
          </a>
          <a href="admin.php?page=config-excursao-faq" class="dropdown-link <?php echo $current_page == 'excursao-faq' ? 'active' : ''; ?>">
            FAQ
          </a>
        </div>
      </div>
      <!-- <a href="admin.php?page=tema-geral-settings" class="nav-tab <?php echo $current_page == 'dashboard' ? 'nav-tab-active' : ''; ?>">
        Dashboard
      </a>
      <a href="admin.php?page=config-pagina-excursao" class="nav-tab <?php echo $current_page == 'excursao' ? 'nav-tab-active' : ''; ?>">
        Página da Excursão
      </a>
      <a href="#" class="nav-tab">Checkout (Em breve)</a> -->
    </nav>
  </div>
<?php
}
