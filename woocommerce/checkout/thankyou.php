<?php
defined( 'ABSPATH' ) || exit;

?>
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/thankyou.js"></script>

<div class="woocommerce-order row">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

      
			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>
    <div class="detalhes-pedido col-md-3">
      
      <div class="progress passo-1" style="height: 6px">
        <div class="progress-bar <?= $order -> status === 'completed' ? 'completed' : 'animate-1 success'; ?>" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
      </div>

      <div class="thankyou-box aer-box">
        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
      <p class="pedido-prazo">Pedido válido por 30 minutos</p>
      <p class="pedido-prazo-aviso">Após esse período, o pedido é automaticamente cancelado e as vagas voltam a ser disponibilizadas para reserva.</p>
        <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

          <li class="woocommerce-order-overview__order order">
            <?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
            <strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </li>

          <li class="woocommerce-order-overview__date date">
            <?php esc_html_e( 'Date:', 'woocommerce' ); ?>
            <strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </li>

          <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
            <li class="woocommerce-order-overview__email email">
              <?php esc_html_e( 'Email:', 'woocommerce' ); ?>
              <strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>
          <?php endif; ?>

          <li class="woocommerce-order-overview__total total">
            <?php esc_html_e( 'Total:', 'woocommerce' ); ?>
            <strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </li>

          <?php if ( $order->get_payment_method_title() ) : ?>
            <li class="woocommerce-order-overview__payment-method method">
              <?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
              <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      
    </div>
			
		<?php endif; ?>
    <div class="detalhes-gateway col-md-9">
      <div class="progress passo-2" style="height: 6px">
        <div class="progress-bar animate-2 <?= $order->status !== 'completed' ? 'pending': 'success' ?>" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="animation-delay: <?= $order->status !== 'completed' ? '5s' : '1s' ?>"></div>
      </div>
      <?php 
        if($order -> status === 'pending'){
          do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
          ?>
            <script>
              fbq('track', 'InitiateCheckout');
              gtag('event', 'conversion', {'send_to': 'AW-999675677/wGPkCLi28-sYEJ2u19wD'});

              if(document.querySelector('.mp-details-title')){
                document.querySelector('.mp-details-title').innerText = 'Quase lá! Agora é só finalizar o pagamento para garantir sua reserva.';
              }
            </script>
          

          <?php
        }elseif ($order->status === 'completed'){
          ?>
          <div id="pagamentoSucesso" class="p-4 d- mb-4">
            <p class="h4 mb-3"><?= aer_icons('sucesso', 24, 24); ?>Muito obrigado! Seu pagamento foi recebido com sucesso.</p>
            <p class="lead">Você receberá um e-mail com informações sobre o pagamento e as excursões que você reservou.</p>
            <p class="lead mb-0">A partir da sua conta, você pode conferir os <a href="<?= wc_get_endpoint_url( 'pedidos', '', wc_get_page_permalink('myaccount') ); ?>">detalhes de seus pedidos</a> e <a href="<?= wc_get_endpoint_url( 'minhas-reservas', '', wc_get_page_permalink('myaccount') ); ?>">gerenciar suas reservas</a>.</p>

          </div>
          <script>
            const successBox = document.querySelector('#pagamentoSucesso');
            successBox.classList.remove('d-none');
            successBox.classList.add('animate');

          //   //conversão Pixel Facebook
          //   fbq('track', 'Purchase');

          //   //Conversão Google Ads
          //   gtag('event', 'conversion', {
          //     'send_to': 'AW-999675677/JWZTCNO0nM8YEJ2u19wD',
          //     'transaction_id': "<?php //$order->get_id(); ?>",
          // });

          </script>

          <?php
        }
      ?>
        <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
    </div>

	<?php else : ?>

		<p class="mb-2 woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; 
  
  if($order->status === 'pending'){
    ?>
  <script>insertReloadAlert()</script>
    <?php
  }
  ?>

</div>
