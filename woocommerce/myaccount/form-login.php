<?php
if (!defined('ABSPATH')) {
	exit(); // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form');
?>


<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')):
endif; ?>

<section id="form-login" class="container">

	<!-- Título -->
	<div class="login-title-section">
		<span>Olá, visitante!</span>
		<h1>Faça login ou cadastre-se para continuar.</h1>
	</div>

	<?php do_action('woocommerce_after_title_my_account'); ?>


	<div class="login-container" id="customer_login">

		<div class="mobile-tabs">
			<div class="tab active" onclick="showTab('login')">Entrar</div>
			<div class="tab" onclick="showTab('cadastro')">Cadastrar</div>
		</div>

		<!-- JÁ SOU CLIENTE -->
		<div class="login-box active" id="login">
			<h2 class="bg-title">Já sou cliente</h2>
			<?php if (isset($_GET['login']) && $_GET['login'] === 'failed') { ?>
				<div class="login-error-alert">
					Erro: Verifique seus dados e tente fazer login novamente.
				</div>
			<?php } ?>
			<form class="woocommerce-form woocommerce-form-login login" method="post" action="<?php echo esc_url(
																																													get_permalink()
																																												); ?>">
				<?php do_action('woocommerce_login_form_start'); ?>

				<div>
					<label for="username"><?php esc_html_e(
																	'Username or email address',
																	'woocommerce'
																); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" name="username" id="username" autocomplete="username" value="<?php echo !empty($_POST['username'])
																																														? esc_attr(wp_unslash($_POST['username']))
																																														: ''; ?>" />
				</div>
				<div>
					<label for="password"><?php esc_html_e(
																	'Password',
																	'woocommerce'
																); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" name="password" id="password" autocomplete="current-password" />
				</div>
				<input type="hidden" id="qr_event_coupon_control_login">

				<?php do_action('woocommerce_login_form'); ?>

				<p class="form-login-end remember-checkbox">
					<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e(
																																																																																	'Remember me',
																																																																																	'woocommerce'
																																																																																); ?></span>
					</label>
					<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
					<button type="submit" data-btn-reactive class="main-btn woocommerce-form-login__submit<?php echo esc_attr(
																																																	wc_wp_theme_get_element_class_name('button')
																																																		? ' ' . wc_wp_theme_get_element_class_name('button')
																																																		: ''
																																																); ?>" name="login" value="<?php esc_attr_e(
																																																															'Log in',
																																																															'woocommerce'
																																																														); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
				</p>

				<p class="woocommerce-LostPassword lost_password">
					<a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e(
																																		'Lost your password?',
																																		'woocommerce'
																																	); ?></a>
				</p>

				<?php do_action('woocommerce_login_form_end'); ?>

			</form>
		</div>

		<!-- QUERO ME CADASTRAR -->
		<div class="login-box" id="cadastro">
			<h2 class="bg-title">Quero me cadastrar</h2>

			<!-- THIRD PARTY LOGIN APP -->
			<div id="thirdPartyLogin"></div>

			<!-- REGISTRO COM FORMULÁRIO -->
			<!-- Botão -->
			<button id="emailRegister" class="secondary-btn toggle-active">
				<div class="d-flex gap-2"><?= aer_icons(
																		'email',
																		20,
																		20
																	) ?><span>Cadastrar com email</span></div>
			</button>

			<!-- Formulário de registro -->
			<form id="emailRegisterForm" method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action(
																																																								'woocommerce_register_form_tag'
																																																							); ?>>

				<?php do_action('woocommerce_register_form_start'); ?>

				<?php if ('no' === get_option('woocommerce_registration_generate_username')): ?>

					<div class="form-row-hidden">
						<input type="hidden" class="<?= isset($_POST['username']) &&
																					strlen($_POST['username']) < 11 &&
																					!isset($_GET['login'])
																					? 'erro-input'
																					: '' ?>" name="username" id="reg_username" autocomplete="username" value="<?php echo !empty($_POST['username'])
																																																											? esc_attr(wp_unslash($_POST['username']))
																																																											: ''; ?>" />
					</div>

				<?php endif; ?>

				<div class="form-row">
					<label for="reg_email"><?php esc_html_e(
																		'Email address',
																		'woocommerce'
																	); ?></label>
					<input type="email" name="email" id="reg_email" autocomplete="email" value="<?php echo !empty($_POST['email'])
																																												? esc_attr(wp_unslash($_POST['email']))
																																												: ''; ?>" />
				</div>

				<?php if ('no' === get_option('woocommerce_registration_generate_password')): ?>

					<div class="form-row-password-container">
						<label for="reg_password"><?php esc_html_e(
																				'Password',
																				'woocommerce'
																			); ?></label>
						<input type="password" name="password" id="reg_password" autocomplete="new-password" />
					</div>

					<?php
					function coupon_to_register()
					{
						if (get_option('qr_code_coupon_status')['status'] === 'ativado') {
							return 'qr_code_coupon_status';
						} elseif (
							get_option('new_register_coupon_status')['status'] === 'ativado'
						) {
							return 'new_register_coupon_status';
						} else {
							return null;
						}
					}
					if (coupon_to_register() !== null) { ?>


						<input type="hidden" data-code>

						<script>
							const cupomInputHidden = document.querySelector('.woocommerce-form-register > input[type="hidden"][data-code]');

							cupomInputHidden.id = window.localStorage.getItem('aer_qr_event') ? 'qr_code_coupon_control_register' : 'new_register_coupon_control_register';
							cupomInputHidden.dataset.code = window.localStorage.getItem('aer_qr_event') ? 'sundayrocksunday' : 'boasvindas';
						</script>
					<?php }
					?>
				<?php else: ?>

					<p><?php esc_html_e(
								'A link to set a new password will be sent to your email address.',
								'woocommerce'
							); ?></p>

				<?php endif; ?>

				<?php do_action('woocommerce_register_form'); ?>
				<input type="hidden" id="register_method" value="site" name="register_method">
				<p class="woocommerce-form-row form-row">
					<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
					<button type="submit" data-btn-reactive class="main-btn woocommerce-form-register__submit" name="register" value="<?php esc_attr_e(
																																																															'Register',
																																																															'woocommerce'
																																																														); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
				</p>
				<?php do_action('woocommerce_register_form_end'); ?>

			</form>
		</div>


</section>

<script>
	const usernameHidden = document.querySelector('form.register input[name="username"]');
	const emailInput = document.querySelector('form.register input[type="email"]');
	emailInput.addEventListener('keyup', ({
		target
	}) => {
		usernameHidden.setAttribute('value', target.value)
	})

	const emailRegisterBtn = document.querySelector('#emailRegister');
	emailRegisterBtn.addEventListener('click', ({
		currentTarget
	}) => {
		const registerForm = document.querySelector('form.register');
		currentTarget.classList.toggle('active');
		registerForm.style.display = currentTarget.classList.contains('active') ? "block" : "none";
	})
</script>

<script>
	let ja_errou = false;

	function cpfMask({
		target
	}) {
		let masked = target.value.replace(/\D/g, '') // substitui qualquer caracter que nao seja numero por nada
			.replace(/(\d{3})(\d)/, '$1.$2') // captura 2 grupos de numero o primeiro de 3 e o segundo de 1, apos capturar o primeiro grupo ele adiciona um ponto antes do segundo grupo de numero
			.replace(/(\d{3})(\d)/, '$1.$2')
			.replace(/(\d{3})(\d{1,2})/, '$1-$2')
			.replace(/(-\d{2})\d+?$/, '$1'); // captura 2 numeros seguidos de um traço e não deixa ser digitado mais nada
		target.value = masked;
	};

	function validarCpf(e) {
		if (e.type === "keyup" && ja_errou) {
			if (e.target.value.length === 14) e.target.classList.remove('erro-input');
			else e.target.classList.add('erro-input');
		} else if (e.type === "blur") {
			if (e.target.value.length !== 11 && e.target.value.length !== 0) {
				e.target.classList.add('erro-input');
				ja_errou = true;
			} else e.target.classList.remove('erro-input');
		}
	}

	document.querySelector('input#reg_username').addEventListener('keyup', (e) => cpfMask(e));


	<?php if (get_option('new_register_coupon_status')) {
		// && !get_option('qr_code_coupon_status')
		$coupon_code = get_option('new_register_coupon_status')['code']; ?>
		const _target = document.querySelector('#new_register_coupon_control_register');
		if (_target) {
			_target.setAttribute('name', 'new_register_coupon_control');
			_target.setAttribute('value', document.querySelector('#new_register_coupon_control_register').dataset.code);
		}

	<?php
	} ?>


	document.querySelectorAll('input[type="password"]').forEach(inp => {
		const eyeWrapperElement = document.createElement('div');
		eyeWrapperElement.classList.add('mostra-senha');
		inp.parentElement.appendChild(eyeWrapperElement);

		eyeWrapperElement.innerHTML = '<span class="mostra-senha_icone"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/></svg></span>';

		eyeWrapperElement.querySelector('.mostra-senha_icone').addEventListener('click', ({
			currentTarget
		}) => {

			const _inp = currentTarget.parentElement.parentElement.children[1];

			if (_inp.type === 'password') {
				currentTarget.children[0].innerHTML = '<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>'
				_inp.type = 'text';

			} else {
				currentTarget.children[0].innerHTML = '<path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>'
				_inp.type = 'password';

			}

		})
	})
</script>
<?php
if (get_option('google_login_enabled') == 1) {
?>
	<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/react_apps/third_party_login.js"></script>
<?php
}
?>
<script>
	function showTab(tabId) {
		document.querySelectorAll('.login-box').forEach(box => {
			box.classList.remove('active');
		});
		document.querySelectorAll('.mobile-tabs .tab').forEach(tab => {
			tab.classList.remove('active');
		});
		document.getElementById(tabId).classList.add('active');
		document.querySelector(`.tab[onclick="showTab('${tabId}')"]`).classList.add('active');
	}
</script>
<!-- React e ReactDOM em produção -->
<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin defer></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin defer></script>
<?php do_action('woocommerce_after_customer_login_form'); ?>