<?php
get_header();

$user = wp_get_current_user();
$user_meta = get_user_meta($user->ID);
$user->metafields = $user_meta;
global $wpdb;
global $product;

function excursao_formatada($id)
{
  global $wpdb;
  $_excursao = wc_get_product($id);
  $_excursao_img = wp_get_attachment_image_src(
    $_excursao->get_image_id(),
    'full'
  );
  $locais_embarque = json_decode(get_post_meta($id, 'embarques', true), true);
  $exc_embarques = json_decode(get_post_meta($id, 'exc_embarques', true), true);

  if ($locais_embarque !== null) {
    $ids_embarques = array_map(function ($_emb) {
      return $_emb['embarqueId'];
    }, $locais_embarque);
    $_ids_str = implode(',', $ids_embarques);
  }

  $embarques_db = isset($_ids_str)
    ? $wpdb->get_results("SELECT * from aer_embarques WHERE id IN ($_ids_str)")
    : [];

  if (isset($locais_embarque)) {
    foreach ($locais_embarque as $_index => $_emb_exc) {
      foreach ($embarques_db as $_emb_db) {
        if ((int) $_emb_db->id === (int) $_emb_exc['embarqueId']) {
          $locais_embarque[$_index]['nome'] = $_emb_db->nome;
          $locais_embarque[$_index]['endereco'] = $_emb_db->endereco;
          $locais_embarque[$_index]['obs'] = $_emb_db->obs;
          $locais_embarque[$_index]['link_mapa'] = $_emb_db->link_mapa;
        }
      }
    }
  }

  return [
    'id' => $id,
    'nome' => $_excursao->get_name(),
    'price' => $_excursao->get_price(),
    'on_sale' => $_excursao->is_on_sale(),
    'regular_price' => $_excursao->get_regular_price(),
    'descricao' => $_excursao->get_description(),
    'img' => $_excursao_img ? $_excursao_img[0] : null,
    'variacoes' => $_excursao->get_available_variations(),
    'atributos' => $_excursao->get_attributes(),
    'embarques' => $locais_embarque ? $locais_embarque : null,
    'exc_embarques' => json_encode($exc_embarques, JSON_UNESCAPED_UNICODE)
    // 'data_final' => $data_final,
    // 'disp_vagas' => disp_vagas($_excursao),
  ];
}

$excursao = excursao_formatada(get_the_ID());

// Define se exibe número de lugares vendidos
$show_vendidos = get_post_meta($excursao['id'], 'show_vendidos', true);

//Define a propriedade 'encerrar_vendas' em cada variação
foreach ($excursao['variacoes'] as $i => $var) {
  $excursao['variacoes'][$i]['encerrar_vendas'] =
    get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes'
    ? true
    : false;
}

//Define e ordena a array de datas
$datas = array_map(function ($_var) {
  return $_var['attributes']['attribute_dia'];
}, $excursao['variacoes']);
usort($datas, function ($a, $b) {
  $dataA = DateTime::createFromFormat('d/m/Y', $a);
  $dataB = DateTime::createFromFormat('d/m/Y', $b);
  return $dataA <=> $dataB;
});


// JSON-LD
$date_obj = DateTime::createFromFormat('d/m/Y', $datas[0]);
$start_date = $date_obj->format('Y-m-d');
$ultima_data = get_post_meta($product->get_id(), 'data_limite_excursao', true);
$is_encerrada = date('Ymd') > $ultima_data;
if ($product) {
  $jsonLd = [
    '@context' => 'https://schema.org/',
    '@type' => ['Product', 'Event'],
    'name' => 'Excursão ' . $product->get_name(),
    'image' => wp_get_attachment_url($product->get_image_id()),
    'description' => wp_strip_all_tags($product->get_short_description()),
    'startDate' => $start_date,
    'eventStatus' => $is_encerrada
      ? 'https://schema.org/EventMovedOnline'
      : 'https://schema.org/EventScheduled',
    'brand' => [
      '@type' => 'Brand',
      'name' => 'Aerotour Excursões'
    ],
    'offers' => [
      '@type' => 'Offer',
      'priceCurrency' => 'BRL',
      'price' => $product->get_price() . '.00',
      'availability' => $is_encerrada
        ? 'https://schema.org/Discontinued'
        : 'https://schema.org/InStock',
      'url' => get_permalink($product->get_id()),
      'seller' => [
        '@type' => 'Organization',
        'name' => 'Aerotour Excursões',
        'url' => 'https://www.aerotour.com.br/'
      ]
    ]
  ];
}
echo '<script type="application/ld+json">' .
  json_encode(
    $jsonLd,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
  ) .
  '</script>';
// FIM JSON-LD
?>

<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/css/woocommerce/single-product.min.css?ver=<?= time() ?>">
<section id="content-event" class="pb-5 aer-bg-light">

  <div class="hero-img">
    <img class="main-image" src="<?= $excursao['img'] ?>" alt="Imagem representativa da excursão <?= $excursao['nome'] ?> da Aerotour" width="100%" height="100%">
  </div>

  <!-- quando houver banner: py-md-3 -->
  <!-- quando NÃO houver banner: py-md-5 -->
  <!-- <div class="container-xxl py-md-3 py-3 excursao-wrapper">  -->
  <div class="container-xxl py-md-5 py-3 excursao-wrapper">
    <div class="notices">
      <?php wc_print_notices(); ?>
    </div>

    <!-- BANNER ARTECULT -->
    <!-- <div id="topAdBanner">
        <small>PARCEIRO</small>
        <?php
        // Insere o banner ArteCult
        // get_template_part('assets/banners/banner-artecult', null);

        // Insere o modal
        // get_template_part('includes/modals/modal', null);
        ?>
       </div> -->


    <!-- quando houver banner: mt-md-3 -->
    <section class="row product-body mt-3">

      <!-- INFORMAÇÕES -->
      <div id="info-body" class="col-md-7 col">

        <div class="woocommerce-notices-wrapper">

        </div>



        <div class="d-flex justify-content-between gap-2">
          <h1><span>Excursão<br /></span><?= $excursao['nome'] ?></h1>

          <!-- SOCIAL SHARE -->
          <?php
          if ($is_encerrada) {
          ?>
            <span></span>
          <?php
          } else {
          ?>
            <div class="share">
              <span>Compartilhe</span>
              <div class="share-icons d-flex gap-2">
                <a href="https://api.whatsapp.com/send?text=<?php echo get_permalink(); ?>" aria-label="Botão compartilhar pelo WhatsApp"><?= aer_icons(
                                                                                                                                            'whatsapp',
                                                                                                                                            18,
                                                                                                                                            18
                                                                                                                                          ) ?></a>
                <a href="https://www.instagram.com/aerotour_excursoes/" aria-label="Botão compartilhar pelo Instagram"><?= aer_icons(
                                                                                                                          'instagram',
                                                                                                                          18,
                                                                                                                          18
                                                                                                                        ) ?>
                </a>
                <a href="https://www.facebook.com/aerotourcampinas/" aria-label="Botão compartilhar pelo Facebook">
                  <?= aer_icons('facebook', 18, 18) ?>
                </a>
              </div>
            </div>
          <?php
          }

          ?>

          <!-- FIM SOCIAL SHARE -->

        </div>


        <!-- CONTADOR DE RESERVAS -->
        <div class="status-badges-container">
          <!-- Aviso de últimas vagas -->
          <!-- se houver apenas uma variação e ela tiver menos de 10 vagas disponíveis -->
          <?php
          $variacoes_disp = array_filter($excursao['variacoes'], function ($_var) {
            return get_post_meta($_var['variation_id'], 'encerrar_vendas', true) !==
              'yes';
          });

          if (count($variacoes_disp) == 1) {
            $vaga_var = $variacoes_disp[0];
            $disponibilidade_html = $vaga_var['availability_html'];
            preg_match('/\d+/', strip_tags($disponibilidade_html), $matches);
            $vagas_disponiveis = isset($matches[0]) ? (int) $matches[0] : 0;

            if ($vagas_disponiveis > 0 && $vagas_disponiveis <= 10) { ?>
              <div class="aviso-ultimas-vagas <?= $show_vendidos === 'yes'
                                                ? 'left'
                                                : '' ?>">
                <strong class="d-block">Últimos lugares!</strong> Apenas <?= $vagas_disponiveis ?> vagas disponíveis!
              </div>
            <?php } elseif (!$vagas_disponiveis) { ?>
              <div class="aviso-ultimas-vagas aviso-esgotado">
                <strong class="d-block">Esgotado!</strong> Não temos mais lugares disponíveis...
              </div>
          <?php }
          }
          ?>
          <!-- Contador de reservas realizadas -->
          <?php if ($show_vendidos === 'yes') { ?>

            <!-- get na tabela reservas para contar quantas reservas existem para o produto atual -->
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'reservas';

            // se uma excursão tiver múltiplas datas, somar as reservas de todas as variações
            $variacao_ids = array_map(function ($_var) {
              return $_var['variation_id'];
            }, $excursao['variacoes']);
            $_ids_str = implode(',', $variacao_ids);
            $reservas_count = $wpdb->get_var(
              $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE status != 'cancel' AND variation_id IN ($_ids_str)"
              )
            );

            // obter o valor numérico no meta "vendidos_inc" e somar ao contador
            $incremento = get_post_meta(
              $excursao['id'],
              'vendidos_inc',
              true
            );
            if (is_numeric($incremento)) {
              $reservas_count += (int) $incremento;
            }
            ?>
            <div class="reservas-contador">
              <p><strong><?= aer_icons(
                            'banco',
                            16,
                            16,
                            '.webp'
                          ) ?></strong><?= $reservas_count ?> lugares reservados!</p>
            </div>

          <?php } ?>

        </div>


        <!-- FIM CONTADOR DE RESERVAS -->


        <!-- info inner -->
        <div class="info">
          <!-- grid container -->
          <section class="grid-container">
            <!-- Box Datas -->
            <div class="box box1">
              <div class="label"><?= aer_icons('calendar-red', 22, 22) ?>
                <span>Data</span>
              </div>

              <?php if (count($datas) > 2) { ?>
                <div class="pre-value">Entre</div>
                <div class="value" style="margin-top: -6px"><?= $datas[0] ?></div>
                <div class="pre-value">e</div>
                <div class="value" style="margin-top: -6px"><?= $datas[count($datas) - 1] ?></div>

                <?php } elseif (count($datas) <= 2) {
                foreach ($datas as $data) { ?>
                  <div class="value"><?= $data === '31/12/2026'
                                        ? 'A definir...'
                                        : $data ?></div>
              <?php }
              } ?>

            </div>

            <!-- Box Local -->
            <div class="box box2">
              <div class="label"><?= aer_icons('pin-red', 22, 22) ?>
                <span>Local</span>
              </div>
              <?php
              $local = get_post_meta($excursao['id'], 'local_evento', true);
              $local_array = preg_split('/\s*\/\s*/', $local);
              ?>
              <div class="value"><?= $local_array[0] ?></div>
              <div class="post-value"><?= $local_array[1] ?></div>
            </div>

            <!-- Box Previsão chegada -->
            <div class="box box3">
              <div class="label"><?= aer_icons('clock-red', 15, 15) ?>
                <span>Chegada prevista</span>
              </div>
              <div class="value"><?= get_post_meta(
                                    get_the_ID(),
                                    'previsao_chegada',
                                    true
                                  ) ?></div>
            </div>

            <!-- Box Ingressos -->
            <div class="box box4">
              <div class="label"><?= aer_icons('ticket-red', 15, 15) ?>
                <span>Ingressos</span>
              </div>
              <div class="value"><a class="ingressos-link" aria-label="Link para venda de ingressos" href="<?= get_post_meta(
                                                                                                              get_the_ID(),
                                                                                                              'ingressos_link',
                                                                                                              true
                                                                                                            ) ?>" target="_blank"><?= get_post_meta(
                                                                                                                                    get_the_ID(),
                                                                                                                                    'ingressos_label',
                                                                                                                                    true
                                                                                                                                  ) ?></a></div>
            </div>
          </section>

          <!-- cta button -->
          <a href="#reservaBox"
            class="cta-button"
            aria-label="Reservar lugar na excursão <?= $excursao['nome'] ?>"
            onclick="gtag('event', 'clique_reservar_cta', {
                  'event_category': 'ads',
                  'event_label': 'clique_reservar_cta',
                  'value': 1
                })">
            <?= aer_icons('bookmark-light', 16, 16, '.webp') ?> Reservar agora
          </a>

          <!-- INFORMAÇÕES SOBRE A EXCURSÃO EM TABS -->
          <section id="informacoes-excursao">
            <h2>Informações sobre a excursão</h2>
            <div class="tab-container">
              <!-- TAB BUTTONS -->
              <div class="tab-nav">
                <button class="tab-btn active" data-tab="tab1" onclick="gtag('event', 'tab_como_funciona', {
                  'event_category': 'ads',
                  'event_label': 'tab_como_funciona',
                  'value': 1
                })">Como funciona</button>
                <button class="tab-btn" data-tab="tab2" onclick="gtag('event', 'tab_locais_embarque', {
                  'event_category': 'ads',
                  'event_label': 'tab_locais_embarque',
                  'value': 1
                })">Locais de embarque</button>
                <button class="tab-btn" data-tab="tab3" onclick="gtag('event', 'tab_principais_duvidas', {
                  'event_category': 'ads',
                  'event_label': 'tab_principais_duvidas',
                  'value': 1
                })">Principais dúvidas</button>
              </div>

              <!-- TAB CONTENT COMO FUNCIONA -->
              <?php
              if (has_term('rock-in-rio', 'product_cat')) get_template_part('woocommerce/single-product/tab', 'como-funciona-rir');
              else get_template_part('woocommerce/single-product/tab', 'como-funciona');
              ?>

              <!-- TAB CONTENT EMBARQUES -->
              <?php if (has_term('rock-in-rio', 'product_cat')) get_template_part('woocommerce/single-product/tab', 'embarques-rir', ['exc_embarques' => $excursao['embarques']]);
              else get_template_part('woocommerce/single-product/tab', 'embarques', ['exc_embarques' => $excursao['embarques']])
              ?>

              <!-- TAB CONTENT PRINCIPAIS DÚVIDAS -->
              <?php get_template_part('woocommerce/single-product/tab', 'duvidas'); ?>
            </div>
          </section>


        </div>

      </div>
      <!-- FIM INFORMAÇÕES -->


      <div id="reservaBox" class="col-md-5 col center-element reserva-box">

        <!-- RESERVA APP - REACT  -->
        <div id="reserva_app" data-cart-url='<?= wc_get_cart_url() ?>'
          data-ajax-url='<?php echo admin_url('admin-ajax.php'); ?>'
          data-variacoes='<?= json_encode($excursao['variacoes'], JSON_UNESCAPED_UNICODE) ?>'
          data-embarques='<?= json_encode($excursao['embarques'], JSON_UNESCAPED_UNICODE) ?>'
          data-product-id='<?= $excursao['id'] ?>'
          data-estado-destino='<?= has_term('rock-in-rio', 'product_cat') ? 'rj' : 'sp'; ?>'>
        </div>
        <!-- FIM RESERVA APP - REACT  -->

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

    <!-- EXCURSÕES RELACIONADAS -->
    <section id="excursoes-relacionadas" class="mt-5 py-md-3">
      <?php
      global $product;

      if ($product) {
        $cross_sells_ids = $product->get_cross_sell_ids();

        if (!empty($cross_sells_ids)) {
          $hoje = date('Ymd');

          $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'post__in' => $cross_sells_ids, // Filtra pelos IDs de cross-sell
            'posts_per_page' => 4,
            'meta_key' => 'data_limite_excursao',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'no_found_rows' => true, // Ganho de performance: não calcula paginação
            'meta_query' => [
              [
                'key' => 'data_limite_excursao',
                'value' => $hoje,
                'compare' => '>=',
                'type' => 'NUMERIC'
              ]
            ]
          ];

          $related_query = new WP_Query($args);

          if ($related_query->have_posts()) {
            // Convertemos os IDs encontrados de volta para objetos WC para o aer_cards_slider
            $display_list = array_map(
              'wc_get_product',
              $related_query->posts
            );

            aer_cards_slider($display_list, 'Veja também', 'light');
          }
          wp_reset_postdata();
        }
      }
      ?>
    </section>

    <!-- SOCIAL FOOTER -->
    <div id="social-footer" class="d-flex mt-sm-4 mt-5">
      <div class="instagram-feed col-md-6">
        <h2 class="bg-title">Siga a Aerotour</h2>
        <!-- botão com ícone para o instagram -->
        <a href="https://www.instagram.com/aerotour_excursoes/" target="_blank" class="instagram-btn mb-3" aria-label="Link para o Instagram da Aerotour">
          <?= aer_icons('instagram', 20, 20) ?> @aerotour_excursoes </a>
      </div>
      <div id="secaoFotos" col-md-6">
        <h2 class="bg-title">Fotos das excursões</h2>
        <div id="carouselExampleControls" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/jorgeemateus.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/linkinpark.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/redhot.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/knotfest19.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/anitta.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/straykids06.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/bmth.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/evanescence.webp" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
              <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/equipe_aerotour.webp" class="d-block w-100" alt="...">
            </div>
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
      </div>
</section>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/single-product.js?ver=<?= time() ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/react_apps/app_reservas_usuario.js?ver=<?= time() ?>"></script>
<!-- React e ReactDOM em produção -->
<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin defer></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin defer></script>
<?php get_footer(); ?>