<?php
defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}

?>
<div class="row">
<section class="woocommerce-order-details mb-4 col-xxl-9 col-12">
	<div>
		<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

		<h2 class="woocommerce-order-details__title bg-title">Reservas neste pedido</h2>

		<!-- Template de tabela de itens do pedido -->
        <?php
        wc_get_template(
          'order/custom-order-details-table.php',
          [
              'order' => $order,
              'order_items' => $order_items,
              'show_purchase_note' => $show_purchase_note,
          ]
        );
        ?>


		<?php // do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
	</div>
</section>

<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	//wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
