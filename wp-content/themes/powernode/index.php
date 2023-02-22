<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

get_header();

do_action( 'powernode_before_main_content' );

if ( have_posts() ) {

	do_action( 'powernode_before_loop_post' );
	
	$GLOBALS['display_type'] = 'loop';

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/post-loop/layout', get_post_format() );

	endwhile;

	do_action( 'powernode_after_loop_post' );
	
	do_action( 'powernode_loop_pagination' );

} else {
	
	get_template_part( 'template-parts/post-loop/content', 'none' );

}

do_action( 'powernode_after_main_content' );

get_footer();