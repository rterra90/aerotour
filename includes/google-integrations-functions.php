<?php
function register_glogin_settings()
{
  register_setting('glogin_group', 'google_login_enabled');
  register_setting('glogin_group', 'google_client_id');
  register_setting('glogin_group', 'google_client_secret');

  add_settings_section(
    'google_login_section',
    'Configurações de Google Login',
    null, // echos out any content at the top of the section
    'google-integrations-settings'
  );

  // Campo: Ativar/Desativar (Switch)
  add_settings_field(
    'google_login_enabled',
    'Ativar Google Login',
    'glogin_render_switch_field',
    'google-integrations-settings',
    'google_login_section'
  );

  // Campo: Client ID com ajuda
  add_settings_field(
    'google_client_id',
    'Google Client ID',
    'glogin_render_id_field',
    'google-integrations-settings',
    'google_login_section',
    ['label_for' => 'google_client_id']
  );

  // Campo: Client Secret
  add_settings_field(
    'google_client_secret',
    'Google Client Secret',
    'glogin_render_secret_field',
    'google-integrations-settings',
    'google_login_section',
    ['label_for' => 'google_client_secret', 'type' => 'password']
  );
}
add_action('admin_init', 'register_glogin_settings');


/**
 * Renderiza input Client ID GOOGLE LOGIN
 */
function glogin_render_id_field()
{
  $value = get_option('google_client_id');
  echo '<input type="text" name="google_client_id" value="' . esc_attr($value) . '" class="regular-text" placeholder="Ex: 123456789-abc.apps.googleusercontent.com">';
  echo '<p class="description">Insira o ID gerado no Google Cloud Console.</p>';
}

/**
 * Renderiza input Client Secret GOOGLE LOGIN
 */
function glogin_render_secret_field()
{
  $value = get_option('google_client_secret');
  echo '<input type="password" name="google_client_secret" value="' . esc_attr($value) . '" class="regular-text">';
  echo '<p class="description">Opcional, para aplicações</p>';
}

/**
 * Renderiza o Switch (Toggle) GOOGLE LOGIN
 */
function glogin_render_switch_field()
{
  $enabled = get_option('google_login_enabled');
?>
  <label class="admin-switch">
    <input type="checkbox" name="google_login_enabled" value="1" <?php checked(1, $enabled); ?>>
    <span class="admin-slider"></span>
  </label>
  <p class="description">Haabilite a opção de "Entrar com Google" para novos cadastros e logins.</p>

<?php
}
