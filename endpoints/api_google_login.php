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
  // Profissionalmente, você usaria a biblioteca Google_Client, 
  // mas aqui faremos uma verificação via API remota do Google:
  $response = wp_remote_get("https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token);

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Falha ao validar token', ['status' => 500]);
  }

  $payload = json_decode(wp_remote_retrieve_body($response), true);

  // Verifica se o Client ID do token é o seu mesmo [cite: 20]
  if ($payload['aud'] !== '131198865017-ohp88m555fk17nj5c744au3k8vogu332.apps.googleusercontent.com') {
    return new WP_Error('invalid_token', 'Token inválido', ['status' => 403]);
  }

  $email = $payload['email'];
  $user = get_user_by('email', $email);

  if (!$user) {
    // Criar usuário se não existir
    $user_id = wp_insert_user([
      'user_login' => $email, // Usar email como login é mais seguro que o username do formulário
      'user_email' => $email,
      'first_name' => $payload['given_name'],
      'last_name'  => $payload['family_name'],
      'user_pass'  => wp_generate_password(),
      'role'       => 'subscriber'
    ]);

    if (is_wp_error($user_id)) {
      return $user_id;
    }
    $user = get_user($user_id);
  }

  // 2. Logar o usuário
  wp_set_current_user($user->ID);
  wp_set_auth_cookie($user->ID, true);

  return [
    'success' => true,
    'redirect' => home_url('/minha-conta')
  ];
}
