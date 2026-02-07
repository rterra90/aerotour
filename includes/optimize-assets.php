<?php
/**
 * inc/optimize-assets.php
 * Entrega segmentada de CSS Crítico
 */

function aer_get_segmented_css()
{
  $theme_dir = get_template_directory();
  $combined_css = '';

  // Lista de arquivos e suas condições
  $assets_map = [
    // Slider e Cards: Comum na Home, Loja e Categorias
    'slider' => [
      'condition' =>
        is_front_page() || is_shop() || is_product_category() || is_product(),
      'files' => [
        '/css/includes/display/display-card.min.css',
        '/css/includes/cards-slider.min.css'
      ]
    ],
    // Estilos específicos para a página de Produto Único
    'product' => [
      'condition' => is_product(),
      'files' => [
        // '/css/includes/product-details.min.css' // exemplo
      ]
    ],
    // Estilos para Carrinho e Checkout
    'ecommerce' => [
      'condition' => is_cart() || is_checkout(),
      'files' => [
        // '/css/includes/cart-checkout.min.css' // exemplo
      ]
    ]
  ];

  foreach ($assets_map as $section) {
    if ($section['condition']) {
      foreach ($section['files'] as $file) {
        $full_path = $theme_dir . $file;
        if (file_exists($full_path)) {
          $combined_css .= file_get_contents($full_path);
        }
      }
    }
  }

  return $combined_css;
}

function aer_inject_optimized_css()
{
  if (is_admin()) {
    return;
  }

  $css = aer_get_segmented_css();

  if (!empty($css)) {
    echo "\n\n";
    echo "<style id='aer-optimized-styles'>\n" . $css . "\n</style>\n";
  }
}
