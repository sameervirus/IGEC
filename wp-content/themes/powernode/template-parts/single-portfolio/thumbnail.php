<?php
/**
 * Single Post Layout
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$args = array();
$args['class'][] = 'entry-thumbnail-wrapper';
$args['class'][] = 'blog-post-img';
$args['class'][] = 'rel';

$image_size = powernodewt_get_loop_prop( 'powernode_blog_loop_post_image_size' );
$fancy_date = powernodewt_get_loop_prop( 'powernode_blog_loop_post_fancy_date' );
?>
<?php if ( has_post_thumbnail()) : ?>
<div <?php echo powernodewt_stringify_atts( $args ); ?>>
	<?php
	$post_image = powernodewt_get_image_html( array( 'attach_id' => get_post_thumbnail_id(), 'size' => $image_size, 'class' => 'col-xl-10 offset-xl-1 px-2'  ) );
	if ( !empty( $post_image ) ) {
		echo '<a href="' . esc_url( get_the_permalink() ) . '"> ' . wp_kses_post( $post_image ) . '</a>';
	}
	if ( $fancy_date ) {
		echo sprintf( '<div class="date-tag"><span class="date-time">%s</span></div>', esc_html( get_the_date( 'M d' ) ) );
	}
	?>
</div>
<?php endif; ?>