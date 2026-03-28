<?php

function render_google_integrations_page()
{
?>
  <div class="wrap">
    <h1><span class="dashicons dashicons-google" style="font-size: 30px; width: 30px; height: 30px;"></span> Integrações Google</h1>
    <hr>
    <form method="post" action="options.php">
      <?php
      settings_fields('glogin_group');
      do_settings_sections('google-integrations-settings');
      submit_button('Salvar Configurações');
      ?>
    </form>
  </div>
<?php
}
