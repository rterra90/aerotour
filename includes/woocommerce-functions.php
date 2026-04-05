<?php
// FUNÇÕES DA PÁGINA SINGLE-PRODUCT
require_once get_template_directory() . '/includes/woocommerce/single-product-functions.php';


//ADICIONAR SUPORTE WOOCOMMERCE
function aerotour_add_woocommercer_support()
{
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'aerotour_add_woocommercer_support');

/**
 * Remove todos os estilos padrão do WooCommerce
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Remove o script de checkout do WooCommerce (que inclui o bloco de pagamento)
add_action(
  'wp_enqueue_scripts',
  function () {
    wp_dequeue_script('wc-checkout');
    if (is_checkout()) {
      wp_dequeue_script('wc-cart-fragments');
    }
  },
  100
);


// Registrar endpoint para "Minhas reservas"
add_action('init', 'add_endpoints');
function add_endpoints()
{
  add_rewrite_endpoint('minhas-reservas', EP_PAGES);
}
add_action('woocommerce_account_minhas-reservas_endpoint', 'minhas_reservas_endpoint_page_create');
function minhas_reservas_endpoint_page_create()
{
  wc_get_template('myaccount/minhas-reservas.php');
}

// Remove campos desnecessários do checkout
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{
  unset($fields['billing']['billing_company']); //remover empresa
  unset($fields['billing']['billing_address_1']); //remover endereço 1
  unset($fields['billing']['billing_address_2']); //remover endereço 2
  unset($fields['billing']['billing_city']); //remover cidade
  unset($fields['billing']['billing_postcode']); //remover cep
  unset($fields['billing']['billing_country']); //remover país 
  unset($fields['billing']['billing_state']); //remover estado
  return $fields;
}

// Modifica os itens do menu da conta do usuário
add_action('woocommerce_account_menu_items', 'custom_account_menu');
function custom_account_menu($menu_links)
{
  unset($menu_links['downloads']);
  unset($menu_links['customer-logout']);
  // $menu_links['customer-logout'] = 'Sair';
  $menu_links = array_slice($menu_links, 0, 5, true)
    + array('minhas-reservas' => 'Minhas reservas')
    + array_slice($menu_links, 5, NULL, true);
  return $menu_links;
}

// Otimiza a query de produtos para exibir apenas excursões ativas (com data limite >= hoje) em arquivos de loja, categoria e tag
add_action('pre_get_posts', 'otimizar_query_produtos_excursao');
function otimizar_query_produtos_excursao($query)
{
  // 1. Saída antecipada (Early Return) para evitar processamento desnecessário
  if (is_admin() || !$query->is_main_query()) {
    return;
  }

  // 2. Agrupa as verificações de página
  if (is_shop() || is_product_category() || is_product_tag()) {

    // Define a data atual uma única vez
    $hoje = date('Ymd');

    // Configurações da Query
    $query->set('posts_per_page', -1); // Nota: Cuidado se tiver +100 produtos
    $query->set('meta_key', 'data_limite_excursao');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');

    // 3. Otimização da Meta Query
    $meta_query = (array) $query->get('meta_query');
    $meta_query[] = [
      'key'     => 'data_limite_excursao',
      'value'   => $hoje,
      'compare' => '>=',
      'type'    => 'NUMERIC'
    ];

    $query->set('meta_query', $meta_query);
  }
}

// Ponto de venda em cart_collaterals
add_action('woocommerce_review_order_before_payment', 'exibe_pdv');
function exibe_pdv()
{
?>
  <div class="cart_collaterals_pdv">
    <p>Ponto de venda: <span></span></p>
    <input type="hidden" name="pdv">
    <script>
      if (window.sessionStorage.getItem('aer_pdv')) {
        document.querySelector('input[name="pdv"]').value = window.sessionStorage.getItem('aer_pdv');
        document.querySelector('.cart_collaterals_pdv span').innerText = window.sessionStorage.getItem('aer_pdv').replace(/\_/g, ' ');
      } else document.querySelector('.cart_collaterals_pdv').remove();
    </script>
  </div>

<?php
}

// Remove breadcrumb do WooCommerce em arquivos de loja, categoria e tag
function remover_breadcrumb_em_arquivos_woocommerce()
{
  if (is_product_category() || is_shop() || is_product_tag()) {
    remove_action(
      'woocommerce_before_main_content',
      'woocommerce_breadcrumb',
      20
    );
  }
}
add_action('wp', 'remover_breadcrumb_em_arquivos_woocommerce');

//Remove a exibição de cross-sell do cart
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');


function filter_woocommerce_cart_totals_coupon_html($coupon_html, $coupon, $discount_amount_html)
{
  // Change text
  $coupon_html = $discount_amount_html . ' <a href="' . esc_url(add_query_arg('remove_coupon', rawurlencode($coupon->get_code()), defined('WOOCOMMERCE_CHECKOUT') ? wc_get_checkout_url() : wc_get_cart_url())) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr($coupon->get_code()) . '">' . __('<i class="bi bi-trash"></i>', 'woocommerce') . '</a>';

  return $coupon_html;
}
add_filter('woocommerce_cart_totals_coupon_html', 'filter_woocommerce_cart_totals_coupon_html', 10, 3);


// Adicionar o filtro ao texto de "obrigado pelo pedido"
add_filter('woocommerce_thankyou_order_received_text', 'customizar_texto_obrigado', 10, 2);
function customizar_texto_obrigado($texto, $pedido)
{
  $novo_texto = "Confira os detalhes do pedido"; // Substitua pelo texto desejado
  return $novo_texto;
}
