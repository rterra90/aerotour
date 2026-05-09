<?php
add_action('admin_init', function () {
  register_setting('opt_contatos', 'contato_whatsapp');
  register_setting('opt_contatos', 'contato_telegram');
  register_setting('opt_contatos', 'contato_instagram');
  register_setting('opt_contatos', 'contato_facebook');
  register_setting('opt_contatos', 'contato_x');
  register_setting('opt_contatos', 'contato_tiktok');
  register_setting('opt_contatos', 'contato_youtube');
});
function render_contato_settings_page()
{
  // Feedback visual de salvamento
  if (isset($_GET['settings-updated'])) {
    add_settings_error('aerotour_messages', 'aerotour_message', 'Configurações de contato salvas!', 'updated');
  }
  settings_errors('aerotour_messages');
?>
  <div class="wrap theme-admin-wrapper">
    <?php render_settings_header('contato'); ?>

    <div class="settings-page-content">
      <div class="content-header">
        <h2>Configurações de Contato</h2>
        <p>Defina as informações de contato e links das redes sociais que serão exibidos no site.</p>
      </div>

      <form method="post" action="options.php">
        <?php settings_fields('opt_contatos'); ?>

        <table class="form-table" role="presentation">
          <tr>
            <th scope="row"><label for="admin_email">E-mail Principal</label></th>
            <td>
              <input name="admin_email" type="email" id="admin_email" value="<?php echo esc_attr(get_option('admin_email')); ?>" class="regular-text">
              <p class="description">Este é o e-mail principal do site (sincronizado com as Configurações Gerais).</p>
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="contato_whatsapp">WhatsApp</label></th>
            <td>
              <input name="contato_whatsapp" type="text" id="contato_whatsapp" value="<?php echo esc_attr(get_option('contato_whatsapp')); ?>" class="regular-text" placeholder="Ex: 5519999999999">
              <p class="description">Somente números, incluindo o DDI (55) e o DDD.</p>
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="contato_telegram">Telegram</label></th>
            <td>
              <input name="contato_telegram" type="url" id="contato_telegram" value="<?php echo esc_url(get_option('contato_telegram')); ?>" class="regular-text" placeholder="https://t.me/seuusuario">
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="contato_instagram">Instagram</label></th>
            <td>
              <input name="contato_instagram" type="url" id="contato_instagram" value="<?php echo esc_url(get_option('contato_instagram')); ?>" class="regular-text" placeholder="https://instagram.com/perfil">
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="contato_facebook">Facebook</label></th>
            <td>
              <input name="contato_facebook" type="url" id="contato_facebook" value="<?php echo esc_url(get_option('contato_facebook')); ?>" class="regular-text">
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="contato_x">X (Twitter)</label></th>
            <td>
              <input name="contato_x" type="url" id="contato_x" value="<?php echo esc_url(get_option('contato_x')); ?>" class="regular-text">
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="contato_tiktok">TikTok</label></th>
            <td>
              <input name="contato_tiktok" type="url" id="contato_tiktok" value="<?php echo esc_url(get_option('contato_tiktok')); ?>" class="regular-text">
            </td>
          </tr>

          <tr>
            <th scope="row"><label for="contato_youtube">YouTube</label></th>
            <td>
              <input name="contato_youtube" type="url" id="contato_youtube" value="<?php echo esc_url(get_option('contato_youtube')); ?>" class="regular-text">
            </td>
          </tr>
        </table>

        <div class="form-footer" style="margin-top: 30px;">
          <?php submit_button('Salvar Contatos'); ?>
        </div>
      </form>
    </div>
  </div>
<?php
}
