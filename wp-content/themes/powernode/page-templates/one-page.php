<?php
/**
 * Template Name: Onepage Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in prestige consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
get_header();

if ( have_posts() ) {

	do_action( 'powernode_before_loop_page' );

	while ( have_posts() ) : the_post();
	?>
	<?php do_action( 'powernodewt_before_page_content' ); ?>
	
	<div class="one-page">

		<?php do_action( 'powernodewt_before_page_inner_content' ); ?>
		
		<?php do_action( 'powernodewt_page_content' ); ?>
		
		<?php do_action( 'powernodewt_after_page_inner_content' ); ?>
		
	</div>

	<?php do_action( 'powernodewt_after_page_content' ); ?>
	<?php
	endwhile;

	do_action( 'powernode_after_loop_page' );

}

get_footer();