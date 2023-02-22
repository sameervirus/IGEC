<?php
/**
 * Topbar Menu
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

$location = apply_filters( 'powernode_topbar_menu_location', $location );
if ( has_nav_menu( $location ) ) {
	wp_nav_menu(array(
		'theme_location'    =>  $location,
		'menu_class'        =>  'topbar-menu menu',
		'container'         => 	false,
		'fallback_cb'       => 	false,
		'menu_type'         => 	'topbar-menu',
	) );
}
