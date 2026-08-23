<?php
defined('ABSPATH') || exit();

get_header('shop');
?>
<section id="archive-product">

  <h1 class="text-center woocommerce-products-header__title page-title mb-md-5 mb-4 mt-3"><?= single_term_title(
    '',
    false
  )
    ? single_term_title('Todas as excursões / ')
    : 'Todas as excursões' ?></h1>
  <div class="archive-container container-lg d-flex">
     <!-- /**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */ -->
     <?php do_action('woocommerce_before_main_content'); ?>
    <header class="woocommerce-products-header">
      <?php if (apply_filters('woocommerce_show_page_title', true)): ?>
        
      <?php endif; ?>

       <!-- /**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */ -->
       <?php do_action('woocommerce_archive_description'); ?>
      <div class="exc-archive-search aer-search-wrapper mb-3">
        <span data-role="button"></span>
        <input class="aer-search-input" type="text" placeholder="Digite para buscar..." />
      </div>
      <?php  ?>
    </header>
    <?php
    if (woocommerce_product_loop()) {
      woocommerce_product_loop_start();
      echo '<div class="row">';

      while (have_posts()) {
        the_post();
        // Define a variável global do produto para o WooCommerce
        global $product;

        // Atribui o objeto atual à variável que o seu template display-card.php espera
        $excursao = $product;
        include __DIR__ . '/../includes/display/display-card.php';
      }

      echo '</div>';
      woocommerce_product_loop_end();

      do_action('woocommerce_after_shop_loop');
    } else {
      do_action('woocommerce_no_products_found');
    }

    /**
     * Hook: woocommerce_after_main_content.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action('woocommerce_after_main_content');

    include 'global/sidebar-exc.php';
    ?>
 </div>
 <script>
const cards = document.querySelectorAll("ul.products .row > div");
const searchInput = document.querySelector(".aer-search-input");
const searchWrapper = document.querySelector('.aer-search-wrapper');
const productContainer = document.querySelector("ul.products");

// 1. Criar o elemento de "Não encontrado" dinamicamente
const noResultsHTML = `
    <li class="no-results-found">
        <span class="icon"><?php echo aer_icons('lost', 130, 130); ?></span>
        <p>Nenhuma excursão com esse nome...</p>
        <button type="button" class="btn-clear-search">Mostrar todas as excursões</button>
    </li>
`;
productContainer.insertAdjacentHTML('beforeend', noResultsHTML);
const noResultsElement = document.querySelector('.no-results-found');

const filterCards = (term) => {
    const query = term.toUpperCase();
    let visibleCount = 0;

    searchWrapper.classList.toggle('active', query.length > 0);

    cards.forEach(card => {
        const name = card.dataset.nome ? card.dataset.nome.toUpperCase() : "";
        const matches = name.includes(query);
        
        card.classList.toggle('d-none', !matches);
        
        if (matches) visibleCount++;
    });

    // 2. Controlar a exibição da mensagem de "Sem resultados"
    if (visibleCount === 0) {
        noResultsElement.style.display = 'block';
    } else {
        noResultsElement.style.display = 'none';
    }
};

// Eventos
searchInput.addEventListener('input', (e) => filterCards(e.target.value));

// Evento para o botão de limpar dentro da mensagem de "Não encontrado"
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-clear-search') || e.target.closest('.aer-search-wrapper span')) {
        searchInput.value = '';
        filterCards('');
        searchInput.focus();
    }
});
 </script>
</section>
<?php get_footer('shop');
