<?php
/**
 * Display Post
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$read_more_style = powernodewt_get_loop_prop( 'powernode_blog_loop_post_read_more' );
$post_style = powernodewt_get_loop_prop( 'powernode_blog_loop_post_style' );
if( empty( $read_more_style ) ) return;
$classes =array( 'read-more-'.$read_more_style );
if( $read_more_style == 'button' ) {
	$classes[] = 'btn button btn-sm text-uppercase';
}
?>
<div class="entry-read-more <?php echo esc_attr( ( $post_style == 'gallery' || $read_more_style == 'icon' )? 'post-link ico-20' : '' ); ?>">
	<a href="<?php echo esc_url( get_permalink( get_the_ID() ) );?>" class="<?php echo powernodewt_stringify_classes( $classes ); ?>">
		<?php if( $read_more_style == 'icon' ) { ?>
		<span class="flaticon-right-arrow"></span>
		<?php } else { ?>
		<?php echo esc_html__( 'Read More', 'powernode' );?>
		<?php } ?>
	</a>
</div>