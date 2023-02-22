<?php
/**
 * Displays social buttons
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_singular() && get_theme_mod( 'powernode_blog_single_post_related', true ) != true )  {
	return '';
}

powernodewt_post_related_posts();