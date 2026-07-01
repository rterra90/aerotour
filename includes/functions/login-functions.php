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


// // // // // // ** ** ** ** ** ** ** ** ** ** ** **
// // // // 
// // CADASTRO E DADOS PESSOAIS

/* Adiciona campos ao formulário de registro */
function campos_registro()
{
  $campos = [
    ['Primeiro nome', 'billing_first_name'],
    ['Sobrenome', 'billing_last_name']
  ];

  foreach ($campos as $campo) { ?>
    <p class="form-row">
      <label for=<?= $campo[1] ?>><?php _e(
                                    $campo[0],
                                    'text_domain'
                                  ); ?><span class="required">*</span></label>
      <input type="text" class="input-text" name=<?= $campo[1] ?> id=<?= $campo[1] ?> value=<?php if (
                                                                                              !empty($_POST[$campo[1]])
                                                                                            ) {
                                                                                              esc_attr_e($_POST[$campo[1]]);
                                                                                            } ?>>
    </p>
  <?php }
}
function salva_campos($customer_id)
{
  $campos = [
    ['Primeiro nome', 'billing_first_name'],
    ['Sobrenome', 'billing_last_name']
  ];

  foreach ($campos as $campo) {
    if ($campo[0] === 'Primeiro nome' && isset($_POST[$campo[1]])) {
      update_user_meta(
        $customer_id,
        $campo[1],
        sanitize_text_field($_POST[$campo[1]])
      );
      wp_update_user(['ID' => $customer_id, 'first_name' => $_POST[$campo[1]]]);
      wp_update_user([
        'ID' => $customer_id,
        'display_name' => $_POST[$campo[1]]
      ]);
    } elseif ($campo[0] === 'Sobrenome' && isset($_POST[$campo[1]])) {
      update_user_meta(
        $customer_id,
        $campo[1],
        sanitize_text_field($_POST[$campo[1]])
      );
      wp_update_user(['ID' => $customer_id, 'last_name' => $_POST[$campo[1]]]);
    } elseif ($campo[0] === 'Telefone' && isset($_POST[$campo[1]])) {
      update_user_meta(
        $customer_id,
        $campo[1],
        sanitize_text_field($_POST[$campo[1]])
      );
    }
  }

  if (isset($_POST['register_method'])) {
    update_user_meta(
      $customer_id,
      'register_method',
      $_POST['register_method']
    );
    // if($_POST['register_method'] === '_google_register'){
    // wp_new_user_notification( $customer_id, null,'user');
    // }
  }

  update_user_meta($customer_id, 'billing_city', '');
  update_user_meta($customer_id, 'data_nasc', '');
  update_user_meta($customer_id, 'rg', '');
  update_user_meta($customer_id, 'rg_orgao_exp', '');
  update_user_meta($customer_id, 'cupons', '');

  if (isset($_POST['qr_event_coupon_control'])) {
    update_user_meta(
      $customer_id,
      'qr_event_coupon_control',
      $_POST['qr_event_coupon_control']
    );
  } elseif (isset($_POST['new_register_coupon_control'])) {
    update_user_meta(
      $customer_id,
      'new_register_coupon_control',
      $_POST['new_register_coupon_control']
    );
  }
}

add_action('woocommerce_register_form_start', 'campos_registro');
// add_action('woocommerce_register_form', 'avisos_registro');
add_action('woocommerce_created_customer', 'salva_campos');
/* Fim Adiciona campos ao formulário de registro */

/* Formulário de alteração de dados pessoais */
function add_fields_to_edit_account_form()
{
  $campos = [
    ['Telefone', 'billing_phone'],
    ['Data de nascimento', 'data_nasc'],
    ['Cidade', 'billing_city']
  ];
  foreach ($campos as $campo) {
    $value = isset(get_user_meta(get_current_user_id())[$campo[1]][0])
      ? esc_attr(get_user_meta(get_current_user_id())[$campo[1]][0])
      : ''; ?>
    <div>
      <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
        <label for="<?= $campo[1] ?>"><?= $campo[0] ?></label>
        <?php if ($campo[0] == 'CPF' && $value !== '') { ?>
          <input disabled type="text" class="modern-text-input woocommerce-Input woocommerce-Input--text input-text" id="<?= $campo[1] ?>" value="<?php echo cpf_mask($value); ?>" />
        <?php } else { ?>
          <input type="text" class="modern-text-input woocommerce-Input woocommerce-Input--text input-text" name="<?= $campo[1] ?>" id="<?= $campo[1] ?>" value="<?php echo $value; ?>" />
        <?php } ?>

      </p>
    </div>
  <?php
  } ?>
<?php
}

function save_account_details_form($customer_id)
{
  $campos = [
    ['billing_phone'],
    ['cpf'], // Onde salvamos CPF ou RNE
    ['data_nasc'],
    ['billing_city']
  ];

  foreach ($campos as $campo) {
    $meta_key = $campo[0];

    if (isset($_POST[$meta_key])) {
      $value = sanitize_text_field($_POST[$meta_key]);

      // Se for o campo de documento, removemos pontuação e traços
      if ($meta_key === 'cpf') {
        // Remove tudo que não for letra ou número
        $value = preg_replace('/[^A-Za-z0-9]/', '', $value);
        // Garante que letras fiquem em maiúsculo (padrão RNE)
        $value = strtoupper($value);
      }

      update_user_meta($customer_id, $meta_key, $value);
    }
  }
}

add_action('woocommerce_edit_account_form', 'add_fields_to_edit_account_form');
add_action('woocommerce_save_account_details', 'save_account_details_form');


/**
 * 1. Validação dos documentos (CPF/RNE) antes de salvar
 */
add_action('woocommerce_save_account_details_errors', 'validar_documentos_aerotour', 10, 1);
function validar_documentos_aerotour($errors)
{
  if (isset($_POST['cpf']) && !empty($_POST['cpf'])) {
    $current_user_id = get_current_user_id();
    $doc = sanitize_text_field($_POST['cpf']);
    $tipo = isset($_POST['doc_type']) ? $_POST['doc_type'] : 'cpf';

    // 1. Limpa o documento para comparação (apenas alfanumérico)
    $clean_doc = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $doc));

    // 2. Validação de Formato
    if ($tipo === 'cpf') {
      // Validação de CPF (Formato e Dígitos)
      if (!validaCPF($doc)) {
        $errors->add('error', 'O <strong>CPF</strong> informado é inválido. Por favor, verifique os números.');
      }
    } else {
      // Validação de RNE (Formato: Letra + 6 ou 7 números + dígito/letra)
      // Regex: Inicia com letra, segue com números, hífen e termina com letra ou número
      if (!preg_match('/^[A-Z]\d{6,7}-[A-Z0-9]$/i', $doc)) {
        $errors->add('error', 'O <strong>RNE/RNM</strong> informado não está no formato correto (Ex: V123456-7).');
      }
    }



    // 3. Verificação de Unicidade no Banco de Dados
    $user_query = new WP_User_Query(array(
      'meta_key'     => 'cpf',
      'meta_value'   => $clean_doc,
      'exclude'      => array($current_user_id), // Ignora o próprio usuário atual
      'number'       => 1,
      'fields'       => 'ID'
    ));

    if (!empty($user_query->get_results())) {
      $errors->add('error', 'Este <strong>CPF/RNE</strong> já está cadastrado em outra conta. Caso precise de ajuda, entre em contato.');
    }
  }
}
/* Fim Formulário de alteração de dados pessoais */