<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
// get_sidebar( 'shop' );

// $aer_categorias = get_terms( array(
//   'taxonomy'     => 'product_cat',
//   'orderby'      => 'name',
//   'order'        => 'DESC',
// ) )
?>

<div id="archive-product-sidebar">
  <?php wp_nav_menu([
    'menu' => 'archive-sidebar',
    'container' => 'nav',
    'container_class' => "sidebar_categorias-nav"
  ]); ?>
</div>
<?php

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
