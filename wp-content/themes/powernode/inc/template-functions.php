<?php
/**
 * Functions
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

/**
 * Sets up the powernodewt_loop global from the passed args or from the main query.
 */
function powernodewt_setup_loop( $args = array() ) {
	
	$default_args = array(
		'powernode_blog_loop_display_type' 			=> 'list',
		'powernode_blog_loop_view_type' 			=> get_theme_mod( 'powernode_blog_loop_view_type', 'list' ),
		'powernode_blog_loop_post_style' 			=> get_theme_mod( 'powernode_blog_loop_post_style', 'default' ),
		'powernode_blog_loop_items_col_lg' 			=> get_theme_mod( 'powernode_blog_loop_items_col_lg', 2 ),
		'powernode_blog_loop_items_col_md' 			=> get_theme_mod( 'powernode_blog_loop_items_col_md', 2 ),
		'powernode_blog_loop_items_col_sm' 			=> get_theme_mod( 'powernode_blog_loop_items_col_sm', 1 ),
		'powernode_blog_loop_items_col_xs' 			=> get_theme_mod( 'powernode_blog_loop_items_col_xs', 1 ),
		'powernode_blog_loop_items_col_xxs' 		=> get_theme_mod( 'powernode_blog_loop_items_col_xxs', 1 ),
		'powernode_blog_loop_post_sections_positioning' => get_theme_mod( 'powernode_blog_loop_post_sections_positioning', array( 'thumbnail', 'tags', 'title', 'content', 'meta', 'read-more' ) ),
		'powernode_blog_loop_post_meta' 			=> get_theme_mod( 'powernode_blog_loop_post_meta', array( 'author', 'date' ) ),
		'powernode_blog_loop_post_read_more' 		=> get_theme_mod( 'powernode_blog_loop_post_read_more', 'button' ),
		'powernode_blog_loop_post_image_size' 		=> get_theme_mod( 'powernode_blog_loop_post_image_size', 'large' ),
		'powernode_blog_loop_post_fancy_date'		=> get_theme_mod( 'powernode_blog_loop_post_fancy_date', false ),
		'powernode_blog_loop_post_content' 			=> get_theme_mod( 'powernode_blog_loop_post_content', 'excerpt' ),
		'powernode_blog_loop_post_excerpt_length' 	=> get_theme_mod( 'powernode_blog_loop_post_excerpt_length', '50' ),
		'slider_nav' 								=> true,
		'slider_nav_position' 						=> 'title-right',
		'slider_autoplay' 							=> false,
		'slider_loop' 								=> false,
		'slider_nav_style' 							=> 'cir',
		'slider_dots' 								=> true,
	);
	
	if ( in_array( $default_args['powernode_blog_loop_view_type'], array( 'full', 'list', 'modern' ) ) ) {
		$default_args['powernode_blog_loop_post_style'] = 'default';
	}
	
	if ( post_type_exists( 'portfolio' ) ) {
		
		$portfolio_default_args = array(
			'powernode_portfolio_loop_display_type' 			=> 'grid',
			'powernode_portfolio_loop_view_type' 				=> get_theme_mod( 'powernode_portfolio_loop_view_type', 'grid' ),
			'powernode_portfolio_loop_post_style' 				=> get_theme_mod( 'powernode_portfolio_loop_post_style', 'default' ),
			'powernode_portfolio_loop_items_col_lg' 			=> get_theme_mod( 'powernode_portfolio_loop_items_col_lg', 2 ),
			'powernode_portfolio_loop_items_col_md' 			=> get_theme_mod( 'powernode_portfolio_loop_items_col_md', 2 ),
			'powernode_portfolio_loop_items_col_sm' 			=> get_theme_mod( 'powernode_portfolio_loop_items_col_sm', 1 ),
			'powernode_portfolio_loop_items_col_xs' 			=> get_theme_mod( 'powernode_portfolio_loop_items_col_xs', 1 ),
			'powernode_portfolio_loop_items_col_xxs' 			=> get_theme_mod( 'powernode_portfolio_loop_items_col_xxs', 1 ),
			'powernode_portfolio_loop_post_sections_positioning' => get_theme_mod( 'powernode_portfolio_loop_post_sections_positioning', array( 'thumbnail', 'tags', 'title', 'meta', 'content', 'categories', 'social-links', 'read-more' ) ),
			'powernode_portfolio_loop_post_meta' 				=> get_theme_mod( 'powernode_portfolio_loop_post_meta', array( 'date', 'author' ) ),
			'powernode_portfolio_loop_post_read_more' 			=> get_theme_mod( 'powernode_portfolio_loop_post_read_more', 'icon' ),
			'powernode_portfolio_loop_post_image_size' 			=> get_theme_mod( 'powernode_portfolio_loop_post_image_size', 'large' ),
			'powernode_portfolio_loop_post_fancy_date'			=> get_theme_mod( 'powernode_portfolio_loop_post_fancy_date', true ),
			'powernode_portfolio_loop_post_content' 			=> get_theme_mod( 'powernode_portfolio_loop_post_content', 'excerpt' ),
			'powernode_portfolio_loop_post_excerpt_length' 		=> get_theme_mod( 'powernode_portfolio_loop_post_excerpt_length', '70' ),
		);
		$default_args = array_merge( $default_args, $portfolio_default_args );
	}
	
	if ( post_type_exists( 'segment' ) ) {
		
		$segment_default_args = array(
			'powernode_segment_loop_display_type' 				=> 'grid',
			'powernode_segment_loop_view_type' 					=> get_theme_mod( 'powernode_segment_loop_view_type', 'slider' ),
			'powernode_segment_loop_post_style' 				=> get_theme_mod( 'powernode_segment_loop_post_style', 'slider' ),
			'powernode_segment_loop_items_col_lg' 				=> get_theme_mod( 'powernode_segment_loop_items_col_lg', 2 ),
			'powernode_segment_loop_items_col_md' 				=> get_theme_mod( 'powernode_segment_loop_items_col_md', 2 ),
			'powernode_segment_loop_items_col_sm' 				=> get_theme_mod( 'powernode_segment_loop_items_col_sm', 1 ),
			'powernode_segment_loop_items_col_xs' 				=> get_theme_mod( 'powernode_segment_loop_items_col_xs', 1 ),
			'powernode_segment_loop_items_col_xxs' 				=> get_theme_mod( 'powernode_segment_loop_items_col_xxs', 1 ),
			'powernode_segment_loop_post_sections_positioning' 	=> get_theme_mod( 'powernode_segment_loop_post_sections_positioning', array( 'thumbnail', 'tags', 'title', 'meta', 'content', 'categories', 'social-links', 'read-more' ) ),
			'powernode_segment_loop_post_meta' 					=> get_theme_mod( 'powernode_segment_loop_post_meta', array( 'date', 'author' ) ),
			'powernode_segment_loop_post_read_more' 			=> get_theme_mod( 'powernode_segment_loop_post_read_more', 'icon' ),
			'powernode_segment_loop_post_image_size' 			=> get_theme_mod( 'powernode_segment_loop_post_image_size', 'large' ),
			'powernode_segment_loop_post_fancy_date'			=> get_theme_mod( 'powernode_segment_loop_post_fancy_date', true ),
			'powernode_segment_loop_post_content' 				=> get_theme_mod( 'powernode_segment_loop_post_content', 'excerpt' ),
			'powernode_segment_loop_post_excerpt_length' 		=> get_theme_mod( 'powernode_segment_loop_post_excerpt_length', '70' ),
		);
		$default_args = array_merge( $default_args, $segment_default_args );
	}

	// Merge any existing values.
	if ( isset( $GLOBALS['powernodewt_loop'] ) ) {
		$default_args = array_merge( $default_args, $GLOBALS['powernodewt_loop'] );
	}

	$GLOBALS['powernodewt_loop'] = wp_parse_args( $args, $default_args );
}
add_action( 'wp', 'powernodewt_setup_loop', 10 );

/**
 * Resets the powernodewt_loop global.
 */
function powernodewt_reset_loop() {
	unset( $GLOBALS['powernodewt_loop'] );
	unset( $GLOBALS['items_count'] );
}

/**
 * Gets a property from the powernodewt_loop global.
 */
function powernodewt_get_loop_prop( $prop, $default = '' ) {
	powernodewt_setup_loop(); // Ensure shop loop is setup.
	
	return isset( $GLOBALS['powernodewt_loop'], $GLOBALS['powernodewt_loop'][ $prop ] ) ? $GLOBALS['powernodewt_loop'][ $prop ] : $default;
}

/**
 * Sets a property in the powernodewt_loop global.
 */
function powernodewt_set_loop_prop( $prop, $value = '' ) {
	if ( ! isset( $GLOBALS['powernodewt_loop'] ) ) {
		powernodewt_setup_loop();
	}
	if ( is_array( $prop ) && !empty( $prop ) ) {
		foreach( $prop as $pk => $pv ) {
			$GLOBALS['powernodewt_loop'][ $pk ] = $pv;	
		}
	} else {
		$GLOBALS['powernodewt_loop'][ $prop ] = $value;	
	}
}

/**
 * Filters theme options
 */
function powernodewt_theme_mod( $name, $default = false ) {
	
	return apply_filters( $name, get_theme_mod( $name, $default ) );
}


/**
 * Display the post header with a link to the post
 */
if ( ! function_exists( 'powernodewt_excerpt_length' ) ) {
	function powernodewt_excerpt_length() {
		return get_theme_mod( 'powernode_excerpt_length', 40 );
	}
}

/**
 * Post : Header
 */
if ( ! function_exists( 'powernodewt_post_header' ) ) {
	function powernodewt_post_header() {
		get_template_part( 'template-parts/post/header' );
	}
}

/**
 * Post : Categories
 */	
if ( ! function_exists( 'powernodewt_post_categories' ) ) {
	function powernodewt_post_categories() {
		get_template_part( 'template-parts/post/categories' );
	}
}

/**
 * Post : Thumbnail
 */	
if ( ! function_exists( 'powernodewt_single_post_thumbnail' ) ) {
	function powernodewt_single_post_thumbnail() {
		get_template_part( 'template-parts/single-post/thumbnail', get_post_format() );
	}
}

/**
 * Post : Content
 */
if ( ! function_exists( 'powernodewt_post_content' ) ) {
	function powernodewt_post_content() {
		get_template_part( 'template-parts/post/content' );
	}
}

/**
 * Post : Category
 */
if ( ! function_exists( 'powernodewt_single_post_category' ) ) {
	function powernodewt_single_post_category() {
		get_template_part( 'template-parts/single-post/category' );		
	}
}

/**
 * Post : Title
 */
if ( ! function_exists( 'powernodewt_post_title' ) ) {
	function powernodewt_post_title() {
		get_template_part( 'template-parts/post/title' );		
	}
}

/**
 * Post : Meta
 */
if ( ! function_exists( 'powernodewt_post_meta' ) ) {
	function powernodewt_post_meta() {
		get_template_part( 'template-parts/post/meta' );		
	}
}

/**
 * Post : Author Info
 */
if ( ! function_exists( 'powernodewt_post_author_info' ) ) {
	function powernodewt_post_author_info() {
		get_template_part( 'template-parts/single-post/author-bio' );
	}
}

/**
 * Post : Post Tags
 */
if ( ! function_exists( 'powernodewt_post_tags' ) ) {
	function powernodewt_post_tags() {
		get_template_part( 'template-parts/post/tags' );
	}
}

/**
 * Post : Social Links
 */
if ( ! function_exists( 'powernodewt_post_social_links' ) ) {
	
	function powernodewt_post_social_links() {
		
		if ( is_single() ) {
			if ( !get_theme_mod( 'powernode_blog_single_post_social_share', true ) )	return;
		} else {
			if ( !get_theme_mod( 'powernode_blog_archive_post_tags', true ) )	return;
		}
		get_template_part( 'template-parts/post/social-buttons' );		
	}
	
}

/**
 * Post : Next/Prev Links
 */
if ( ! function_exists( 'powernodewt_post_next_prev' ) ) {
	
	function powernodewt_post_next_prev() {
		get_template_part( 'template-parts/post/next-prev' );		
	}
}

/**
 * Post : Related Posts
 */
if ( ! function_exists( 'powernodewt_post_related_posts' ) ) {
	
	function powernodewt_post_related_posts( $args = array() ) {
		
		// Only display for standard posts.
		if ( !function_exists( 'powernodewt_blog' ) || get_post_type() !== 'post' ) {
			return;
		}
		
		// Args
		$taxonomy = get_theme_mod( 'powernode_blog_single_post_related_posts_taxonomy', 'category' );
		$taxonomy = $taxonomy ? $taxonomy : 'category';

		$default_args = array(
			'posts_per_page' => apply_filters( 'powernode_blog_single_post_related_posts_number', absint( get_theme_mod( 'powernode_blog_single_post_related_posts_number', '6' ) ) ),
			'orderby'        => 'rand',
			'no_found_rows'  => true,
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
					'field' => 'id',
					'terms' => $terms_ids
				)
			);
		}

		$args = apply_filters( 'powernode_blog_single_post_related_posts_query_args', $args );
		
		$atts = array(); 
		$atts['display_type'] 			= 'related_posts';
		$atts['query_args'] 			= $args;
		$atts['sec_title'] 				= '';
		$atts['exclude_posts'] 			= array( get_the_ID() );
		$atts['view_type'] 				= 'slider';
		$atts['items_col_lg'] 			= apply_filters( 'powernode_blog_single_post_related_posts_columns', absint( get_theme_mod( 'powernode_blog_single_post_related_posts_columns', '2' ) ) );
		$atts['el_class'] 				= 'related-posts';
				
		if ( is_single() )  {
			$atts['blog_loop_post_style'] = get_theme_mod( 'powernode_blog_single_post_related_style', 'box' );
			$atts['blog_loop_post_content'] = get_theme_mod( 'powernode_blog_single_post_related_content', 'excerpt' );
			$atts['blog_loop_post_excerpt_length'] = get_theme_mod( 'powernode_blog_single_post_related_excerpt_length', 20 );
			$atts['blog_loop_post_read_more'] = get_theme_mod( 'powernode_blog_single_post_related_read_more', 'icon' );
		}

		echo powernodewt_blog( $atts );
	}
}

/**
 * Post : Comments
 */
if ( ! function_exists( 'powernodewt_post_comments' ) ) {
	function powernodewt_post_comments() {
		get_template_part( 'template-parts/post/comments' );
	}
}

/**
 * Post : Read More
 */
if ( ! function_exists( 'powernodewt_post_read_more' ) ) {
	function powernodewt_post_read_more() {
		get_template_part( 'template-parts/post/read-more' );
	}
}

/**
 * Loop Post : Start Wrapper
 */
if ( ! function_exists( 'powernodewt_before_loop_post' ) ) {
	function powernodewt_before_loop_post() {
		
		do_action( 'powernodewt_before_blog_loop_post_start' );
		
		echo '<div '.powernodewt_blog_loop_post_wrapper_atts() .'>';
		
		do_action( 'powernodewt_after_blog_loop_post_start' );
		
	}
}

/**
 * Loop Post : End Wrapper
 */
if ( ! function_exists( 'powernodewt_after_loop_post' ) ) {
	function powernodewt_after_loop_post() {
		
		do_action( 'powernodewt_before_blog_loop_post_end' );
		
		echo '</div>';
		
		do_action( 'powernodewt_after_blog_loop_post_end' );
	}
}

/**
 * Loop Post : Reset Looop
 */
if ( ! function_exists( 'powernodewt_after_loop_post_reset' ) ) {
	function powernodewt_after_loop_post_reset() {
		
		powernodewt_reset_loop();		
	}
}

/**
 * Page : Content
 */
if ( ! function_exists( 'powernodewt_template_page_content' ) ) {
	function powernodewt_template_page_content() {
		
		get_template_part( 'template-parts/page/content' );
	}
}

/**
 * Loop Post Pagination
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_pagination' ) ) {

	function powernodewt_blog_loop_post_pagination() {
		
		$style = powernodewt_blog_loop_post_pagination_style();
		
		// Category based settings
		if ( is_category() ) {
			
			// Get taxonomy meta
			$term       = get_query_var( 'cat' );
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
			$args['item-selector'] = '.'.powernodewt_get_loop_prop( 'powernode_blog_loop_display_type' ) . '-item-entry';
			
			// Last text
			$last = get_theme_mod( 'powernode_blog_loop_post_pagination_last_text' );
			$last = powernodewt_tm_translation( 'powernode_blog_loop_post_pagination_last_text', $last );
			$last = $last ? $last: esc_html__( 'End of content', 'powernode' );
			$args['last'] = $last;
			
			// Load more
			if ( $style == 'load-more' ) {
				$load_more = get_theme_mod( 'powernode_blog_loop_post_load_more_button_text' );
				$load_more = powernodewt_tm_translation( 'powernode_blog_loop_post_load_more_button_text', $load_more );
				$load_more = $load_more ? $load_more: esc_html__( 'More Posts', 'powernode' );
				$args['last'] = $load_more;
			
			}
			
			powernodewt_infinite_scroll( $args );
		} else {
			powernodewt_pagination();
		}
	}
}


/**
 * Get Post Types List
 */
if ( ! function_exists( 'powernodewt_get_post_type_posts' ) ) {

	function powernodewt_get_post_type_posts( $args = null, $select_option = '' ) {
		
		$results = array();
		
		if( !empty( $select_option ) ) {
			$results[] = $select_option;
		}
		
		$posts = get_posts( $args );
		if( !empty( $posts ) ) {
			foreach( $posts as $p ) {
				$results[$p->ID] = $p->post_title;
			}
		}
		
		return $results;
	}
}

/**
 * Is Verified
 */
if ( ! function_exists( 'powernodewt_is_license_verified' ) ) {
	function powernodewt_is_license_verified( $redirect = false ) {
		$verified = ( get_option( 'powernodewt_license_verified' ) && get_option( 'envato_purchase_code_39354794' ) ) ? true : false;
		if( !$verified && $redirect == true ) {
			wp_redirect(admin_url('?page=powernode-dashboard'));
		}
		return $verified;
	}
}

if ( ! function_exists( 'powernodewt_comments' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own powernodewt_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 */
function powernodewt_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p class="comment-body"><?php esc_html_e( 'Pingback:', 'powernode' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'powernode' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
    	<div class="comment">            
            <div class="media">            	
                <a href="<?php echo esc_url(get_comment_author_link()); ?>" class="pull-left"><?php echo get_avatar( $comment, 100 ); ?></a>
                <div class="media-body">
                	<h4 class="media-heading"><?php comment_author(); ?> <span><?php echo human_time_diff( get_comment_time( 'U' ), current_time('timestamp') ) . esc_html__(' ago', 'powernode'); ?></span></h4>
                    <span class="position-edit-links">
						<?php		
						edit_comment_link( esc_html__( 'Edit', 'powernode' ), '<span class="edit-link">', '</span>' );
						comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'powernode' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
						?>
                    </span>                   
                    <div class="comment-body"><?php comment_text(); ?></div>          
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'powernode' ); ?></p>
                    <?php endif; ?> 
                </div>
             </div>
         </div>							
	<?php
		break;
	endswitch; // end comment_type check
}
endif;