<?php
function aer_cards_slider($excursoes_src, $section_title, $color_scheme = 'dark'){
  $slider_ref = slugify($section_title);
  ?>
  <section id="<?= $slider_ref; ?>"class="container-md aer-cards-slider">
    <div class="d-flex justify-content-between align-items-center px-md-0 px-2">
      <h2 class="<?= strtolower($section_title) === 'veja também' ? 'bg-title' : '' ?>"><?= $section_title; ?></h2>
      <a href="<?= wc_get_page_permalink( 'shop' ); ?>" class="ver-todas-link">Ver todas</a>
    </div>
    
    <div class="slider-frame" data-slider-ref="<?= $slider_ref; ?>">
      <div class="controls-wrapper">
        <span data-action="previous" class="disabled" onclick="handleSlider('<?= $slider_ref; ?>', 'previous', 4)"> < </span>
        <span data-action="next" onclick="handleSlider('<?= $slider_ref; ?>', 'next', 4)"> > </span>
      </div>

      <div class="slider-wrapper">
        <div class="slider" data-page=1 data-scroll=0>
          <?php
            foreach($excursoes_src as $index => $excursao){
              $is_slider = true;
              include 'display/display-card.php';
            }
          ?>
        </div>
      </div>
    </div>
  </section>
  <?php
}
?>
