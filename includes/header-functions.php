<?php
// Inclui os estilos otimizados diretamente no header
require_once get_template_directory() . '/includes/optimize-assets.php';
add_action('wp_head', 'aer_inject_optimized_css', 10);

// Carrega as funções de template e SEO
require_once get_template_directory() .
  '/includes/functions/header-setup-functions.php';

// Enqueue Bootstrap Icons
function enqueue_bootstrap_icons()
{
  wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', array(), '1.11.3');
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_icons');
