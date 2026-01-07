<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<?php 
  global $woocommerce;
  $items_carrinho = $woocommerce->cart->get_cart();

  // print_r($items_carrinho);
  ?>
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/woocommerce/carrinho.min.css">

  <h1>Carrinho de reservas</h1>
	<div class="notices woocommerce-notices-wrapper">
		<?php wc_print_notices(); ?>
	</div>
  <div id="carrinho-container" class="row">
    <form class="woocommerce-cart-form col-lg-9" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				// print_r($cart_item);
				$passageiros = json_decode(str_replace('\"', '"', $cart_item['passageiros']));
				$passageiros = array_filter($passageiros, function($p) {if($p !== false) return $p; });
				$embarque = $cart_item['embarque'];
				$horario = $cart_item['horario'];
				// $aer_qty = $cart_item['aer_qty'];
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				/**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<div>
								<?php
									if ( ! $product_permalink ) {
										echo wp_kses_post( $product_name . '&nbsp;' );
									} else {
										$nome_exp = explode(' - ', $_product->get_name());
										echo '<i>Excursão Aerotour</i>' . wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( explode('?', $product_permalink)[0] ), $nome_exp[sizeof($nome_exp) - 2] ), $cart_item, $cart_item_key ) );
									}
									echo '<p class="data-excursao mb-0">Data: '. $nome_exp[sizeof($nome_exp) - 1] .' | Horário: ' . $horario .'</p><p class="mb-0">Local de embarque: ' . $embarque . '</p>';

									do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

									// Meta data.
									echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

									// Backorder notification.
									if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
									}
								?>
							</div>
							
							<div class="mobile-cart-passageiros">
								<span onclick="handleMobilePassageiros(this)"><?= sizeof($passageiros); ?> <?= sizeof($passageiros) > 1 ? 'passageiros' : 'passageiro' ?><span class="arrow">></span></span>
								<div class="d-none">
									<?php include 'cart-passageiros.php'; ?>
								</div>
								
							</div>
						</td>

            <td class="product-passageiro" data-title="Passageiro">
              <?php include 'cart-passageiros.php'; ?>
            </td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
  <div class="pt-3">
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text" onclick="toggleCupomInputs('coupon_inputs')">Tem um cupom de desconto?</label> 
							<div id="coupon_inputs">
								<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button data-btn-reactive type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> btn btn-dark" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
							</div>
							
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
          </div>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
<div class="col-lg-3">
	<div class="cart-collaterals">
		<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>
</div>

</div>
<script>
	const finalizarBtn = document.querySelector('.checkout-button');
	finalizarBtn.classList.add('btn');
	finalizarBtn.classList.add('btn-dark');
	finalizarBtn.classList.add('btn-lg');
	finalizarBtn.innerText = "Continuar para pagamento"


	function toggleCupomInputs(element_id){
		document.querySelector('#' + element_id).classList.toggle('active');
	}

	function handleMobilePassageiros(element){
		element.nextElementSibling.classList.toggle('d-none');
		element.parentElement.classList.toggle('active');
	}
</script>

<?php do_action( 'woocommerce_after_cart' ); ?>
