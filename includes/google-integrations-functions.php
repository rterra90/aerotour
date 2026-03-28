<?php

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
  <p class="description">Habilite a opção de "Entrar com Google" para novos cadastros e logins.</p>

  <style>
    .admin-switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .admin-switch input[type="checkbox"] {
      visibility: hidden;
    }

    .admin-switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .admin-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      width: 48px;
      transition: .4s;
      border-radius: 24px;
      height: 20px;
    }

    .admin-slider:before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 3px;
      bottom: 2px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked+.admin-slider {
      background-color: #2271b1;
    }

    input:checked+.admin-slider:before {
      transform: translateX(26px);
    }
  </style>
<?php
}

/**
 * Texto de introdução e ajuda geral GOOGLE LOGIN
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
