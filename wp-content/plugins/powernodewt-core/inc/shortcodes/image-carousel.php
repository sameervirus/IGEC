<?php
/*
Element Description: Image Carousel
*/

if ( ! function_exists( 'powernodewt_image_carousel' ) ) :

	function powernodewt_image_carousel( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'items'							=> array(),
			'image_box_style'				=> 'default',
			'animation'						=> '',
			'animation_delay'				=> '',
			'show_section_bg'				=> '1',
			'el_classes' 						=> '',
			'overlay_bg_color'				=> '#141414a6',
			'section_bg_color'				=> '#005cda',
			'section_bg_color2'				=> '#006cff',
			'image_rounded_cornors'			=> '',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'hover_overlay'					=> '1',
			'image_popup'					=> '1',
			'image_el_classes'				=> '',
			'title_size'					=> 'h5',
			'title_font_size'				=> '',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> 'default',
			'title_color_custom'			=> '',
			'title_line_height'				=> '',
			'title_letter_spacing'			=> '',
			'title_alignment'				=> '',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'title_el_classes'				=> '',
			'content_size'					=> 'p',
			'content_font_size'				=> '',
			'content_custom_font_size'		=> '',
			'content_font_weight'			=> '',
			'content_font_style'			=> '',
			'content_text_transform'		=> '',
			'content_color'					=> 'default',
			'content_color_custom'			=> '',
			'content_line_height'			=> '',
			'content_letter_spacing'		=> '',
			'content_alignment'				=> '',
			'content_alignment_tablet'		=> '',
			'content_alignment_mobile'		=> '',
			'content_el_classes'			=> '',
			'content_wrap_el_classes' 		=> '',
			'carousel_per_page'				=> '5',
			'carousel_per_page_tablet'		=> '3',
			'carousel_per_page_mobile'		=> '1',
			'carousel_navigation'			=> '1',
			'carousel_infinite'				=> '1',
			'carousel_dots'					=> '0',
			'carousel_autoplay'				=> '1',
			'carousel_autoplay_speed'		=> '3500',
			'carousel_center_mode'			=> '0',
			'carousel_variable_width'		=> '0',
			'remove_items_padding'			=> '0',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-image-carousel-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-image-carousel';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content -----------------------------------------------------------------------------------------------
		
		$data_attr['id']		 			= 'gallery-1';
		$data_attr['class'] 				= array( 'gallery-section', 'division' );
		$data_attr['class'][] 				= 'imgbx-s-' . ( ( !empty( $image_box_style ) ) ? $image_box_style : 'default' );
		$data_attr['class'][] 				= ( !empty( $show_section_bg ) ) ? 'bg-50' : '';
		$data_attr['class'][] 				= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] 			= 'wow';
			$data_attr['class'][] 			= $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';

			$gallery_car_atts = array();
			$gallery_car_atts['class'][] = 'gallery-carousel';
			$gallery_car_atts['class'][] = 'pnwt-slick-slider';
			$gallery_car_atts['class'][] = ( $remove_items_padding ) ? 'remove-items-padding' : '';
		
			$gallery_car_atts['data-items'] = (int)$carousel_per_page;
			$gallery_car_atts['data-items-md'] = (int)$carousel_per_page_tablet;
			$gallery_car_atts['data-items-sm'] = (int)$carousel_per_page_mobile;
			$gallery_car_atts['data-nav'] = powernodewt_bool_text( (int)$carousel_navigation );
			$gallery_car_atts['data-infinite'] = powernodewt_bool_text( (int)$carousel_infinite );
			$gallery_car_atts['data-dots'] = powernodewt_bool_text( (int)$carousel_dots );
			$gallery_car_atts['data-autoplay'] = powernodewt_bool_text( (int)$carousel_autoplay );
			$gallery_car_atts['data-autoplay-speed'] = $carousel_autoplay_speed;
			$gallery_car_atts['data-center-mode'] = powernodewt_bool_text( (int)$carousel_center_mode );
			$gallery_car_atts['data-variable-width'] = powernodewt_bool_text( (int)$carousel_variable_width );
		
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $gallery_car_atts ) . '>';
			foreach( $items as $k => $item ) {
				
				$image = $item['image'];
				$title = $item['title'];
				$content = $item['content'];
				
				$item_attr = array();
				$item_attr['class'] = array( 'car-item');
				$item_attr['class'][] = ( !empty( $icon_type ) ) ? 'icon-type-'. $icon_type : '';
				$item_attr['class'][] = ( $image_rounded_cornors ) ? $image_rounded_cornors : '';
				$item_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
				
				if( $image_box_style == 'style-2' ) { 
					$item_attr['class'][] = 'gallery-image';
				}
				
				if ( $image_box_style == 'style-1' ) {
					$item_attr['class'][] = 'fbox-13';
				} else {
					$item_attr['class'][] = 'fbox-10';
				}
				
				$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $item_attr ) . '>';
				
				if( !empty( $item['link']['url'] ) ) {
					$args['sec_content'] .= '<a ' . powernodewt_stringify_atts( powernodewt_get_url_data( $item['link'] ) ) . '>';
				}
						
				// Image ---------------------------------------

				if( !empty( $image ) ) {
					
					$image_attr = array();
					$image_attr['class'] = array( 'bx-img', 'bx-ico-img' );
					$image_attr['class'][] = ( !in_array( $image_alignment, array( '' ) ) ) ? 'txt-' . $image_alignment : '';
					$image_attr['class'][] = ( !in_array( $image_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $image_alignment_tablet : '';
					$image_attr['class'][] = ( !in_array( $image_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $image_alignment_mobile : '';
					$image_attr['class'][] = ( ! empty( $hover_overlay ) ) ? 'hover-overlay' : '';
					$image_attr['class'][] = ( ! empty( $image_el_classes ) ) ? $image_el_classes : '';
					
					$image_size = '';
					
					if ( $item['thumbnail_size'] == 'custom' && !empty( $item['thumbnail_custom_dimension']['width'] ) && !empty( $item['thumbnail_custom_dimension']['height'] )  ) {
						$image_size = $item['thumbnail_custom_dimension']['width'].'x'.$item['thumbnail_custom_dimension']['height'];
					} else {
						$image_size = $item['thumbnail_size'];
					}
								
					$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $image_attr ) . '>';
					$args['sec_content'] .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'size' => $image_size ) ) :  '<img src="' . $image['url'] . '" />';
					$args['sec_content'] .= '</div>';
					
					$image_css_ar = array();
					$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-img' => $image_css_ar ) );			
				}
				
				if( !empty( $title ) || !empty( $content ) ) {
						
					$content_wrap_attr = array();
					$content_wrap_attr['class'] = array();
					if( $image_box_style == 'style-1' ) {
						$content_wrap_attr['class'][] = 'fbox-13-txt';
					} else if( $image_box_style == 'style-2' ) { 
						$content_wrap_attr['class'][] = 'image-description';
					} else {
						$content_wrap_attr['class'][] = 'fbox-txt';
					}
					
					$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
					
					$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_wrap_attr ) . '>';
					
					// Image Gallery Style
					if( $image_box_style == 'style-2' ) { 
						
						$sub_content_wrap_attr = array();
						$sub_content_wrap_attr['class'] = array('image-data');
						$args['sec_content'] .= '<div class="item-overlay"></div>';
						$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $sub_content_wrap_attr ) . '>';
					}
							
					// Title ----------------------------------------
					
					if( !empty( $title ) ) {
						$title_attr = array();
						$title_attr['class'] = array( 'bx-title' );
						$title_attr['class'][] = ( !in_array( $title_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $title_size, $title_font_size ) : '';
						$title_attr['class'][] = ( !in_array( $title_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $title_font_weight : '';
						$title_attr['class'][] = ( !in_array( $title_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $title_font_style : '';
						$title_attr['class'][] = ( !in_array( $title_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $title_text_transform : '';
						$title_attr['class'][] = ( !in_array( $title_alignment, array( '' ) ) ) ? 'txt-' . $title_alignment : '';
						$title_attr['class'][] = ( !in_array( $title_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $title_alignment_tablet : '';
						$title_attr['class'][] = ( !in_array( $title_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $title_alignment_mobile : '';
						$title_attr['class'][] = ( !in_array( $title_color, array( '', 'custom', 'default' ) ) ) ? $title_color . '-color' : '';
						$title_attr['class'][] = ( ! empty( $title_el_classes ) ) ? $title_el_classes : '';
						
						if( in_array( $title_size, array( '', 'h5' ) ) ) {
							$args['sec_content'] .= '<h5 ' . powernodewt_stringify_atts( $title_attr ) . '>' . do_shortcode( $title ) . '</h5>';
						} else {
							$title_attr['class'][] = ( ! empty( $title_size ) ) ? $title_size . '-sm' : '';
							$args['sec_content'] .= '<'. $title_size .' ' . powernodewt_stringify_atts( $title_attr ) . '>' . do_shortcode( $title ) . '</'. $title_size .'>';
						}
					}
							
					// Content -----------------------------------------
					
					if( !empty( $content ) ) {
						$content_attr = array();
						$content_attr['class'] = array( 'bx-content' );
						$content_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
						$content_attr['class'][] = ( !in_array( $content_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $content_font_weight : '';
						$content_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
						$content_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
						$content_attr['class'][] = ( !in_array( $content_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $content_alignment_mobile : '';
						$content_attr['class'][] = ( !in_array( $content_alignment_tablet, array( '') ) ) ? 'txt-md-' . $content_alignment_tablet : '';
						$content_attr['class'][] = ( !in_array( $content_alignment, array( '' ) ) ) ? 'txt-' . $content_alignment : '';
						$content_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
						$content_attr['class'][] = ( ! empty( $content_el_classes ) ) ? $content_el_classes : '';
						
						if( in_array( $content_size, array( '', 'p' ) ) ) {
							$args['sec_content'] .= '<p ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</p>';
						} else {
							$args['sec_content'] .= '<'. $content_size .' ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</'. $content_size .'>';
						}
						
					}
					
					// Image Gallery Style
					if( $image_box_style == 'style-2' ) { 
						
						$args['sec_content'] .= '</div>';
					}
					
					$args['sec_content'] .= '</div>';
				}
				
				if( !empty( $item['link']['url'] ) ) {
					$args['sec_content'] .= '</a>';
				}
				
				$args['sec_content'] .= '</div>';
			}
					
			// Title ----------------------------------------
			
			$title_css_ar = array();
			if( $title_color == 'custom' ) $title_css_ar['color'] = $title_color_custom;
			if( $title_font_size == 'custom' ) $title_css_ar['font-size'] = $title_custom_font_size;
			if( $title_line_height != '' ) $title_css_ar['line-height'] = $title_line_height;
			if( $title_letter_spacing != '' ) $title_css_ar['letter-spacing'] = $title_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .ovr-title' => $title_css_ar ) );
			
			// Content -----------------------------------------
			
			$content_css_ar = array();
			if( $content_color == 'custom' ) $content_css_ar['color'] = $content_color_custom;
			if( $content_font_size == 'custom' ) $content_css_ar['font-size'] = $content_custom_font_size;
			if( $content_line_height != '' ) $content_css_ar['line-height'] = $content_line_height;
			if( $content_letter_spacing != '' ) $content_css_ar['letter-spacing'] = $content_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .ovr-content' => $content_css_ar ) );
			
			// Overlay ----------------------------------------
			
			$overlay_content_css_ar = array();
			if ( !empty( $overlay_bg_color ) && $overlay_bg_color != '#141414a6' ) $overlay_content_css_ar['background-color'] = $overlay_bg_color;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .item-overlay' => $overlay_content_css_ar ) );
			
			// Section ----------------------------------------
			
			if ( !empty( $show_section_bg ) ) {
				$section_content_css_ar = array();
				$grad_colors = array();
				if ( !empty( $section_bg_color ) && $section_bg_color != '#005cda' ) $grad_colors[] = $section_bg_color;
				if ( !empty( $section_bg_color2 ) && $section_bg_color2 != '#006cff' ) $grad_colors[] = $section_bg_color2 . ' 100%';
				if( !empty( $grad_colors ) ) {
					$section_content_css_ar['background-image'] = 'linear-gradient(to right, '. implode( ',', $grad_colors ) .')';
				}
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .gallery-section:after' => $section_content_css_ar ) );
			}
					
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