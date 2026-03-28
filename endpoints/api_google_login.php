<?php
add_action('rest_api_init', function () {
  register_rest_route('aerotour/v1', '/google-login', [
    'methods' => 'POST',
    'callback' => 'handle_google_login_api',
    'permission_callback' => '__return_true',
  ]);
});

function handle_google_login_api($request)
{
  $params = $request->get_json_params();
  $id_token = $params['token'];

  // 1. Validar o token com o Google
  $response = wp_remote_get("https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token);

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Falha ao validar token', ['status' => 500]);
  }

  $payload = json_decode(wp_remote_retrieve_body($response), true);

  // Verifica se o Client ID do token é o seu mesmo
  if ($payload['aud'] !== '131198865017-ohp88m555fk17nj5c744au3k8vogu332.apps.googleusercontent.com') {
    return new WP_Error('invalid_token', 'Token inválido', ['status' => 403]);
  }

  $email = $payload['email'];
  $user = get_user_by('email', $email);

  if (!$user) {
    // Criar usuário se não existir
    $_POST['terms'] = 1; // Aceita os termos
    $customer_id = wc_create_new_customer($email, $email, wp_generate_password());

    if (is_wp_error($customer_id)) {
      return $customer_id;
    }

    // Salvar dadods padrão do usuário
    $userdata = array(
      'ID'         => $customer_id,
      'first_name' => sanitize_text_field($payload['given_name']),
      'last_name'  => sanitize_text_field($payload['family_name']),
      'display_name' => sanitize_text_field($payload['given_name']),
    );
    wp_update_user($userdata);

    // 3. Salvar metadados de cobrança (Billing)
    // Importante fazer isso antes do redirecionamento para que o perfil esteja completo
    update_user_meta($customer_id, 'billing_first_name', $userdata['first_name']);
    update_user_meta($customer_id, 'billing_last_name', $userdata['last_name']);

    $user = get_user($user_id);
  }

  // 2. Logar o usuário
  wp_set_current_user($customer_id);
  wp_set_auth_cookie($customer_id, true);

  return [
    'success' => true,
    'redirect' => home_url('/minha-conta')
  ];
}
