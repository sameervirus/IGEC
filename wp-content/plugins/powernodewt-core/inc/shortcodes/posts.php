<?php
/**
 * @package PowerNodeWT/Elements
 * @shortcode : posts
 * @version 1.0.0
 */
 
if ( ! function_exists( 'powernodewt_posts' ) ) :

	function powernodewt_posts( $atts ) {
		$wrapperClass = $css = $el_classes = '';
		
		$atts = shortcode_atts(array(
			'display_type' 					=> 'shortcode',
			'posts_type'					=> 'post',
			'query_args'					=> array(),
			'title'							=> '',
			'categories'					=> '',
			'view_type'						=> '',
			'exclude_posts'					=> '',
			'orderby' 						=> 'name',
			'order' 						=> 'ASC',
			'limit'							=> '6',
			'nums_rows' 					=> '1',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'posts_thumbnail' 				=> true,
			'thumbnail_size'				=> 'medium',
			'thumbnail_custom_dimension'	=> array(),
			'posts_date' 					=> true,
			'posts_categories' 				=> false,
			'posts_title' 					=> true,
			'posts_content' 				=> '',
			'posts_excerpt_length' 			=> 20,
			'remove_list_border'			=> false,
			'image_rounded_cornors'			=> 'rounded',
			'image_el_classes'				=> '',
			'title_size'					=> 'p',
			'title_font_size'				=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> 'default',
			'title_alignment'				=> 'left',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'posts_title_length'    		=> '',
			'title_el_classes'				=> '',
			'content_size'					=> 'p',
			'content_font_size'				=> '',
			'content_font_weight'			=> '',
			'content_font_style'			=> '',
			'content_text_transform'		=> '',
			'content_color'					=> 'default',
			'content_alignment'				=> 'left',
			'content_alignment_tablet'		=> '',
			'content_alignment_mobile'		=> '',
			'content_el_classes'			=> '',
			'content_wrap_el_classes' 		=> '',
			'date_size'						=> 'p',
			'date_font_size'				=> '',
			'date_font_weight'				=> '',
			'date_font_style'				=> '',
			'date_text_transform'			=> '',
			'date_color'					=> 'default',
			'date_alignment'				=> 'left',
			'date_el_classes'				=> '',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'							=> '',
		), $atts);
		extract($atts);
		

		$atts['rows'] 						= ( in_array($atts['view_type'], array('grid') ) ) ? 1 :  $atts['nums_rows'];
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-posts-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element', 'posts-section', 'powernode-posts' );
		$args['wrap_atts']['class'][] 		= ( !empty( $remove_list_border ) ) ? 'removed-list-border' : '';
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
				'post_type'          	=> $posts_type,
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
		if ( $title != '' ) {
			$wrap_classes[] = 'sec-title';
			$args['sec_heading'] =  ( $title != '' ) ? '<h2 class="sec-title">' . powernodewt_js_remove_wpautop( $title, true ) . '</h2>' : '';
		}
		
		// Section Content --------------------------
		$query = new WP_Query( $query_args );
		
		// Section Content --------------------------
		
		if( !empty( $query ) ) {
			
			if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
			$data_attr['class'] 				= array( 'pnwt-posts', 'latest-news' );
			$data_attr['class'][] 				= ( ! empty( $el_classes ) ) ? $el_classes : '';
		

			$args['sec_content'] .= '<ul ' . powernodewt_stringify_atts( $data_attr ) . '>';
			
			while ( $query->have_posts() ) : $query->the_post();
				$item_attr		 					= array();
				$item_attr['class'] 				= array( 'clearfix d-flex align-items-center' );
				$args['sec_content'] .= '<li ' . powernodewt_stringify_atts( $item_attr ) . '>';
				
				// Thumbnail -------------------------------------
				
				$show_image_flag = false;
				
				if( has_post_thumbnail() && !empty( $posts_thumbnail ) ) {
					
					$image_size = '';
					if ( $thumbnail_size == 'custom' && !empty( $thumbnail_custom_dimension['width'] ) && !empty( $thumbnail_custom_dimension['height'] )  ) {
						$image_size = $thumbnail_custom_dimension['width'].'x'.$thumbnail_custom_dimension['height'];
					} else {
						$image_size = $thumbnail_size;
					}
					
					$image_attr = array();
					$image_attr['attach_id'] = get_post_thumbnail_id();
					$image_attr['size'] = $image_size;
					$image_attr['class'] = array( 'img-fluid', 'h-auto' );
					$image_attr['class'][] = $image_rounded_cornors;
					$image_attr['class'][] = ( ! empty( $image_el_classes ) ) ? $image_el_classes : '';
					$image_attr['class'] = powernodewt_stringify_classes( $image_attr['class'] );
					
					$post_image = powernodewt_get_image_html( $image_attr );
					
					if( !empty( $post_image ) ) { 
						$args['sec_content'] .= $post_image;
					}
					
					$show_image_flag = true;
				}
				
				$content_wrap_attr = array();
				$content_wrap_attr['class'] = array( 'post-summary' );
				$content_wrap_attr['class'][] = ( empty( $show_image_flag ) ) ? 'pl-0' : '';
				$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
				
				$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_wrap_attr ) . '>';
				
				// Title ----------------------------------------
		
				if( !empty( $posts_title ) ) {
					$title_attr = array();
					$title_attr['class'] = array( 'post-title' );
					$title_attr['class'][] = ( !in_array( $title_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $title_size, $title_font_size ) : '';
					$title_attr['class'][] = ( !in_array( $title_font_weight, array( '' ) ) ) ? 'fw-' . $title_font_weight : '';
					$title_attr['class'][] = ( !in_array( $title_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $title_font_style : '';
					$title_attr['class'][] = ( !in_array( $title_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $title_text_transform : '';
					$title_attr['class'][] = ( !in_array( $title_alignment, array( '' ) ) ) ? 'txt-' . $title_alignment : '';
					$title_attr['class'][] = ( !in_array( $title_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $title_alignment_tablet : '';
					$title_attr['class'][] = ( !in_array( $title_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $title_alignment_mobile : '';
					$title_attr['class'][] = ( !in_array( $title_color, array( '', 'custom', 'default' ) ) ) ? $title_color . '-color' : '';
					$title_attr['class'][] = ( ! empty( $title_el_classes ) ) ? $title_el_classes : '';
					$title_link = sprintf( '<a href="%s" rel="post">%s</a>', esc_url( get_permalink() ), ( ( !empty( $posts_title_length ) ) ? powernodewt_content_limit( get_the_title(), $posts_title_length ) : get_the_title() ) );
					
					if( in_array( $title_size, array( '', 'h5' ) ) ) {
						$args['sec_content'] .= '<h5 ' . powernodewt_stringify_atts( $title_attr ) . '>' . $title_link . '</h5>';
					} else {
						$args['sec_content'] .= '<'. $title_size .' ' . powernodewt_stringify_atts( $title_attr ) . '>' . $title_link . '</'. $title_size .'>';
					}
				}
				
				// Content -----------------------------------------
		
				if( !empty( $posts_content ) ) {
					$content_attr = array();
					$content_attr['class'] = array( 'post-content' );
					$content_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
					$content_attr['class'][] = ( !in_array( $content_font_weight, array( '' ) ) ) ? 'fw-' . $content_font_weight : '';
					$content_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
					$content_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
					$content_attr['class'][] = ( !in_array( $content_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $content_alignment_mobile : '';
					$content_attr['class'][] = ( !in_array( $content_alignment_tablet, array( '') ) ) ? 'txt-md-' . $content_alignment_tablet : '';
					$content_attr['class'][] = ( !in_array( $content_alignment, array( '' ) ) ) ? 'txt-' . $content_alignment : '';
					$content_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
					$content_attr['class'][] = ( ! empty( $content_el_classes ) ) ? $content_el_classes : '';
					
					if ( has_excerpt() && ! empty( $post->post_excerpt ) ) {
						$content = get_the_excerpt();
					} else {
						$content = get_the_content();
					}
					$content = powernodewt_content_limit( $content, $posts_excerpt_length );
					
					if( in_array( $content_size, array( 'p' ) ) ) {
						$content_size = 'div';
					}
					
					if( in_array( $content_size, array( '', 'p' ) ) ) {
						$args['sec_content'] .= '<p ' . powernodewt_stringify_atts( $content_attr ) . '>' . $content . '</p>';
					} else {
						$args['sec_content'] .= '<'. $content_size .' ' . powernodewt_stringify_atts( $content_attr ) . '>' . $content . '</'. $content_size .'>';
					}
				}
				
				// Date -----------------------------------------
		
				if( !empty( $posts_date ) ) {
					$date_attr = array();
					$date_attr['class'] = array( 'post-list-date' );
					$date_attr['class'][] = ( !in_array( $date_font_size, array( '', 'custom' ) ) ) ? $date_size . '-' . $date_font_size : '';
					$date_attr['class'][] = ( !in_array( $date_font_weight, array( '' ) ) ) ? 'fw-' . $date_font_weight : '';
					$date_attr['class'][] = ( !in_array( $date_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $date_font_style : '';
					$date_attr['class'][] = ( !in_array( $date_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $date_text_transform : '';
					$date_attr['class'][] = ( !in_array( $date_alignment, array( '', 'left' ) ) ) ? 'text-' . $date_alignment : '';
					$date_attr['class'][] = ( !in_array( $date_color, array( '', 'custom', 'default' ) ) ) ? $date_color . '-color' : '';
					$date_attr['class'][] = ( ! empty( $date_el_classes ) ) ? $date_el_classes : '';
					
					
					$date = get_the_date('M d, Y');
					
					
					if( in_array( $date_size, array( '', 'p' ) ) ) {
						$args['sec_content'] .= '<p ' . powernodewt_stringify_atts( $date_attr ) . '>' . $date . '</p>';
					} else {
						$args['sec_content'] .= '<'. $content_size .' ' . powernodewt_stringify_atts( $date_attr ) . '>' . $date . '</'. $date_size .'>';
					}
				}
				
				// Categories -----------------------------------------
		
				if( !empty( $posts_categories ) ) {
					
					$categories_list = get_the_category_list( esc_html__( ', ', 'powernodewt' ) );
					if( !empty( $categories_list ) ) {

						$args['sec_content'] .= '<span class="meta-cats">' . $categories_list . '</span>';
					}
				}
				
				$args['sec_content'] .= '</div>';
				
				$args['sec_content'] .= '</li>';
				
			endwhile;
			
			wp_reset_postdata();
			
			$args['sec_content'] .= '</ul>';
		}
	
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
		powernodewt_exts_get_template( 'shortcodes/posts', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'powernode_posts', 'powernodewt_posts' );