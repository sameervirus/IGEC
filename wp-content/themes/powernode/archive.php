 <?php
/**
 * The template for displaying all posts and attachments
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

get_header(); 

do_action( 'powernode_before_main_content' );

do_action( 'powernode_before_loop_post' );

while ( have_posts() ) : the_post();

	get_template_part( 'template-parts/post-loop/layout', get_post_format() );

endwhile;

do_action( 'powernode_after_loop_post' );

do_action( 'powernode_loop_pagination' );

do_action( 'powernode_after_main_content' );
	
get_footer();