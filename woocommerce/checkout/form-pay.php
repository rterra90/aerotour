<?php

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals();
?>
<section>
  <h1 class="mb-4">Finalizar pagamento</h1>

  <!-- NOVO -->
  <form id="order_review" method="post">
    <div>
      <div class="table-wrapper woocommerce-order-details">
        <div>
          <h2 class="bg-title h5">Pedido #<?= $order -> get_id(); ?></h2>

        <!-- Template de tabela de itens do pedido -->
        <?php
        wc_get_template(
          'order/custom-order-details-table.php',
          [
              'order' => $order,
              'order_items' => $order->get_items(),
              'show_purchase_note' => false,
          ]
        );
        ?>
        </div>
        
      </div>

      
    </div>
    <div id="payment">
        <h3 class="h6">Selecione a forma de pagamento</h3>
        <?php if ( $order->needs_payment() ) : ?>
          <ul class="wc_payment_methods payment_methods methods">
            <?php
            if ( ! empty( $available_gateways ) ) {
              foreach ( $available_gateways as $gateway ) {
                wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
              }
            } else {
              echo '<li>';
              wc_print_notice( apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) ), 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
              echo '</li>';
            }
            ?>
          </ul>
        <?php endif; ?>
        <div class="form-row">
          <input type="hidden" name="woocommerce_pay" value="1" />

          <?php wc_get_template( 'checkout/terms.php' ); ?>

          <?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

          <?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="main-btn button alt' . esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ) . '" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

          <?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

          <?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
        </div>
      </div>
  <form>


<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/form-pay.css">
</section>

