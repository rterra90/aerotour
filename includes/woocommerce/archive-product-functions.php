<?php
    // // //
    // Registra script com variáveis globais para o app de archive-product
    add_action('wp_enqueue_scripts', function() {
        if (is_post_type_archive('product') || is_shop()) {
            // 1. Carrega o arquivo compilado do AppArchiveProduct
            wp_enqueue_script('script-archive-app', get_template_directory_uri() . '/js/react_apps/app_archive_product.js', array('wp-element'), filemtime( get_stylesheet_directory() . '/js/react_apps/app_archive_product.js' ), true);

            // 2. Resgata todos os gêneros para montar o Select de filtros
            $termos_genero = get_terms( array(
                'taxonomy'   => 'exc_genre',
                'hide_empty' => true,
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
                    
                    // Variáveis globais necessárias para que o display-card.php funcione
                    global $product;
                    $excursao = $product; 

                    // Extrai os slugs da taxonomia 'exc_genre' para o filtro do React
                    $product_genres = wp_get_post_terms( get_the_ID(), 'exc_genre', array( 'fields' => 'slugs' ) );
                    if ( is_wp_error( $product_genres ) ) {
                        $product_genres = array();
                    }

                    // Captura o HTML renderizado do card sem imprimi-lo na tela
                    ob_start();
                    include get_stylesheet_directory() . '/includes/display/display-card.php';
                    $html_card = ob_get_clean();

                    // Monta o objeto que será lido pelo TypeScript
                    $excursoes_vigentes[] = array(
                        'id'     => get_the_ID(),
                        'html'   => $html_card,
                        'genres' => $product_genres,
                        'data_limite' => intval( get_post_meta( get_the_ID(), 'data_limite_excursao', true ) ),
                    );
                }
                wp_reset_postdata();
            }







            
            // Expõe as variáveis para o JavaScript
            wp_localize_script('script-archive-app', 'ArchiveProductData', array(
                'apiUrl' => esc_url_raw(rest_url('api/v1/arquivo')),
                'nonce' => wp_create_nonce('wp_rest'),
                'generos' => ['rock', 'pop', 'jazz'], // Exemplo de array de gêneros, substitua conforme necessário
                'excursoesVigentes' => $excursoes_vigentes // Aqui entra o array com os HTMLs processados
            ));

            // enfileirar o script archive-product.js
            wp_enqueue_script('archive-product-js', get_template_directory_uri() . '/js/archive-product.js', array('wp-element'), filemtime(get_stylesheet_directory() . '/js/archive-product.js'), true);
        }
    });


  // Enfileira o App de Reservas
  $app_arch_prod_file = get_stylesheet_directory_uri() . '/js/react_apps/app_archive_product.js';
  wp_enqueue_script(
    'aer-archive-product-app',
    $app_arch_prod_file,
    ['react', 'react-dom'], // Dependências garantem a ordem correta
    file_exists($app_arch_prod_file) ? filemtime($app_arch_prod_file) : '1.0.0', // Cache busting automático
    null,
  );


?>