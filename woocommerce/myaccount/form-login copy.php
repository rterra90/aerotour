<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>



<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	<section id="form-login" class="container">

	<script>
		const qr_event_local_storage = JSON.parse(window.localStorage.getItem('aer_qr_event'));

		if(qr_event_local_storage){

			const current_time = new Date().getTime();

			const expire_time = qr_event_local_storage.request_time + 3600;
			
			if(+current_time < +expire_time){
				const qr_alert = document.createElement('div');
				qr_alert.classList.add('qr_event_inner_alert', 'mb-3');
				qr_alert.innerText = "Faça login ou cadastre-se para resgatar seu cupom!";
				document.querySelector('#form-login').insertBefore(qr_alert, document.querySelector('#form-login #customer-login'));
			}else window.localStorage.removeItem('aer_qr_event');


		}
	</script>

		<div class="u-columns row" id="customer_login">

			<div class="col-lg-5 col-12 form-login-section">

				<?php endif; ?>
			<div class="aer-box">				
				<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>
				<?php
					if(isset($_GET['login']) && $_GET['login'] === 'failed'){
						?>
							<div class="login-error-alert">
								Erro: Verifique seus dados e tente fazer login novamente.
							</div>
						<?php
					}
				?>
				<form class="woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text aer-text-input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
						<input class="woocommerce-Input woocommerce-Input--text input-text aer-text-input" type="password" name="password" id="password" autocomplete="current-password" />
					</p>
					<input type="hidden" id="qr_event_coupon_control_login">

					<?php do_action( 'woocommerce_login_form' ); ?>

					<p class="form-row remember-checkbox">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
						</label>
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<button type="submit" data-btn-reactive class="btn btn-dark w-50 woocommerce-button button woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
					</p>
					<p class="woocommerce-LostPassword lost_password">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
					</p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>
				</div>


			</div>

			<div class="col-lg-5 col-12 registrar form-login-section"><div class="aer-box">

				<h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

				<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide reg_username">
							<label for="reg_username">CPF <i>(apenas números)</i></label>
							<input type="number" class="woocommerce-Input woocommerce-Input--text input-text <?= isset($_POST['username']) && strlen($_POST['username']) < 11 && !isset($_GET['login']) ? 'erro-input' : ''; ?> aer-text-input" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</p>

					<?php endif; ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?></label>
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text aer-text-input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?></label>
							<input type="password" class="woocommerce-Input woocommerce-Input--text input-text aer-text-input" name="password" id="reg_password" autocomplete="new-password" />
						</p>


						<?php
						function coupon_to_register(){
							if(get_option('qr_code_coupon_status')['status'] === 'ativado') return 'qr_code_coupon_status';
							else if(get_option('new_register_coupon_status')['status'] === 'ativado') return 'new_register_coupon_status';
							else return null;
						};
						if(coupon_to_register() !== null){
							?>
								<input type="hidden" id="<?= str_replace('_status', '_control', coupon_to_register()). '_register'; ?>" data-code="<?= get_option(coupon_to_register())['code']; ?>" />
							<?php
						}
							
						?>
					<?php else : ?>

						<p><?php esc_html_e( 'A link to set a new password will be sent to your email address.', 'woocommerce' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

					<p class="woocommerce-form-row form-row">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<button type="submit" data-btn-reactive class="btn btn-dark woocommerce-Button woocommerce-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
					</p>
					<?php do_action( 'woocommerce_register_form_end' ); ?>

				</form>

			
		</div>
	</section>


<script>
	let ja_errou = false;
	function validarCpf(e){
		if(e.type === "keyup" && ja_errou){
			if(e.target.value.length === 11) e.target.classList.remove('erro-input');
			else e.target.classList.add('erro-input');
		}else if(e.type === "blur"){
			if(e.target.value.length !== 11 && e.target.value.length !== 0){
				e.target.classList.add('erro-input');
				ja_errou = true;
			}else e.target.classList.remove('erro-input');
		}
  
}
document.querySelector('.reg_username input').addEventListener('keyup', validarCpf);
document.querySelector('.reg_username input').addEventListener('blur', validarCpf);

document.querySelectorAll('input[name="billing_last_name"], input[name="billing_first_name"]').forEach(inp => inp.classList.add('aer-text-input'));


if(qr_event_local_storage){
	document.querySelector('#qr_code_coupon_control_register').setAttribute('name', 'qr_event_coupon_control');
	document.querySelector('#qr_code_coupon_control_register').setAttribute('value', qr_event_local_storage.coupon);
	document.querySelector('#qr_event_coupon_control_login').setAttribute('name', 'qr_event_coupon_control');
	document.querySelector('#qr_event_coupon_control_login').setAttribute('value', qr_event_local_storage.coupon);
}

<?php
	if(get_option('new_register_coupon_status')){
		$coupon_code = get_option('new_register_coupon_status')['code'];
		?>
			document.querySelector('#new_register_coupon_control_register').setAttribute('name', 'new_register_coupon_control');
			document.querySelector('#new_register_coupon_control_register').setAttribute('value', document.querySelector('#new_register_coupon_control_register').dataset.code);
		<?php
	}
?>
    
    
    
    
    	document.querySelectorAll('input[type="password"]').forEach(inp => {
    	const eyeWrapperElement = document.createElement('div');
        eyeWrapperElement.classList.add('mostra-senha');
        eyeWrapperElement.innerHTML = '<span class="mostra-senha_icone"><i class="bi bi-eye-slash-fill"></i></span>';
        inp.parentElement.appendChild(eyeWrapperElement);
            
        eyeWrapperElement.querySelector('.mostra-senha_icone').addEventListener('click', ({currentTarget}) => {

            const _inp = currentTarget.parentElement.parentElement.children[1];
            _inp.type = _inp.type === 'password' ? 'text' : 'password'; 
            
            currentTarget.children[0].classList.toggle('bi-eye-fill');
            currentTarget.children[0].classList.toggle('bi-eye-slash-fill');
             
        })
    })

</script>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>