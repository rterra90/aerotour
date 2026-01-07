<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="flex-checkout-review-order-table">

	<!-- Excursões e cupons-->
	<?php
		//Excursões
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$passageiros = array_filter(json_decode(str_replace('\"', '"', $cart_item['passageiros'])), function($item) {if($item !== false) return $item;});

  		$aer_embarques = get_option('aer_embarques');
			foreach($aer_embarques as $embarque){
				if($embarque['nome'] === $cart_item['embarque']) $endereco_embarque = $embarque['endereco'];
			};
			
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
					<div class="single-excursao checkout-box">
						<p class="exc-name mb-0"><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', substr($_product->get_name(), 0, -13), $cart_item, $cart_item_key ) ); ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?></p>
						<div class="detalhes">
							<p>Data: <?= $_product->get_attribute('dia') ?></p>
							<p>Embarque: <?php print_r(get_embarque_by_id($cart_item['embarque'], 'nome')); ?> &nbsp; <i class="bi bi-info-circle-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?= $endereco_embarque; ?>"></i></p>
							<p>Horário: <?= $cart_item['horario'] ?></p>
						</div>
						<div class="passageiros">
							<p>Reserva para <?= sizeof($passageiros) ?> <?= sizeof($passageiros) > 1 ? 'passageiros' : 'passageiro'; ?></p>
							<ul>
								<?php
									foreach($passageiros as $passageiro){
										?>
										<li class="d-flex gap-2">
											<div>
												<svg xmlns="http://www.w3.org/2000/svg" width="12.211" height="8.141" viewBox="0 0 12.211 8.141">
													<path id="Icon_awesome-ticket-alt" data-name="Icon awesome-ticket-alt" d="M2.714,6.535H9.5v4.07H2.714Zm8.48,2.035a1.018,1.018,0,0,0,1.018,1.018v2.035a1.018,1.018,0,0,1-1.018,1.018H1.018A1.018,1.018,0,0,1,0,11.623V9.588A1.018,1.018,0,0,0,1.018,8.57,1.018,1.018,0,0,0,0,7.553V5.518A1.018,1.018,0,0,1,1.018,4.5H11.193a1.018,1.018,0,0,1,1.018,1.018V7.553A1.018,1.018,0,0,0,11.193,8.57Zm-1.018-2.2a.509.509,0,0,0-.509-.509H2.544a.509.509,0,0,0-.509.509v4.409a.509.509,0,0,0,.509.509H9.667a.509.509,0,0,0,.509-.509Z" transform="translate(0 -4.5)" fill="#707070"/>
												</svg>
											</div>
											<div style="flex-grow:1">
												<p class="nome-passageiro"><?= $passageiro -> nome_completo; ?></p>
												<div class="pax-info-flex">
													<p class="doc-passageiro small">CPF: <?= cpf_mask($passageiro -> cpf); ?></p>
													<p class="telefone-passageiro small">Telefone: <?= $passageiro -> celular; ?></p>
													<p class="data-nasc-passageiro small">Nasc.: <?= data_to_dmy($passageiro -> data_nascimento); ?></p>
													<p class="rota-passageiro small"><?= $passageiro -> tripType == 'ida-e-volta' ? "Ida e volta" : 'Apenas ' . $passageiro -> tripType ?></p></div>
												
											</div>
	
										</li>
										<?php
									}
								?>
							</ul>
						</div>
						<div class="subtotal">
							<strong class="d-block text-end px-4 pt-2">Subtotal: <span><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span></strong>
						</div>
					</div>
				<?php
			}
		}

		// Cupom
		if(sizeof(WC()->cart->get_coupons()) > 0){
			foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="checkout-box cupom mt-3 coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<p class="title">Cupom aplicado</p>
					<div class="d-flex justify-content-between px-3">
						<p class="mb-1"><?= strtoupper($code); ?></p>
						<p class="mb-1 valor-cupom"><?php wc_cart_totals_coupon_html( $coupon ); ?></p>
					</div>
				</div>
			<?php endforeach;
		}
	?>

	<p class="text-center my-2" style="font-size: .725rem; opacity: .85">Precisa alterar algo? Vá para o <a class="fw-bold" href="<?= wc_get_cart_url(); ?>">carrinho.</a></p>

	<!-- Total -->
	<div class="checkout-box d-flex justify-content-between mt-3 px-3">
		<p class="mb-1 fw-bold">TOTAL</p>
		<p class="mb-1"><?php wc_cart_totals_order_total_html(); ?></p>
	</div>

</div>



<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
	</thead>
	<tbody>
	</tbody>
	<tfoot>

		<!-- <tr class="cart-subtotal">
			<th><?php //esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php //wc_cart_totals_subtotal_html(); ?></td>
		</tr> -->

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<?php do_action( 'Selecione a forma de pagamento' ); ?>

	</tfoot>
</table>


