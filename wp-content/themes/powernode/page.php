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
	
	?>
	<?php do_action( 'powernodewt_before_page_content' ); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php do_action( 'powernodewt_before_page_inner_content' ); ?>
		
		<?php do_action( 'powernodewt_page_content' ); ?>
		
		<?php do_action( 'powernodewt_after_page_inner_content' ); ?>

	</article>

	<?php do_action( 'powernodewt_after_page_content' ); ?>
	<?php

	endwhile;

	do_action( 'powernode_after_loop_page' );

}

do_action( 'powernode_after_main_content' );

get_footer();