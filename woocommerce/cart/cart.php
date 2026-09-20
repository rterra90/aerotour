<?php
defined('ABSPATH') || exit();

do_action('woocommerce_before_cart');

global $woocommerce;
global $wpdb;
$items_carrinho = $woocommerce->cart->get_cart();
?>


<link rel="stylesheet" href="<?= esc_url(
  get_stylesheet_directory_uri()
) ?>/css/includes/banner-cupom.css">

<h1 class="mt-2">Carrinho de reservas</h1>

<div class="notices woocommerce-notices-wrapper">
    <?php wc_print_notices(); ?>
</div>

<div id="carrinho-container" class="row">
    <form class="woocommerce-cart-form col-lg-8" action="<?php echo esc_url(
      wc_get_cart_url()
    ); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>

        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <tbody>
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php foreach (
                  WC()->cart->get_cart()
                  as $cart_item_key => $cart_item
                ):

                  $emb_id = intval($cart_item['embarque']);
                  $embarque = $wpdb->get_var(
                    $wpdb->prepare(
                      'SELECT nome FROM aer_embarques WHERE id = %d',
                      $emb_id
                    )
                  );

                  $passageiros = json_decode(
                    str_replace('\"', '"', $cart_item['passageiros'])
                  );
                  $passageiros = array_filter($passageiros);

                  $_product = $cart_item['data'];
                  $product_id = $cart_item['product_id'];
                  $product_name = $_product->get_name();

                  $data_exc = explode(' - ', $product_name);
                  $data_exc = end($data_exc);

                  $remove_url = wc_get_cart_remove_url($cart_item_key);

                  if (
                    $_product &&
                    $_product->exists() &&
                    $cart_item['quantity'] > 0
                  ): 
                
                  get_template_part('woocommerce/cart/cart-item', null, [
                    'item' => $cart_item,
                    'cart_item_key' => $cart_item_key,
                    'passageiros' => $passageiros
                  ]);
                  endif;
                  ?>
                <?php
                endforeach; ?>

                <?php do_action('woocommerce_cart_contents'); ?>
                <?php do_action('woocommerce_after_cart_contents'); ?>
            </tbody>
        </table>

        <!-- Coupon section -->
        <div class="pt-3">
            <tr>
                <td colspan="6" class="actions">
                    <?php if (wc_coupons_enabled()): ?>
                        <div class="coupon">
                            <label for="coupon_code" class="screen-reader-text" onclick="toggleCupomInputs('coupon_inputs')">Tem um cupom de desconto?</label> 
                            <div id="coupon_inputs">
                                <input type="text" name="coupon_code" class="input-text" id="coupon_code" placeholder="<?php esc_attr_e(
                                  'Coupon code',
                                  'woocommerce'
                                ); ?>" />
                                <button type="submit" class="button btn cart-btn-style" name="apply_coupon" value="<?php esc_attr_e(
                                  'Apply coupon',
                                  'woocommerce'
                                ); ?>">
                                    <?php esc_html_e(
                                      'Apply coupon',
                                      'woocommerce'
                                    ); ?>
                                </button>
                            </div>
                            <?php do_action('woocommerce_cart_coupon'); ?>
                        </div>
                    <?php endif; ?>

                    <?php do_action('woocommerce_cart_actions'); ?>
                    <?php wp_nonce_field(
                      'woocommerce-cart',
                      'woocommerce-cart-nonce'
                    ); ?>
                </td>
            </tr>
        </div>

        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>
    <div class="col-lg-4">
        <div class="cart-collaterals">
            <?php do_action('woocommerce_cart_collaterals'); ?>
        </div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const accordions = document.querySelectorAll('.accordion-toggle');
    
    accordions.forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('active');
            const content = this.nextElementSibling;
            content.classList.toggle('open');
            
            // Opcional: Mudar texto do botão dinamicamente
            const count = this.getAttribute('data-qty');
            const textSpan = this.querySelector('span');
            if(this.classList.contains('active')) {
                 // Mantém o ícone via innerHTML e atualiza o texto
                 textSpan.innerHTML = `<svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Ocultar passageiros`;
            } else {
                 textSpan.innerHTML = `<svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Passageiros (${count})`;
            }
        });
    });
});

</script>

<?php
do_action('woocommerce_after_cart');

//Enfileira o script customizado do carrinho
wp_enqueue_script(
  'cart-custom-js',
  get_stylesheet_directory_uri() . '/js/cart.js',
  ['jquery'],
  time(),
  true
);


?>

