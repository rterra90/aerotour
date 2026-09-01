<?php
$header_type_class = get_theme_mod('theme_header_type', 'header-fixed'); ?>
<?php
$destaques_hero = aer_proximas_excursoes($excursoes, 'destaque');
if (count($destaques_hero) > 0): ?>
<div id="main-banner" class="d-flex justify-content-center mb-3 <?= $header_type_class ?>">
  
  <div id="hero" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <?php
      $i_button = 0;
      foreach (aer_proximas_excursoes($excursoes, 'destaque') as $excursao) {
        // wp_die(print_r($excursao, true));
          if (get_post_meta($excursao->get_id())['destaque'][0] === 'yes') { ?>
          <button type="button" data-bs-target="#hero" data-bs-slide-to="<?= $i_button ?>" class="
          <?= $i_button === 0 ? 'active' : '' ?>" aria-current="
              <?= $i_button === 0 ? 'true' : '' ?>" aria-label="
                  <?= $excursao->get_name() ?>"></button>
      <?php $i_button++;}
      }
      ?>
    </div>

    <div class="carousel-inner h-100">
      <?php
      $i_main = 0;
      foreach (
          aer_proximas_excursoes($excursoes, 'destaque')
          as $_i => $excursao
      ) {
          $datas_array = $excursao->attributes['dia']['options'];
          $img = wp_get_attachment_image_src(
              get_post_thumbnail_id($excursao->get_id()),
              'single-post-thumbnail',
          );
          $background_img = wp_get_attachment_image_src(
              get_post_meta($excursao->get_id(), 'dest_img_1_id', true),
              'single-post-thumbnail',
          )[0];
          $focus_img = wp_get_attachment_image_src(
              get_post_meta($excursao->get_id(), 'dest_img_2_id', true),
              'large',
          )[0];
          if (get_post_meta($excursao->get_id(), 'destaque', true) === 'yes') {

              // Percorre as variações para obter datas e disponibilidade
              $exc_variacoes = $excursao->get_available_variations();
              $dias_lugares = [];
              foreach ($exc_variacoes as $key => $variation) {
                  $var_obj = wc_get_product($variation['variation_id']);
                  $data_label = $variation['attributes']['attribute_dia']; // Verifica se a venda foi encerrada manualmente via meta
                  $meta_encerrar = get_post_meta(
                      $variation['variation_id'],
                      'encerrar_vendas',
                      true,
                  );
                  if ($meta_encerrar === 'yes' || !$var_obj->is_purchasable()) {
                      $dias_lugares[$data_label] = 'encerrada';
                  } else {
                      // Pega o número real de estoque definido na variação
                      $estoque = $var_obj->get_stock_quantity();
                      $dias_lugares[$data_label] =
                          $estoque > 0 ? $estoque . ' vagas' : 'esgotado';
                  }
              }
              ?>
          <div
            class="carousel-item<?= $i_main === 0
                ? ' featured-bg active'
                : '' ?>" <?php if ($i_main > 0): ?>
            style="background-image: url('<?= esc_url($background_img) ?>')"
            <?php endif; ?>>

            <div class="carousel-item-flex d-flex hero-container">
              <div class="carousel-info">
                <span data-animate class="pre-title hero-colored-bg" style="animation-delay:.5s">Excursão</span>
                <h3 data-animate style="animation-delay:.8s" class="mb-4 mb-sm-2"><a href="<?= get_permalink(
                    $excursao->get_id(),
                ) ?>"><?= $excursao->get_name() ?></a></h3>

                <div class="d-flex">
                  <div class="carousel-img mobile">
                    <?php if ($i_main == 0) { ?>
                      <img data-animate style="animation-delay:1.5s" src="<?= $focus_img ?>" alt="<?= $excursao->get_name() ?>">
                    <?php } else { ?>
                      <img loading="lazy" data-animate style="animation-delay:1.5s" src="<?= $focus_img ?>" alt="<?= $excursao->get_name() ?>">
                    <?php } ?>
                  </div>
                  <div>
                    <div class="data-local" data-animate style="animation-delay:1s">
                      <div class="hero-date-wrapper hero-colored-bg">
                        <?= aer_icons('calendar', 18, 18) ?>
                        <span>
                          <?php
                          $datas_array = array_values($excursao->attributes['dia']['options'] ?? []);
                          $total = count($datas_array);

                          if ($total === 1) {
                              echo substr($datas_array[0], 0, 5);
                          } elseif ($total === 2) {
                              echo substr($datas_array[0], 0, 5) . ' e ' . substr($datas_array[1], 0, 5);
                          } elseif ($total > 2) {
                              $primeira = substr($datas_array[0], 0, 5);
                              $ultima = substr(end($datas_array), 0, 5);
                              echo 'Entre ' . $primeira . ' e ' . $ultima;
                          }
                          ?>
                        </span>
                      </div>

                      <div class="hero-local-wrapper hero-colored-bg">
                        <?= aer_icons('pin', 18, 18) ?>
                        <span>
                        <?= get_post_meta(
                            $excursao->get_id(),
                            'local_evento',
                            true,
                        ) ?></span></div>

                    </div>
                  </div>
                </div>

                <div class="hero-buttons" data-animate style="animation-delay:1.5s">
                  <a class="main-btn" data-btn-reactive aria-label="Informações e reservas" href="<?= get_permalink(
                      $excursao->get_id(),
                  ) ?>"><span>Informações e reservas</span> <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M5 12H19M13 6L19 12L13 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </div>
              </div>
              <div class="carousel-img desktop">
                <a href="<?= get_permalink($excursao->get_id()) ?>">
                  <?php if ($i_main == 0) { ?>
                    <img data-animate style="animation-delay:1.5s" src="<?= $focus_img ?>" alt="<?= $excursao->get_name() ?>">
                  <?php } else { ?>
                    <img loading="lazy" data-animate style="animation-delay:1.5s" src="<?= $focus_img ?>" alt="<?= $excursao->get_name() ?>">
                  <?php } ?>

                </a>
              </div>
            </div>
          </div>
      <?php $i_main++;
          }
      }
      ?>
    </div>
  </div>
</div>
<?php endif;
 ?>
