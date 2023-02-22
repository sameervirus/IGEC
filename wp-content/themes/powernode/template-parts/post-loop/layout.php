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

$blog_view_type = 'loop';

$sections = powernodewt_blog_loop_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}

if( !isset( $GLOBALS['items_count'] ) ) $GLOBALS['items_count'] = 0;

$view_type = powernodewt_get_loop_prop( 'powernode_blog_loop_view_type' );
$post_style = powernodewt_get_loop_prop( 'powernode_blog_loop_post_style' );

$nums_rows = powernodewt_get_loop_prop( 'nums_rows' );
if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && $GLOBALS['items_count'] % $nums_rows == 0 ) {
	echo '<div class="products">';
}

$sub_atts = array();
$sub_atts['class'] = array( 'entry-post', 'blog-post' );
if ( !in_array( $view_type, array( 'grid', 'micro_grid', 'slider' ) ) ) {
	$sub_atts['class'][] = 'b-bottom';
}

$content_args = array();
$content_args['class'] = array( 'entry-content-wrapper' );
if ( has_post_thumbnail() ) {
	if ( in_array( $view_type, array( 'list' ) ) ) {
		$content_args['class'][] = 'col-md-7';
	} else if ( in_array( $view_type, array( 'modern' ) ) ) {
		$content_args['class'][] = 'col-lg-5';	
	}
} else {
	$content_args['class'][] = 'col-md-12';	
}

if( $post_style == 'fancy' ) {
	$sub_atts['class'][] = 'blog-2-post';
} else if( $post_style == 'modern' ) {
	$sub_atts['class'][] = 'blog-3-post';
	$sub_atts['class'][] = 'theme-border';
} else if( $post_style == 'box' ) {
	$sub_atts['class'][] = 'blog-1-post';
	$content_args['class'][] = 'blog-post-txt';
}

$sections = array_values(array_filter($sections));

$GLOBALS['display_type'] = ( isset( $GLOBALS['display_type'] ) ) ?  $GLOBALS['display_type'] : 'loop';

if( ( $paged = (get_query_var('paged')) ? get_query_var('paged') : 1 ) && $paged == 1 ) {
	
	$flt_args = array( 'items_count' => $GLOBALS['items_count'], 'exclude_posts' => wp_list_pluck( $wp_query->posts, 'ID' ), 'display_type' => $GLOBALS['display_type'] );

	do_action( 'powernode_outer_before_loop_post_start', $flt_args );

	$sub_atts = apply_filters( 'powernode_loop_post_subatts', $sub_atts, $flt_args );
}
?>
<article <?php echo powernodewt_blog_loop_post_atts(); ?>>
	
	<?php do_action( 'powernode_after_loop_post_start' ); ?>
	
	<div <?php echo powernodewt_stringify_atts( $sub_atts ); ?>>
	<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '<div class="row entry-post-inner d-flex align-items-center">'; ?>
	<?php
		foreach ( $sections as $section ) :
				if ( $sections[0] == 'thumbnail' && $sections[1] == $section ) {
					echo '<div ' . powernodewt_stringify_atts( $content_args ) . '>';
				}
				get_template_part( 'template-parts/post-loop/'. $section  );

				if ( $sections[0] == 'thumbnail' && end($sections) == $section ) {
					echo '</div>';
				}
		endforeach; 
	?>
	<?php if ( in_array( $view_type, array( 'list', 'modern' ) ) ) echo '</div>'; ?>
	</div>
	<?php do_action( 'powernode_before_loop_post_end' ); ?>
</article>
<?php
do_action( 'powernode_outer_after_loop_post_end', array( 'items_count' => $GLOBALS['items_count'], 'exclude_posts' => wp_list_pluck( $wp_query->posts, 'ID' ) ) );

if ( $nums_rows > 1 && ( !in_array( $view_type, array( 'grid', 'micro_grid' ) ) ) && ( $GLOBALS['items_count'] % $nums_rows == ( $nums_rows-1 ) || ( $GLOBALS['items_count'] == ( $query->post_count - 1) ) ) ) {
	echo '</div>';
}
$GLOBALS['items_count']++;