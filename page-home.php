<?php
// Template Name: Home
?>
<?php
//Busca excursões com data limite maior ou igual a hoje
get_header();
$hoje = date('Ymd');
$args = [
  'post_type' => 'product',
  'post_status' => 'publish',
  'posts_per_page' => 30,
  'meta_key' => 'data_limite_excursao',
  'orderby' => 'meta_value_num',
  'order' => 'ASC',
  'meta_query' => [
    [
      'key' => 'data_limite_excursao',
      'value' => $hoje,
      'compare' => '>=',
      'type' => 'NUMERIC'
    ]
  ]
];
$query = new WP_Query($args);
$excursoes_ids = $query->posts; // Converte IDs em objetos de produto do WooCommerce
$excursoes = array_map('wc_get_product', $excursoes_ids);

// Prepara dados para JavaScript
$dados_js = array_map(function ($p) {
  $nome_original = get_the_title($p->get_id());
  return [
    'nome' => $nome_original,
    'nome_limpo' => sanitizar_termo($nome_original), // Versão para busca
    'url'  => get_permalink($p->get_id())
  ];
}, $excursoes);

?>


<section id="content-home">
  <?php // Insere o modal de QR Code se ativo


  if (
    isset($_GET['qr_event']) &&
    get_option('qr_code_coupon_status')['status'] === 'ativado' &&
    $_GET['qr_event'] === get_option('qr_code_coupon_status')['code']
  ) {
    include 'includes/qr-event-modal.php'; ?>
    <input type="hidden" id="open-qr-modal-btn" data-bs-toggle="modal" data-bs-target="#qr-event-modal">
    <script>
      window.onload = () => document.querySelector('#open-qr-modal-btn').click()
    </script>
    <?php
  }

  //HERO BANNER
  include 'includes/main-carousel.php';

  //SLIDES DA PÁGINA INICIAL
  $displays_sections = get_option('aer_home_displays');
  foreach ($displays_sections as $_section) {
    if ($_section['type'] === 'proximas') {
      aer_cards_slider(array_slice($excursoes, 0, 8), $_section['nome']);
    } elseif ($_section['type'] === 'apos-data') {
      aer_cards_slider(
        aer_excursoes_apos_data($excursoes, $_section['type_value']),
        $_section['nome']
      );
    } elseif ($_section['type'] === 'categoria') {
      // Supomos que $_section['type_value'] seja o SLUG ou ID da categoria
      $slug_alvo = $_section['type_value'];
      $_display_results = array_filter($excursoes, function ($excursao) use (
        $slug_alvo
      ) {
        // Verifica se o produto pertence à categoria (funciona com ID ou Slug)
        return has_term($slug_alvo, 'product_cat', $excursao->get_id());
      });
      $_display_results = array_slice($_display_results, 0, 8); // Opcional: Se você precisar de apenas os 4 primeiros dessa categoria na seção:
      aer_cards_slider($_display_results, $_section['nome']);
    }
  } //Sugestão
  include 'includes/sugestao.php';
  // Loop
  if (have_posts()):
    while (have_posts()):
      the_post();
      $args = [
        'post_type' => 'post',
        'posts_per_page' => 4,
        'nofound_rows' => true
      ];
      $query = new WP_Query($args);
      if ($query->have_posts()): ?>
        <section class="post-list container-md">
          <h2>Blog</h2>
          <ul class="d-flex">
            <?php while ($query->have_posts()):

              $query->the_post();
              $main_img = wp_get_attachment_image_src(
                get_post_thumbnail_id(get_the_ID()),
                'large'
              );
            ?>

              <li>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <div>
                    <a href="<?php the_permalink(); ?>" aria-label="<?= the_title() ?>">
                      <div class="header-img" style="background-image: url('<?= $main_img[0] ?>')"></div>
                    </a>


                    <div class="blog-card-body px-2 px-sm-3 pb-2 mt-2">
                      <div class="blog-card-header d-flex justify-content-between">
                        <span class="posted-on"><?php echo get_the_date(); ?></span>
                        <div class="badges"></div>
                      </div>
                      <h3><a href="<?php the_permalink(); ?>"><?= the_title() ?></a></h3>


                      <footer class="entry-footer d-flex justify-content-end">
                        <a href="<?php the_permalink(); ?>" class="read-more">Leia mais</a>
                      </footer>
                    </div>
                  </div>


                </article>
              </li>
            <?php
            endwhile; ?>
          </ul>
        </section>

      <?php wp_reset_postdata();
      else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif;
    endwhile;
  else:
    ?>
    <p>Nenhum conteúdo para exibir.</p>
  <?php
  endif; //Parceiros
  include 'includes/parceiros.php';
  ?>

</section>

<?php get_footer(); ?>