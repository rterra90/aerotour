<?php
// Template Name: Home
?>
<?php
get_header(); 

$excursoes = wc_get_products(array(
  'orderby' => 'date',
  'order' => 'DESC',
  'status' => 'publish',
  'limit' => -1,
));

?>
<section id="content-home">
    
  <?php
    // Insere o modal de QR Code se ativo
    if(isset($_GET['qr_event']) && get_option('qr_code_coupon_status')['status'] === 'ativado' && $_GET['qr_event'] === get_option('qr_code_coupon_status')['code']){
      include 'includes/qr-event-modal.php';
      ?>
        <input type="hidden" id="open-qr-modal-btn" data-bs-toggle="modal" data-bs-target="#qr-event-modal">
        <script>window.onload = () => document.querySelector('#open-qr-modal-btn').click()</script>
      <?php
    }

    //Carrossel principal
    include 'includes/main-carousel.php';    

    //SLIDES DA PÁGINA INICIAL
    $displays_sections = get_option('aer_home_displays');
    foreach($displays_sections as $_section){
      if($_section['type'] === 'proximas'){
        aer_cards_slider(aer_proximas_excursoes($excursoes), $_section['nome']);
      }else if($_section['type'] === 'apos-data'){
        aer_cards_slider(aer_excursoes_apos_data($excursoes, $_section['type_value']), $_section['nome']);
      }else if($_section['type'] === 'categoria'){
       $_display_results = wc_get_products(array(
          'category' => array( $_section['type_value'] )
       ));
       aer_cards_slider(aer_proximas_excursoes($_display_results), $_section['nome']);
      }
    }



    //Sugestão
    include 'includes/sugestao.php';

    // Loop
    if(have_posts()) : while(have_posts()) : the_post();

    $args = array(
      'post_type' => 'post',
      'posts_per_page' => 4 
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) : ?>
      <section class="post-list container-md">
        <h2>Blog</h2>
        <ul class="d-flex">
          <?php while ($query->have_posts()) : $query->the_post(); 

            $main_img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'large');
          
          ?>
          
            <li>
              <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div>
                  <a href="<?php the_permalink(); ?>" aria-label="<?= the_title(); ?>">
                    <div class="header-img" style="background-image: url('<?= $main_img[0] ?>')"></div>
                  </a>
                  

                  <div class="blog-card-body px-2 px-sm-3 pb-2 mt-2">
                    <div class="blog-card-header d-flex justify-content-between">
                      <span class="posted-on"><?php echo get_the_date(); ?></span>
                      <div class="badges"></div>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?= the_title(); ?></a></h3>
                  
      
                    <footer class="entry-footer d-flex justify-content-end">
                        <a href="<?php the_permalink(); ?>" class="read-more">Leia mais</a>
                    </footer>
                  </div>
                </div>
                
                
              </article>
            </li>
          <?php endwhile; ?>
        </ul>
      </section>
  
      <?php
      // Restaura os dados originais do post
      wp_reset_postdata();
  else : ?>
      <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
  <?php endif;

    endwhile; else: ?>
      <p>Nenhum conteúdo para exibir.</p>
    <?php
    endif;

    //Parceiros
    include 'includes/parceiros.php';
  ?>

  </section>
  
<?php get_footer(); ?>
