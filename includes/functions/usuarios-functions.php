<?php

//Remove os campos de redes sociais
add_filter('user_contactmethods', 'custom_remove_user_contact_methods', 99);
function custom_remove_user_contact_methods($methods)
{
  unset($methods['linkedin']);
  unset($methods['myspace']);
  unset($methods['pinterest']);
  unset($methods['soundcloud']);
  unset($methods['tumblr']);
  unset($methods['wikipedia']);
  unset($methods['twitter']); // Nome de usuário X
  unset($methods['youtube']);
  return $methods;
}

// Remove o seletor de Idioma e Atalhos de Teclado via JS/CSS (método mais limpo para user-edit)
add_action('admin_head-user-edit.php', 'custom_remove_personal_options');
add_action('admin_head-profile.php', 'custom_remove_personal_options');
function custom_remove_personal_options()
{
  $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : get_current_user_id();
  $is_admin_user = user_can($user_id, 'edit_posts'); // Define se o usuário editado tem acesso ao painel
?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      // Remove o campo "Site" (URL)
      $('tr.user-url-wrap').remove();
      // Remove Atalhos de Teclado
      $('tr.user-comment-shortcuts-wrap').remove();
      // Remove Idioma
      $('tr.user-language-wrap').remove();
      // Garantia extra para campos do Yoast que resistirem ao PHP
      $('th:contains("Wikipedia"), th:contains("X (sem @)"), th:contains("YouTube")').closest('tr').remove();

      // Se o usuário editado NÃO for administrativo, remove Cores e Barra de Ferramentas
      <?php if (!$is_admin_user) : ?>
        $('.user-admin-color-wrap, .user-admin-bar-front-wrap').remove();
      <?php endif; ?>
    });
  </script>
<?php
}

/**
 * EXIBE OS CAMPOS PERSONALIZADOS NO PERFIL DO USUÁRIO
 */
add_action('show_user_profile', 'custom_user_profile_fields');
add_action('edit_user_profile', 'custom_user_profile_fields');

function custom_user_profile_fields($user)
{
?>
  <hr />
  <h3>Informações Adicionais (Dados de Cadastro)</h3>

  <table class="form-table">
    <tbody id="campos-para-mover">
      <tr>
        <th><label for="cpf">CPF</label></th>
        <td>
          <input type="text" name="cpf" id="cpf" value="<?php echo esc_attr(get_the_author_meta('cpf', $user->ID)); ?>" class="regular-text" />
        </td>
      </tr>
      <tr>
        <th><label for="billing_phone">Telefone (Billing)</label></th>
        <td>
          <input type="text" name="billing_phone" id="billing_phone" value="<?php echo esc_attr(get_the_author_meta('billing_phone', $user->ID)); ?>" class="regular-text" />
        </td>
      </tr>
      <tr>
        <th><label for="data_nasc">Data de Nascimento</label></th>
        <td>
          <input type="text" name="data_nasc" id="data_nasc" value="<?php echo esc_attr(get_the_author_meta('data_nasc', $user->ID)); ?>" class="regular-text" />
        </td>
      </tr>
      <tr>
        <th><label for="billing_city">Cidade</label></th>
        <td>
          <input type="text" name="billing_city" id="billing_city" value="<?php echo esc_attr(get_the_author_meta('billing_city', $user->ID)); ?>" class="regular-text" />
        </td>
      </tr>
    </tbody>
  </table>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      // Move os campos para logo após a linha do Sobrenome (last_name)
      $('#campos-para-mover tr').insertAfter($('.user-last-name-wrap'));
    });
  </script>
<?php
}

/**
 * 2. SALVA OS DADOS QUANDO O PERFIL É ATUALIZADO
 */
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

function save_custom_user_profile_fields($user_id)
{
  if (!current_user_can('edit_user', $user_id)) {
    return false;
  }

  update_user_meta($user_id, 'cpf', $_POST['cpf']);
  update_user_meta($user_id, 'billing_phone', $_POST['billing_phone']);
  update_user_meta($user_id, 'data_nasc', $_POST['data_nasc']);
  update_user_meta($user_id, 'billing_city', $_POST['billing_city']);
}


/**
 * Remove Telefone e Cidade da seção de Faturamento do WooCommerce
 * para evitar duplicidade de IDs no perfil do usuário.
 */
add_filter('woocommerce_customer_meta_fields', 'custom_remove_duplicated_woo_fields');

function custom_remove_duplicated_woo_fields($fields)
{

  // Remove o telefone do faturamento
  if (isset($fields['billing']['fields']['billing_phone'])) {
    unset($fields['billing']['fields']['billing_phone']);
  }

  // Remove a cidade do faturamento
  if (isset($fields['billing']['fields']['billing_city'])) {
    unset($fields['billing']['fields']['billing_city']);
  }

  return $fields;
}


// CABEÇALHO CUSTOMIZADO
/**
 * Adiciona o Cabeçalho Moderno via user_edit_form_tag
 * Posicionamento: Logo abaixo do título da página.
 */
add_action('user_edit_form_tag', 'custom_user_profile_header_top');

function custom_user_profile_header_top()
{
  // Verificação de segurança: apenas nas páginas de perfil/edição
  $screen = get_current_screen();
  if (! $screen || ! in_array($screen->id, ['user-edit', 'profile'])) return;

  // Recupera o ID do usuário (trata edição de terceiros ou perfil próprio)
  $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : get_current_user_id();
  $user_data = get_userdata($user_id);
  if (!$user_data) return;

  // Dados para o cabeçalho
  $nome_completo = trim($user_data->first_name . ' ' . $user_data->last_name) ?: $user_data->display_name;
  $cpf           = get_user_meta($user_id, 'cpf', true) ?: false;
  $email         = $user_data->user_email;
  $nasc          = get_user_meta($user_id, 'data_nasc', true);
  $data_nasc     = $nasc ? date('d/m/Y', strtotime($nasc)) : false;
  $telefone      = get_user_meta($user_id, 'billing_phone', true) ?: false;
  $cidade        = get_user_meta($user_id, 'billing_city', true) ?: false;

  // Métricas Financeiras
  $customer_orders = wc_get_orders([
    'customer' => $user_id,
    'status'   => ['wc-completed', 'wc-processing'],
    'limit'    => -1,
  ]);

  $qtd_pedidos = count($customer_orders);
  $total_gasto = 0;
  foreach ($customer_orders as $order) {
    $total_gasto += $order->get_total();
  }

  $valor_total = wc_price($total_gasto);
  $valor_medio = ($qtd_pedidos > 0) ? wc_price($total_gasto / $qtd_pedidos) : wc_price(0);

  // O hook user_edit_form_tag imprime DENTRO da tag <form>. 
  // Fechamos a aspa da tag (que o WP deixa aberta) e injetamos o HTML.
  echo ' >';
?>

  <div class="user-header-card">
    <div class="user-header-top">
      <div class="user-header-name">
        <h1><?php echo esc_html($nome_completo); ?></h1>
        <span class="user-id-badge">ID do Cliente: #<?php echo $user_id; ?></span>
      </div>
      <div class="stats-container">
        <div class="stats-badge">
          <small>Pedidos</small>
          <strong><?php echo $qtd_pedidos; ?></strong>
        </div>
        <div class="stats-badge">
          <small>Total Gasto</small>
          <strong><?php echo $valor_total; ?></strong>
        </div>
        <div class="stats-badge highlight">
          <small>Ticket Médio</small>
          <strong><?php echo $valor_medio; ?></strong>
        </div>
      </div>
    </div>

    <div class="user-header-grid">
      <div class="info-item <?= empty($cpf) ? 'sem-info' : '' ?>">
        <label>CPF</label>
        <p><?php echo $cpf ? esc_html($cpf) : 'Não informado'; ?></p>
      </div>
      <div class="info-item">
        <label>E-mail</label>
        <p><?php echo esc_html($email); ?></p>
      </div>
      <div class="info-item <?= empty($telefone) ? 'sem-info' : '' ?>">
        <label>Telefone</label>
        <p><?php echo $telefone ? esc_html($telefone) : 'Não informado'; ?></p>
      </div>
      <div class="info-item <?= empty($data_nasc) ? 'sem-info' : '' ?>">
        <label>Nascimento</label>
        <p><?php echo $data_nasc ? esc_html($data_nasc) : 'Não informado'; ?></p>
      </div>  
      <div class="info-item <?= empty($cidade) ? 'sem-info' : '' ?>">
        <label>Cidade</label>
        <p><?php echo $cidade ? esc_html($cidade) : 'Não informada'; ?></p>
      </div>
    </div>
  </div>

  <style>
    .user-header-card {
      background: #ffffff;
      border: 1px solid #dcdcde;
      border-radius: 12px;
      margin: 10px 0px 30px 0;
      padding: 30px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
      font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .user-header-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 25px;
      padding-bottom: 20px;
      border-bottom: 2px solid #f6f7f7;
      flex-wrap: wrap;
      gap: 20px;
    }

    .user-header-name h1 {
      margin: 0 !important;
      font-size: 28px !important;
      font-weight: 700;
      color: #1d2327;
    }

    .user-id-badge {
      display: inline-block;
      margin-top: 5px;
      padding: 4px 10px;
      background: #f0f0f1;
      border-radius: 4px;
      font-size: 12px;
      color: #50575e;
      font-weight: 600;
    }

    .stats-container {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .stats-badge {
      background: #ffffff;
      border: 1px solid #dcdcde;
      padding: 12px 20px;
      border-radius: 10px;
      text-align: center;
      min-width: 110px;
      transition: transform 0.2s;
    }

    .stats-badge.highlight {
      border-color: #2271b1;
      background: #f0f6fa;
    }

    .stats-badge small {
      font-size: 10px;
      text-transform: uppercase;
      color: #646970;
      font-weight: 700;
      display: block;
      margin-bottom: 4px;
    }

    .stats-badge strong {
      font-size: 20px;
      color: #2271b1;
    }

    .user-header-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 20px;
    }

    .info-item.sem-info p {
      opacity: .3;
    }

    .info-item label {
      display: block;
      font-size: 11px;
      font-weight: 700;
      color: #a7aaad;
      text-transform: uppercase;
      margin-bottom: 5px;
    }

    .info-item p {
      margin: 0;
      font-size: 15px;
      color: #2c3338;
      font-weight: 500;
    }
  </style>
<?php
}
