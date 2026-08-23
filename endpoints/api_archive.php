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

    $query = new WP_Query($args_passadas);
    $html_cards = '';

    if ($query->have_posts()) {
        ob_start(); // Inicia o buffer para capturar o HTML do PHP
        while ($query->have_posts()) {
            $query->the_post();
            global $product;
            $excursao = $product;
            
            // Inclui seu template atual, que fará a lógica das badges dinâmicas
            include get_stylesheet_directory() . '/includes/display/display-card.php';
        }
        $html_cards = ob_get_clean(); // Salva o HTML gerado
        wp_reset_postdata();
    }

    return new WP_REST_Response(array(
        'html'        => $html_cards,
        'max_pages'   => $query->max_num_pages,
        'total_posts' => $query->found_posts
    ), 200);
}

?>