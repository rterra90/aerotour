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

//Define as propriedades 'encerrar_vendas' e 'dia' em cada variação
foreach ($excursao['variacoes'] as $i => $var) {
  $excursao['variacoes'][$i]['encerrar_vendas'] = get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes' ? true : false;
  $att_dia = $var['attributes']['attribute_dia'];
  $excursao['variacoes'][$i]['dia'] = $att_dia;
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

if (has_term('rock-in-rio', 'product_cat')) {
  if (isset($_GET['ref']) && $_GET['ref'] == "artecult") {
?>
    <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . '/css/includes/modals/promo-modal.css'; ?>">
<?php
  }
}
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

    <!-- BANNER ROCK IN RIO ARTECULT -->
    <?php
    if (has_term('rock-in-rio', 'product_cat')) {
      if (isset($_GET['ref']) && $_GET['ref'] == "artecult") {
    ?>
        <div id="topAdBanner">
          <img src="<?= get_stylesheet_directory_uri() ?>/assets/banners/BannerAerotourArteCult-2.gif" alt="Promoção Aerotour + ArteCult + Bandas Novas" data-bs-toggle="modal" data-bs-target="#modal-promo-rir">
        </div>
      <?php
      }
    } else if ($excursao['id'] == 6495) {
      ?>
      <div id="topAdBanner">
        <img src="<?= get_stylesheet_directory_uri() ?>/assets/banners/banner_jb.gif" alt="Promoção Aerotour + JBSP Fã Clube Jonas Brothets" data-bs-toggle="modal" data-bs-target="#modal-promo-jb">
      </div>

    <?php
    }
    ?>





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
                <a href="https://api.whatsapp.com/send?text=<?php echo get_permalink(); ?>" aria-label="Botão compartilhar pelo WhatsApp"><?= aer_icons('whatsapp', 18, 18) ?></a>
                <a href="https://www.instagram.com/aerotour_excursoes/" aria-label="Botão compartilhar pelo Instagram"><?= aer_icons('instagram', 18, 18) ?></a>
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


        <!-- BADGES DE DISPONIBILIDADE -->
        <div class="status-badges-container">
          <?php
          if (count($excursao['variacoes']) > 1) {

            $statuses = []; // Armazenará os tipos de status encontrados
            $total_vars = count($excursao['variacoes']);

            foreach ($excursao['variacoes'] as $_var) {
              $disponibilidade_html = $_var['availability_html'];
              preg_match('/\d+/', strip_tags($disponibilidade_html), $matches);
              $vagas = isset($matches[0]) ? (int) $matches[0] : 0;

              if (!$_var['encerrar_vendas']) {
                if ($vagas > 10) {
                  $statuses[] = array('dia' => $_var['dia'], 'label' => "Vagas disponíveis", 'slug' => 'disponivel');
                } elseif ($vagas > 0 && $vagas <= 10) {
                  $statuses[] = array('dia' => $_var['dia'], 'label' => "Últimas vagas", 'slug' => 'ultimas');
                } else {
                  $statuses[] = array('dia' => $_var['dia'], 'label' => "Esgotado", 'slug' => 'esgotado');
                }
              }
            }

            // Se todas as variações tiverem vendas encerradas, exibe um badge geral de "Esgotado"
            if (count($statuses) === 0) {
              echo "<div class='badge-excursao badge-encerrado'>Reservas encerradas</div>";
            } else {
              // Lógica de exibição baseada na contagem de tipos de status
              $mapped = array_map(function ($_s) {
                return $_s['slug'];
              }, $statuses);

              $todos_status_iguais = count(array_unique($mapped)) === 1;

              if ($todos_status_iguais) {
                // Caso 1, 2 e 3: Tudo igual
                $tipo = $mapped[0];
                echo "<div class='badge-excursao badge-$tipo'>{$statuses[0]['label']}</div>";
              } else {
                // Caso 4: Status Mistos - Slider Horizontal

                echo '<div class="badge-slider-container">';
                echo '<div class="badge-slider-track">';
                foreach ($statuses as $status_obj) {
                  $badge_dia = substr($status_obj['dia'], 0, -5);
                  $label = $status_obj['label'];
                  $slug = $status_obj['slug'];
                  echo "<div class='badge-excursao badge-item multi-badges badge-$slug'><span>$badge_dia</span>$label</div>";
                }
                echo '</div>';
                echo '</div>';
              }

              // verifica se a largura de  badge-slider-track é maior do que a largura de badge-slider-container e, se sim, aplica a classe .overflowing para ativar a animação
          ?>
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  const container = document.querySelector('.badge-slider-container');
                  const track = document.querySelector('.badge-slider-track');

                  if (track.offsetWidth > container.offsetWidth) {
                    container.classList.add('overflowing');

                  }
                });
              </script>
          <?php
            }
          } else {
            // Captura a disponibilidade da variação única
            $disponibilidade_html = $excursao['variacoes'][0]['availability_html'];
            preg_match('/\d+/', strip_tags($disponibilidade_html), $matches);
            $vagas_disponiveis = isset($matches[0]) ? (int) $matches[0] : 0;

            // Lógica de exibição seguindo o novo estilo de badges
            if (!$excursao['variacoes'][0]['encerrar_vendas']) {
              if ($vagas_disponiveis >= 10) {
                // Caso: Mais de 9 vagas
                echo '<div class="badge-excursao badge-disponivel">Vagas disponíveis</div>';
              } elseif ($vagas_disponiveis > 0 && $vagas_disponiveis < 10) {
                // Caso: Entre 1 e 9 vagas (Gera urgência)
                echo '<div class="badge-excursao badge-ultimas">Últimas ' . $vagas_disponiveis . ' vagas restantes</div>';
              } else {
                // Caso: Esgotado
                echo '<div class="badge-excursao badge-esgotado">Esgotado</div>';
              }
            } else {
              echo '<div class="badge-excursao badge-encerrado">Reservas encerradas</div>';
            }
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
      <!-- <div class="modal-footer">
        <button class="modal-button modal-button-ok"><img src="${rootUrl}/assets/images/parceiros/artecult.webp" width="44px" height="44px"><a href="https://artecult.com/" target="_blank" atia-label="Link para visitar o blog da ArteCult" onclick="gtag('event', 'btn_artecult', {
                  'event_category': 'ads',
                  'event_label': 'btn_artecult',
                  'value': 1
                })">Visite o site da ArteCult</a></button>
      </div> -->
    </div>

  </div>
</div>
</div>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/single-product.js?ver=<?= time() ?>"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/react_apps/app_reservas_usuario.js?ver=<?= time() ?>"></script>
<!-- React e ReactDOM em produção -->
<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin defer></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin defer></script>
<?php get_footer(); ?>