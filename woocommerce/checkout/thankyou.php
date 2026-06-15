<?php
defined( 'ABSPATH' ) || exit;

?>
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/thankyou.js"></script>
<script>
  function rearrangeThankyou(){
    const successContainer = document.querySelector('#pagamentoSucesso').parentElement;
    const refContainer = document.querySelector('.woocommerce-order.row');
    refContainer.insertBefore(successContainer, refContainer.firstChild);

    const prazoContainer = document.querySelector('#pedido-prazo')
    if(prazoContainer) prazoContainer.remove();
  }
</script>
<div id="page-thankyou" class="woocommerce-order row" style="flex-direction: <?= $order -> status === 'completed' ? 'row-reverse' : 'row' ?>">
  <?php
    if($order->has_status(['pending', 'on-hold'])){
      ?>
        <h2 class="thankyou-title">Quase lá! Agora é só finalizar o pagamento para garantir sua reserva.</h2>
      <?php
    }

?>
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
      
      <div class="progress step-1" style="height: 6px">
        <?php
        $bar_style = '';
        if($order -> status === 'completed' ){
          $bar_style = 'completed';
        } elseif ($order->has_status(['pending', 'on-hold'])) {
          $bar_style = 'animate-1 success';
        } elseif ($order -> status === 'cancelled' ){
          $bar_style = 'cancelled';

        }
        ?>
        <div class="progress-bar step-1 <?= $bar_style; ?>" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
      </div>

      <div id="thankyou-box"class="thankyou-box card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
        
        <!-- TIMER É INSERIDO NESTE HOOK -->
        <?php do_action( 'woocommerce_before_thankyou_box', $order->get_id() ); ?>

        
          <div id="pedido-prazo" class="text-center mb-2 mb-md-3">
            <?php
            // se o pedido estiver pendente
            if($order->has_status(['pending', 'on-hold'])) : ?>
              <p class="pedido-prazo-aviso text-muted small m-0 px-2">
                  <i class="bi bi-info-circle me-1 text-warning"></i> Após esse período, o pedido é automaticamente cancelado e as vagas voltam para o sistema.
              </p>
            

              <?php elseif($order->has_status(['cancelled'])) : ?>
              <div class="alert alert-danger text-center fw-bold mb-4 py-2">Este pedido está cancelado e não pode mais ser pago.</div>
              <p class="pedido-prazo-aviso text-muted small m-0 px-2">
                  <i class="bi bi-info-circle me-1 text-warning"></i>Será necessário fazer um novo pedido para garantir sua reserva.
              </p>
              
            <?php endif; ?>
          </div>

          <hr class="border-light my-3">
      
          <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received h5 fw-bold text-dark mb-2 text-center text-sm-start">
              Resumo do pedido
          </p>
          
          <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details d-flex flex-column gap-1 m-0 p-0">

          <li class="woocommerce-order-overview__order order d-flex w-100 justify-content-between">
            <span class="d-block text-muted small text-uppercase"><?php esc_html_e( 'Order number:', 'woocommerce' ); ?></span>
            <strong class="text-dark text-end"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </li>

          <li class="woocommerce-order-overview__date date col-6 col-sm-4 col-md-2 d-flex w-100 justify-content-between">
            <span class="d-block text-muted small text-uppercase"><?php esc_html_e( 'Date:', 'woocommerce' ); ?></span>
            <strong class="text-dark text-end"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </li>

          <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
            <li class="woocommerce-order-overview__email email col-6 col-sm-4 col-md-2 d-flex w-100 justify-content-between">
              <span class="d-block text-muted small text-uppercase"><?php esc_html_e( 'Email:', 'woocommerce' ); ?></span>
              <strong class="text-dark text-end"><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
            </li>
          <?php endif; ?>

          <li class="woocommerce-order-overview__total total col-6 col-sm-4 col-md-2 d-flex w-100 justify-content-between">
            <span class="d-block text-muted small text-uppercase"><?php esc_html_e( 'Total:', 'woocommerce' ); ?></span>
            <strong class="text-dark text-end"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
          </li>

          <?php if ( $order->get_payment_method_title() ) : ?>
            <li class="woocommerce-order-overview__payment-method method col-6 col-sm-4 col-md-2 d-flex w-100 justify-content-between">
              <span class="d-block text-muted small text-uppercase"><?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></span>
              <strong class="text-dark text-end"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      
    </div>
			
		<?php endif; ?>
    <div class="detalhes-gateway col-md-9">
      <div class="progress step-2" style="height: 6px">

        <?php
          $bar_style_2 = '';
          if( $order->status === 'completed') {$bar_style_2 = 'success';}
          elseif ($order->has_status(['pending', 'on-hold'])) {$bar_style_2 = 'pending';}
          elseif ( $order->status === 'cancelled') {$bar_style_2 = 'cancelled';}
        ?>

        <div class="progress-bar step-2 animate-2 <?= $bar_style_2; ?>" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="animation-delay: <?= $order->has_status(['completed', 'cancelled']) ? '1s' : '5s' ?>"></div>
      </div>
      <?php 
        if($order -> status === 'pending'){
          do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );
          ?>
            <script>

                const mpDetailsTitle = document.querySelector('.mp-details-title');
                if(mpDetailsTitle){
                  mpDetailsTitle.innerText = 'Quase lá! Agora é só finalizar o pagamento para garantir sua reserva...';
                  mpDetailsTitle.remove();
                }

              
            </script>
          

          <?php
        }elseif ($order->status === 'completed'){
          ?>
          <div id="pagamentoSucesso" class="card border-0 shadow-sm overflow-hidden mb-2 rounded-4">
      <div class="bg-success text-white p-4 text-center">
          <div class="success-icon-wrapper mb-3 d-inline-flex align-items-center justify-content-center bg-white text-success rounded-circle shadow-sm" style="width: 60px; height: 60px;">
              <?= aer_icons('sucesso', 32, 32); ?>
          </div>
          <h2 class="h3 fw-bold mb-1">Pagamento Confirmado!</h2>
          <p class="mb-0 opacity-85 fs-5">Sua vaga está garantida na excursão.</p>
      </div>

      <div class="card-body p-4 p-md-5 bg-white">
          
          <div class="alert alert-info border-0 bg-light-subtle p-3 mb-4 rounded-3 d-flex align-items-start gap-3">
              <span class="fs-4 text-info lh-1">💡</span>
              <div>
                  <strong class="d-block text-dark mb-1">Tudo pronto e automático!</strong>
                  <span class="text-secondary small">Nosso sistema já identificou sua transação. <span class="fw-bold">Não é necessário</span> enviar comprovantes por WhatsApp ou e-mail.</span>
              </div>
          </div>

          <h4 class="h6 text-uppercase tracking-wider text-muted fw-bold mb-4">O que acontece agora?</h4>

          <div class="row g-4 mb-4">
              <div class="col-12 col-md-6">
                  <div class="d-flex gap-3 align-items-start">
                      <div class="step-number bg-success-subtle text-success fw-bold rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">1</div>
                      <div>
                          <h5 class="h6 fw-bold mb-1">Confirmação por E-mail</h5>
                          <p class="text-secondary small mb-0">Enviamos os detalhes da transação e os detalhes da sua reserva diretamente para a sua caixa de entrada.</p>
                      </div>
                  </div>
              </div>

              <div class="col-12 col-md-6">
                  <div class="d-flex gap-3 align-items-start">
                      <div class="step-number bg-success-subtle text-success fw-bold rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">2</div>
                      <div>
                          <h5 class="h6 fw-bold mb-1">Gerenciamento na Conta</h5>
                          <p class="text-secondary small mb-0">Você pode visualizar o voucher e gerenciar suas reservas acessando "Minhas reservas" na área de membros.</p>
                      </div>
                  </div>
              </div>
          </div>

          <hr class="text-muted opacity-25 my-4">

          <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-3 mt-2">
              <a href="<?= wc_get_endpoint_url( 'minhas-reservas', '', wc_get_page_permalink('myaccount') ); ?>" class="btn btn-success px-4 py-2 w-100 w-sm-auto rounded-3 d-inline-flex align-items-center justify-content-center gap-2">
                  Ver Minhas Reservas
              </a>
              <a href="<?= wc_get_endpoint_url( 'pedidos', '', wc_get_page_permalink('myaccount') ); ?>" class="btn btn-outline-secondary px-4 py-2 w-100 w-sm-auto rounded-3">
                  Histórico de Pedidos
              </a>
          </div>

      </div>
    </div>
          <script>
            const successBox = document.querySelector('#pagamentoSucesso');
            if(successBox){
              successBox.classList.remove('d-none');
              successBox.classList.add('animate');
              rearrangeThankyou()
            }

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
  <script>              if (fbq) fbq('track', 'InitiateCheckout');
              if (gtag) gtag('event', 'conversion', {'send_to': 'AW-999675677/wGPkCLi28-sYEJ2u19wD'});</script>
    <?php
  }
  ?>

</div>
