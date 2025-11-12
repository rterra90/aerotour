<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/account/view-order.css?ver=<?= time(); ?>" />
<a class="voltar-header" href="<?= wc_get_account_endpoint_url( 'orders' ); ?>">< Voltar para pedidos</a>
<h2 class="mb-4">Pedido #<?= $order->get_order_number(); ?></h2>
<p class="informacao-status-header" data-status="<?= $order->get_status(); ?>">
	Esse pedido foi realizado em <b><?= wc_format_datetime( $order->get_date_created() ) ?></b> e atualmente está <mark class="order-status "><?=wc_get_order_status_name( $order->get_status() )?></mark>
</p>
<?php
if($order->get_status() === 'completed'){
	?>
	<div class="mt-sm-4 mt-5 mb-5" id="meus-pedidos-cta">
		<a href="<?= wc_get_endpoint_url( 'minhas-reservas', '', wc_get_page_permalink('myaccount')); ?>">Visualizar reserva ></a>
	</div>
	

	<!-- Mostrar parceiro afiliado se houver -->
	<?php
	if($order->get_meta('parceiro_pdv')){
		?>
		<p class="parceiro-pedido-badge">Pedido realizado via parceiro <strong><?= esc_html( $order->get_meta('parceiro_pdv') ); ?></strong></p>
		<?php
	}
	?>


	<?php
}else if($order->get_status() === 'pending'){
	$actions = wc_get_account_orders_actions( $order );
	?>
		<div class="pending-order-buttons mb-4 d-flex gap-3">
			<?php
				if ( ! empty( $actions ) ) {
					foreach ( array_reverse($actions) as $key => $action ) {
						if($key !== 'view') {
							echo '<a href="' . esc_url( $action['url'] ) . '" data-action="'.sanitize_html_class( $key ).'"><div>' . aer_icons($action['name'], 15, 15) . '</div><span>'.$action['name'].'<span></a>';
						}	
					}
				}
			?>
		</div>
	<?php
}
?>
<div id="pedidoContent">
	<?php if ( $notes ) : ?>
	<div id="atualizacoesDoPedido">
		<h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
		<ol class="woocommerce-OrderUpdates commentlist notes">
			<?php foreach ( $notes as $note ) : ?>
			<li class="woocommerce-OrderUpdate comment note">
				<div class="woocommerce-OrderUpdate-inner comment_container">
					<div class="woocommerce-OrderUpdate-text comment-text">
						<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<div class="woocommerce-OrderUpdate-description description">
							<?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
			<?php endforeach; ?>
		</ol>
	</div>

	<?php endif; ?>
	<div id="detalhesDoPedido"><?php do_action( 'woocommerce_view_order', $order_id ); ?></div>
</div>


