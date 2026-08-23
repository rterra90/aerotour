<?php

/**
 * Carrega os scripts da single product e App de Reservas apenas em páginas de produto
 */
add_action('wp_enqueue_scripts', function () {
  if (! function_exists('is_product') || ! is_product()) {
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
    false // Carrega no footer
  );

  // Enfileira o App de Reservas
  $app_reservas_file = get_stylesheet_directory_uri() . '/js/react_apps/app_reservas_usuario.js';
  wp_enqueue_script(
    'aer-reserva-app',
    $app_reservas_file,
    ['react', 'react-dom'], // Dependências garantem a ordem correta
    file_exists($app_reservas_file) ? filemtime($app_reservas_file) : '1.0.0', // Cache busting automático
    null,
  );

  // 4. Passa os dados necessários (o que estava nos data-attributes)
  global $post;
  $current_user = wp_get_current_user();
  $user_id = $current_user->ID;
  $excursao = Single_Product_Helper::get_formatted_excursion_data($post->ID); // Sua função de lógica

  wp_localize_script('aer-reserva-app', 'singleProductData', [
    'variacoes' => $excursao['variacoes'],
    'embarques' => $excursao['embarques'],
    'embarquesDetalhes' => isset($excursao['embarques_detalhes']) ? $excursao['embarques_detalhes'] : null,
    'embarquesVariacao' => isset($excursao['embarques_por_variacao']) ? $excursao['embarques_por_variacao'] : null,
    'productId' => $excursao['id'],
    'estadoDestino' => has_term('rock-in-rio', 'product_cat', $post->ID) ? 'rj' : 'sp',
    'userData' => $user_id ? [
      'nome_completo'   => $current_user->first_name . ' ' . $current_user->last_name,
      'cpf'             => get_user_meta($user_id, 'cpf', true), // Ajuste a meta_key se for outra
      'celular'         => get_user_meta($user_id, 'billing_phone', true),
      'data_nascimento' => get_user_meta($user_id, 'data_nasc', true),
    ] : null,
    'session_id' => (WC()->session) ? WC()->session->get_customer_id() : 'guest_' . uniqid()
  ]);
});

/**
 * Injeta JSON-LD de Produto no Head para SEO e Performance
 */
add_action('wp_head', function () {
  if (! is_product()) return;

  $product_id = get_the_ID();
  $schema = Single_Product_Helper::get_excursion_schema($product_id);

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
