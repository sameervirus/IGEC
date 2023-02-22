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

the_title( sprintf( '<h5 class="entry-title h5-xs"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );