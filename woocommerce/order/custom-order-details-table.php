<table id="custom-order-details-table" class="woocommerce-table woocommerce-table--order-details shop_table order_details">

			<thead>
				<tr>
					<th class="woocommerce-table__product-name product-name">Excursão</th>
					<th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php
				do_action( 'woocommerce_order_details_before_order_table_items', $order );

				foreach ( $order_items as $item_id => $item ) {
					$product = $item->get_product();

					wc_get_template(
						'order/order-details-item.php',
						array(
							'order'              => $order,
							'item_id'            => $item_id,
							'item'               => $item,
							'show_purchase_note' => $show_purchase_note,
							'purchase_note'      => $product ? $product->get_purchase_note() : '',
							'product'            => $product,
						)
					);
				}

				do_action( 'woocommerce_order_details_after_order_table_items', $order );
				?>
			</tbody>

			<tfoot>
				<?php
				foreach ( $order->get_order_item_totals() as $key => $total ) {
					?>
						<tr>
							<th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
							<td><?php echo wp_kses_post( $total['value'] ); ?></td>
						</tr>
						<?php
				}
				?>
				<?php if ( $order->get_customer_note() ) : ?>
					<tr>
						<th><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
						<td><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
					</tr>
				<?php endif; ?>
			</tfoot>
		</table>