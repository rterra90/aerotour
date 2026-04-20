<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

if (!defined('ABSPATH')) {
	exit();
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (
	!$checkout->is_registration_enabled() &&
	$checkout->is_registration_required() &&
	!is_user_logged_in()
) {
	echo esc_html(
		apply_filters(
			'woocommerce_checkout_must_be_logged_in_message',
			__('You must be logged in to checkout.', 'woocommerce')
		)
	);
	return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(
																																										wc_get_checkout_url()
																																									); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__(
																																																																			'Checkout',
																																																																			'woocommerce'
																																																																		); ?>">

	<?php if ($checkout->get_checkout_fields()): ?>

		<?php do_action('woocommerce_checkout_before_customer_details'); ?>
		<div class="row justify-content-between">
			<div class="col-sm-6 col-md-7 p-3" id="customer_details">
				<div class="row">
					<div>
						<?php do_action('woocommerce_checkout_billing'); ?>
					</div>

					<!-- <div class="col-6">
				<?php
				//do_action( 'woocommerce_checkout_shipping' );
				?>
			</div> -->
				</div>
			</div>
			<?php do_action('woocommerce_checkout_after_customer_details'); ?>

		<?php endif; ?>

		<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
		<div class="checkout-pagamento col-sm-6 col-md-5 p-3">
			<div class="checkout-pagamento-inner">
				<h2 id="order_review_heading" class="bg-title mx-auto mb-3">Confira seu pedido</h2>
				<?php do_action('woocommerce_checkout_before_order_review'); ?>
				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action('woocommerce_checkout_order_review'); ?>
				</div>
			</div>

		</div>
		</div>

		<?php do_action('woocommerce_checkout_after_order_review'); ?>

</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

<script>
	const formCheckoutTitle = document.querySelector('#customer_details h3');
	formCheckoutTitle.classList.add('bg-title');

	// Adiciona listeners para aplicação de máscaras ao digitar nos inputs de doc, telefone e data
	function setupInputListeners() {
		const phoneInput = document.querySelector('input#billing_phone');
		const docInput = document.querySelector('input#cpf');

		docInput.setAttribute('value', applyMask(docInput.value, 'cpf'));

		const targetInputs = {
			phone: phoneInput,
			cpf: docInput
		};
		Object.entries(targetInputs).forEach(([_type, _input]) => {
			if (_input && _input.dataset.maskListenerAdded !== 'true') {
				console.log('adicionou listener para ' + _type)
				_input.addEventListener('input', function(e) {
					e.target.value = applyMask(e.target.value, _type);
				});
				_input.dataset.maskListenerAdded = 'true';
			}
		});
	}


	// Gerencia exibição do resumo de dados de faturamento e do formulário
	jQuery(document).ready(function($) {
		const $wrapper = $('.woocommerce-billing-fields__field-wrapper');
		const $summary = $('#billing-summary-section');
		// const $mainTitle = $('.woocommerce-billing-fields h3').first();
		let blurTimeout;

		function checkBillingCompletion(isInitialLoad = false) {
			let allFilled = true;

			// Verifica campos obrigatórios
			$wrapper.find('.validate-required').each(function() {
				const input = $(this).find('input, select');
				if (input.length && input.val().trim() === '') {
					allFilled = false;
				}
			});

			// NOVA REGRA: Só permite virar card se o CPF for válido
			const cpfValue = $('#cpf').val().replace(/\D/g, '');
			const isCpfValid = validarCPF(cpfValue);
			if (allFilled && isCpfValid) {
				renderSummary();
				// No carregamento inicial, usamos .show() para ser instantâneo
				// Em interações posteriores, podemos usar .slideDown() se preferir
				if (isInitialLoad) {
					$summary.show();
					$wrapper.hide();
					// $mainTitle.hide();
				} else {
					$wrapper.slideUp();
					$summary.slideDown();
					// $mainTitle.hide();

				}
			} else {
				// Se não estiver preenchido, garante que o formulário apareça
				$wrapper.show();
				//adicionar display = grid em $wrapper para manter o layout
				$wrapper.css('display', 'grid');
				$summary.hide();
				// $mainTitle.show();
			}

			// // Força a exibição da mensagem de erro
			// if (allFilled && !isCpfValid) {
			// 	handleCPFValidation();
			// }
			setupInputListeners();
		}

		function renderSummary() {
			const firstName = $('#billing_first_name').val();
			const lastName = $('#billing_last_name').val();
			const cpf = applyMask($('#cpf').val(), 'cpf') || '';
			const email = $('#billing_email').val();
			const phone = $('#billing_phone').val();

			const summaryHtml = `
            <p class="summary-name"><strong>${firstName} ${lastName}</strong></p>
            <p>CPF: ${cpf}</p>
            <p>Telefone: ${phone ? applyMask(phone, 'phone') : '<span class="edit-billing edit-billing-phone">Informar telefone</span>'}</p>
            <p>E-mail: ${email}</p>
        `;
			$('.summary-content').html(summaryHtml);
		}

		// Lógica de Foco/Blur (mantida a anterior para evitar o card ao tabular)
		$(document).on('focusout', '.woocommerce-billing-fields__field-wrapper input', function() {
			clearTimeout(blurTimeout);
			blurTimeout = setTimeout(function() {
				if (!$wrapper.is(':focus-within')) {
					checkBillingCompletion(false);
				}
			}, 200);
		});

		// Botão Editar
		$('.edit-billing-data').on('click', function() {
			$summary.slideUp();
			$wrapper.slideDown();
			$wrapper.css('display', 'grid');
			$('#billing_first_name').focus();
		});

		// Novo elemento que deve abrir o form
		// Delegação para o span de "Informar telefone" criado dinamicamente
		$(document).on('click', '.edit-billing-phone', function() {
			$summary.slideUp();
			$wrapper.hide().css('display', 'grid').slideDown();

			// Pequeno timeout para garantir que o elemento esteja visível antes do foco
			setTimeout(function() {
				$('#billing_phone').focus();
			}, 100);
		});

		// EXECUÇÃO IMEDIATA: Verifica assim que o DOM está pronto
		checkBillingCompletion(true);
	});

	// Validação de CPF em tempo real e bloqueio do checkout se inválido
	jQuery(document).ready(function($) {
		const $cpfInput = $('input#cpf');

		function handleCPFValidation() {
			const cpfValue = $cpfInput.val().replace(/\D/g, ''); // Remove máscara para validar
			const $fieldWrapper = $cpfInput.closest('.form-row');

			// Remove mensagens de erro anteriores
			$fieldWrapper.find('.cpf-error-message').remove();

			if (cpfValue.length > 0 && !validarCPF(cpfValue)) {
				$cpfInput.addClass('input-error');
				$fieldWrapper.append('<span class="cpf-error-message">CPF inválido. Verifique os números.</span>');
				return false;
			} else {
				$cpfInput.removeClass('input-error');
				return true;
			}
		}

		// 1. Validação em Tempo Real (ao sair do campo)
		$(document).on('blur', '#cpf', function() {
			handleCPFValidation();
		});

		// 2. Bloqueio do Checkout
		// O WooCommerce dispara o evento 'checkout_place_order' antes de processar
		$(document.body).on('checkout_place_order', function() {
			const isCpfValid = handleCPFValidation();

			if (!isCpfValid) {
				// Rola a tela até o erro para o usuário ver
				$('html, body').animate({
					scrollTop: ($cpfInput.offset().top - 100)
				}, 500);

				// Retornar false impede o envio do formulário do WooCommerce
				return false;
			}
			return true;
		});
	});
</script>