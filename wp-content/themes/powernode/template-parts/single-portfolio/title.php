<?php
/**
 * Post Title
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array();
$args['class'][] = 'entry-title h4-lg px-2';
$args['class'][] = ( powernodewt_get_post_meta( 'portfolio_single_layout' ) == 'compact' ) ? 'col-xl-10 offset-xl-1' : '';

the_title( '<h4 '. powernodewt_stringify_atts( $args ) .'>', '</h4>' );