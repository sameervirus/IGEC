<?php
/**
 * The template for displaying all single posts
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

get_header();

do_action( 'powernode_before_main_content' );

if ( have_posts() ) {

	do_action( 'powernode_before_loop_page' );

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/single-portfolio/layout', get_post_format() );

	endwhile;

	do_action( 'powernode_after_loop_page' );

}

do_action( 'powernode_after_main_content' );

get_footer();