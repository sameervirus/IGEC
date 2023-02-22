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

$sections = powernodewt_portfolio_loop_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}
global $items_count;
$view_type = powernodewt_portfolio_loop_view_type();
$post_style = powernodewt_get_loop_prop( 'powernode_portfolio_loop_post_style' );
$nums_rows = powernodewt_get_loop_prop( 'nums_rows' );
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && $items_count % $nums_rows == 0 ) {
	echo wp_kses_post( '<div class="products">' );
}

$sub_atts = array();
$sub_atts['class'] = array( 'entry-post', 'portfolio-post' );

$content_args = array();
$content_args['class'] = array( 'entry-content-wrapper' );
if ( has_post_thumbnail() ) {
	if ( in_array( $view_type, array( 'list' ) ) ) {
		$content_args['class'][] = 'col-md-7';
	} else if ( in_array( $view_type, array( 'modern' ) ) ) {
		$content_args['class'][] = 'col-lg-4';	
	}
}
$post_type = get_post_type();
if( $post_style == 'box' || $post_type == 'segment' ) {
	$sub_atts['class'][] = 'hover-overlay';
	$content_args['class'] = 'project-meta white-color';
} else {
	$sub_atts['class'][] = 'text-center gallery-image';
	$content_args['class'] = 'pt-2';
}
?>
<div <?php echo powernodewt_portfolio_loop_post_atts(); ?>>
<?php

if( ($post_style == 'box' && !empty( $sections )) || $post_type == 'segment') { ?>
	<div class="gallery-image">
		<div <?php echo powernodewt_stringify_atts( $sub_atts ); ?>>
		<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '<div class="row entry-post-inner d-flex align-items-center">'; ?>
		<?php echo ( in_array( 'thumbnail', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/thumbnail' ) : ''; ?>
		<div class="item-overlay"></div>

		<div <?php echo powernodewt_stringify_atts( $content_args ); ?>>
			<div class="project-meta-txt">
				<?php echo ( in_array( 'meta', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/meta' ) : ''; ?>
				<?php echo ( in_array( 'categories', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/categories' ) : ''; ?>
				<?php echo ( in_array( 'title', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/title' ) : ''; ?>
				<?php echo ( in_array( 'content', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/content' ) : ''; ?>
				<?php echo ( in_array( 'social-links', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/social-links' ) : ''; ?>
			</div>
			<?php echo ( in_array( 'read-more', $sections ) ) ? get_template_part( 'template-parts/portfolio-loop/read-more' ) : ''; ?>
		</div>
		<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '</div>'; ?>
		</div>
	</div>
<?php } else { ?>
	
	<div <?php echo powernodewt_stringify_atts( $sub_atts ); ?>>
	<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '<div class="row entry-post-inner d-flex align-items-center">'; ?>
	<?php		
		foreach ( $sections as $section ) :
	
				if ( $sections[0] == 'thumbnail' && $sections[1] == $section ) {
					echo '<div ' . powernodewt_stringify_atts( $content_args ) . '>';
				}
				get_template_part( 'template-parts/portfolio-loop/'. $section  );
				
				if ( $sections[0] == 'thumbnail' && end( $sections ) == $section ) {
					echo '</div>';
				}
		endforeach; 
	?>
	<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '</div>'; ?>
	</div>
<?php } ?>
</div>
<?php 
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && ( $items_count % $nums_rows == ( $nums_rows-1 ) || ( $items_count == ( $query->post_count - 1) ) ) ) {
	echo '</div>';
}
$items_count++;