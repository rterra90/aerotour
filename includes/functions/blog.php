<?php 

function wpdocs_custom_excerpt_length( $length ) {
	return 34;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );

?>