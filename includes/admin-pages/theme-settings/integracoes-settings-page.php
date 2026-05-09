<?php

/**
 * Renderiza a página de personalização da excursão
 */

add_action('admin_init', function () {
  register_setting('opt_theme_integrations', 'theme_gtm_id');
  register_setting('opt_theme_integrations', 'gtm_enabled');
  register_setting('opt_theme_integrations', 'google_login_enabled');
  register_setting('opt_theme_integrations', 'google_client_id');
  register_setting('opt_theme_integrations', 'google_client_secret');

  // SEÇÃO GTM
  add_settings_section(
    'gtm_section',
    'Google Tag Manager (GTM)',
    'gtm_section_header',
    'config-integracoes'
  );

  add_settings_field(
    'gtm_enabled',
    'Ativar GTM',
    'render_settings_switch',
    'config-integracoes',
    'gtm_section',
    array(
      'label_for' => 'gtm_enabled',
    )
  );

  add_settings_field(
    'gtm_id_field',
    'ID do Container (GTM-XXXXX)',
    'render_settings_field_text',
    'config-integracoes',
    'gtm_section',
    array(
      'label_for' => 'theme_gtm_id',
      'placeholder' => "GTM-XXXXXXX"
    )
  );

  // SEÇÃO GOOGLE LOGIN
  add_settings_section(
    'glogin_section',
    'Google Login',
    'glogin_section_callback',
    'config-integracoes'
  );

  add_settings_field(
    'google_login_enabled',
    'Ativar Google Login',
    'render_settings_switch',
    'config-integracoes',
    'glogin_section',
    array(
      'label_for' => 'google_login_enabled',
    )
  );

  add_settings_field(
    'google_client_id',
    'Google Client ID',
    'render_settings_field_text',
    'config-integracoes',
    'glogin_section',
    array(
      'label_for' => 'google_client_id',
      'placeholder' => "Insira o Client ID..."
    )
  );
  add_settings_field(
    'google_client_secret',
    'Google Client Secret',
    'render_settings_field_text',
    'config-integracoes',
    'glogin_section',
    array(
      'label_for' => 'google_client_secret',
      'placeholder' => "Insira o Client Secret... (opcional)",
      'type' => 'password'
    )
  );
});



/**
 * Cabeçalho explicativo GTM
 */
function gtm_section_header()
{
?>
  <div class="aerotour-admin-help-box" style="background: #f0f6fb; border-left: 4px solid #11a0d2; padding: 15px; margin-bottom: 20px; max-width: 800px;">
    <p><strong>O que é o Google Tag Manager (GTM)?</strong></p>
    <p>O GTM é uma ferramenta que centraliza a gestão de scripts (tags) do seu site, como Analytics, Ads, Pixel etc, em um único lugar.</p>
    <hr style="border: 0; border-top: 1px solid #dcdcde; margin: 15px 0;">
    <p><strong>Como obter o ID:</strong></p>
    <ol>
      <li>Acesse o <a href="https://tagmanager.google.com/" target="_blank">Google Tag Manager</a>.</li>
      <li>Crie ou selecione seu container.</li>
      <li>No topo da página, ao lado de "Espaço de trabalho", você encontrará um código no formato <strong>GTM-XXXXXXX</strong>.</li>
    </ol>
  </div>
<?php
}

/**
 * Cabeçalho explicativo Google Login
 */
function glogin_section_callback()
{
  echo '<p>Configure aqui a integração para que seus clientes possam entrar no site usando a conta do Google.</p>';
  echo '<div style="background: #efe2d1; padding: 15px; border-left: 4px solid #2271b1; margin-bottom: 20px;">
            <strong>Como obter as credenciais:</strong>
            <ol>
                <li>Acesse o <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a>.</li>
                <li>Crie um novo projeto ou selecione um existente.</li>
                <li>Vá em <strong>APIs e Serviços > Tela de permissão OAuth</strong> e configure as informações do seu site.</li>
                <li>Em <strong>Credenciais</strong>, clique em "Criar Credenciais" > "ID do cliente OAuth".</li>
                <li>Selecione "Aplicativo da Web" e adicione a URL do seu site em "Origens JavaScript autorizadas".</li>
            </ol>
          </div>';
}

/**
 * HTML da Página
 */
function render_integrations_settings_page()
{
?>
  <div class="wrap">
    <?php render_settings_header('integracoes'); ?>
    <div class="settings-page-content">
      <div class="content-header">
        <h2>Integrações do Sistema</h2>
      </div>

      <form action="options.php" method="post">
        <?php
        settings_fields('opt_theme_integrations');
        do_settings_sections('config-integracoes');
        submit_button();
        ?>
      </form>
    </div>
  </div>
<?php
}
