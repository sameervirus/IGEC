<?php
/**
*	Register segment content type
*/
function powernodewt_segment_post_type() {
	
	$singular_name = get_option('segment-singular-name', 'Segment');
	$name = get_option('segment-name', 'Segment');
	$slug = get_option('segment-slug', 'segment');
	$category_name = sprintf( __('%s Categories','powernodewt-core'), $singular_name );
	$categories_name = sprintf( __('%s Categories','powernodewt-core'), $singular_name );
	$category_slug = get_option('powernode-segment-categories', 'segment-cat');
	$skill_name = sprintf( __('%s Skill','powernodewt-core'), $singular_name );
	$skills_name = sprintf( __('%s Skills','powernodewt-core'), $singular_name );
	$skill_slug = get_option('powernode-segment-skill', 'segment-skill');
	
	$args = array(
		'labels' 				=> powernodewt_posttype_labels( $singular_name, $name ),
		'menu_icon'				=> 'dashicons-images-alt2',
		'public' 				=> true,
		'has_archive' 			=> true,
		'with_front'            => true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export' 			=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'show_in_menu' 			=> true,
		'show_in_rest' 			=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'powernodewt_core_segment_slug', $slug ) ),
		'supports' 				=> array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'elementor' ),
	);
	
	register_post_type( 'segment', $args );
	
	register_taxonomy( 'segment-cat', 'segment', array(
		'hierarchical' 			=> true,
		'labels' 				=> powernodewt_texonomy_labels( $category_name, $categories_name ),
		'exclude_from_search' 	=> true,
		'public' 				=> true,
		'show_ui' 				=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'powernodewt_core_segment_cat_slug', $category_slug ) ),
		'menu_icon' 			=> 'dashicons-images-alt2',
		'supports' 				=> array('title', 'editor'),
		'query_var' 			=> true,
		'show_in_nav_menus' 	=> false,
		'show_admin_column'     => true,
		'show_tagcloud'         => true,
		'show_in_rest'			=> true,
	) );
}	
add_action( 'init', 'powernodewt_segment_post_type' );

/**
 *	Single Segment Sidebar
 */
register_sidebar( array(
	'name'          => __( 'Single Segment Sidebar', 'powernodewt' ),
	'id'            => 'single-segment-sidebar',
	'description'   => 'Single Segment Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
	'before_widget' => '<div id="%1$s" class="sidebar-widget sidebar-div mb-50 %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h6 class="widget-title">',
	'after_title'   => '</h6>'
) );

/**
 *	Segment Sidebar
 */
register_sidebar( array(
	'name'          => __( 'Segment Sidebar', 'powernodewt' ),
	'id'            => 'segment-sidebar',
	'description'   => 'Segment Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
	'before_widget' => '<div id="%1$s" class="sidebar-widget sidebar-div mb-50 %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h6 class="widget-title">',
	'after_title'   => '</h6>'
) );


/**
 *	Segment Main Meta Boxes
 */

if( ! function_exists( 'powernodewt_segment_main_metaboxes' ) ) {
	
    function powernodewt_segment_main_metaboxes( $posttypes )
    {
		if( !empty( $posttypes ) ) {
			$posttypes = array_merge( $posttypes, array( 'segment' ) );
		}
		return $posttypes;
    }
}
add_filter( 'powernode_main_metaboxes_post_types', 'powernodewt_segment_main_metaboxes' );

/**
 *	Segment Meta Boxes Content
 */
if( ! function_exists( 'powernodewt_segment_meta_boxes_content' ) )
{
    function powernodewt_segment_meta_boxes_content( $array )
    {
		$prefix = POWERNODEWT_PREFIX;
		
		if( !empty( $array ) ) {
			$segment_meta[] =  array(
				'id'       => "{$prefix}segment_settings",
				'title'    => esc_html__( 'Segment', 'powernodewt' ),
				'pages'    => 'segment',
				'context'  => 'normal',
				'autosave' => true,
				'fields'   => array(
					array(
						'name'			=> esc_html__( 'Segment Layout', 'powernodewt' ),
						'id'			=> "{$prefix}segment_single_layout",
						'type'			=> 'select_advanced',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'powernodewt' ),
											'compact' 		=> esc_html__( 'Compact', 'powernodewt' ),
										),
						'placeholder'	=> 'Default',
					),
					array(
						'id'      => "{$prefix}segment_show_categories",
						'type'    => 'radio',
						'name'    => __( 'Show Categories?', 'powernodewt' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'powernodewt'),
							'0'  => __('No', 'powernodewt'),
						),
					),
					array(
						'id'      => "{$prefix}segment_show_title",
						'type'    => 'radio',
						'name'    => __( 'Show Title?', 'powernodewt' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'powernodewt'),
							'0'  => __('No', 'powernodewt'),
						),
					),
					array(
						'id'      => "{$prefix}segment_show_share",
						'type'    => 'radio',
						'name'    => __( 'Show Social Share?', 'powernodewt' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'powernodewt'),
							'0'  => __('No', 'powernodewt'),
						),
					),
					array(
						'id'      => "{$prefix}segment_show_related",
						'type'    => 'radio',
						'name'    => __( 'Show Related Segment?', 'powernodewt' ),
						'std'     => '0',
						'options' => array(
							'1' => __('Yes', 'powernodewt'),
							'0'  => __('No', 'powernodewt'),
						),
					),
				),
			);
			
			
			$array = array_merge( ( $segment_meta ), $array );
		}
		return $array;
    }
}
add_filter( 'powernode_meta_boxes_content', 'powernodewt_segment_meta_boxes_content' );


/*
 * Segment/Post
 */
add_action( 'powernode_before_segment_loop_post', 'powernodewt_before_segment_loop_post', 10 );
add_action( 'powernode_after_segment_loop_post', 'powernodewt_after_segment_loop_post', 10 );
add_action( 'powernode_after_segment_loop_post', 'powernodewt_after_loop_post_reset', 999 );
add_action( 'powernode_segment_loop_pagination', 'powernodewt_segment_loop_post_pagination', 10 );
add_action( 'wp_enqueue_scripts', 'powernodewt_segment_loop_post_theme_js' );
add_action( 'powernode_before_segment_loop_post_start', 'powernodewt_before_segment_loop_post_start', 10 );


/**
 * Loop Segment : Start Wrapper
 */
if ( ! function_exists( 'powernodewt_before_segment_loop_post' ) ) {
	
	function powernodewt_before_segment_loop_post() {
		
		do_action( 'powernode_before_segment_loop_post_start' );
		
		echo '<div '.powernodewt_segment_loop_post_wrapper_atts() .'>';
		
		do_action( 'powernode_after_segment_loop_post_start' );
		
	}
}

/**
 * Loop Segment : End Wrapper
 */
if ( ! function_exists( 'powernodewt_after_segment_loop_post' ) ) {
	
	function powernodewt_after_segment_loop_post() {
		
		do_action( 'powernode_before_segment_loop_post_end' );
		
		echo '</div>';
		
		do_action( 'powernode_after_segment_loop_post_end' );
		
	}
}

/**
 * Segment Loop Wrapper Classes
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_wrapper_classes' ) ) {

	function powernodewt_segment_loop_post_wrapper_classes( $class = '' ) {
		
		$classes = array();
		$classes[] = 'segment-posts';
		
		$view_type = powernodewt_segment_loop_view_type();
		$classes[] = 'view-'.$view_type;
		$classes[] = 'segment-'.$view_type;
		
		$classes[] = 'segment-style-'.powernodewt_get_loop_prop( 'powernode_segment_loop_post_style' );
		
		if ( in_array( $view_type, array( 'slider', 'micro-slider' ) )  ) {
			
			$classes[] = 'items-cen-cont';
			$classes[] = 'pnwt-owl-slider';
			$classes[] = 'owl-carousel';
			$classes[] = 'nav-on-hover';
			$classes = array_merge( $classes, powernodewt_get_nav_classes( array( 'slider_nav' => powernodewt_get_loop_prop( 'powernode_segment_loop_slider_nav' ), 'slider_nav_position' => powernodewt_get_loop_prop( 'powernode_segment_loop_slider_nav_position' ), 'slider_nav_style' => powernodewt_get_loop_prop( 'powernode_segment_loop_slider_nav_style' ) ) ) );

		} else {
			
			if ( $view_type == 'grid' ) {
				$segment_grid_columns = powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_lg', 2 );
				$classes[] = 'row';
				$classes[] = 'segment-grid-'.$segment_grid_columns.'cols';
			}
			
			if ( powernodewt_is_segment_archive() && in_array( powernodewt_segment_loop_post_pagination_style(), array( 'infinite-scroll', 'load-more' ) ) ) {
				$classes[] = 'infinite-scroll-wrap';
			}
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}

		// Filter secondary div class names.
		$classes = apply_filters( 'powernode_segment_loop_post_wrapper_classes', $classes, $class );

		$classes = array_map( 'sanitize_html_class', $classes );

		return array_unique( $classes );
		
	}

}

/**
 * Segment Loop Wrapper Attributes
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_wrapper_atts' ) ) {

	function powernodewt_segment_loop_post_wrapper_atts() {

		$atts = array();
		
		$post_style = powernodewt_get_loop_prop( 'powernode_segment_loop_post_style', true );
		

		$atts['id'] = ( $post_style == 'box' ) ? 'gallery-4' : 'segment-1';
		$view_type = powernodewt_segment_loop_view_type();
		if ( in_array( $view_type, array( 'gallery-filter' ) )  ) {
			$atts['id'] = 'gallery-3';
		}
		$atts['class'] = powernodewt_stringify_classes( powernodewt_segment_loop_post_wrapper_classes() );
		
		$p_atts = array(
			'view_type'			=> powernodewt_segment_loop_view_type(),
			'slider_nav'		=> powernodewt_get_loop_prop( 'powernode_segment_loop_slider_nav', true ),
			'slider_loop'		=> powernodewt_get_loop_prop( 'powernode_segment_loop_slider_loop', false ),
			'slider_autoplay' 	=> powernodewt_get_loop_prop( 'powernode_segment_loop_slider_autoplay', false ),
			'slider_dots' 		=> powernodewt_get_loop_prop( 'powernode_segment_loop_slider_dots', false ),
			'items_col_lg' 		=> powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_lg' ),
			'items_col_md' 		=> powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_md' ),
			'items_col_sm' 		=> powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_sm' ),
			'items_col_xs' 		=> powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_xs' ),
			'items_col_xxs' 	=> powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_xxs', 1 ),
		);

		$atts = array_merge( $atts, powernodewt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'powernode_segment_loop_post_wrapper_atts', $atts );
		
		return powernodewt_stringify_atts( $atts );
		
	}
	
}

/**
 * Segment Loop Segment Classes
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_classes' ) ) {

	function powernodewt_segment_loop_post_classes( $class = '' ) {
		
		$classes = array();		
		$display_type = powernodewt_get_loop_prop( 'powernode_segment_loop_display_type' );
		$view_type = powernodewt_segment_loop_view_type();
		if ( in_array( $view_type, array( 'slider', 'micro-slider' ) )  ) {
			$classes[] = 'slider-item';
		} else {
			
			if ( in_array( $view_type, array( 'gallery-filter' ) )  ) {
				$segment_cat = get_the_terms( get_the_ID(), 'segment-cat' );
				if( !empty( $segment_cat ) ) {
					$cat_ar = array_column( get_the_terms( get_the_ID(), 'segment-cat' ), 'slug');
					$classes[] = 'masonry-image';
					$classes[] = ( !empty( $cat_ar ) ) ? implode( ' ', $cat_ar ) : '';
				}
			}
			
			$nums_rows = powernodewt_get_loop_prop('nums_rows');
			$classes[] = 'item-entry';
			$classes[] = $display_type . '-item-entry';
			if ( in_array( $view_type, array( 'grid', 'gallery-filter' ) ) ) {
				$classes[] = powernodewt_cols_class( 'lg', powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_lg' ) );
				$classes[] = powernodewt_cols_class( 'md', powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_md' ) );
				$classes[] = powernodewt_cols_class( 'sm', powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_sm' ) );
				$classes[] = powernodewt_cols_class( 'xs', powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_xs' ) );
				$classes[] = powernodewt_cols_class( 'xxs', powernodewt_get_loop_prop( 'powernode_segment_loop_items_col_xxs' ) );
			}
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			// Ensure that we always coerce class to being an array.
			$class = array();
		}
		
		
		$classes = array_merge( $classes, get_post_class() );

		// Filter secondary div class names.
		$classes = apply_filters( 'powernode_segment_loop_post_wrapper_classes', $classes, $class );

		//$classes = array_map( 'sanitize_html_class', $classes );

		return array_unique( $classes );
		
	}

}

/**
 * Segment Loop Segment Attributes
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_atts' ) ) {

	function powernodewt_segment_loop_post_atts() {

		$atts = array();

		$atts['class'] = powernodewt_segment_loop_post_classes();
		
		$p_atts = array(
			'id'			=> 'post-'.get_the_ID(),
		);

		$atts = array_merge( $atts, powernodewt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'powernode_segment_loop_post_atts', $atts );
		
		return powernodewt_stringify_atts( $atts );
		
	}
	
}
 
/**
 * Segment Loop View Type
 */
if ( ! function_exists( 'powernodewt_segment_loop_view_type' ) ) {

	function powernodewt_segment_loop_view_type() {
		
		$view_type = powernodewt_get_loop_prop( 'powernode_segment_loop_view_type' );
		// powernodewt_debug_to_console($view_type);
		if ( empty( $view_type ) ) {
			$view_type = get_theme_mod( 'powernode_segment_loop_view_type', 'slider' );
		}
		
		return apply_filters( 'powernode_segment_loop_view_type', $view_type );
	}
}

/**
 * Post : Related Segment
 */
if ( ! function_exists( 'powernodewt_post_related_segment' ) ) {
	
	function powernodewt_post_related_segment( $args = array() ) {
		
		$show_related = powernodewt_get_post_meta( 'segment_show_related' );
		if ( empty( $show_related ) ) {
			$show_related = get_theme_mod( 'powernode_segment_single_post_related_posts', true );
		}
		if( !$show_related ) return;
		
		// Only display for standard posts.
		if ( !function_exists( 'powernodewt_segment' ) || get_post_type() !== 'segment' ) {
			return;
		}
		
		// Args
		$taxonomy = get_theme_mod( 'powernode_segment_single_post_related_posts_taxonomy', 'segment-cat' );
		$taxonomy = $taxonomy ? $taxonomy : 'segment-cat';

		$default_args = array(
			'post_type'      		=> 'segment',
			'post_status'        	=> array('publish'),
			'ignore_sticky_posts'	=> true,
			'order'					=> 'date',
			'posts_per_page' 		=> apply_filters( 'powernode_segment_single_post_related_posts_number', absint( get_theme_mod( 'powernode_segment_single_post_related_posts_number', '6' ) ) ),
			'orderby'        		=> 'rand',
			'no_found_rows'  		=> true,
		);
		
		$args = wp_parse_args( $args, $default_args );

		$terms     = wp_get_post_terms( get_the_ID(), $taxonomy );
		$terms_ids = array();
		foreach ( $terms as $term ) {
			$terms_ids[] = $term->term_id;
		}

		if( !empty( $terms_ids ) ){
			$args['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'operator' => 'IN',
					'terms' => $terms_ids
				)
			);
		}

		$args = apply_filters( 'powernode_segment_single_post_related_posts_query_args', $args );
				
		$atts = array(); 
		$atts['query_args'] 			= $args;
		$atts['title'] 					= esc_html__( 'Related Segment', 'powernodewt' );
		$atts['exclude_posts'] 			= array( get_the_ID() );
		$atts['view_type'] 				= 'slider';
		$atts['items_col_lg'] 			= apply_filters( 'powernode_segment_single_post_related_posts_columns', absint( get_theme_mod( 'powernode_segment_single_post_related_posts_columns', '2' ) ) );
		$atts['segment_loop_post_content']  = '';
		$atts['el_classes'] 				= 'related-segment';
		
		if ( is_singular( 'segment' ) )  {
			$atts['segment_loop_post_style'] = get_theme_mod( 'powernode_segment_single_post_related_style', 'slider' );
			$atts['segment_loop_post_content'] = get_theme_mod( 'powernode_segment_single_post_related_content', 'hidden' );
			$atts['segment_loop_post_excerpt_length'] = get_theme_mod( 'powernode_segment_single_post_related_excerpt_length', 20 );
			$atts['segment_loop_post_read_more'] = get_theme_mod( 'powernode_segment_single_post_related_read_more', 'icon' );
			$atts['segment_loop_post_remove_items_padding'] = get_theme_mod( 'powernode_segment_single_related_remove_items_padding', 'box' );
		}
		
		echo powernodewt_segment( $atts );
		
		//powernodewt_get_template( 'template-parts/post/related-posts', $args );		
	}
	
}

/**
 * Returns segment meta
 */
if ( ! function_exists( 'powernodewt_segment_post_meta' ) ) {

	function powernodewt_segment_post_meta() {

		$sections = array( 'categories' );
		$option_name = 'powernode_segment_loop_post_meta';
		
		if ( is_singular( 'segment' ) ) {
			$option_name = 'powernode_segment_single_post_meta';
		}

		$sections = powernodewt_get_loop_prop( $option_name, $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		$sections = apply_filters( $option_name, $sections );

		return $sections;

	}
}

/**
 * Returns the pagination style
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_pagination_style' ) ) {

	function powernodewt_segment_loop_post_pagination_style() {

		$style = get_theme_mod( 'powernode_segment_loop_post_pagination_style', 'default' );
		$style = apply_filters( 'powernode_segment_loop_post_pagination_style', $style );
		return $style;
	}

}

/**
 * Segment Gallery
 */
if ( ! function_exists( 'powernodewt_after_segment_loop_post_start' ) ) {

	function powernodewt_after_segment_loop_post_start() {
		
		$view_type = powernodewt_segment_loop_view_type();
		if ( $view_type == 'gallery-filter' ) {
			$html = '';
			$categories = powernodewt_categories( 'segment-cat' );
			unset($categories['']);
			if( !empty( $categories ) ) {
				$html .= '<div class="row">
							<div class="col-md-12 text-center">
								<div class="masonry-filter theme-filter ico-20 mb-50">
									<button data-filter="*" class="is-checked">All</button>';
				foreach( $categories as $key => $name ) {
					$html .= '<button data-filter=".'.$key.'">'.$name.'</button>';
				}
				$html .= '		</div>
							</div>
						  </div>';
			}
			echo $html;
		}
		//return apply_filters( 'powernode_segment_loop_view_type', $view_type );
	}
	
	add_action( 'powernode_after_segment_loop_post_start', 'powernodewt_after_segment_loop_post_start', 10 );
}

/**
 * Segment Gallery Filter
 */

if ( ! function_exists( 'powernodewt_segment_gallery_filter_start' ) ) {

	function powernodewt_segment_gallery_filter_start() {
		
		$view_type = powernodewt_segment_loop_view_type();
		$html = '';
		if ( $view_type == 'gallery-filter' ) {
			$html = '<div class="row">	
						<div class="col-md-12 gallery-items-list">
							<div class="masonry-wrap grid-loaded">';
			}
			echo $html;
	}
	
	add_action( 'powernode_after_segment_loop_post_start', 'powernodewt_segment_gallery_filter_start', 20 );
}

if ( ! function_exists( 'powernodewt_segment_gallery_filter_end' ) ) {

	function powernodewt_segment_gallery_filter_end() {
		
		$view_type = powernodewt_segment_loop_view_type();
		$html = '';
		if ( $view_type == 'gallery-filter' ) {
			$html = '</div></div></div>';
		}
		echo $html;
	}
	
	add_action( 'powernode_before_segment_loop_post_end', 'powernodewt_segment_gallery_filter_end', 20 );
}

/**
 * Loop Segment Pagination
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_pagination' ) ) {

	function powernodewt_segment_loop_post_pagination() {
		
		$style = powernodewt_segment_loop_post_pagination_style();
		
		// Category based settings
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term       = get_query_var( 'segment-cat' );
			$term_data  = get_option( 'category_'. $term );
			$term_style = $term_pagination = '';
			
			if ( isset( $term_data['powernode_term_style'] ) ) {
				$term_style = $term_data['powernode_term_style'] ? $term_data['powernode_term_style'] .'' : $term_style;
			}
			
			if ( isset( $term_data['powernode_term_pagination'] ) ) {
				$term_pagination = $term_data['powernode_term_pagination'] ? $term_data['powernode_term_pagination'] .'' : '';
			}
			
			if ( $term_pagination ) {
				$style = $term_pagination;
			}
			
		}
		
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			
			$args = array( 'style' => $style );
			$args['item-selector'] = '.'.powernodewt_get_loop_prop( 'powernode_segment_loop_display_type' ) . '-item-entry';
			
			// Last text
			$last = get_theme_mod( 'powernode_segment_loop_post_pagination_last_text' );
			$last = powernodewt_tm_translation( 'powernode_segment_loop_post_pagination_last_text', $last );
			$last = $last ? $last: esc_html__( 'End of content', 'powernodewt' );
			$args['last'] = $last;
			
			// Load more
			if ( $style == 'load-more' ) {
				$load_more = get_theme_mod( 'powernode_segment_loop_post_load_more_button_text' );
				$load_more = powernodewt_tm_translation( 'powernode_segment_loop_post_load_more_button_text', $load_more );
				$load_more = $load_more ? $load_more: esc_html__( 'More Posts', 'powernodewt' );
				$args['load_more'] = $load_more;
			
			}
			
			powernodewt_infinite_scroll( $args );
		} else {
			powernodewt_pagination();
		}

	}

}

/**
 * Loop Segment JS
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_theme_js' ) ) {

	function powernodewt_segment_loop_post_theme_js() {
		
		$style = powernodewt_segment_loop_post_pagination_style();
		
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			wp_enqueue_script( 'infinite-scroll', POWERNODEWT_JS_DIR_URI . 'third/' . 'infinite-scroll.pkgd.min.js', array( 'jquery' ) );
		}
	}
}

/**
 * Loop Segment Main Content
 */
if ( ! function_exists( 'powernodewt_before_segment_loop_post_start' ) ) {

	function powernodewt_before_segment_loop_post_start() {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ( !empty( $term->description ) ): ?>
		<div class="archive-description mb-4">
		  <?php echo esc_html($term->description); ?>
		</div>
		<?php endif;
	}
}