<?php

/**
 * Carrega os scripts da single product e App de Reservas apenas em páginas de produto
 */
add_action('wp_enqueue_scripts', function () {
  if (! is_product()) {
    return;
  }

  // 1. Enfileira o script JS padrão da página single-product
  $js_path = '/js/single-product.js';
  $js_full_path = get_stylesheet_directory() . $js_path;
  $version = file_exists($js_full_path) ? filemtime($js_full_path) : '1.0.0';

  wp_enqueue_script(
    'aer-single-product',
    get_stylesheet_directory_uri() . $js_path,
    ['jquery', 'aer-reserva-app'], // Adicione dependências se o script usar jQuery ou o App React
    $version,
    true // Carrega no footer
  );

  // 2. Registra e enfileira o React (preferencialmente local para evitar DNS lookup externo)
  wp_enqueue_script('react', 'https://unpkg.com/react@18/umd/react.production.min.js', [], '18', true);
  wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js', ['react'], '18', true);

  // 3. Enfileira o seu App de Reservas
  $app_reservas_file = get_stylesheet_directory_uri() . '/js/react_apps/app_reservas_usuario.js';
  wp_enqueue_script(
    'aer-reserva-app',
    $app_reservas_file,
    ['react', 'react-dom'], // Dependências garantem a ordem correta
    file_exists($app_reservas_file) ? filemtime($app_reservas_file) : '1.0.0', // Cache busting automático
    null,
    true // Carrega no footer
  );

  // 4. Passa os dados necessários (o que estava nos data-attributes)
  global $post;
  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;
  $excursao = Aerotour_Helper::get_formatted_excursion_data($post->ID); // Sua função de lógica

  wp_localize_script('aer-reserva-app', 'singleProductData', [
    'variacoes' => $excursao['variacoes'],
    'embarques' => $excursao['embarques'],
    'productId' => $excursao['id'],
    'estadoDestino' => has_term('rock-in-rio', 'product_cat', $post->ID) ? 'rj' : 'sp',
    'userData' => $user_id ? [
      'nome_completo'   => $current_user->first_name . ' ' . $current_user->last_name,
      'cpf'             => get_user_meta($user_id, 'cpf', true), // Ajuste a meta_key se for outra
      'celular'         => get_user_meta($user_id, 'billing_phone', true),
      'data_nascimento' => get_user_meta($user_id, 'data_nasc', true),
    ] : null,
  ]);
});

/**
 * Injeta JSON-LD de Produto no Head para SEO e Performance
 */
add_action('wp_head', function () {
  if (! is_product()) return;

  $product_id = get_the_ID();
  $schema = Aerotour_Helper::get_excursion_schema($product_id);

  if ($schema) {
    echo "\n\n";
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
  }
});


// DEFER
add_filter('script_loader_tag', function ($tag, $handle) {
  if ('aer-single-product' !== $handle) {
    return $tag;
  }
  // Adiciona o atributo defer sem quebrar a tag gerada pelo WP
  return str_replace(' src', ' defer src', $tag);
}, 10, 2);
