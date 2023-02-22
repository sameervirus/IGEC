<?php
/**
 * Single Post Content
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$content_type = apply_filters( 'powernode_segment_loop_post_content', powernodewt_get_loop_prop( 'powernode_segment_loop_post_content' ) );
if( empty( $content_type ) ) return '';
if ( is_singular( 'post' ) && !in_array( $view_type, array('slider', 'grid') ) ) {
	$content_type = 'full';
}
?>
<div class="entry-content">
	<?php
	if ( $content_type == 'excerpt' ) {
		
		if ( has_excerpt() && ! empty( $post->post_excerpt ) ) {
			$content = get_the_excerpt();
		} else {
			$content = get_the_content();
		}
		$content = powernodewt_content_limit( $content, apply_filters( 'powernode_segment_loop_post_excerpt_length', powernodewt_get_loop_prop( 'powernode_segment_loop_post_excerpt_length' ) ) );
		
	} else {
		$content = get_the_content(); 
	}
	
	echo apply_filters( 'segment_loop_content', $content );
	
	if ( $content_type == 'full' ) {
		wp_link_pages(
			array(
				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'powernode' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			)
		);
	}
	?>	
</div>