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
                'number' => 1, // só precisa de um
            ]);

            if (!empty($users)) {
                $found_user = $users[0];
                $target_user_email = $found_user->user_email;

                // Passa null como primeiro parâmetro
                return wp_authenticate_username_password(
                    null,
                    $target_user_email,
                    $password,
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
            // se o usuário nao tem meta CPF salvo
            if (!str_contains($_username, '@')) {
                // se o username for CPF (usuário antigo)
                update_user_meta($user->ID, 'cpf', $_username); // atualiza o meta CPF para o mesmo valor que está no username
            }
        }
    }
}

// RESET PASSWORD / RECUPERA SENHA

//Tela de confirmação (reset-link-sent=true)
add_action(
    'woocommerce_before_lost_password_confirmation_message',
    function () {
        echo '<div class="login-container confirmation-container">';
        echo '<div class="login-box">';
    },
);
add_filter(
    'woocommerce_lost_password_confirmation_message',
    'custom_lost_password_message',
    10,
    1,
);
function custom_lost_password_message($message)
{
    $message =
        'Prontinho! Olhe a sua caixa de entrada (e a de spam). Enviamos as instruções de recuperação para você.';
    return $message;
}
add_action('woocommerce_after_lost_password_confirmation_message', function () {
    echo '<div class="mt-5 text-center"><a href="' .
        wc_get_page_permalink('myaccount') .
        '" class="small link-voltar"><< Voltar à tela de login</a></div>';
    echo '</div>';
    echo '</div>';
});

//Tela do formulário de redefinição de senha
add_action('woocommerce_before_reset_password_form', function () {
    echo '<div class="login-container confirmation-container">';
    echo '<div class="login-box">';
});
add_action('woocommerce_after_reset_password_form', function () {
    echo '</div>';
    echo '</div>';?>
      <script>
          const inputs = document.querySelectorAll('input[type="password"]');
          const btn = document.querySelector('button[type="submit"]');
          if(inputs) inputs.forEach(inp => inp.classList.add('modern-text-input'));
          if(btn) btn.classList.add('main-btn');
      </script>
    <?php
});
