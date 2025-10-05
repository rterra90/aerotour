<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
<section id="archive-product">

  <h1 class="text-center woocommerce-products-header__title page-title mb-md-5 mb-4 mt-3"><?= single_term_title('', false) ? single_term_title('Todas as excursões / ') : 'Todas as excursões' ?></h1>
  <div class="archive-container container-lg d-flex">
    <?php
  /**
   * Hook: woocommerce_before_main_content.
   *
   * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
   * @hooked woocommerce_breadcrumb - 20
   * @hooked WC_Structured_Data::generate_website_data() - 30
   */

    do_action( 'woocommerce_before_main_content' );

    ?>
    <header class="woocommerce-products-header">
      <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
        
      <?php endif; ?>

      <?php
      /**
       * Hook: woocommerce_archive_description.
       *
       * @hooked woocommerce_taxonomy_archive_description - 10
       * @hooked woocommerce_product_archive_description - 10
       */
      do_action( 'woocommerce_archive_description' );
      ?>
      <div class="exc-archive-search aer-search-wrapper mb-3">
        <span data-role="button"></span>
        <input class="aer-search-input" type="text" placeholder="Digite para buscar..." />
      </div>
      <?php 
      
      ?>
    </header>
    <?php

    if ( woocommerce_product_loop() ) {

      /**
       * Hook: woocommerce_before_shop_loop.
       *
       * @hooked woocommerce_output_all_notices - 10
       * @hooked woocommerce_result_count - 20
       * @hooked woocommerce_catalog_ordering - 30
       */
      // do_action( 'woocommerce_before_shop_loop' );

      woocommerce_product_loop_start();
      echo '<div class="row">';

      $archive_products = array();
      while ( have_posts() ) {
          the_post();
          
          /**
           * Hook: woocommerce_shop_loop.
           */
          do_action( 'woocommerce_shop_loop' );
          global $product;
          array_push($archive_products, $product);
          
        
        };
      if ( wc_get_loop_prop( 'total' ) ) {
        
        // print_r($archive_products);
        foreach(aer_proximas_excursoes($archive_products, 'galeria') as $excursao){
          include __DIR__ . '/../includes/display/display-card.php';
        };
        
        
        
        
      } else {
        //Está caindo aqui quando na página de galeria geral

        wp_redirect( 'https://aerotour.com.br/excursoes/categoria/shows/');
        ?>
        <p>Oops, parece que houve um erro ao obter as informações...</p>
        <?php
      }
      echo '</div>';
      woocommerce_product_loop_end();
      ?>
        <!-- <section id="archive-passadas">
          <div>
            <span role="button">Ver passadas</span>

          </div>
        </section> -->
      <?php
      /**
       * Hook: woocommerce_after_shop_loop.
       *
       * @hooked woocommerce_pagination - 10
       */
      do_action( 'woocommerce_after_shop_loop' );
    } else {
      /**
       * Hook: woocommerce_no_products_found.
       *
       * @hooked wc_no_products_found - 10
       */
      do_action( 'woocommerce_no_products_found' );
    }

  /**
   * Hook: woocommerce_after_main_content.
   *
   * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
   */
  do_action( 'woocommerce_after_main_content' );

  include 'global/sidebar-exc.php';
  ?>
 </div>
 <script>
    const cards = document.querySelectorAll("ul.products .row > div");
    let searchCards = [];
    const searchInput = document.querySelector(".aer-search-input");
    searchInput.addEventListener('keyup', ({target}) => {
      if(target.value.length > 0){
        target.parentElement.classList.add('active');
        cards.forEach(card => card.classList.remove('d-none'));

      } 
      else{
        target.parentElement.classList.remove('active');
      } 

      searchCards = [];
      cards.forEach(card => {if(card.dataset.nome.toUpperCase().includes(target.value.toUpperCase())) searchCards.push(card)});
      cards.forEach(card => searchCards.includes(card) ? card.classList.remove('d-none') : card.classList.add('d-none'))
    })

    const _clear = document.querySelector('.aer-search-wrapper > span');
    _clear.addEventListener('click', ({target}) => {
      target.parentElement.querySelector('input').value = '';
      target.parentElement.classList.remove('active');
      cards.forEach(card => card.classList.remove('d-none'));
    })
 </script>
</section>
<?php
get_footer( 'shop' );