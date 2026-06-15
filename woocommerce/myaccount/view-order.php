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
?>

<div id="view-order-container">
<a class="voltar-header" href="<?= wc_get_account_endpoint_url( 'orders' ); ?>">< Voltar para pedidos</a>
<h2 class="mt-4 mb-3 bg-title">Pedido #<?= $order->get_order_number(); ?></h2>

<?php
do_action( 'woocommerce_view_order_start', $order_id );
$notes = $order->get_customer_order_notes();
?>

<p class="order-summary-text" data-status="<?= $order->get_status(); ?>">
	Esse pedido foi realizado em <b><?= wc_format_datetime( $order->get_date_created() ) ?></b> e atualmente está <mark class="order-status "><?=wc_get_order_status_name( $order->get_status() )?></mark>
</p>
<?php
if($order->get_status() === 'completed'){
	?>
	<div class="mt-sm-4 mt-5 mb-5" id="meus-pedidos-cta">
		<a href="<?= wc_get_endpoint_url( 'minhas-reservas', '', wc_get_page_permalink('myaccount')); ?>">Visualizar reserva ></a>
	</div>
	<?php
}else if($order->get_status() === 'pending'){
	$actions = wc_get_account_orders_actions( $order );
	?>
		<div class="pending-order-buttons mb-5 d-inline-flex align-items-center gap-2">
			<?php
				if ( ! empty( $actions ) ) {
					foreach ( array_reverse($actions) as $key => $action ) {
						if ( $key !== 'view' ) {
							// Define classes específicas para cada tipo de ação (ex: btn-pay ou btn-cancel)
							$btn_class = ( $key === 'pay' ) ? 'btn-pay' : 'btn-cancel';
							
							echo '<a href="' . esc_url( $action['url'] ) . '" class="btn ' . esc_attr( $btn_class ) . ' d-inline-flex align-items-center gap-2" data-action="' . sanitize_html_class( $key ) . '">';
							echo aer_icons($action['name'], 15, 15);
							echo '<span>' . esc_html( $action['name'] ) . '</span>';
							echo '</a>';
						}   
					}
				}
			?>
		</div>
	<?php
}
$notes = $notes ? $notes : [
    (object) [
        'comment_date' => '2026-06-08 09:15:00',
        'comment_content' => 'Pedido recebido e aguardando confirmação do pagamento.'
    ],
    (object) [
        'comment_date' => '2026-06-08 09:47:00',
        'comment_content' => 'Pagamento aprovado pela operadora. Pedido liberado para separação.'
    ],
    (object) [
        'comment_date' => '2026-06-09 14:20:00',
        'comment_content' => 'Itens separados no estoque e encaminhados para expedição.'
    ],
    (object) [
        'comment_date' => '2026-06-09 18:05:00',
        'comment_content' => 'Pedido despachado. Código de rastreamento enviado ao cliente.'
    ],
];
?>
<hr class="mb-5 mt-0">
<div id="pedidoContent">
	<?php if ( $notes ) : ?>
<div id="atualizacoesDoPedido" class="card border-0 shadow-sm rounded-4 p-4">
    <h2 class="h5 fw-bold mb-4 accent-color-text d-flex align-items-center gap-2">
        <?php echo aer_icons('clock', 10, 10); // Ou o seu sistema de ícones para dar um charme ?>
        <?php esc_html_e( 'Order updates', 'woocommerce' ); ?>
    </h2>

    <?php if ( $notes ) : ?>
        <ol class="aerotour-timeline list-unstyled mb-0 ps-2">
            <?php foreach ( $notes as $note ) : ?>
                <li class="timeline-item position-relative pb-4">
                    <span class="timeline-marker position-absolute rounded-circle"></span>
                    
                    <div class="timeline-content ms-2">
                        <span class="text-muted d-block small mb-1 fw-medium">
							<?php echo date_i18n( esc_html__( 'j \d\e F \d\e Y, \à\s H:i', 'woocommerce' ), strtotime( $note->comment_date ) ); ?>
                        </span>
                        
                        <div class="timeline-body text-secondary lh-base bg-light rounded-3 border border-light-subtle">
                            <?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php else : ?>
        <p class="text-muted small mb-0"><?php esc_html_e( 'No updates found.', 'woocommerce' ); ?></p>
    <?php endif; ?>
</div>

	<?php else : ?>
	<p class="no_updates"><?php esc_html_e( 'There are no updates to show.', 'woocommerce' ); ?></p>
	<?php endif; ?>
	<div id="detalhesDoPedido"><?php do_action( 'woocommerce_view_order', $order_id ); ?></div>

</div>
</div>



