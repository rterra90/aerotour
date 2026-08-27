<?php
// Registra script com variáveis globais para o app de archive-product
add_action('wp_enqueue_scripts', function() {
    
    // Verifica se é o Shop principal, Arquivo de Produto, ou Arquivo de Taxonomia (Categoria, Gênero, Local)
    if ( is_shop() || is_post_type_archive('product') || is_product_category() || is_tax('exc_genre') || is_tax('exc_venue') ) {
        
        $app_arch_prod_file = get_stylesheet_directory() . '/js/react_apps/app_archive_product.js';
        $app_arch_prod_uri = get_stylesheet_directory_uri() . '/js/react_apps/app_archive_product.js';

        // 1. Carrega o arquivo compilado do AppArchiveProduct
        wp_enqueue_script(
            'script-archive-app', 
            $app_arch_prod_uri, 
            array('wp-element'), // O WordPress já carrega react e react-dom através do wp-element
            file_exists($app_arch_prod_file) ? filemtime($app_arch_prod_file) : '1.0.0', 
            true
        );

        // 2. Resgata todos os gêneros para montar o Select de filtros
        $termos_genero = get_terms( array(
            'taxonomy'   => 'exc_genre',
            'hide_empty' => false,
        ) );

        $generos_formatados = array();
        if ( ! is_wp_error( $termos_genero ) && ! empty( $termos_genero ) ) {
            foreach ( $termos_genero as $termo ) {
                $generos_formatados[] = array(
                    'term_id' => $termo->term_id,
                    'name'    => $termo->name,
                    'slug'    => $termo->slug,
                );
            }
        }
        
        $termos_categoria = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true ) );
        $termos_local = get_terms( array( 'taxonomy' => 'exc_venue', 'hide_empty' => false ) );

        // 3. Monta a consulta das excursões vigentes
        $hoje = date( 'Ymd' );
        $args_vigentes = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'     => 'data_limite_excursao',
                    'value'   => $hoje,
                    'compare' => '>=',
                    'type'    => 'NUMERIC'
                )
            )
        );

        $query_vigentes = new WP_Query( $args_vigentes );
        $excursoes_vigentes = array();

        if ( $query_vigentes->have_posts() ) {
            while ( $query_vigentes->have_posts() ) {
                $query_vigentes->the_post();
                
                global $product;
                $excursao = $product; 

                $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat', array( 'fields' => 'slugs' ) );
                $product_genres = wp_get_post_terms( get_the_ID(), 'exc_genre', array( 'fields' => 'slugs' ) );
                $product_venues = wp_get_post_terms( get_the_ID(), 'exc_venue', array( 'fields' => 'slugs' ) );

                ob_start();
                include get_stylesheet_directory() . '/includes/display/display-card.php';
                $html_card = ob_get_clean();

                $excursoes_vigentes[] = array(
                    'id'          => get_the_ID(),
                    'html'        => $html_card,
                    'genres'      => !is_wp_error($product_genres) ? $product_genres : [],
                    'data_limite' => intval( get_post_meta( get_the_ID(), 'data_limite_excursao', true ) ),
                    'categorias'  => !is_wp_error($product_cats) ? $product_cats : [],
                    'venues'      => !is_wp_error($product_venues) ? $product_venues : []
                );
            }
            wp_reset_postdata();
        }

        // 4. Expõe as variáveis para o JavaScript
        wp_localize_script('script-archive-app', 'ArchiveProductData', array(
            'apiUrl' => esc_url_raw(rest_url('aerotour/v1/historico')), // Corrigido para a rota REST que criamos anteriormente
            'nonce' => wp_create_nonce('wp_rest'),
            'generos' => $generos_formatados,
            'categorias' => $termos_categoria,
            'locais' => $termos_local,
            'excursoesVigentes' => $excursoes_vigentes 
        ));

        // Enfileira o script auxiliar caso seja necessário
        $archive_js_file = get_stylesheet_directory() . '/js/archive-product.js';
        wp_enqueue_script(
            'archive-product-js', 
            get_template_directory_uri() . '/js/archive-product.js', 
            array('wp-element'), 
            file_exists($archive_js_file) ? filemtime($archive_js_file) : '1.0.0', 
            true
        );
    }
});
?>