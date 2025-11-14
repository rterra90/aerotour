<?php
include 'pdv-relatorios-functions.php';
include 'pdv-email-functions.php';
// ======================
// RASTREAMENTO DE PARCEIRO
// ======================

// 1) Detecta o parâmetro ?ref= na URL e grava cookie por 60 minutos (3600s).
add_action('init', function () {
  if (isset($_GET['pdv']) && !empty($_GET['pdv'])) {
    $codigo = sanitize_title($_GET['pdv']);

    // Tenta localizar o parceiro com esse código (slug)
    $args = [
      'name' => $codigo,
      'post_type' => 'pdv',
      'post_status' => 'publish',
      'numberposts' => 1
    ];
    $posts = get_posts($args);

    if (!empty($posts)) {
      // Parceiro encontrado, grava o cookie
      $expire = time() + 3600; // 1 hora
      setcookie(
        'parceiro_pdv',
        $codigo,
        $expire,
        COOKIEPATH ?: '/',
        COOKIE_DOMAIN ?: '',
        is_ssl(),
        true
      );
      $_COOKIE['parceiro_pdv'] = $codigo; // atualiza $_COOKIE para uso imediato
    } else {
      // Parceiro não encontrado, opcionalmente pode limpar o cookie
      setcookie(
        'parceiro_pdv',
        '',
        time() - 3600,
        COOKIEPATH ?: '/',
        COOKIE_DOMAIN ?: '',
        is_ssl(),
        true
      );
      unset($_COOKIE['parceiro_pdv']);
    }
  }
});

// 2) Ao criar o pedido (checkout), salva meta parceiro_pdv se cookie existir
add_action(
  'woocommerce_checkout_create_order',
  function ($order, $data) {
    if (!empty($_COOKIE['parceiro_pdv'])) {
      $pdv = sanitize_text_field(wp_unslash($_COOKIE['parceiro_pdv']));

      // Busca o parceiro pelo código
      $pdv_post = get_page_by_path($pdv, OBJECT, 'pdv');

      if ($pdv_post && $pdv) {
        // Nome e comissão vigentes
        $nome = get_the_title($pdv_post->ID);
        $comissao = get_post_meta($pdv_post->ID, 'pdv_comissao', true);
        $comissao = $comissao ? floatval($comissao) : 0;

        $order->update_meta_data('parceiro_pdv', $pdv);
        $order->update_meta_data('pdv_nome', $nome);
        $order->update_meta_data('pdv_comissao', $comissao);
      }
    }
  },
  10,
  2
);

//Adiciona o ID do pedido na meta pdv_pedido_id após o pedido ser criado
add_action('woocommerce_new_order', function ($order_id) {
  $order = wc_get_order($order_id);
  $order->update_meta_data('pdv_pedido_id', $order->get_id());
  $order->save();
});

// 3) Opcional: limpa cookie após compra (na página de obrigado)
add_action('woocommerce_thankyou', function ($order_id) {
  if (isset($_COOKIE['parceiro_pdv'])) {
    // zera o cookie
    setcookie(
      'parceiro_pdv',
      '',
      time() - 3600,
      COOKIEPATH ?: '/',
      COOKIE_DOMAIN ?: '',
      is_ssl(),
      true
    );
    unset($_COOKIE['parceiro_pdv']);
  }
});

//Exibe o afiliado na área administrativa do pedido
add_action('woocommerce_admin_order_data_after_order_details', function (
  $order
) {
  $parceiro = $order->get_meta('parceiro_pdv');
  if ($parceiro) {
    echo '<p><strong>Parceiro:</strong> ' . esc_html($parceiro) . '</p>';
  }
});

// ======================
// COLUNA "PARCEIRO" NA LISTAGEM DE PEDIDOS
// ======================

// 1) Adicionar nova coluna
add_filter(
  'manage_edit-shop_order_columns',
  function ($columns) {
    // Remover a coluna "Origem" (alguns plugins adicionam com esse nome)
    foreach ($columns as $key => $label) {
      if (
        stripos($label, 'Origem') !== false ||
        stripos($label, 'Source') !== false
      ) {
        unset($columns[$key]);
      }
    }

    // Inserir a nova coluna "Parceiro" antes ou depois de onde desejar
    // Exemplo: adicionar antes da coluna "Total"
    $new_columns = [];

    foreach ($columns as $key => $label) {
      if ($key === 'order_total') {
        // adiciona nossa coluna antes do total
        $new_columns['parceiro_pdv'] = __('Parceiro', 'meutema');
      }
      $new_columns[$key] = $label;
    }

    // Caso 'order_total' não exista, adiciona no fim
    if (!isset($new_columns['parceiro_pdv'])) {
      $new_columns['parceiro_pdv'] = __('Parceiro', 'meutema');
    }

    return $new_columns;
  },
  20
);

// 2) Preencher a coluna com o valor salvo
add_action(
  'manage_shop_order_posts_custom_column',
  function ($column, $post_id) {
    if ($column === 'parceiro_pdv') {
      $order = wc_get_order($post_id);
      if ($order) {
        $codigo_pdv = $order->get_meta('parceiro_pdv');
        if ($codigo_pdv) {
          $nome_pdv = obter_nome_pdv_por_codigo($codigo_pdv);
          echo esc_html($nome_pdv ?: $codigo_pdv);
        } else {
          echo '&mdash;'; // deixa em branco (ou hífen)
        }
      }
    }
  },
  20,
  2
);

// ======================
// BADGE DE PARCEIRO NO CARRINHO (cart_collaterals)
// ======================
add_action('woocommerce_cart_collaterals', function () {
  if (isset($_COOKIE['parceiro_pdv']) && $_COOKIE['parceiro_pdv']) {
    $codigo_pdv = sanitize_text_field($_COOKIE['parceiro_pdv']);
    $nome_pdv = obter_nome_pdv_por_codigo($codigo_pdv);

    // Renderiza o bloco visual
    echo '<div class="wc-parceiro-badge">
            <span>Ponto de venda</span>
            <div>' .
      esc_html($nome_pdv ?: $codigo_pdv) .
      '</div>
        </div>';
  }
});

// ======================
// CUSTOM POST TYPE: PARCEIROS
// ======================
add_action('init', function () {
  $labels = [
    'name' => 'Pontos de venda',
    'singular_name' => 'Ponto de venda',
    'menu_name' => 'Pontos de venda',
    'name_admin_bar' => 'PDVs',
    'add_new' => 'Adicionar',
    'add_new_item' => 'Adicionar PDV',
    'new_item' => 'Novo ponto de venda',
    'edit_item' => 'Editar ponto de venda',
    'view_item' => 'Ver ponto de venda',
    'all_items' => 'Todos os PDVs',
    'search_items' => 'Buscar pontos de venda',
    'not_found' => 'Nenhum PDV encontrado',
    'not_found_in_trash' => 'Nenhum PDV encontrado na lixeira'
  ];

  $args = [
    'labels' => $labels,
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-store',
    'supports' => ['title', 'custom-fields'],
    'capability_type' => 'post',
    'map_meta_cap' => true,
    'rewrite' => false
  ];

  register_post_type('pdv', $args);
});

add_action('add_meta_boxes', function () {
  // Adiciona o metabox para comissão no editor de parceiro
  add_meta_box(
    'pdv_comissao',
    'Comissão do PDV',
    'render_metabox_pdv_comissao',
    'pdv',
    'side',
    'default'
  );

  //Adiciona o metabox para informações de contato do parceiro
  add_meta_box(
    'pdv_contato',
    'Informações de Contato',
    'render_meta_box_contato_pdv',
    'pdv',
    'normal',
    'default'
  );
});
// Renderiza o campo de comissão
function render_metabox_pdv_comissao($post)
{
  $valor = get_post_meta($post->ID, 'pdv_comissao', true); ?>
    <p>
        <label for="pdv_comissao"><strong>Percentual de comissão (%):</strong></label><br>
        <input type="number" step="0.01" min="0" id="pdv_comissao" name="pdv_comissao"
               value="<?php echo esc_attr($valor); ?>" style="width:100%;">
        <small>Informe o percentual de comissão aplicado às vendas deste parceiro.</small>
    </p>
    <?php
}

//Renderiza a seção de contato do parceiro
function render_meta_box_contato_pdv($post)
{
  $email = get_post_meta($post->ID, 'pdv_email', true);
  $telefone = get_post_meta($post->ID, 'pdv_telefone', true);
  $contato = get_post_meta($post->ID, 'pdv_nome_contato', true);
  wp_nonce_field('salvar_pdv_contato', 'pdv_contato_nonce');
  ?>
  <table class="form-table">
    <tr>
      <th><label for="pdv_nome_contato">Nome do contato</label></th>
      <td><input type="text" id="pdv_nome_contato" name="pdv_nome_contato" value="<?php echo esc_attr(
        $contato
      ); ?>" class="regular-text"></td>
    </tr>
    <tr>
      <th><label for="pdv_email">E-mail</label></th>
      <td><input type="email" id="pdv_email" name="pdv_email" value="<?php echo esc_attr(
        $email
      ); ?>" class="regular-text"></td>
    </tr>
    <tr>
      <th><label for="pdv_telefone">Telefone</label></th>
      <td><input type="text" id="pdv_telefone" name="pdv_telefone" value="<?php echo esc_attr(
        $telefone
      ); ?>" class="regular-text"></td>
    </tr>
  </table>
  <?php
}

// ======================
// Exibir coluna "Código" na listagem de parceiros
// ======================
add_filter('manage_pdv_posts_columns', function ($columns) {
  $columns['codigo_pdv'] = 'Código do PDV';
  return $columns;
});

add_action(
  'manage_pdv_posts_custom_column',
  function ($column, $post_id) {
    if ($column === 'codigo_pdv') {
      $slug = get_post_field('post_name', $post_id);
      echo esc_html($slug);
    }
  },
  10,
  2
);

// ======================
// CAMPO "CÓDIGO DO PARCEIRO" EDITÁVEL
// ======================

// 1️⃣ Adiciona o campo no editor
add_action('add_meta_boxes', function () {
  add_meta_box(
    'pdv_codigo_box',
    'Código do PDV',
    'render_pdv_codigo_field',
    'pdv',
    'side',
    'high'
  );
});

function render_pdv_codigo_field($post)
{
  $slug = $post->post_name;
  wp_nonce_field('salvar_codigo_pdv', 'codigo_pdv_nonce');

  echo '<p>Este código é usado nos links de referência. Deve ser único e sem espaços.</p>';
  echo '<label for="codigo_pdv"><strong>Código:</strong></label><br>';
  echo '<input type="text" id="codigo_pdv" name="codigo_pdv" value="' .
    esc_attr($slug) .
    '" style="width:100%;" />';
  echo '<small>Exemplo: <code>loja_joao</code></small>';
}

// Salva os campos personalizados do parceiro
add_action('save_post_pdv', function ($post_id) {
  // Segurança
  if (
    !isset($_POST['codigo_pdv_nonce']) ||
    !wp_verify_nonce($_POST['codigo_pdv_nonce'], 'salvar_codigo_pdv')
  ) {
    return;
  }

  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  //Salva o novo slug
  if (isset($_POST['codigo_pdv'])) {
    $novo_slug = sanitize_title($_POST['codigo_pdv']); // garante formato limpo
    $post = get_post($post_id);
    if ($post->post_name !== $novo_slug) {
      wp_update_post([
        'ID' => $post_id,
        'post_name' => $novo_slug
      ]);
    }
  }

  // Salva a comissão
  if (isset($_POST['pdv_comissao'])) {
    update_post_meta(
      $post_id,
      'pdv_comissao',
      floatval($_POST['pdv_comissao'])
    );
  }
  //Salva o nome de contato
  update_post_meta(
    $post_id,
    'pdv_nome_contato',
    sanitize_text_field($_POST['pdv_nome_contato'] ?? '')
  );
  //Salva o e-mail
  update_post_meta(
    $post_id,
    'pdv_email',
    sanitize_email($_POST['pdv_email'] ?? '')
  );
  //Salva o telefone
  update_post_meta(
    $post_id,
    'pdv_telefone',
    sanitize_text_field($_POST['pdv_telefone'] ?? '')
  );
});

// ======================
// FUNÇÃO AUXILIAR: obter nome do parceiro a partir do código (slug)
// ======================
function obter_nome_pdv_por_codigo($codigo)
{
  if (empty($codigo)) {
    return null;
  }

  $args = [
    'name' => $codigo,
    'post_type' => 'pdv',
    'post_status' => 'publish',
    'numberposts' => 1
  ];

  $posts = get_posts($args);
  if (!empty($posts)) {
    return $posts[0]->post_title;
  }

  return null; // caso não encontre
}
function obter_post_pdv_por_codigo($codigo)
{
  $query = new WP_Query([
    'post_type' => 'pdv',
    'name' => $codigo, // Usa o parâmetro 'name' para buscar pelo slug (post_name)
    'posts_per_page' => 1
  ]);
  return $query->posts ? $query->posts[0] : null;
}

function obter_comissao_pdv_por_codigo($codigo)
{
  $post = obter_post_pdv_por_codigo($codigo);
  if ($post) {
    $comissao = get_post_meta($post->ID, 'pdv_comissao', true);
    return $comissao ? floatval($comissao) : 0;
  }
  return 0;
}

?>
