<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>Olá, <?php print_r( $email -> object -> display_name); ?>!</p>

<p>Obrigado por se cadastrar na Aerotour Excursões!</p>
<p>A partir de agora, você poderá reservar seu lugar em nossas excursões de forma prática e segura por meio do nosso site.</p>
<!-- <p>Para finalizar suas reservas, será necessário informar alguns dados adicionais, como o número do documento de identidade e telefone. Você pode fazer isso acessando Minha conta > Detalhes da Conta ou na finalização de uma reserva.</p> -->





<?php
/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	// echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

do_action( 'woocommerce_email_footer', $email );
