<?php
function aer_cards_slider(
  $excursoes_src,
  $section_title,
  $color_scheme = 'dark'
) {
  // 1. Validação de segurança: se não houver excursões, encerra a função
  if (empty($excursoes_src)) {
    return;
  }

  $slider_ref = sanitize_title($section_title); // slugify nativo do WP
  $count = count($excursoes_src);
?>

  <section id="<?= esc_attr(
                  $slider_ref
                ) ?>" class="<?= $color_scheme === 'light' ? '' : 'container-md' ?> aer-cards-slider status-<?= esc_attr(
                                                                                                              $color_scheme
                                                                                                            ) ?>">
    <div class="d-flex justify-content-between align-items-center px-md-0 px-2">
      <h2 class="<?= strtolower($section_title) === 'veja também'
                    ? 'bg-title'
                    : '' ?>">
        <?= esc_html($section_title) ?>
      </h2>
      <a href="<?= esc_url(
                  wc_get_page_permalink('shop')
                ) ?>" class="ver-todas-link">Ver todas</a>
    </div>

    <div class="slider-frame" data-slider-ref="<?= esc_attr(
                                                  $slider_ref
                                                ) ?>">

      <?php if (
        $count > 1
      ): // Só exibe controles se houver mais de um item
      ?>
        <div class="controls-wrapper">
          <span data-action="previous" class="disabled" onclick="handleSlider('<?= $slider_ref ?>', 'previous')">
            < </span>
              <span data-action="next" onclick="handleSlider('<?= $slider_ref ?>', 'next')"> > </span>
        </div>
      <?php endif; ?>

      <div class="slider-wrapper">
        <div class="slider"
          data-page="1"
          data-scroll="0"
          data-total-items="<?= $count ?>">

          <?php foreach ($excursoes_src as $index => $excursao) {
            // Garante que a variável esperada pelo display-card esteja correta
            // Se o item vier da WP_Query, ele pode ser um ID ou objeto WP_Post
            if (is_numeric($excursao)) {
              $excursao = wc_get_product($excursao);
            }

            $card_index = $index;

            ?>
            <div class="col-lg-3 col-md-4 col-sm-5 col-9 display-flex-child">
            <?php
            // Localiza o template de forma mais eficiente
            $template = locate_template(
              'includes/display/display-card.php'
            );
            if ($template) {
              include $template;
            }

            ?>
            </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </section>
<?php
}
?>