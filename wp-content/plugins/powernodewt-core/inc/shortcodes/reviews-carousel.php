<?php
/*
Element Description: Reviews Carousel
*/

if ( ! function_exists( 'powernodewt_reviews_carousel' ) ) :

	function powernodewt_reviews_carousel( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'items'							=> array(),
			'reviews_style'					=> 'review-3',
			'reviews_bg'					=> '',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'name_size'						=> 'h6',
			'name_font_size'				=> '',
			'name_custom_font_size'			=> '',
			'name_font_weight'				=> '',
			'name_font_style'				=> '',
			'name_text_transform'			=> '',
			'name_color'					=> '',
			'name_color_custom'				=> '',
			'name_line_height'				=> '',
			'name_letter_spacing'			=> '',
			'name_alignment'				=> 'left',
			'name_el_classes'				=> '',
			'title_size'					=> 'h5',
			'title_font_size'				=> '',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> '',
			'title_color_custom'			=> '',
			'title_line_height'				=> '',
			'title_letter_spacing'			=> '',
			'title_alignment'				=> 'left',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'title_el_classes'				=> '',
			'content_size'					=> 'p',
			'content_font_size'				=> '',
			'content_custom_font_size'		=> '',
			'content_font_weight'			=> '',
			'content_font_style'			=> '',
			'content_text_transform'		=> '',
			'content_color'					=> 'grey',
			'content_color_custom'			=> '',
			'content_line_height'			=> '',
			'content_letter_spacing'		=> '',
			'content_alignment'				=> 'left',
			'content_alignment_tablet'		=> '',
			'content_alignment_mobile'		=> '',
			'content_el_classes'			=> '',
			'items_col_lg'					=> '3',
			'items_col_md'					=> '3',
			'items_col_sm'					=> '2',
			'items_col_xs'					=> '1',
			'carousel_navigation'			=> '1',
			'carousel_infinite'				=> '1',
			'carousel_dots'					=> '0',
			'carousel_autoplay'				=> '1',
			'carousel_autoplay_speed'		=> '3500',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-reviews-carousel-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-reviews-carousel overflow-hidden';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= ( ! empty( $reviews_bg ) ) ? $reviews_bg : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content -----------------------------------------------------------------------------------------------
		
		$data_attr['id']		 			= $reviews_style;
		$data_attr['class'] 				= array( 'reviews-section', 'division' );
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] 			= 'wow';
			$data_attr['class'][] 			= $animation;
			$data_attr['class'][] 			= ( ! empty( $el_classes ) ) ? $el_classes : '';
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
			
			$image_size = '460x460';
			
			$items_car_atts = array();
			$items_car_atts['class'][] = 'pnwt-owl-slider reviews-wrapper';
			$items_car_atts['data-items'] = (int)$items_col_lg;
			$items_car_atts['data-items-lg'] = (int)$items_col_lg;
			$items_car_atts['data-items-md'] = (int)$items_col_md;
			$items_car_atts['data-items-sm'] = (int)$items_col_sm;
			$items_car_atts['data-items-xs'] = (int)$items_col_xs;
			$items_car_atts['data-nav'] = powernodewt_bool_text( (int)$carousel_navigation );
			$items_car_atts['data-infinite'] = powernodewt_bool_text( (int)$carousel_infinite );
			$items_car_atts['data-dots'] = powernodewt_bool_text( (int)$carousel_dots );
			$items_car_atts['data-autoplay'] = powernodewt_bool_text( (int)$carousel_autoplay );
			$items_car_atts['data-autoplay-speed'] = $carousel_autoplay_speed;
		
			$args['sec_content'] .= '<div class="pnwt-owl-slider-wrapper">';
				$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $items_car_atts ) . '>';
					foreach( $items as $k => $item ) {
						
						$image = $item['image'];
						$title = $item['title'];
						$name = $item['name'];
						$rating = $item['rating'];
						$content = $item['content'];
													
						// Image ---------------------------------------
						$image_content = '';
						if( !empty( $image['url'] ) ) {
							$image_content .= '<div class="rounded-circle review-img overflow-hidden">';	
							$image_content .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'size' => $image_size, 'class' => ''  ) ) :  '<img src="' . $image['url'] . '" />';
							$image_content .= '</div>';	
						}
						
						
						// Content -----------------------------------------
						$content_text = '';
						if( !empty( $content ) ) {
							$content_attr = array();
							$content_attr['class'] = array( 'review-content' );
							$content_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
							$content_attr['class'][] = ( !in_array( $content_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $content_font_weight : '';
							$content_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
							$content_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
							$content_attr['class'][] = ( !in_array( $content_alignment, array( '', 'left' ) ) ) ? 'text-' . $content_alignment : '';
							$content_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
							$content_attr['class'][] = ( ! empty( $content_el_classes ) ) ? $content_el_classes : '';
							
							if( in_array( $content_size, array( '', 'p' ) ) ) {
								$content_text .= '<p ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</p>';
							} else {
								$content_text .= '<'. $content_size .' ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</'. $content_size .'>';
							}
						}
						
						// Rating -----------------------------------------
						$rating_content = '';
						if( !empty( $rating ) ) {
							$rating_attr = array();
							$rating_attr['class'] = array( 'app-rating ico-20 yellow-color' );
							$rating_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ?  'fs-' . $content_font_size : '';
							$rating_attr['class'][] = ( !in_array( $content_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $content_font_weight : '';
							$rating_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
							$rating_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
							$rating_attr['class'][] = ( !in_array( $content_alignment, array( '', 'left' ) ) ) ? 'text-' . $content_alignment : '';
							$rating_attr['class'][] = ( ! empty( $content_el_classes ) ) ? $content_el_classes : '';
							
							if( $rating ) {
								$rating_cont = '';
								for ( $i = 1; $i<= 5; $i++ ) {
									if( $i <= $rating ) {
										$rating_cont .= '<span class="flaticon-star"></span>';
									} else {
										$rating_cont .= '<span class="flaticon-star-1"></span>';
									}
								}
							}
							
							$rating_content .= '<div ' . powernodewt_stringify_atts( $rating_attr ) . '>' . $rating_cont . '</div>';
						}
						
						// Name ----------------------------------------
						$name_content = '';
						if( !empty( $name ) ) {
							$name_attr = array();
							$name_attr['class'] = array('review-name');
							$name_attr['class'][] = ( !in_array( $name_font_size, array( '', 'custom' ) ) ) ? $name_size . '-' . $name_font_size : '';
							$name_attr['class'][] = ( !in_array( $name_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $name_font_weight : '';
							$name_attr['class'][] = ( !in_array( $name_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $name_font_style : '';
							$name_attr['class'][] = ( !in_array( $name_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $name_text_transform : '';
							$name_attr['class'][] = ( !in_array( $name_alignment, array( '', 'left' ) ) ) ? 'text-' . $name_alignment : '';
							$name_attr['class'][] = ( !in_array( $name_color, array( '', 'custom', 'default' ) ) ) ? $name_color . '-color' : '';
							$name_attr['class'][] = ( ! empty( $name_el_classes ) ) ? $name_el_classes : '';
							
							if( in_array( $name_size, array( '', 'h6' ) ) ) {
								$name_content .= '<h6 ' . powernodewt_stringify_atts( $name_attr ) . '>' . do_shortcode( $name ) . '</h6>';
							} else {
								$name_content .= '<'. $name_size .' ' . powernodewt_stringify_atts( $name_attr ) . '>' . do_shortcode( $name ) . '</'. $name_size .'>';
							}
						}
						
						// Title ----------------------------------------
						$title_content = '';
						if( !empty( $title ) ) {
							$title_attr = array();
							$title_attr['class'] = array('review-title');
							$title_attr['class'][] = ( !in_array( $title_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $title_size, $title_font_size ) : '';
							$title_attr['class'][] = ( !in_array( $title_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $title_font_weight : '';
							$title_attr['class'][] = ( !in_array( $title_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $title_font_style : '';
							$title_attr['class'][] = ( !in_array( $title_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $title_text_transform : '';
							$title_attr['class'][] = ( !in_array( $title_alignment, array( '' ) ) ) ? 'txt-' . $title_alignment : '';
							$title_attr['class'][] = ( !in_array( $title_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $title_alignment_tablet : '';
							$title_attr['class'][] = ( !in_array( $title_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $title_alignment_mobile : '';
							$title_attr['class'][] = ( !in_array( $title_color, array( '', 'custom', 'default' ) ) ) ? $title_color . '-color' : '';
							$title_attr['class'][] = ( ! empty( $title_el_classes ) ) ? $title_el_classes : '';
							
							if( in_array( $title_size, array( '', 'p' ) ) ) {
								$title_content .= '<p ' . powernodewt_stringify_atts( $title_attr ) . '>' . do_shortcode( $title ) . '</p>';
							} else {
								$title_content .= '<'. $title_size .' ' . powernodewt_stringify_atts( $title_attr ) . '>' . do_shortcode( $title ) . '</'. $title_size .'>';
							}
						}

						if(  $reviews_style == 'review-2' ) {
							$args['sec_content'] .= '<div class="'. $reviews_style . '">';
							$args['sec_content'] .= $rating_content;
							$args['sec_content'] .= $title_content;
							$args['sec_content'] .= '<div class="'. $reviews_style . '-txt">';
							$args['sec_content'] .= $content_text;
							$args['sec_content'] .= $name_content;
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= '</div>';
						
						} else {
							$args['sec_content'] .= '<div class="'. $reviews_style . '">';
							$args['sec_content'] .= '<div class="'. $reviews_style . '-txt">';
							$args['sec_content'] .= $content_text;
							$args['sec_content'] .= $rating_content;
							$args['sec_content'] .= $name_content;
							$args['sec_content'] .= $title_content;
							$args['sec_content'] .= '</div>';
							$args['sec_content'] .= '</div>';
						}
					}
					
					// Name ----------------------------------------
					
					$name_css_ar = array();
					if( $name_color == 'custom' ) $name_css_ar['color'] = $name_color_custom;
					if( $name_font_size == 'custom' ) $name_css_ar['font-size'] = $name_custom_font_size;
					if( $name_line_height != '' ) $name_css_ar['line-height'] = $name_line_height;
					if( $name_letter_spacing != '' ) $name_css_ar['letter-spacing'] = $name_letter_spacing;
					$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .review-name' => $name_css_ar ) );
					
					// Title ----------------------------------------
					
					$title_css_ar = array();
					if( $title_color == 'custom' ) $title_css_ar['color'] = $title_color_custom;
					if( $title_font_size == 'custom' ) $title_css_ar['font-size'] = $title_custom_font_size;
					if( $title_line_height != '' ) $title_css_ar['line-height'] = $title_line_height;
					if( $title_letter_spacing != '' ) $title_css_ar['letter-spacing'] = $title_letter_spacing;
					$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .review-title' => $title_css_ar ) );
					
					// Content -----------------------------------------
					
					$content_css_ar = array();
					if( $content_color == 'custom' ) $content_css_ar['color'] = $content_color_custom;
					if( $content_font_size == 'custom' ) $content_css_ar['font-size'] = $content_custom_font_size;
					if( $content_line_height != '' ) $content_css_ar['line-height'] = $content_line_height;
					if( $content_letter_spacing != '' ) $content_css_ar['letter-spacing'] = $content_letter_spacing;
					$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .review-content' => $content_css_ar ) );
					
				$args['sec_content'] .= '</div>';
			$args['sec_content'] .= '</div>';
			$args['sec_content'] .= '</div>';
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
		powernodewt_exts_get_template( 'shortcodes/image-carousel', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_image_carousel', 'powernodewt_image_carousel' );