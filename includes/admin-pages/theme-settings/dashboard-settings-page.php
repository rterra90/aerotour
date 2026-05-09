<?php
// Callback da Página Inicial (Dashboard)
function render_admin_dashboard_page()
{
  add_action('admin_init', function () {
    register_setting('opt_theme_geral', 'numero_wpp');
  });
?>
  <div class="wrap theme-admin-wrapper">
    <?php render_settings_header('dashboard'); ?>

    <div class="settings-page-content">
      <div class="content-header">
        <h2>Configurações do site</h2>
      </div>

      <h3>Atalhos Rápidos</h3>
      <ul>
        <li><a href="admin.php?page=config-pagina-excursao" class="welcome-icon dashicons-edit">Configurar Tab "Como Funciona"</a></li>
      </ul>
    </div>
  </div>
<?php
}
