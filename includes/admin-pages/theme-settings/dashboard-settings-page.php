<?php
// Callback da Página Inicial (Dashboard)
function render_admin_dashboard_page()
{
  add_action('admin_init', function () {
    register_setting('opt_theme_geral', 'numero_wpp');
  });
?>
  <div class="wrap">
    <?php render_settings_header('dashboard'); ?>

    <div class="aerotour-settings-content">
      <h2>Bem-vindo</h2>
      <p>Utilize o menu acima para navegar entre as seções de personalização do seu tema.</p>

      <div class="welcome-panel" style="margin-top: 20px;">
        <div class="welcome-panel-content">
          <h3>Atalhos Rápidos</h3>
          <ul>
            <li><a href="admin.php?page=config-pagina-excursao" class="welcome-icon dashicons-edit">Configurar Tab "Como Funciona"</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php
}
