<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-notices-wrapper">
    <?php wc_print_notices(); ?>
</div>

<div id="carrinho-container" class="empty-cart-modern">
	<h1 class="mb-4">Carrinho de reservas</h1>
    
	<div class="empty-cart-flex mb-5">
		<div class="empty-cart-hero">
			<div class="empty-cart-icon">
				<svg class="empty-cart-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" width="100" height="100" fill="none">
  <!-- Círculo de Fundo Suave -->
  <circle cx="60" cy="60" r="50" fill="#400f0f" opacity="0.08" />

  <!-- Ônibus Principal -->
  <g stroke="#400f0f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <!-- Corpo do Ônibus -->
    <path d="M34 44 C34 35, 40 30, 50 30 H70 C80 30, 86 35, 86 44 V74 C86 78, 82 82, 78 82 H42 C38 82, 34 78, 34 74 Z" />
    
    <!-- Para-brisa -->
    <path d="M40 38 H80 V52 C80 55, 77 58, 74 58 H46 C43 58, 40 55, 40 52 Z" fill="#400f0f" fill-opacity="0.1" />
    
    <!-- Faróis e Grade -->
    <circle cx="44" cy="70" r="2.5" fill="#400f0f" />
    <circle cx="76" cy="70" r="2.5" fill="#400f0f" />
    <line x1="52" y1="68" x2="68" y2="68" />
    <line x1="56" y1="73" x2="64" y2="73" />
    
    <!-- Rodas -->
    <path d="M44 82 V87 C44 89, 46 90, 48 90 H50 C52 90, 54 89, 54 87 V82" fill="#400f0f" />
    <path d="M66 82 V87 C66 89, 68 90, 70 90 H72 C74 90, 76 89, 76 87 V82" fill="#400f0f" />

    <!-- Trajeto / Estrada Pontilhada -->
    <path d="M18 96 C38 96, 42 102, 60 102 C78 102, 82 96, 102 96" stroke-dasharray="4 4" opacity="0.5" />
  </g>

  <!-- Ticket de Evento (Destaque Superior Direito) -->
  <g transform="translate(62, 14) rotate(12)" stroke="#400f0f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <rect x="0" y="0" width="36" height="22" rx="3" fill="#ffffff" />
    <!-- Picotes do Ticket -->
    <path d="M 0 11 A 3 3 0 0 0 0 11" fill="#400f0f" />
    <line x1="10" y1="7" x2="26" y2="7" stroke-dasharray="2 2" />
    <!-- Estrela / Ícone do Show -->
    <polygon points="18,10 19.5,13 23,13.5 20.5,16 21,19.5 18,17.5 15,19.5 15.5,16 13,13.5 16.5,13" fill="#400f0f" stroke="none" />
  </g>
</svg>

			</div>
			<h2 class="empty-cart-title">Seu carrinho de reservas está vazio...</h2>
			<p class="empty-cart-subtitle">Seu carrinho de reservas está vazio no momento. Que tal escolher a sua próxima excursão?</p>
			<a href="<?= esc_url( get_home_url() ); ?>" class="main-btn py-3 px-5">Ver Próximas Excursões</a>
		</div>

		<div class="empty-cart-recomendations">
			<h3 class="recommendations-title">Excursões em destaque</h3>
			<div class="cards-container">
				<?php
				$excursoes_destaque = get_excursoes(['product_cat' => 'destaque']);

				// iterar sobre as excursões em destaque renderizando os cards
				foreach ($excursoes_destaque as $excursao) {
					$exc_id = $excursao->get_id();
					$exc_nome = $excursao->get_name();
					$exc_url = get_permalink($exc_id);
					$exc_img = get_the_post_thumbnail_url($exc_id, 'medium');
					?>

					<div class="alt-exc-card">
						<a href="<?= esc_url( $exc_url ); ?>" class="alt-exc-card">
							<img class="w-100" src="<?= esc_url( $exc_img ); ?>" alt="<?= esc_attr( $exc_nome ); ?>">
							<h4><?= esc_html( $exc_nome ); ?></h4>
						</a>
					</div>
					<?php
				}
				?>

			</div>

		</div>
	</div>

		<!-- 2. Seção de Educação / Blog -->
		<div class="empty-cart-blog">
			<h3>Primeira vez viajando com a gente?</h3>
			<p>Preparamos alguns guias rápidos para tirar todas as suas dúvidas antes de reservar:</p>
			
			<div class="blog-grid">
				<!-- Card 1 -->
				<a href="<?= esc_url( get_home_url( null, '/como-reservar' ) ); ?>" class="blog-card">
					<span class="blog-icon">📝</span>
					<h4>Como fazer sua reserva</h4>
					<p>Veja o passo a passo de como garantir sua vaga em nossas excursões.</p>
				</a>
				
				<!-- Card 2 -->
				<a href="<?= esc_url( get_home_url( null, '/o-que-esta-incluso' ) ); ?>" class="blog-card">
					<span class="blog-icon">🎒</span>
					<h4>O que está incluso?</h4>
					<p>Saiba tudo o que o nosso pacote oferece para o seu conforto.</p>
				</a>
				
				<!-- Card 3 -->
				<a href="<?= esc_url( get_home_url( null, '/formas-de-pagamento' ) ); ?>" class="blog-card">
					<span class="blog-icon">🔒</span>
					<h4>Formas de pagamento</h4>
					<p>Conheça nossas opções seguras para parcelar a sua viagem.</p>
				</a>
			</div>
		</div>

</div>




</div>