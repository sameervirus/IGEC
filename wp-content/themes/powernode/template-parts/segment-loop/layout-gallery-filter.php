<?php
/**
 * Post Loop Layout
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$sections = powernodewt_segment_loop_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}

global $items_count;
$view_type = powernodewt_segment_loop_view_type();
$post_style = powernodewt_get_loop_prop( 'powernode_segment_loop_post_style' );
$nums_rows = powernodewt_get_loop_prop( 'nums_rows' );
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && $items_count % $nums_rows == 0 ) {
	echo '<div class="products">';
}

$sub_atts = array();
$sub_atts['class'] = array( 'entry-post', 'segment-post', 'hover-overlay' );
if( !in_array( $view_type, array( 'grid', 'micro_grid', 'slider' ) ) ) {
	$sub_atts['class'][] = 'b-bottom';
}

$content_args = array();
$content_args['class'] = array( 'entry-content-wrapper project-meta white-color' );
if ( has_post_thumbnail() ) {
	if ( in_array( $view_type, array( 'list' ) ) ) {
		$content_args['class'][] = 'col-md-7';
	} else if ( in_array( $view_type, array( 'modern' ) ) ) {
		$content_args['class'][] = 'col-lg-4';	
	}
}

if( $post_style == 'fancy' ) {
	$sub_atts['class'][] = 'segment-2-post';
} else if( $post_style == 'box' ) {
	$sub_atts['class'][] = 'segment-1-post';
	$content_args['class'][] = 'segment-post-txt';
}
?>
<div id="img-4-1" class="gallery-image">
	<div <?php echo powernodewt_segment_loop_post_atts(); ?>>
		<?php do_action( 'powernode_before_segment_loop_post' ); ?>

		<div <?php echo powernodewt_stringify_atts( $sub_atts ); ?>>
		<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '<div class="row entry-post-inner d-flex align-items-center">'; ?>
		<?php echo get_template_part( 'template-parts/segment-loop/thumbnail'  ); ?>
		<div class="item-overlay"></div>
			
		<div <?php echo powernodewt_stringify_atts( $content_args ); ?>>
			<div class="project-meta-txt">
				<?php echo get_template_part( 'template-parts/segment-loop/meta' ); ?>
				<?php echo get_template_part( 'template-parts/segment-loop/title' ); ?>
				<?php echo get_template_part( 'template-parts/segment-loop/content' ); ?>
			</div>
			<?php echo get_template_part( 'template-parts/segment-loop/read-more' ); ?>
		</div>
		<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '</div>'; ?>
		</div>
		<?php do_action( 'powernode_after_segment_loop_post' ); ?>
	</div>
</div>
<?php 
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && ( $items_count % $nums_rows == ( $nums_rows-1 ) || ( $items_count == ( $query->post_count - 1) ) ) ) {
	echo '</div>';
}
$items_count++;