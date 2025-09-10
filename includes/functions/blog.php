<?php 
//Filtra resultados da busca de posts
function filter_search_results($query) {
  if ($query->is_search && !is_admin()) {
      $query->set('post_type', 'post');
  }
  return $query;
}
add_filter('pre_get_posts', 'filter_search_results');

function wpdocs_custom_excerpt_length( $length ) {
	return 34;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

?>