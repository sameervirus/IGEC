<?php
/**
 * Enqueue script and styles for child theme
 */
function powernodewt_child_enqueue_styles() {
	wp_enqueue_style( 'powernode-child-style', get_stylesheet_directory_uri().'/style.css', array( 'powernode-style' ), wp_get_theme( 'PowerNode' )->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'powernodewt_child_enqueue_styles', 10010 );