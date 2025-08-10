
<?php
defined( 'ABSPATH' ) || exit;

?>

<div class="notices woocommerce-notices-wrapper">
<?php wc_print_notices(); ?>
</div>
<div id="carrinho-container" class="empty-cart text-center">
<h1>Carrinho de reservas</h1>
<div class="empty-cart">
	<p>Nenhuma reserva em seu carrinho no momento.</p>
	<p><a href="<?= get_home_url(); ?>">Que tal conferir nossas próximas excursões?</a></p>
</div>


</div>





<?php


if ( wc_get_page_id( 'shop' ) > 0 && 1 === 2 ) : ?>
	<p class="return-to-shop">
		<a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php
				/**
				 * Filter "Return To Shop" text.
				 *
				 * @since 4.6.0
				 * @param string $default_text Default text.
				 */
				echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) );
			?>
		</a>
	</p>
<?php endif; ?>

