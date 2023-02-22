<?php
/**
 * @package PowerNodeWT/Elements
 * @widget : Portfolio
 * @version 1.0.0
 */
 
if ( ! function_exists( 'powernodewt_portfolio' ) ) :

	function powernodewt_portfolio( $atts ) {
		
		$wrapperClass = $css = $el_classes = '';
		
		$atts = shortcode_atts( array(
			'display_type' 						=> 'shortcode',
			'query_args'						=> array(),
			'title'								=> '',
			'categories'						=> '',
			'exclude_posts'						=> '',
			'orderby' 							=> 'name',
			'order' 							=> 'ASC',
			'limit'								=> '6',
			'nums_rows' 						=> '1',
			'animation'							=> '',
			'animation_delay'					=> '',
			'el_classes' 						=> '',
			'view_type' 						=> 'grid',
			'rows' 								=> '1',
			'slider_autoplay'		 			=> false,
			'slider_loop' 						=> false,
			'slider_nav'						=> true,
			'slider_nav_style'					=> 'cir',
			'slider_dots'						=> false,
			'slider_nav_position'				=> 'slider-middle',
			'items_col_lg' 						=> '3',
			'items_col_md' 						=> '3',
			'items_col_sm' 						=> '2',
			'items_col_xs' 						=> '2',
			'items_col_xxs' 					=> '1',
			'portfolio_loop_post_style' 					=> 'default',
			'portfolio_loop_post_thumbnail' 				=> true,
			'portfolio_loop_post_image_custom_dimension' 	=> array(),
			'portfolio_loop_post_fancy_date' 				=> false,
			'portfolio_loop_post_image_size' 			 	=> 'medium',
			'portfolio_loop_post_categories' 				=> true,
			'portfolio_loop_post_title' 					=> true,
			'portfolio_loop_post_content' 					=> 'excerpt',
			'portfolio_loop_post_excerpt_length' 			=> 30,
			'portfolio_loop_post_read_more' 				=> 'icon',
			'portfolio_loop_post_remove_items_padding' 		=> false,
			'css'											=> '',
		), $atts );
		extract( $atts );
	
		$atts['rows'] 						= ( in_array($atts['view_type'], array('grid') ) ) ? 1 : $atts['rows'];
				
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-portfolio-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element', 'portfolio-section', 'powernode-portfolio' );
		$args['wrap_atts']['class'][] 		= ( ! empty( $el_classes ) ) ? $el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
		
		if( $portfolio_loop_post_remove_items_padding == 'yes' ) {
			$args['wrap_atts']['class'][] = 'remove-items-padding';
			$args['wrap_atts']['class'][] = 'gallery-4-wrapper';
		}
		
		if( !empty( $animation ) ) {
			$args['wrap_atts']['class'][] = 'wow';
			$args['wrap_atts']['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $args['wrap_atts']['data-wow-delay'] = $animation_delay;
		}
				
		// Args
		if ( empty( $query_args ) ) {
			$query_args = array(
				'post_type'      		=> 'portfolio',
				'post_status'        	=> array('publish'),
				'posts_per_page'    	=> $limit,
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
						'taxonomy' => 'portfolio-cat',
						'field'    => 'term_id',
						'operator' => 'IN',
						'terms'    => $categories_ar
					)
				);
			}	
		}

		// Exclude Posts
		if( !empty( $exclude_posts ) ) {
			if( !is_array( $exclude_posts ) ) {
				$exclude_posts = explode( ',', $exclude_posts );	
			}
			if ( !empty( $exclude_posts ) ) {
				$query_args['post__not_in'] = $exclude_posts;	
			}
		}
				
		// Section Heading --------------------------
		if ( $title != '' ) {
			$wrap_classes[] = 'sec-title';
			$args['sec_heading'] =  ( $title != '' ) ? '<h2 class="sec-title">' . powernodewt_js_remove_wpautop( $title, true ) . '</h2>' : '';
		}
		
		// Section Content --------------------------
		$args['query'] = new WP_Query( $query_args );
		
		if( $portfolio_loop_post_style == 'box' ) {
			$post_sections_positioning = array( 'thumbnail', 'categories', 'title', 'content', 'social_links', 'meta', 'read-more' );
		} else {
			$post_sections_positioning = array( 'thumbnail', 'title', 'categories', 'content', 'social_links', 'meta', 'read-more' );
		}
		
		$unset_sections_positioning = array('social_links');
		if ( empty( $portfolio_loop_post_thumbnail ) ) $unset_sections_positioning[] = 'thumbnail';
		if ( empty( $portfolio_loop_post_title ) ) $unset_sections_positioning[] = 'title';
		if ( empty( $portfolio_loop_post_categories ) ) $unset_sections_positioning[] = 'categories';
		if ( empty( $portfolio_loop_post_content ) ) $unset_sections_positioning[] = 'content';
		if ( empty( $portfolio_loop_post_meta ) ) $unset_sections_positioning[] = 'meta';
		if ( empty( $portfolio_loop_post_read_more ) ) $unset_sections_positioning[] = 'read-more';
				
        $post_sections_positioning = array_diff( $post_sections_positioning, $unset_sections_positioning );
		
		$loop_prop = array (
			'powernode_portfolio_loop_display_type' 			=> $display_type,
			'powernode_portfolio_loop_view_type' 				=> $view_type,
			'powernode_portfolio_loop_post_style' 				=> $portfolio_loop_post_style,
			'powernode_portfolio_loop_slider_nav'				=> $slider_nav,
			'powernode_portfolio_loop_slider_nav_style'			=> $slider_nav_style,
			'powernode_portfolio_loop_slider_nav_position' 		=> $slider_nav_position,
			'powernode_portfolio_loop_slider_loop' 				=> $slider_loop,
			'powernode_portfolio_loop_slider_autoplay' 			=> $slider_autoplay,
			'powernode_portfolio_loop_slider_dots' 				=> $slider_dots,
			'powernode_portfolio_loop_items_col_lg'				=> $items_col_lg,
			'powernode_portfolio_loop_items_col_md' 			=> $items_col_md,
			'powernode_portfolio_loop_items_col_sm' 			=> $items_col_sm,
			'powernode_portfolio_loop_items_col_xs' 			=> $items_col_xs,
			'powernode_portfolio_loop_items_col_xxs' 			=> $items_col_xxs,
			'nums_rows' 										=> $rows,
			'powernode_portfolio_loop_post_sections_positioning' => $post_sections_positioning,
			'powernode_portfolio_loop_post_thumbnail' => $portfolio_loop_post_thumbnail,
			'powernode_portfolio_loop_post_meta' => array( 'categories' ),
		);
		
		if ( $portfolio_loop_post_thumbnail ) {
			$loop_prop['powernode_portfolio_loop_post_fancy_date'] = $portfolio_loop_post_fancy_date;
			$image_size = '';
			if ( $portfolio_loop_post_image_size == 'custom' && !empty( $portfolio_loop_post_image_custom_dimension['width'] ) && !empty( $portfolio_loop_post_image_custom_dimension['height'] )  ) {
				$image_size = $portfolio_loop_post_image_custom_dimension['width'].'x'.$portfolio_loop_post_image_custom_dimension['height'];
			} else {
				$image_size = $portfolio_loop_post_image_size;
			}
			$loop_prop['powernode_portfolio_loop_post_image_size'] = $image_size;
		}
		
		if ( $portfolio_loop_post_content != '' ) {
			$loop_prop['powernode_portfolio_loop_post_content'] = $portfolio_loop_post_content;
			$loop_prop['powernode_portfolio_loop_post_excerpt_length'] = $portfolio_loop_post_excerpt_length;
		}
		
		if ( !empty( $portfolio_loop_post_read_more ) ) {
			$loop_prop['powernode_portfolio_loop_post_read_more'] = $portfolio_loop_post_read_more;
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
		powernodewt_exts_get_template( 'shortcodes/portfolio', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'powernode_portfolio', 'powernodewt_portfolio' );