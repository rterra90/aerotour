<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<section id="form-lost-password">
	<h1 class="mb-4">Recupere sua senha</h1>
	<form method="post" class="woocommerce-ResetPassword lost_reset_password login-container">
		<div class="login-box">
				<p>Esqueceu sua senha? Informe seu e-mail ou CPF cadastrado no site para receber um link de redefinição e volte a reservar suas excursões conosco!</p>

				<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first text-center">
					<label for="user_login">CPF ou e-mail</label>
					<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
				</p>

				<div class="clear"></div>

				<?php do_action( 'woocommerce_lostpassword_form' ); ?>

				<p class="woocommerce-form-row form-row">
					<input type="hidden" name="wc_reset_password" value="true" />
					<button type="submit" class="btn btn-small main-btn woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" value="Solicitar e-mail">Solicitar e-mail</button>
				</p>

				<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
		</div>
	</form>
</section>

<?php
do_action( 'woocommerce_after_lost_password_form' );
