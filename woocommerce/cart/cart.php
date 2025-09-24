<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<?php 
  global $woocommerce;
	global $wpdb;
  $items_carrinho = $woocommerce->cart->get_cart();

  // print_r($items_carrinho);
  ?>
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/woocommerce/carrinho.min.css?ver=<?= time(); ?>">
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/includes/banner-cupom.css">

  <h1 class="mt-3">Carrinho de reservas</h1>
	<div class="notices woocommerce-notices-wrapper">
		<?php wc_print_notices(); ?>
	</div>
  <div id="carrinho-container" class="row">
    <form class="woocommerce-cart-form col-lg-8" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
				<tbody>
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$emb_id = $cart_item['embarque'];
						$nome_embarque = $wpdb -> get_results("SELECT nome from aer_embarques WHERE id = $emb_id");
						$passageiros = json_decode(str_replace('\"', '"', $cart_item['passageiros']));
						$passageiros = array_filter($passageiros, function($p) {if($p !== false) return $p; });
						$embarque = $nome_embarque[0] -> nome;
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
						$data_exc = explode(' - ', $product_name);
						$data_exc = $data_exc[sizeof($data_exc) - 1];

						$remove_url   = wc_get_cart_remove_url( $cart_item_key );
						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>

							<div class="cart-item" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
								<!-- Botão remover -->
								<a href="<?php echo esc_url( $remove_url ); ?>" 
									class="remove-item" 
									aria-label="<?php esc_attr_e( 'Remover', 'woocommerce' ); ?>" 
									data-product_id="<?php echo esc_attr( $product_id ); ?>" 
									data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>" 
									data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">
									✖
								</a>

								<!-- Informações da excursão -->
								<div class="tour-info">
									<h3 class="bg-title">Excursão <?php echo esc_html( preg_replace('/ - \d{2}\/\d{2}\/\d{4}$/', '', $product_name) ); ?></h3>
									
									<div class="d-flex justify-content-between">
										<?php if ($data_exc) : ?>
											<p><strong>Data:</strong> <?php echo esc_html($data_exc); ?></p>
										<?php endif; ?>
										<?php if ($horario) : ?>
											<p class="w-50"><strong>Horário:</strong> <?php echo esc_html($horario); ?></p>
										<?php endif; ?>
									</div>
										<?php if ($embarque) : ?>
											<p><strong>Embarque:</strong> <?php echo esc_html($embarque); ?></p>
										<?php endif; ?>
											<p><strong>Valor:</strong> <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></p>
								
								</div>

								<!-- Passageiros -->
								<?php if (!empty($passageiros)) : ?>
									<div class="passengers">
										<button type="button" data-qty="<?= count($passageiros); ?>"class="toggle-passengers cart-btn-style">Ver passageiros (<?= count($passageiros); ?>)</button>
										<div class="passenger-list">
											<?php foreach ($passageiros as $passenger) : ?>
												<div class="passenger">
													<p><strong>Nome:</strong> <?php echo esc_html($passenger -> nome_completo); ?></p>
													<p><strong>CPF:</strong> <?php echo esc_html($passenger -> cpf); ?></p>
													<p><strong>Celular:</strong> <?php echo esc_html($passenger -> celular); ?></p>
													<?php
														$rota = esc_html($passenger -> tripType);
														$rota = $rota == 'ida-e-volta' ? "Ida e volta" : 'Apenas ' . $rota;
													?>
													<div>
													<p><strong>Nascimento:</strong> <?php echo esc_html(data_to_dmy($passenger -> data_nascimento)); ?></p>
													<span class="rota"><?= strtoupper($rota); ?></span>
													</div>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>

							</div>


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
										<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button data-btn-reactive type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> btn cart-btn-style" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
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
		<div class="col-lg-4">
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
	<!--<div id="bannerRoleta" class="mt-2"><img style="width: 100%; max-width: 460px" src="<?= get_stylesheet_directory_uri()?>/assets/banners/banner-roleta.webp" alt="Banner roleta Aerotour"></div>-->
	<script>
		const totalTitle = document.querySelector('.cart_totals h2');
		totalTitle.classList.add('bg-title');
		const finalizarBtn = document.querySelector('.checkout-button');
		finalizarBtn.innerText = "Continuar para pagamento"

		function toggleCupomInputs(element_id){
			document.querySelector('#' + element_id).classList.toggle('active');
		}

		function handleMobilePassageiros(element){
			element.nextElementSibling.classList.toggle('d-none');
			element.parentElement.classList.toggle('active');
		}

			gtag('event', 'ads_conversion_Adicionar_ao_carrinho_1', {
				// <event_parameters>
			});


			document.addEventListener("DOMContentLoaded", () => {
				// Toggle passageiros
				document.querySelectorAll(".toggle-passengers").forEach(btn => {
					btn.addEventListener("click", () => {
						const list = btn.nextElementSibling;
						const paxQty = btn.dataset.qty;
						list.classList.toggle("open");
						btn.classList.toggle("open");
						btn.textContent = list.classList.contains("open") 
							? "Ocultar passageiros ("+paxQty+")"
							: "Ver passageiros ("+paxQty+")";
					});
				});

				// // Remover item com animação (WooCommerce já remove via link)
				// document.querySelectorAll(".remove-item").forEach(btn => {
				// 	btn.addEventListener("click", (e) => {
				// 		const item = btn.closest(".cart-item");
				// 		item.style.opacity = "0";
				// 		item.style.transform = "translateX(50px)";
				// 		setTimeout(() => item.remove(), 300);
				// 	});
				// });

				// Remover item com confirmação
				document.querySelectorAll(".remove-item").forEach(btn => {
					btn.addEventListener("click", (e) => {
						if (!confirm("Tem certeza que deseja remover esta excursão do carrinho?")) {
							e.preventDefault(); // bloqueia remoção
						}
					});
				});
			});

	</script>

<?php do_action( 'woocommerce_after_cart' ); ?>
