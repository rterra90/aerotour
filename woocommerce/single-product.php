<?php

/**
 * Template para página de produto (Excursão)
 * Focado em LCP e Core Web Vitals
 */
get_header();

// A lógica pesada agora vem via helper/controller
$excursao = Aerotour_Helper::get_formatted_excursion_data(get_the_ID());
$is_encerrada = Aerotour_Helper::is_excursion_closed($product->get_id());
?>

<section id="content-event" class="pb-5 aer-bg-light">
  <div class="hero-img">
    <img class="main-image"
      src="<?= $excursao['img'] ?>"
      alt="Excursão <?= $excursao['nome'] ?>"
      fetchpriority="high"
      width="100%" height="100%">
  </div>

  <div class="container-xxl py-md-5 py-3 excursao-wrapper">
    <?php wc_print_notices(); ?>

    <?php Aerotour_Template::render_partner_banners($excursao); ?>

    <section class="row product-body mt-3">
      <div id="info-body" class="col-md-7">
        <div class="d-flex justify-content-between align-items-start">
          <h1><span>Excursão<br /></span><?= $excursao['nome'] ?></h1>
          <?php if (!$is_encerrada): ?>
          <?php endif; ?>
        </div>

        <div class="status-badges-container">
          <?= Aerotour_Template::render_status_badges($excursao); ?>
        </div>

        <div class="info">
          <section class="grid-container">
            <?php Aerotour_Template::render_info_grid($excursao); ?>
          </section>

          <a href="#reservaBox" class="cta-button">
            <?= aer_icons('bookmark-light', 16, 16, '.webp') ?> Reservar agora
          </a>
        </div>

        <?php Aerotour_Template::render_info_tabs($excursao); ?>
      </div>

      <div id="reservaBox" class="col-md-5 reserva-box">
        <div id="reserva_app">
          <div class="loading-skeleton">Carregando formulário de reserva...</div>
        </div>
      </div>
    </section>

    <!-- BOTÃO WHATSAPP -->
    <div id="exc-wpp-cta" class="desktop">
      <a href="https://api.whatsapp.com/send?phone=5519997477465&text=Olá. Estive no site da Aerotour e gostaria de saber mais sobre a excursão <?= $excursao['nome'] ?>" aria-label="Botão para chamar no WhatsApp">
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
    <!-- FIM BOTÃO WHATSAPP -->

    <?php Aerotour_Template::render_related_excursions(); ?>
    <?php Aerotour_Template::render_product_footer(); ?>
  </div>
</section>
<?php Aerotour_Template::render_product_modals($excursao); ?>

<?php get_footer(); ?>