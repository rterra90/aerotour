<?php
add_action('rest_api_init', function () {
    register_rest_route('api/v1', '/arquivo', array(
        'methods'  => 'GET',
        'callback' => 'get_historico_excursoes',
        'permission_callback' => '__return_true'
    ));
});

function get_historico_excursoes($request) {
    $hoje = date('Ymd');
    $page = $request->get_param('page') ? (int) $request->get_param('page') : 1;
    $search = $request->get_param( 'search' );
    $genre  = $request->get_param( 'genre' );

    $args_passadas = array(
        'post_type'      => 'product',
        'posts_per_page' => 12, // Paginação controlada
        'paged'          => $page,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'data_limite_excursao',
                'value'   => $hoje,
                'compare' => '<', // Menor que hoje
                'type'    => 'NUMERIC'
            )
        )
    );

    // Aplica busca por texto (título do produto)
    if ( ! empty( $search ) ) {
        $args_passadas['s'] = sanitize_text_field( $search );
    }

    // Aplica filtro por gênero musical
    if ( ! empty( $genre ) ) {
        $args_passadas['tax_query'] = array(
            array(
                'taxonomy' => 'exc_genre',
                'field'    => 'slug',
                'terms'    => sanitize_text_field( $genre ),
            ),
        );
    }

    $query = new WP_Query($args_passadas);
    $excursoes_html = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            global $product;
            $excursao = $product;
            
            ob_start();
            include get_stylesheet_directory() . '/includes/display/display-card.php';
            $excursoes_html[] = array(
                'id'   => get_the_ID(),
                'html' => ob_get_clean()
            );
        }
        wp_reset_postdata();
    }

    return new WP_REST_Response( array(
        'items'       => $excursoes_html,
        'max_pages'   => $query->max_num_pages,
        'total_posts' => $query->found_posts
    ), 200 );
}

?>