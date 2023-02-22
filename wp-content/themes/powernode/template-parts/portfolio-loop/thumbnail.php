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
//$thumbnail = apply_filters( 'powernode_portfolio_loop_post_thumbnail', powernodewt_get_loop_prop( 'powernode_portfolio_loop_post_thumbnail' ) );
//if( empty( $thumbnail ) ) return '';
$view_type = powernodewt_portfolio_loop_view_type();

$args = array();
$args['class'][] = 'entry-thumbnail-wrapper';
$args['class'][] = 'portfolio-post-img';
$args['class'][] = 'rel';
if ( ( in_array( $view_type, array( 'list' ) ) ) ) {
	$args['class'][] = 'col-md-5';
} else if ( ( in_array( $view_type, array( 'modern' ) ) ) ) {
	$args['class'][] = 'col-lg-8';
}

$image_size = powernodewt_get_loop_prop( 'powernode_portfolio_loop_post_image_size' );
$fancy_date = powernodewt_get_loop_prop( 'powernode_portfolio_loop_post_fancy_date' );
?>
<?php //if ( has_post_thumbnail()) : ?>
<div <?php echo powernodewt_stringify_atts( $args ); ?>>
	<div class="hover-overlay">
	<?php
	$post_image = ( !empty( get_post_thumbnail_id() ) ) ? powernodewt_get_post_thumbnail( $image_size ) : '<img src="' . powernodewt_placeholder_img_src( $image_size, POWERNODEWT_IMAGES_DIR_URI. 'placeholder-portfolio.png' ) . '" />';
	if ( !empty( $post_image ) ) {
		echo '<a href="' . esc_url( get_the_permalink() ) . '"> ' . wp_kses_post( $post_image ) . '</a>';
	}
	if ( $fancy_date ) {
		echo sprintf( '<div class="date-tag"><span class="date-time">%s</span></div>', esc_html( get_the_date( 'M d' ) ) );
	}
	?>
	</div>
</div>
<?php //endif; ?>
