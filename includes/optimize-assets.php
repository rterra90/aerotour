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
    // Estilos globais
    'global' => [
      'condition' => true, // Carrega em todas as páginas
      'files' => ['/css/header.min.css', '/css/footer.min.css']
    ],
    // Home Page
    'home' => [
      'condition' => is_front_page(),
      'files' => [
        '/css/includes/hero.min.css',
        '/css/page-home.min.css',
        '/css/includes/sugestao.min.css',
        '/css/includes/parceiros-home.min.css',
        '/css/includes/qr-event-modal.min.css'
      ]
    ],
    // Slider e Cards: Comum na Home, Loja e Categorias
    'slider' => [
      'condition' =>
      is_front_page() || is_shop() || is_product_category() || is_product(),
      'files' => [
        '/css/includes/display/display-card.min.css',
        '/css/includes/cards-slider.min.css'
      ]
    ],
    //Estilos para páginas de gelrria de arquivo
    'archive' => [
      'condition' => is_archive(),
      'files' => ['/css/woocommerce/archive-product.min.css']
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
      'files' => ['/css/woocommerce/checkout.min.css']
    ],
    // Estilos para home do blog
    'blog_home' => [
      'condition' => is_home(),
      'files' => ['/css/home.min.css', '/css/single-post.min.css']
    ],
    // Estilos para blog posts individuais
    'blog_single' => [
      'condition' => is_single() && 'post' === get_post_type(),
      'files' => ['/css/single-post.min.css']
    ],
    // Estilos para Minha Conta
    'my_account' => [
      'condition' => is_account_page(),
      'files' => [
        '/css/form-login.min.css',
        '/css/woocommerce/form-edit-account.min.css',
        '/css/woocommerce/orders.min.css',
        '/css/minha-conta.min.css',
        '/css/account/account-menu.min.css',
        '/css/account/dashboard.min.css',
        '/css/account/minhas-reservas.min.css'
      ]
    ],
    // Estilos para página contato
    'contato' => [
      'condition' => is_page('contato'),
      'files' => ['/css/contato.min.css']
    ],
    //Estilos para página de pedido recebido
    'thankyou' => [
      'condition' => is_order_received_page(),
      'files' => ['/css/thankyou.min.css']
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
