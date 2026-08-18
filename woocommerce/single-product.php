<?php
/**
 * Template para página de produto (Excursão)
 * Focado em LCP e Core Web Vitals
 */
get_header();

// A lógica pesada agora vem via helper/controller
$excursao = Single_Product_Helper::get_formatted_excursion_data(get_the_ID());
$is_encerrada = Single_Product_Helper::is_excursion_closed(get_the_ID());
$header_type_class = get_theme_mod('theme_header_type', 'header-fixed');

?>

<section id="content-event" class="<?= $header_type_class; ?> pb-5 aer-bg-light">
  <?php
  if(isset($excursao['img'])) : ?>
  <div class="hero-img">
    <img class="main-image"
      src="<?= $excursao['img'] ?>"
      alt="Excursão <?= $excursao['nome'] ?>"
      fetchpriority="high"
      width="100%" height="100%">
  </div>
  <?php endif; ?>
  

  <div class="container-xxl py-md-5 py-3 excursao-wrapper <?= isset($excursao['img']) ? 'has-image' : ''; ?>">
    <?php wc_print_notices(); ?>

    <?php Single_Product_Template::render_partner_banners($excursao); ?>

    <?php

    // iteraar sobre as variações e obter o meta _embarques_config para cada variação
    // foreach ($excursao['variacoes'] as $variacao) {
    //   $variacao_id = $variacao['variation_id'];
    //   $embarques_config = get_post_meta($variacao_id, '_embarques_config', true);
    //   echo "<br /><br />Variação ID: $variacao_id - Embarques Config: $embarques_config <br>";
    // };

    // print_r($excursao['embarques_por_variacao']);
?>

    <section class="row product-body mt-sm-3 mt-1">
      <div id="info-body" class="col-md-7">



          <?php if ($excursao['id'] == 7484): ?>
            <div class="promo-badge mb-md-3" id="promoBadge">
                <!-- Imagem de fundo e overlay escuro -->
                <div class="promo-bg" id="promoBg"></div>
                <div class="promo-overlay"></div>

                <!-- Efeito de iluminação/flash que dispara nas transições -->
                <div class="promo-flash" id="promoFlash"></div>

                <!-- Conteúdo: Tela 1 -->
                <div class="promo-screen screen-1 active">
                  <span>GANHE ATÉ <strong>10% DE DESCONTO</strong>. VÁLIDO ATÉ DIA 31/08!</span>
                </div>
                
                <!-- Conteúdo: Tela 2 -->
                <div class="promo-screen screen-2">
                  <span>CUPOM: <strong>SOAD+FNM</strong> — ADICIONE NO CARRINHO</span>
                  <!-- <button id="copyPromoBtn" class="copy-btn" aria-label="Copiar cupom">Copiar</button> -->
                </div>
              </div>
          <?php endif; ?>

          <style>
            /* Container principal */
.promo-badge {
  position: relative;
  width: 100%;
  height: 44px; /* Altura fina */
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
  font-size: 14px;
  letter-spacing: 0.5px;
  overflow: hidden;
  z-index: 100;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  user-select: none;
}

/* Imagem de Fundo com ajuste para movimento vertical */
.promo-bg {
  position: absolute;
  top: -20px;
  left: 0;
  width: 100%;
  height: calc(100% + 40px); /* Altura estendida para permitir o movimento */
  background-image: url('https://cadernopop.com.br/wp-content/smush-webp/2026/08/One-Night-Only.jpg.webp');
  background-size: cover;
  background-position: center 0%;
  z-index: 1;
  transition: transform 0.1s linear;
}

/* Overlay escuro com leve desfoque para máxima legibilidade */
.promo-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  /* Gradiente com variações da cor #400f0f em diferentes opacidades e tonalidades */
background: linear-gradient(90deg, rgb(64 15 15 / 66%) 0%, rgb(35 8 8 / 80%) 50%, rgb(64 15 15 / 66%) 100%);
  backdrop-filter: blur(1px);
  z-index: 2;
}

/* Camada do Efeito Flash (Transição Brilhante) */
.promo-flash {
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    90deg, 
    transparent 0%, 
    rgba(255, 255, 255, 0.6) 50%, 
    transparent 100%
  );
  z-index: 4;
  pointer-events: none;
  opacity: 0;
}

/* Animação do Flash atravessando a barra */
.promo-flash.trigger-flash {
  animation: flashSweep 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes flashSweep {
  0% {
    left: -100%;
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
  100% {
    left: 100%;
    opacity: 0;
  }
}

/* Telas de Informação */
.promo-screen {
  position: absolute;
  z-index: 3;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.5s ease;
  opacity: 0;
  transform: translateY(120%) scale(0.95);
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
}

.promo-screen strong {
  color: #ffd700; /* Destaque amarelo ouro */
  font-weight: 700;
}

/* Estado ativo (visível) */
.promo-screen.active {
  opacity: 1;
  transform: translateY(0) scale(1);
}

/* Estado de saída (saindo por cima) */
.promo-screen.exit-up {
  opacity: 0;
  transform: translateY(-120%) scale(0.95);
}

/* Botão de Copiar */
.copy-btn {
  margin-left: 12px;
  background: linear-gradient(135deg, #ff416c, #ff4b2b);
  border: none;
  color: #fff;
  border-radius: 20px;
  padding: 4px 14px;
  font-size: 11px;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(255, 75, 43, 0.4);
  transition: transform 0.2s, box-shadow 0.2s;
}

.copy-btn:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 12px rgba(255, 75, 43, 0.6);
}

/* Responsividade para telas menores */
@media (max-width: 600px) {
  .promo-badge {
    font-size: 11px;
    height: 48px;
  }
  .copy-btn {
    padding: 3px 8px;
    margin-left: 6px;
    font-size: 10px;
  }
}
           
          </style>
          <script>
            document.addEventListener("DOMContentLoaded", () => {
  const badge = document.getElementById("promoBadge");
  const bg = document.getElementById("promoBg");
  const flash = document.getElementById("promoFlash");
  const screen1 = badge.querySelector(".screen-1");
  const screen2 = badge.querySelector(".screen-2");
  const copyBtn = document.getElementById("copyPromoBtn");

  let isScreen1Visible = true;

  // 1. Efeito de Movimento Vertical Sutil no Background
  let posY = 0;
  let direction = 1;

  function animateBackground() {
    // Oscila a posição Y do fundo em um ciclo lento
    posY += 0.08 * direction;
    if (posY >= 100 || posY <= 0) {
      direction *= -1; // Inverte a direção
    }
    bg.style.backgroundPositionY = `${posY}%`;
    requestAnimationFrame(animateBackground);
  }
  animateBackground();

  // 2. Disparo da Transição + Efeito Flash
  setInterval(() => {
    // Ativa a animação do Flash
    flash.classList.add("trigger-flash");
    setTimeout(() => {
      flash.classList.remove("trigger-flash");
    }, 500);

    // Alterna a exibição das telas
    if (isScreen1Visible) {
      screen1.classList.remove("active");
      screen1.classList.add("exit-up");

      screen2.classList.remove("exit-up");
      screen2.classList.add("active");
    } else {
      screen2.classList.remove("active");
      screen2.classList.add("exit-up");

      screen1.classList.remove("exit-up");
      screen1.classList.add("active");
    }
    isScreen1Visible = !isScreen1Visible;
  }, 4500); // Executa a cada 4.5 segundos

  // 3. Funcionalidade de Copiar Cupom
  if (copyBtn) {
    copyBtn.addEventListener("click", () => {
      navigator.clipboard.writeText("SOAD+FNM").then(() => {
        const originalText = copyBtn.innerText;

        copyBtn.innerText = "COPIADO!";
        copyBtn.style.background = "#00b09b"; // Verde
        copyBtn.style.boxShadow = "0 2px 8px rgba(0, 176, 155, 0.5)";

        setTimeout(() => {
          copyBtn.innerText = originalText;
          copyBtn.style.background = "";
          copyBtn.style.boxShadow = "";
        }, 2000);
      });
    });
  }
});
          </script>
  


        <div class="d-flex justify-content-between align-items-start">
          <h1><span>Excursão<br /></span><?= $excursao['nome'] ?></h1>
          <?php if (!$is_encerrada): ?>
          <?php endif; ?>
        </div>

        <div class="status-badges-container">
          <?= Single_Product_Template::render_status_badges($excursao); ?>
        </div>

        <div class="info">
          <section class="grid-container">
            <?php Single_Product_Template::render_info_grid($excursao); ?>
          </section>

          <a href="#reservaBox" class="cta-button">
            <?= aer_icons('bookmark-light', 16, 16, '.webp') ?> Reservar agora
          </a>
        </div>

        <?php Single_Product_Template::render_info_tabs($excursao); ?>
      </div>

      <div id="reservaBox" class="col-md-5 reserva-box">
        <div id="reserva_app">
          <div class="loading-skeleton">Carregando formulário de reserva...</div>
        </div>
      </div>
    </section>

    <!-- BOTÃO WHATSAPP -->
    <?php
    $numero_wpp =  get_option('contato_whatsapp', '');
    $exibir_botao_wpp   = get_option('exibir_botao_whatsapp_excursao', '');
    $texto_custom    = get_option('texto_whatsapp_excursao', 'Olá, gostaria de saber mais sobre a excursão [NOME_EXCURSAO].');

    // Faz a substituição da flag pelo nome real
    $mensagem_final = str_replace('[NOME_EXCURSAO]', $excursao['nome'], $texto_custom);

    if ($numero_wpp && $exibir_botao_wpp) : ?>
      <div id="exc-wpp-cta" class="desktop">
        <a href="https://api.whatsapp.com/send?phone=<?= $numero_wpp ?>&text=<?= $mensagem_final ?>" aria-label="Botão para chamar no WhatsApp">
          <div role="button" class="mt-5">
            <div class="wpp-icon">
              <?= aer_icons('whatsapp', 30, 30) ?>
            </div>
            <div class="wpp-text">
              <p>Dúvidas?</p>
              <span>Fale conosco no WhatsApp!</span>
            </div>
          </div>
        </a>
      </div>
    <?php endif; ?>
    <!-- FIM BOTÃO WHATSAPP -->

    <?php Single_Product_Template::render_related_excursions(); ?>
    
    <?php Single_Product_Template::render_product_footer(); ?>
  </div>
</section>
<?php Single_Product_Template::render_product_modals($excursao); ?>

<?php get_footer(); ?>