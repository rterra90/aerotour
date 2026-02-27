<?php

/**
 * Template Name: Rock in Rio
 * Template Post Type: product
 */

if (! defined('ABSOLUTE_PATH')) {
  exit; // Exit if accessed directly
}

get_header('shop');

// Aqui entra a estrutura do WooCommerce
while (have_posts()) :
  the_post();
  wc_get_template_part('content', 'single-product');
endwhile;

get_footer('shop');
