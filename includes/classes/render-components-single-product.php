<?php
// inc/template-excursoes.php

class Aerotour_Template
{

  /**
   * Renderiza os badges de status (Originalmente no template [cite: 29-49])
   */
  public static function render_status_badges($excursao)
  {
    $statuses = [];
    foreach ($excursao['variacoes'] as $var) {
      $encerrar_vendas = isset($var['encerrar_vendas']) && $var['encerrar_vendas'] === 'yes';
      if ($encerrar_vendas) continue;

      preg_match('/\d+/', strip_tags($var['availability_html']), $matches);
      $vagas = isset($matches[0]) ? (int)$matches[0] : 0;

      if ($vagas > 10) $status = ['label' => "Vagas disponíveis", 'slug' => 'disponivel'];
      elseif ($vagas > 0) $status = ['label' => "Últimas vagas", 'slug' => 'ultimas'];
      else $status = ['label' => "Esgotado", 'slug' => 'esgotado'];

      $status['dia'] = $var['dia'];
      $statuses[] = $status;
    }

    if (empty($statuses)) {
      return "<div class='badge-excursao badge-encerrado'>Reservas encerradas</div>";
    }

    // Lógica de Slider vs Badge Único [cite: 35-41]
    ob_start();
    $slugs = array_unique(array_column($statuses, 'slug'));
    if (count($slugs) === 1) {
      echo "<div class='badge-excursao badge-{$slugs[0]}'>{$statuses[0]['label']}</div>";
    } else {
      echo '<div class="badge-slider-container"><div class="badge-slider-track">';
      foreach ($statuses as $s) {
        $dia_curto = substr($s['dia'], 0, -5);
        echo "<div class='badge-excursao badge-item multi-badges badge-{$s['slug']}'><span>$dia_curto</span>{$s['label']}</div>";
      }
      echo '</div></div>';
    }
    return ob_get_clean();
  }

  public static function render_info_grid($excursao)
  {
    $datas = $excursao['datas']; ?>

    <div class="box box1">
      <div class="label"><?= aer_icons('calendar-red', 22, 22) ?>
        <span>Data</span>
      </div>

      <?php if (count($datas) > 2) : ?>
        <div class="pre-value">Entre</div>
        <div class="value" style="margin-top: -6px"><?= $datas[0] ?></div>
        <div class="pre-value">e</div>
        <div class="value" style="margin-top: -6px"><?= $datas[count($datas) - 1] ?></div>

        <?php elseif (count($datas) <= 2) :
        foreach ($datas as $data) : ?>
          <div class="value"><?= $data === '31/12/2026' ? 'A definir...' : $data ?></div>
      <?php endforeach;
      endif; ?>
    </div>

    <div class="box box2">
      <div class="label"><?= aer_icons('pin-red', 22, 22) ?>
        <span>Local</span>
      </div>
      <?php

      $local_array = preg_split('/\s*\/\s*/', $excursao['local']);
      ?>
      <div class="value"><?= $local_array[0] ?? '' ?></div>
      <div class="post-value"><?= $local_array[1] ?? '' ?></div>
    </div>

    <div class="box box3">
      <div class="label"><?= aer_icons('clock-red', 15, 15) ?>
        <span>Chegada prevista</span>
      </div>
      <div class="value"><?= $excursao['chegada'] ?></div>
    </div>

    <div class="box box4">
      <div class="label"><?= aer_icons('ticket-red', 15, 15) ?>
        <span>Ingressos</span>
      </div>
      <div class="value">
        <a class="ingressos-link"
          aria-label="Link para venda de ingressos"
          href="<?= $excursao['ingressos']['url'] ?>"
          target="_blank">
          <?= $excursao['ingressos']['label'] ?>
        </a>
      </div>
    </div>

  <?php
  }

  public static function render_info_tabs($excursao)
  {
    $product_id = $excursao['id'];
    $is_rir = has_term('rock-in-rio', 'product_cat', $product_id);
  ?>

    <section id="informacoes-excursao">
      <h2>Informações sobre a excursão</h2>
      <div class="tab-container">
        <div class="tab-nav">
          <button class="tab-btn active" data-tab="tab1" onclick="window.dataLayer = window.dataLayer || [];
           window.dataLayer.push({
               'event': 'interacao_tabs',
               'tab_name': 'tab_como_funciona',
               'tab_title': 'Como funciona'
           });">Como funciona</button>

          <button class="tab-btn" data-tab="tab2" onclick="window.dataLayer = window.dataLayer || [];
           window.dataLayer.push({
               'event': 'interacao_tabs',
               'tab_name': 'tab_embarques',
               'tab_title': 'Locais de embarque'
           });">Locais de embarque</button>

          <button class="tab-btn" data-tab="tab3" onclick="window.dataLayer = window.dataLayer || [];
           window.dataLayer.push({
               'event': 'interacao_tabs',
               'tab_name': 'tab_principais_duvidas',
               'tab_title': 'Principais dúvidas'
           });">Principais dúvidas</button>
        </div>

        <?php
        // TAB COMO FUNCIONA content 
        $como_funciona_set_name = get_post_meta($product_id, 'como_funciona_set', true);
        get_template_part('woocommerce/single-product/tab', 'como-funciona', ['set_escolhido' => $como_funciona_set_name]);

        // TAB EMBARQUES content 
        $tab_embarque_slug = $is_rir ? 'embarques-rir' : 'embarques';
        get_template_part(
          'woocommerce/single-product/tab',
          $tab_embarque_slug,
          ['exc_embarques' => $excursao['embarques']]
        );
        ?>

        <?php
        $grupo_escolhido_id = get_post_meta($product_id, 'grupo_faq', true);
        get_template_part('woocommerce/single-product/tab', 'duvidas', ['grupo_escolhido' => $grupo_escolhido_id]); ?>
      </div>
    </section>

    <?php
  }
  public static function render_related_excursions()
  {
    global $product;

    // Se não houver produto no contexto global, encerra
    if (! $product) {
      return;
    }

    $cross_sells_ids = $product->get_cross_sell_ids();

    // Se não houver IDs de venda cruzada configurados, encerra
    if (empty($cross_sells_ids)) {
      return;
    }

    $hoje = date('Ymd');

    $args = [
      'post_type'      => 'product',
      'post_status'    => 'publish',
      'post__in'       => $cross_sells_ids,
      'posts_per_page' => 4,
      'meta_key'       => 'data_limite_excursao',
      'orderby'        => 'meta_value_num',
      'order'          => 'ASC',
      'no_found_rows'  => true, // Melhora a performance ao não calcular paginação
      'meta_query'     => [
        [
          'key'     => 'data_limite_excursao',
          'value'   => $hoje,
          'compare' => '>=',
          'type'    => 'NUMERIC'
        ]
      ]
    ];

    $related_query = new WP_Query($args);

    if ($related_query->have_posts()) : ?>
      <section id="excursoes-relacionadas" class="mt-5 py-md-3">
        <?php
        // Converte os IDs dos posts encontrados de volta para objetos WC_Product
        $display_list = array_map(
          'wc_get_product',
          $related_query->posts
        );

        // Chama o componente de slider da Aerotour
        if (function_exists('aer_cards_slider')) {
          aer_cards_slider($display_list, 'Veja também', 'light');
        }
        ?>
      </section>
    <?php
    endif;

    wp_reset_postdata();
  }

  public static function render_partner_banners($excursao)
  {
    $product_id = $excursao['id'];
    $theme_uri = get_stylesheet_directory_uri();

    // Verifica se é Rock in Rio e se possui a referência do ArteCult na URL
    $is_rir = has_term('rock-in-rio', 'product_cat', $product_id);
    $is_ref_artecult = isset($_GET['ref']) && $_GET['ref'] === 'artecult';

    if ($is_rir && $is_ref_artecult) : ?>
      <div id="topAdBanner">
        <img src="<?= $theme_uri ?>/assets/banners/BannerAerotourArteCult-2.gif"
          alt="Promoção Aerotour + ArteCult + Bandas Novas"
          data-bs-toggle="modal"
          data-bs-target="#modal-promo-rir"
          style="cursor: pointer;">
      </div>

    <?php
    // Caso específico para a excursão dos Jonas Brothers (ID 6495)
    elseif ($product_id == 6495) : ?>
      <div id="topAdBanner">
        <img src="<?= $theme_uri ?>/assets/banners/banner_jb.gif"
          alt="Promoção Aerotour + JBSP Fã Clube Jonas Brothets"
          style="cursor: pointer;">
      </div>
    <?php



    endif;
  }

  public static function render_product_modals($excursao)
  {
    ?>
    <!-- MODAL ROCK IN RIO ARTECULT -->
    <div class="modal fade" id="modal-promo-rir" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">

          <div class="modal-header">
            <h5 class="modal-title">Aerotour, ArteCult e Bandas Novas no Rock in Rio 2026!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body artecult-promo">
            <p>Aproveite o cupom exclusivo para seguidores e ganhe até 10% de desconto na sua reserva!*</p>
            <small>*Cupom promocional de 5% + desconto de reserva antecipada até 30 dias antes da viagem.</small>

            <style>

            </style>
            <ul>
              <li>
                <div>Siga as páginas da Aerotour <a href="https://instagram.com/aerotour_excursoes" target="_blank" aria-label="Link para seguir a Aerotour">(@aerotour_excursoes)</a>, ArteCult <a href="https://instagram.com/artecult" target="_blank" aria-label="Link para seguir a ArteCult">(@artecult)</a> e Bandas Novas <a href="https://instagram.com/bandasnovas.oficial" target="_blank" aria-label="Link para seguir a Bandas Novas">(@bandasnovas.oficial)</a> no Instagram</div>
              </li>
              <li>
                <div><a href="https://aerotour.com.br" target="_blank" aria-label="Link para se cadastrar no site da Aerotour">Cadastre-se </a> no site da Aerotour</div>
              </li>
              <li>
                <div>Envie seu <i>@username</i> para o e-mail da Aerotour (contato@aerotour.com.br). Utilize seu e-mail do cadastro aqui no site.</div>
              </li>
              <li>Aguarde nosso retorno com a liberação do cupom e utilize no carrinho.</li>
            </ul>
            <div class="promo-email-cta">
              <a href="mailto:contato@aerotour.com.br?subject=Promoção%20Aerotour,%20ArteCult%20e%20Bandas%20novas%20no%20Rock%20In%20Rio&body=Olá,%0AGostaria%20de%20participar%20da%20promoção.%0AMeu%20@%20no%20Instagram%20é:%20">Já sigo as páginas, quero enviar meu @ para participar! >></a>
            </div>
          </div>
          <button class="close-modal" type="button" data-bs-dismiss="modal">Fechar</button>
        </div>

      </div>
    </div>
  <?php
  }

  public static function render_product_footer()
  {
    // Verifica se a exibição da galeria está ativa nas configurações
    $exibir_galeria = get_option('exibir_galeria_excursao', '1');
  ?>
    <!-- SOCIAL FOOTER -->
    <div id="social-footer" class="d-flex mt-sm-4 mt-5">
      <div class="instagram-feed col-md-6">
        <h2 class="bg-title">Siga a Aerotour</h2>
        <!-- botão com ícone para o instagram -->
        <a href="https://www.instagram.com/aerotour_excursoes/" target="_blank" class="instagram-btn mb-3" aria-label="Link para o Instagram da Aerotour">
          <?= aer_icons('instagram', 20, 20) ?> @aerotour_excursoes </a>
      </div>

      <?php if ($exibir_galeria === '1') : ?>
        <div id="secaoFotos" class="col-md-6">
          <h2 class="bg-title">Fotos das excursões</h2>
          <?php
          // Busca e reindexa o array imediatamente
          $galeria = get_option('galeria_excursao', []);
          if (!empty($galeria)) {
            $galeria = array_values($galeria);
          }

          if (!empty($galeria)) :
          ?>
            <div id="carouselExampleControls" class="carousel slide carousel-fade" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php foreach ($galeria as $index => $item) : ?>
                  <div class="carousel-item <?= ($index === 0) ? 'active' : ''; ?>">
                    <img src="<?= esc_url($item['url']); ?>" class="d-block w-100" alt="<?= esc_attr($item['legenda']); ?>">

                    <?php if (!empty($item['legenda'])) : ?>
                      <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); border-radius: 8px; padding: 5px 15px;">
                        <p class="mb-0"><?= esc_html($item['legenda']); ?></p>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>

              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          <?php else : ?>
            <p class="text-muted">Nenhuma foto disponível na galeria.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
<?php
  }
}
