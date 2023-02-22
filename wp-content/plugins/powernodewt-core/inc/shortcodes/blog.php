<?php
/**
 * @package PowerNodeWT/Elements
 * @widget : Products
 * @version 1.0.0
 */
 
if ( ! function_exists( 'powernodewt_blog' ) ) :

	function powernodewt_blog( $atts ) {
		
		$atts = shortcode_atts(array(
			'display_type' 				=> 'shortcode',
			'query_args'				=> array(),
			'sec_title'					=> '',
			'categories'				=> '',
			'exclude_posts'				=> '',
			'orderby' 					=> 'name',
			'order' 					=> 'ASC',
			'limit'						=> '6',
			'nums_rows' 				=> '1',
			'animation'					=> '',
			'animation_delay'			=> '',
			'el_classes' 				=> '',
			'view_type' 				=> 'grid',
			'slider_autoplay'		 	=> false,
			'slider_loop' 				=> false,
			'slider_nav'				=> true,
			'slider_nav_style'			=> 'cir',
			'slider_dots'				=> false,
			'slider_nav_position'		=> 'slider-middle',
			'items_col_lg' 				=> '3',
			'items_col_md' 				=> '3',
			'items_col_sm' 				=> '2',
			'items_col_xs' 				=> '2',
			'items_col_xxs' 			=> '1',
			'blog_loop_post_style' 					=> 'fancy',
			'blog_loop_post_thumbnail' 				=> true,
			'blog_loop_post_image_custom_dimension' => array(),
			'blog_loop_post_fancy_date' 			=> false,
			'blog_loop_post_image_size' 			=> 'medium',
			'blog_loop_post_meta' 					=> true,
			'blog_loop_post_title' 					=> true,
			'blog_loop_post_content' 				=> 'excerpt',
			'blog_loop_post_tags' 					=> false,
			'blog_loop_post_excerpt_length' 		=> 30,
			'blog_loop_post_read_more' 				=> '',
			'wrap_id' 								=> '',
			'wrap_el_classes' 						=> '',
			'css'									=> '',
		), $atts);
	
		extract($atts);
		
		// Set Post style when view style is list etc.
		if( in_array( $view_type, array( 'list' ) ) ) {
			$blog_loop_post_style = 'default';
		}
		
		$atts['rows'] 						= ( in_array($atts['view_type'], array('grid') ) ) ? 1 :  $atts['nums_rows'];
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-blog-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element', 'blog-section', 'powernode-blog' );
		$args['wrap_atts']['class'][] 		= ( ! empty( $el_classes ) ) ? $el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
		
		if( !empty( $animation ) ) {
			$args['wrap_atts']['class'][] = 'wow';
			$args['wrap_atts']['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $args['wrap_atts']['data-wow-delay'] = $animation_delay;
		}
		
		// Args
		if ( empty( $query_args ) ) {
			$query_args = array(
				'post_type'          	=> 'post',
				'post_status'        	=> array('publish'),
				'posts_per_page'    	=> $atts['limit'],
				'ignore_sticky_posts'	=> true,
				'orderby'				=> $orderby,
				'order'					=> $order,
			);
		}
		
		// Categories
		$categories = trim($categories);
		if( !empty( $categories ) ){
			$categories_ar = explode(',', $categories);
			if( !empty( $categories_ar ) ){
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $categories_ar
					)
				);
			}	
		}
		
		// Exclude Posts
		if( !empty( $exclude_posts ) ) {
			if( !is_array( $exclude_posts ) ) {
				$exclude_posts_ar = explode( ',', $exclude_posts );	
			}
			if ( !empty( $exclude_posts_ar ) ) {
				$query_args['post__not_in'] = $exclude_posts_ar;	
			}
		}
				
		// Section Heading --------------------------
		if ( $sec_title != '' ) {
			$wrap_classes[] = 'sec-title';
			$args['sec_heading'] = $sec_title;
		}
		
		// Section Content --------------------------
		$args['query'] = new WP_Query( $query_args );
		
		$post_meta_positioning = array('author', 'date');

		if( $blog_loop_post_style == 'box' ) {
			$post_sections_positioning = array( 'thumbnail', 'title', 'tags', 'content' , 'social_links', 'meta', 'read-more' );
		} else if( $blog_loop_post_style == 'modern' ) {
			$post_sections_positioning = array( 'thumbnail', 'meta', 'title', 'content', 'tags' , 'social_links', 'read-more' );
			$post_meta_positioning = array('date');
		} else if( $blog_loop_post_style == 'fancy' ) {
			$post_sections_positioning = array( 'meta', 'thumbnail', 'title', 'content', 'tags', 'social_links', 'read-more' );
		} else if( in_array( $view_type, array( 'list' ) ) && in_array( $display_type, array( 'widget' ) )   ) {
			$post_sections_positioning = array( 'thumbnail', 'title', 'content', 'meta', 'tags', 'read-more' );
		} else {
			$post_sections_positioning = array( 'thumbnail', 'tags', 'title', 'content', 'meta', 'social_links', 'read-more' );
			$post_meta_positioning = array('author', 'date');
		}
		
		$unset_sections_positioning = array('social_links');
		if ( empty( $blog_loop_post_thumbnail ) ) $unset_sections_positioning[] = 'thumbnail';
		if ( empty( $blog_loop_post_title ) ) $unset_sections_positioning[] = 'title';
		if ( empty( $blog_loop_post_meta ) ) $unset_sections_positioning[] = 'meta';
		if ( empty( $blog_loop_post_content ) ) $unset_sections_positioning[] = 'content';
		if ( empty( $blog_loop_post_tags ) ) $unset_sections_positioning[] = 'tags';
		if ( empty( $blog_loop_post_read_more ) ) $unset_sections_positioning[] = 'read-more';
        $post_sections_positioning = array_diff( $post_sections_positioning, $unset_sections_positioning );
		
		$loop_prop = array (
			'powernode_blog_loop_display_type' 				=> $display_type,
			'powernode_blog_loop_view_type' 				=> $view_type,
			'powernode_blog_loop_post_style' 				=> $blog_loop_post_style,
			'powernode_blog_loop_slider_nav'				=> $slider_nav,
			'powernode_blog_loop_slider_nav_style'			=> $slider_nav_style,
			'powernode_blog_loop_slider_nav_position' 		=> $slider_nav_position,
			'powernode_blog_loop_slider_loop' 				=> $slider_loop,
			'powernode_blog_loop_slider_autoplay' 			=> $slider_autoplay,
			'powernode_blog_loop_slider_dots' 				=> $slider_dots,
			'powernode_blog_loop_items_col_lg'				=> $items_col_lg,
			'powernode_blog_loop_items_col_md' 				=> $items_col_md,
			'powernode_blog_loop_items_col_sm' 				=> $items_col_sm,
			'powernode_blog_loop_items_col_xs' 				=> $items_col_xs,
			'powernode_blog_loop_items_col_xxs' 			=> $items_col_xxs,
			'nums_rows' 									=> $nums_rows,
			'powernode_blog_loop_post_sections_positioning' => $post_sections_positioning,
			'powernode_blog_loop_post_meta' => $post_meta_positioning,
		);
		
		// Widget Set Meta
		if( in_array( $view_type, array( 'list' ) ) && in_array( $display_type, array( 'widget' ) )   ) {
			$loop_prop['powernode_blog_loop_post_meta'] = array('date');
		}
		
		if ( $blog_loop_post_thumbnail ) {
			$loop_prop['powernode_blog_loop_post_fancy_date'] = $blog_loop_post_fancy_date;
			$image_size = '';
			if ( $blog_loop_post_image_size == 'custom' && !empty( $blog_loop_post_image_custom_dimension['width'] ) && !empty( $blog_loop_post_image_custom_dimension['height'] )  ) {
				$image_size = $blog_loop_post_image_custom_dimension['width'].'x'.$blog_loop_post_image_custom_dimension['height'];
			} else {
				$image_size = $blog_loop_post_image_size;
			}
			$loop_prop['powernode_blog_loop_post_image_size'] = $image_size;
		}
				
		if ( $blog_loop_post_content ) {
			$loop_prop['powernode_blog_loop_post_content'] = $blog_loop_post_content;
			$loop_prop['powernode_blog_loop_post_excerpt_length'] = $blog_loop_post_excerpt_length;
		}
		
		if ( !empty( $blog_loop_post_read_more ) ) {
			$loop_prop['powernode_blog_loop_post_read_more'] = $blog_loop_post_read_more;
		}
		powernodewt_set_loop_prop( $loop_prop );
		
		if ( ! empty( $args['wrap_style_css'] ) ) {
			$args['wrap_atts']['style'] = powernodewt_stringify_classes( $args['wrap_style_css'] );
			unset( $args['wrap_style_css'] );
		}

		// Output CSS
		if ( ! empty( $css_output ) ) {
			powernodewt_exts_css_output( $css_output, $args );
		}
				
		$html = '';
		ob_start();
		powernodewt_exts_get_template( 'shortcodes/blog', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'powernode_blog', 'powernodewt_blog' );