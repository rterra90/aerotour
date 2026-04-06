<?php
if (! defined('ABSPATH')) {
	exit;
}
global $wpdb;
$customer_id = get_current_user_id();
// Verifica se há pedido pendente do usuário
$customer_orders = wc_get_orders(array(
	'customer' => $customer_id,
	'status'   => array('wc-pending', 'wc-on-hold'), // Status que acionam o alerta
	'limit'    => 1,
));
$pending_order = ! empty($customer_orders) ? $customer_orders[0] : null;

// Verifica se há próxima excursão para o usuário
// 1. Busca as variações vinculadas ao usuário
$customer_reservas = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT variation_id FROM aer_reservas WHERE user_id = %d AND status != 'cancel'",
		$customer_id
	)
);

$proximas = [];
$hoje = new DateTime('today');

foreach ($customer_reservas as $reserva) {
	$variation_id = $reserva->variation_id;
	$data_meta = get_post_meta($variation_id, 'attribute_dia', true); // 'dd/mm/aaaa'

	if ($data_meta) {
		// Converte o formato dd/mm/aaaa para um objeto DateTime
		$data_excursao = DateTime::createFromFormat('d/m/Y', $data_meta);

		// Garante que a data é válida e se é igual ou superior a hoje
		if ($data_excursao && $data_excursao >= $hoje) {
			$proximas[] = [
				'variation_id' => $variation_id,
				'timestamp'    => $data_excursao->getTimestamp(),
				'data_formatada' => $data_meta
			];
		}
	}
}
// 2. Lógica para pegar a mais próxima
$variation_id_proxima = null;

if (!empty($proximas)) {
	// Ordena o array pelo timestamp (do menor para o maior)
	usort($proximas, function ($a, $b) {
		return $a['timestamp'] <=> $b['timestamp'];
	});

	// O primeiro item após o sort é a excursão mais próxima
	$variation_id_proxima = $proximas[0]['variation_id'];
	$data_da_proxima = $proximas[0]['data_formatada'];

	// Instancia a variação como um objeto de produto do WooCommerce
	$variation = wc_get_product($variation_id_proxima);

	if ($variation) {
		// 1. Obtém o ID do produto pai
		$parent_id = $variation->get_parent_id();

		// 2. Busca o nome do produto pai (Produto Principal)
		$nome_excursao = get_the_title($parent_id);

		// 3. Obtém a imagem (Busca a imagem da variação, se não tiver, busca a do produto pai)
		$image_id  = $variation->get_image_id();
		$image_url = wp_get_attachment_image_url($image_id, 'medium'); // Tamanho 'medium' é ideal para cards

		// Fallback: se a variação não tiver imagem própria, usa uma padrão do tema ou placeholder
		if (! $image_url) {
			$image_url = wc_placeholder_img_src();
		}

		// 4. Link para a página do produto (opcional para o card)
		$link_excursao = get_permalink($variation->get_parent_id());
	}
}

// CUPONS
$meta_cupons = get_user_meta($customer_id, 'cupons', true);
$cupons_ativos = [];

if (!empty($meta_cupons)) {
	$ids_cupons = json_decode($meta_cupons, true);

	if (is_array($ids_cupons)) {
		foreach ($ids_cupons as $id) {
			$coupon = new WC_Coupon($id);

			// Verifica se o ID realmente corresponde a um cupom válido
			if (!$coupon->get_id()) continue;
			// 1. Verificação de Expiração (Nativo WC)
			$data_expiracao = $coupon->get_date_expires();
			$is_expirado = ($data_expiracao && $data_expiracao->getTimestamp() < time());

			// 2. Verificação de Uso por este Usuário (CORRIGIDO)
			// Pegamos o array de IDs de usuários que já usaram o cupom
			$users_who_used = $coupon->get_used_by();

			// Contamos quantas vezes o ID do usuário atual aparece no array
			$uso_do_usuario = is_array($users_who_used) ? count(array_keys($users_who_used, $customer_id)) : 0;

			$limite_por_usuario = $coupon->get_usage_limit_per_user();

			// Se o limite por usuário for maior que 0 e o uso for maior ou igual ao limite
			$ja_usado = ($limite_por_usuario > 0 && $uso_do_usuario >= $limite_por_usuario);

			// 3. Só adicionamos aos ativos se não expirou, não atingiu o limite de uso e está publicado
			if (!$is_expirado && !$ja_usado && $coupon->get_status() === 'publish') {
				$cupons_ativos[] = $coupon;
			}
		}
	}
}

$show_dashboard = isset($variation_id_proxima) || count($cupons_ativos) > 0;
?>


<div id="account-dashboard" class="h-100">
	<h2 class="mb-3">Olá, <?php echo esc_html($current_user->display_name); ?>!</h2>

	<?php
	// Lógica para verificar dados faltantes
	$user_id = get_current_user_id();
	$cpf = get_user_meta($user_id, 'cpf', true);
	$data_nasc = get_user_meta($user_id, 'data_nasc', true);
	$sobrenome = get_user_meta($user_id, 'last_name', true);
	$telefone = get_user_meta($user_id, 'billing_phone', true);


	if (empty($cpf) || empty($data_nasc) || empty($sobrenome) || empty($telefone)) : ?>
		<div class="account-alert friendly alert-dismissible d-flex align-items-center alert" role="alert">
			<i class="bi bi-lightbulb-fill me-2"></i>
			<div class="completar-dados-alert">Dica: Complete seu cadastro e finalize suas reservas de forma mais rápida utilizando seus dados cadastrais. <a href="<?= esc_url(wc_customer_edit_account_url()) ?>">(Editar dados)</a></div>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php endif; ?>


	<?php
	if ($show_dashboard) {
	?>
		<div class="dashboard-flex">

			<!-- ALERTA DE PEDIDO PENDENTE -->
			<?php if ($pending_order) :
				$order_id   = $pending_order->get_id();
				$order_url  = $pending_order->get_view_order_url();
			?>
				<div class="order-pending-alert">
					<div class="order-pending-alert-header">
						<span class="badge-alert" role="title">Pedido pendente: #<?= $order_id; ?></span>
					</div>

					<p>O pagamento pelo pedido <strong>#<?php echo $order_id; ?></strong> ainda não foi identificado.</p>

					<p class="card-note"><small>Finalize o pagamento para garantir sua vaga na excursão.</small></p>

					<div class="alert-actions">
						<a href="<?php echo esc_url($order_url); ?>" class="dashboard-btn">
							Ver pedido
						</a>
					</div>
				</div>

			<?php endif; ?>

			<!-- PRÓXIMA EXCURSÃO - DASHBOARD -->
			<?php if ($variation_id_proxima && isset($nome_excursao)) : ?>
				<div class="dashboard-section proxima-viagem">
					<?php
					$texto_contagem = "";

					if ($variation_id_proxima) {
						$hoje = new DateTime('today');
						$data_viagem = DateTime::createFromFormat('d/m/Y', $data_da_proxima);
						$data_viagem->setTime(0, 0, 0); // Normaliza para comparar apenas as datas

						if ($data_viagem == $hoje) {
							$texto_contagem = "Sua próxima excursão é hoje! 🎒";
						} else {
							$intervalo = $hoje->diff($data_viagem);
							$dias_restantes = $intervalo->days;

							if ($dias_restantes == 1) {
								$texto_contagem = "Falta apenas 1 dia para sua próxima excursão! 🚌";
							} else {
								$texto_contagem = "Faltam " . $dias_restantes . " dias para sua próxima excursão";
							}
						}
					}
					?>
					<h3><?= $texto_contagem; ?></h3>
					<div class="dashboard-card next-trip-card">
						<div class="next-trip-img">
							<img src="<?php echo esc_url($image_url); ?>" alt="">

						</div>
						<div class="next-trip-content">

							<h4><?php echo esc_html($nome_excursao); ?></h4>
							<div class="next-trip-date">
								<?php echo esc_html($data_da_proxima); ?>
							</div>
							<div class="next-trip-actions mobile">
								<a href="<?php echo esc_url(wc_get_endpoint_url('minhas-reservas')); ?>" class="dashboard-btn">
									Ver Voucher
								</a>
							</div>
						</div>
						<div class="next-trip-actions desktop">
							<a href="<?php echo esc_url(wc_get_endpoint_url('minhas-reservas')); ?>" class="dashboard-btn">
								Ver Voucher
							</a>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<!-- CUPONS - DASHBOARD -->
			<?php if (!empty($cupons_ativos)) : ?>
				<div class="dashboard-section coupons-section">
					<h3>Seus Cupons de Desconto</h3>
					<?php foreach ($cupons_ativos as $coupon) : ?>
						<div class="dashboard-card coupon-card">
							<div class="coupon-info">
								<div class="coupon-header">
									<span class="coupon-title">CUPOM</span>
									<span class="coupon-code"><?php echo esc_html($coupon->get_code()); ?></span>
								</div>
								<p class="coupon-description"><?php echo esc_html($coupon->get_description()); ?></p>
								<span class="coupon-expiry"><small>Válido até: <?php echo $coupon->get_date_expires()->date('d/m/Y'); ?></small></span>
							</div>
							<div class="coupon-actions">
								<button class="dashboard-btn" onclick="navigator.clipboard.writeText('<?php echo mb_strtoupper($coupon->get_code()); ?>'); alert('Código copiado!');">
									Copiar Código
								</button>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>


			<!-- <div class="dashboard-card">
				<h3>💬 Suporte ao Viajante</h3>
				<p>Precisa de ajuda com sua reserva ou quer entrar no grupo da excursão?</p>
				<a href="#" class="ae-btn-link">Chamar no WhatsApp</a>
			</div> -->

		</div>
	<?php
	} else {
	?>
		<div class="account-empty-placeholder">
			<div class="placeholder-content">
				<div class="placeholder-icon">
					<svg viewBox="0 0 24 24" fill="none" stroke="#400f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="12" r="10"></circle>
						<path d="M16.2 7.8l-2 5.6-5.6 2 2-5.6 5.6-2z"></path>
					</svg>
				</div>
				<!-- <h3>Sua próxima aventura começa aqui!</h3> -->
				<p>No momento, você não possui nenhuma excursão confirmada ou informação importante. Que tal conferir nossas próximas excursões?</p>

				<a href="<?= esc_url(wc_get_page_permalink('shop')) ?>" class="ae-btn-primary">
					Explorar Próximas Excursões
				</a>
			</div>
		</div>
	<?php
	}
	?>
	<div class="account-dashboard-footer" style="margin-top: 30px;">
		<p><small>Não é <strong><?php echo esc_html($current_user->display_name); ?></strong>? <a href="<?php echo esc_url(wc_logout_url()); ?>">Sair da conta</a></small></p>
	</div>
</div>


<script>
	const redirect = window.sessionStorage.getItem('aer_redirect_after_login');
	if (redirect) {
		window.sessionStorage.removeItem('aer_redirect_after_login');
		window.location.href = JSON.parse(redirect).url;
	}
</script>
<?php
do_action('woocommerce_account_dashboard');
do_action('woocommerce_before_my_account');
do_action('woocommerce_after_my_account');
