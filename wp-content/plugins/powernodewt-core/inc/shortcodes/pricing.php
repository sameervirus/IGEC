<?php
/*
Element Description: Pricing
*/

if ( ! function_exists( 'powernodewt_pricing' ) ) :

	function powernodewt_pricing( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'pricing_box_style'				=> 'pricing-5-table',
			'icon_type'						=> 'flat-icon',
			'flat_icon'						=> '',
			'icon'							=> array(),
			'image'							=> '',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'icon_text'						=> '',
			'title'							=> '',
			'content_items'					=> array(),
			'price_amount'					=> '',
			'price_currency'				=> '',
			'price_period'					=> '',
			'price_prefix'					=> '',
			'price_validity'				=> '',
			'button_text'					=> '',
			'button_link'					=> '',
			'button_link_target'			=> '',
			'icon_position'					=> 'top',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'add_pricing_box_shadow' 		=> '0',
			'pricing_box_bg_color' 			=> '',
			'pricing_box_bg_color_custom' 	=> '',
			'el_classes' 					=> '',
			'icon_view'						=> 'default',
			'icon_shape'					=> 'circle',
			'icon_bg_image'					=> '',
			'icon_bg_image_size'			=> '',
			'icon_bg_image_custom_dimension'=> array(),
			'icon_size'						=> '93px',
			'icon_color'					=> '',
			'icon_color_custom'				=> '',
			'icon_bg_color'					=> '',
			'icon_bg_color_custom'			=> '',
			'icon_alignment'				=> '',
			'icon_alignment_tablet'			=> '',
			'icon_alignment_mobile'			=> '',
			'icon_el_classes' 				=> '',
			'icon_wrap_el_classes' 			=> '',
			'title_size'					=> 'h6',
			'title_font_size'				=> '',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> 'uppercase',
			'title_color'					=> 'default',
			'title_color_custom'			=> '',
			'title_line_height'				=> '',
			'title_letter_spacing'			=> '',
			'title_alignment'				=> 'center',
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
			'content_alignment'				=> 'center',
			'content_alignment_tablet'		=> '',
			'content_alignment_mobile'		=> '',
			'content_el_classes'			=> '',
			'content_wrap_el_classes'		=> '',
			'cotnent_list_size'				=> 'span',
			'cotnent_list_font_size'		=> '',
			'cotnent_list_custom_font_size'	=> '',
			'cotnent_list_font_weight'		=> '',
			'cotnent_list_font_style'		=> '',
			'cotnent_list_text_transform'	=> '',
			'cotnent_list_color'			=> 'default',
			'cotnent_list_color_custom'		=> '',
			'cotnent_list_line_height'		=> '',
			'cotnent_list_letter_spacing'	=> '',
			'cotnent_list_alignment'		=> 'center',
			'cotnent_list_el_classes'		=> '',
			'cotnent_list_wrap_el_classes'	=> '',
			'price_size'					=> 'span',
			'price_font_size'				=> '',
			'price_custom_font_size'		=> '',
			'price_font_weight'				=> '',
			'price_font_style'				=> '',
			'price_text_transform'			=> 'uppercase',
			'price_color'					=> 'default',
			'price_color_custom'			=> '',
			'price_line_height'				=> '',
			'price_letter_spacing'			=> '',
			'price_alignment'				=> 'center',
			'price_el_classes'				=> '',
			'period_size'					=> 'p',
			'period_font_size'				=> '',
			'period_custom_font_size'		=> '',
			'period_font_weight'			=> '',
			'period_font_style'				=> '',
			'period_text_transform'			=> '',
			'period_color'					=> 'default',
			'period_color_custom'			=> '',
			'period_line_height'			=> '',
			'period_letter_spacing'			=> '',
			'period_alignment'				=> 'left',
			'period_el_classes'				=> '',
			'button_style'					=> 'flat',
			'button_position'				=> 'center',
			'button_size'					=> 'md',
			'button_custom_font_size'		=> '',
			'button_font_weight'			=> '500',
			'button_font_style'				=> 'default',
			'button_text_transform'			=> 'default',
			'button_line_height'			=> '',
			'button_letter_spacing'			=> '',
			'button_alignment'				=> '',
			'button_corners_style'			=> 'rounded',
			'button_custom_radius'			=> '',
			'button_color'					=> 'default',
			'button_bg_color'				=> '',
			'button_text_color'				=> '',
			'button_border_color'			=> '',
			'button_hover_color'			=> 'default',
			'button_bg_hcolor'				=> '',
			'button_text_hcolor'			=> '',
			'button_border_hcolor'			=> '',
			'button_align'					=> '',
			'button_el_classes'				=> '',
			'wrap_id'						=> '',
			'wrap_el_classes'				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-pricing-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-pricing';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 				= array( 'pnwt-pricing', 'pnwt-bxim', 'radius-06' );
		$data_attr['class'][] 				= ( !empty( $icon_type ) ) ? 'media-' . $icon_type : '';
		$data_attr['class'][] 				= ( !empty( $icon_position ) ) ? 'bxim-pos-' . $icon_position : '';
		$data_attr['class'][] 				= ( !in_array( $pricing_box_bg_color, array( '', 'custom', 'default' ) ) ) ? 'bg-' . $pricing_box_bg_color : '';
		$data_attr['class'][] 				= ( !empty( $add_pricing_box_shadow ) ) ? 'bx-shadow' : '';
		$data_attr['class'][] 				= ( !empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'][] 				= ( !empty( $pricing_box_style ) ) ? $pricing_box_style : 'pricing-5-table';
		
		$pricing_box_css_ar = array();
		if( $pricing_box_bg_color == 'custom' ) $pricing_box_css_ar['color'] = $pricing_box_bg_color_custom;
		$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .pnwt-pricing' => $pricing_box_css_ar ) );
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
				
		// Icon ----------------------------------------------
		
		$icon_html = '';
				
		if( $icon_type != 'none' ) {
			
			$icon_image_wrap_attr = array();
			$icon_image_wrap_attr['class'] = array( 'fbox-ico fbx-icons bx-icon-wrap' );
			$icon_image_wrap_attr['class'][] = ( ! empty( $icon_wrap_el_classes ) ) ? $icon_wrap_el_classes : '';
			$icon_image_wrap_attr['class'][] = ( ! empty( $image_wrap_el_classes ) ) ? $image_wrap_el_classes : '';
			
			$icon_image_wrap_attr['class'][] = ( !empty( $icon_type ) ) ? 'media-' . $icon_type : '';
			$icon_image_wrap_attr['class'][] = ( !empty( $image_position ) ) ? 'bxim-pos-' . $image_position : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_view, array( '', 'default' ) ) ) ? 'bxim-view-' . $icon_view : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_view, array( '', 'default' ) ) && !in_array( $icon_shape, array( '', 'default' ) ) ) ? 'bxim-shape-' . $icon_shape : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_position, array( '', 'default' ) ) ) ? 'bxim-pos-' . $icon_position : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_alignment, array( '' ) ) ) ? 'align-itms-' . $icon_alignment : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_alignment_tablet, array( '' ) ) ) ? 'align-itms-md-' . $icon_alignment_tablet : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_alignment_mobile, array( '' ) ) ) ? 'align-itms-' . $icon_alignment_mobile : '';
			
			$icon_html .= '<div ' . powernodewt_stringify_atts( $icon_image_wrap_attr ) . '>';
						
				$icon_attr = array();
				$icon_attr['class'] = array( 'fbx-icon', 'bx-ico-img' );
				$icon_attr['class'][] = ( !in_array( $icon_color, array( '', 'custom', 'default' ) ) ) ? $icon_color . '-color' : '';
				$icon_attr['class'][] = ( !in_array( $icon_bg_color, array( '', 'custom', 'default' ) ) ) ? 'bg-' . $icon_bg_color : '';
				$icon_attr['class'][] = ( ! empty( $icon_el_classes ) ) ? $icon_el_classes : '';
			
				$icon_html .= '<div ' . powernodewt_stringify_atts( $icon_attr ) . '>';
				
				// Icon ---------------------------------------
				
				if( $icon_type == 'icon' && !empty( $atts['icon'] ) ) {					
					$icon_html .= powernodewt_elementor_render_icon( $atts['icon'], array( 'class' => 'list-icon' ), 'span' );
				}
				
				// Flat Icon ---------------------------------------

				if( $icon_type == 'flat-icon' && !empty( $atts['flat_icon'] ) ) {
					$icon_html .= '<span class="' . esc_attr($atts['flat_icon']) .'"></span>';
				}
				
				// Image ---------------------------------------
		
				if( $icon_type == 'image' && !empty( $image ) ) {
					
					$image_size = '';
					if ( $thumbnail_size == 'custom' && !empty( $thumbnail_custom_dimension['width'] ) && !empty( $thumbnail_custom_dimension['height'] )  ) {
						$image_size = $thumbnail_custom_dimension['width'].'x'.$thumbnail_custom_dimension['height'];
					} else {
						$image_size = $thumbnail_size;
					}
					
					$icon_html .= '<div class="bx-img bx-ico-img">';
					$icon_html .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'size' => $image_size, 'class' => $image_rounded_cornors  ) ) :  '<img src="' . $image['url'] . '" />';
					$icon_html .= '</div>';
					
					$bx_img_css_ar = array();
					if ( !empty(  $image_below_padding ) && $image_below_padding != '30px' ) $bx_img_css_ar['margin-bottom'] = $image_below_padding;
					$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-img' => $bx_img_css_ar ) );			
				}
				
				// Text Icon ---------------------------------------
				
				if( $icon_type == 'text' && $icon_text ) {
					$icon_html .= '<span class="icon-text">' . $icon_text .'</span>';
				}
				
				// Icon BG Image ---------------------------------------
				
				if( in_array( $icon_type, array( 'flat-icon', 'icon', 'text' ) ) && !empty( $icon_bg_image ) ) {
					$icon_bg_image_size = '';
					if ( $icon_bg_image_size == 'custom' && !empty( $icon_bg_image_custom_dimension['width'] ) && !empty( $icon_bg_image_custom_dimension['height'] )  ) {
						$icon_bg_image_size = $icon_bg_image_custom_dimension['width'].'x'.$icon_bg_image_custom_dimension['height'];
					} else {
						$icon_bg_image_size = $icon_bg_image_size;
					}
					$icon_html .= ( !empty( $icon_bg_image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $icon_bg_image['id'], 'size' => $icon_bg_image_size, 'class' => 'block-ico-bkg' ) ) : '';
				}
				
				$icon_html .= '</div>';
			$icon_html .= '</div>';
			
			if ( in_array( $icon_type, array( 'flat-icon', 'icon', 'text' ) ) ) {
				$icon_css_ar = array();
				if ( ! in_array( $icon_size, array( '', '93px' ) ) ) {
					$icon_css_ar['font-size'] = $icon_size;
					if( !in_array( $icon_view, array( '', 'default', 'bg' ) ) ) {
						$icon_css_ar['width'] = 'calc(' . $icon_size . '*1.8)';
						$icon_css_ar['height'] = 'calc(' . $icon_size . '*1.8)';
					}
				}
				if( in_array( $icon_color, array( 'custom' ) ) ) $icon_css_ar['color'] = $icon_color_custom;
				if( in_array( $icon_bg_color_custom, array( 'custom' ) ) ) $icon_css_ar['background-color'] = $icon_bg_color_custom;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon' => $icon_css_ar ) );
			}
			
			if ( in_array( $icon_type, array( 'image' ) ) ) {
				$image_css_ar = array();
				if ( ! in_array( $icon_size, array( '', '93px' ) ) ) {
					$image_css_ar['font-size'] = $icon_size;
					if( !in_array( $icon_view, array( '', 'default', 'bg' ) ) ) {
						$icon_css_ar['width'] = 'calc(' . $icon_size . '*1.8)';
						$icon_css_ar['height'] = 'calc(' . $icon_size . '*1.8)';
					}
				}
				if( in_array( $icon_color, array( 'custom' ) ) ) $image_css_ar['color'] = $icon_color_custom;
				if( in_array( $icon_bg_color_custom, array( 'custom' ) ) ) $image_css_ar['background-color'] = $icon_bg_color_custom;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon' => $image_css_ar ) );
			}
		}
		
		$content_wrap_attr = array();
		$content_wrap_attr['class'] = array( 'pricing-tab-wrap' );
		$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
		
		$args['sec_content'] .= $icon_html;
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_wrap_attr ) . '>';
			
		// Title ----------------------------------------
		
		$title_html = '';
		
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
				$title_html .= '<h5 ' . powernodewt_stringify_atts( $title_attr ) . '>' . do_shortcode( $title ) . '</h5>';
			} else {
				$title_html .= '<'. $title_size .' ' . powernodewt_stringify_atts( $title_attr ) . '>' . do_shortcode( $title ) . '</'. $title_size .'>';
			}
			
			$title_css_ar = array();
			if( $title_color == 'custom' ) $title_css_ar['color'] = $title_color_custom;
			if( $title_font_size == 'custom' ) $title_css_ar['font-size'] = $title_custom_font_size;
			if( $title_line_height != '' ) $title_css_ar['line-height'] = $title_line_height;
			if( $title_letter_spacing != '' ) $title_css_ar['letter-spacing'] = $title_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-title' => $title_css_ar ) );
		}
		
		// Content -----------------------------------------
		
		$content_html = '';
		
		if( !empty( $content ) ) {
			$content_attr = array();
			$content_attr['class'] = array( 'bx-content' );
			$content_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
			$content_attr['class'][] = ( !in_array( $content_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $content_font_weight : '';
			$content_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
			$content_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
			$content_attr['class'][] = ( !in_array( $content_alignment, array( '' ) ) ) ? 'txt-' . $content_alignment : '';
			$content_attr['class'][] = ( !in_array( $content_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $content_alignment : '';
			$content_attr['class'][] = ( !in_array( $content_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $content_alignment : '';
			$content_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
			$content_attr['class'][] = ( ! empty( $content_el_classes ) ) ? $content_el_classes : '';
			
			if( in_array( $content_size, array( '', 'p' ) ) ) {
				$title_html .= '<p ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</p>';
			} else {
				$title_html .= '<'. $content_size .' ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</'. $content_size .'>';
			}
			
			$content_css_ar = array();
			if( $content_color == 'custom' ) $content_css_ar['color'] = $content_color_custom;
			if( $content_font_size == 'custom' ) $content_css_ar['font-size'] = $content_custom_font_size;
			if( $content_line_height != '' ) $content_css_ar['line-height'] = $content_line_height;
			if( $content_letter_spacing != '' ) $content_css_ar['letter-spacing'] = $content_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-content' => $content_css_ar ) );
		}
		
		// Content Items -----------------------------------------
		
		$content_items_html = '';
		
		if( !empty( $content_items ) ) {
			
			$data_attr = array();
			$data_attr['class'] 				= array( 'features' );
			$data_attr['class'][] 				= ( !empty( $cotnent_list_wrap_el_classes ) ) ? $cotnent_list_wrap_el_classes : '';
			
			$content_items_html .= '<ul ' . powernodewt_stringify_atts( $data_attr ) . '>';
	
			foreach( $content_items as $k => $item ) {
				
				$cotnent_list_attr = array();
				$cotnent_list_attr['class'] = array( 'item' );
				$cotnent_list_attr['class'][] = ( !in_array( $cotnent_list_font_size, array( '', 'custom' ) ) ) ?  $cotnent_list_size. '-' . $cotnent_list_font_size : '';
				$cotnent_list_attr['class'][] = ( !in_array( $cotnent_list_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $cotnent_list_font_weight : '';
				$cotnent_list_attr['class'][] = ( !in_array( $cotnent_list_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $cotnent_list_font_style : '';
				$cotnent_list_attr['class'][] = ( !in_array( $cotnent_list_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $cotnent_list_text_transform : '';
				$cotnent_list_attr['class'][] = ( !in_array( $cotnent_list_alignment, array( '' ) ) ) ? 'text-' . $cotnent_list_alignment : '';
				$cotnent_list_attr['class'][] = ( !in_array( $cotnent_list_color, array( '', 'custom', 'default' ) ) ) ? $cotnent_list_color . '-color' : '';
				$cotnent_list_attr['class'][] = ( ! empty( $cotnent_list_el_classes ) ) ? $cotnent_list_el_classes : '';
				
				$content_items_html .= '<li ' . powernodewt_stringify_atts( $cotnent_list_attr ) . '>';
				
				$content_items_html .= ( !empty( $item['icon'] ) ) ? '<span class="' . esc_attr( $item['icon'] ) .' mr-2"></span>' : '';
			
				if( in_array( $cotnent_list_size, array( '', 'span' ) ) ) {
					$content_items_html .= '<span>' . wp_kses_post( $item['title'] ) . '</span>';
				} else {
					$content_items_html .= '<'. $cotnent_list_size .'>' . wp_kses_post( $item['title'] ) . '</'. $cotnent_list_size .'>';
				}
				
				$content_items_html .= '</li>';
			}
		
			$content_items_html .= '</ul>';
		}
		
		// Pricing -----------------------------------------
		
		$pricing_html = '';
		
		if( !empty( $price_amount ) ) {
			
			$price_wrap_attr = array();
			$price_wrap_attr['class'] = array( 'pricing-plan' );
			$price_wrap_attr['class'][] = ( ! empty( $price_el_classes ) ) ? $price_el_classes : '';
			
			$pricing_html .= '<div ' . powernodewt_stringify_atts( $price_wrap_attr ) . '>';
			
			$price_attr = array();
			$price_attr['class'] = array( 'price' );
			$price_attr['class'][] = ( !in_array( $price_font_size, array( '', 'custom' ) ) ) ?  'span-' . $price_font_size : '';
			$price_attr['class'][] = ( !in_array( $price_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $price_font_weight : '';
			$price_attr['class'][] = ( !in_array( $price_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $price_font_style : '';
			$price_attr['class'][] = ( !in_array( $price_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $price_text_transform : '';
			$price_attr['class'][] = ( !in_array( $price_alignment, array( '', 'left' ) ) ) ? 'text-' . $price_alignment : '';
			$price_attr['class'][] = ( !in_array( $price_color, array( '', 'custom', 'default' ) ) ) ? $price_color . '-color' : '';
			
			$pricing_html .= '<sup>' . $price_currency . '</sup>';
			
			if( in_array( $price_size, array( '', 'span' ) ) ) {
				$pricing_html .= '<span ' . powernodewt_stringify_atts( $price_attr ) . '>' . $price_amount . '</span>';
			} else {
				$pricing_html .= '<'. $price_size .' ' . powernodewt_stringify_atts( $price_attr ) . '>' . $price_amoun . '</'. $price_size .'>';
			}
			
			$pricing_html .= ( $price_prefix ) ? '<sup class="pricing-coins">' . $price_prefix . '</sup>' : '';
			$pricing_html .= ( $price_validity ) ? '<sup class="validity">' . $price_validity . '</sup>' : '';
			
			// Period -----------------------------------------
		
			if( !empty( $price_period ) ) {
				$period_attr = array();
				$period_attr['class'] = array( 'bx-period' );
				$period_attr['class'][] = ( !in_array( $period_font_size, array( '', 'custom' ) ) ) ? $period_size . '-' . $period_font_size : '';
				$period_attr['class'][] = ( !in_array( $period_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $period_font_weight : '';
				$period_attr['class'][] = ( !in_array( $period_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $period_font_style : '';
				$period_attr['class'][] = ( !in_array( $period_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $period_text_transform : '';
				$period_attr['class'][] = ( !in_array( $period_alignment, array( '', 'left' ) ) ) ? 'text-' . $period_alignment : '';
				$period_attr['class'][] = ( !in_array( $period_color, array( '', 'custom', 'default' ) ) ) ? $period_color . '-color' : '';
				$period_attr['class'][] = ( ! empty( $period_el_classes ) ) ? $period_el_classes : '';
				
				if( in_array( $period_size, array( '', 'p' ) ) ) {
					$pricing_html .= '<p ' . powernodewt_stringify_atts( $period_attr ) . '>' . wp_kses_post( $price_period ) . '</p>';
				} else {
					$pricing_html .= '<'. $period_size .' ' . powernodewt_stringify_atts( $period_attr ) . '>' . wp_kses_post( $price_period ) . '</'. $period_size .'>';
				}
				
				$period_css_ar = array();
				if( $period_color == 'custom' ) $period_css_ar['color'] = $period_color_custom;
				if( $period_font_size == 'custom' ) $period_css_ar['font-size'] = $period_custom_font_size;
				if( $period_line_height != '' ) $period_css_ar['line-height'] = $period_line_height;
				if( $period_letter_spacing != '' ) $period_css_ar['letter-spacing'] = $period_letter_spacing;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-period' => $period_css_ar ) );
			}
			
			$price_css_ar = array();
			if( $price_color == 'custom' && !empty( $price_color_custom ) ) $price_css_ar['color'] = $price_color_custom;
			if( $price_font_size == 'custom' && !empty( $price_custom_font_size ) ) $price_css_ar['font-size'] = $price_custom_font_size;
			if( $price_line_height != '' ) $price_css_ar['line-height'] = $price_line_height;
			if( $price_letter_spacing != '' ) $price_css_ar['letter-spacing'] = $price_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-content' => $price_css_ar ) );
			
			$pricing_html .= '</div>';
		}
		
		$button_html = '';
		
		// Button -----------------------------------------
		
		$data_attr = array();
		
		$data_attr['class'] = array( 'pnwt-button', 'btn' );
		
		$data_attr['class'][] = ( !empty( $button_style ) && !in_array( $button_style, array( 'default' ) ) ) ? 'btn-' . $button_style : '';
		$data_attr['class'][] = ( !empty( $button_size ) && !in_array( $button_size, array( 'default' ) ) ) ? 'btn-' . $button_size : '';
		$data_attr['class'][] = ( !empty( $button_corners_style ) && !in_array( $button_corners_style, array( 'default' ) ) ) ? 'btn-' . $button_corners_style : '';
		$data_attr['class'][] = ( !empty( $button_font_weight ) && !in_array( $button_font_weight, array( 'default' ) ) ) ? 'fw-' . $button_font_weight : '';
		$data_attr['class'][] = ( !empty( $button_font_style ) && !in_array( $button_font_style, array( 'default' ) ) ) ? 'font-' . $button_font_style : '';
		$data_attr['class'][] = ( !empty( $button_text_transform ) && !in_array( $button_text_transform, array( 'default' ) ) ) ? 'text-' . $button_text_transform : '';
		$data_attr['class'][] = ( !in_array( $button_color, array( '', 'custom', 'default' ) ) ) ? 'btn-' . $button_color : 'btn-clr-custom';
		$data_attr['class'][] = ( !in_array( $button_hover_color, array( '', 'custom', 'default' ) ) ) ? $button_hover_color . '-hover' : 'btn-hclr-custom';
		$data_attr['class'][] = ( ! empty( $button_el_classes ) ) ? $button_el_classes : '';
		
		if( !empty( $button_link['url'] ) ) {
			$data_attr = $data_attr + powernodewt_get_url_data( $button_link );
		}
				
		$button_html .= ( ( $button_link ) ? '<a' : '<button' ) . ' ' .  powernodewt_stringify_atts( $data_attr ) . '>';
		
		$button_html .= $button_text;
		
		$button_html .= ( ( $button_link ) ? '</a>' : '</button>' );
		
		if ( ! empty( $args['wrap_style_css'] ) ) {
			$args['wrap_atts']['style'] = powernodewt_stringify_classes( $args['wrap_style_css'] );
			unset( $args['wrap_style_css'] );
		}
		
		if( in_array( $pricing_box_style, array( 'pricing-1-table' ) ) ) {
			$args['sec_content'] .= $title_html . $pricing_html . $content_items_html . $content_html . $button_html;
		} else {
			$args['sec_content'] .= $title_html . $content_items_html . $pricing_html . $content_html . $button_html;
		}
			
		$args['sec_content'] .= '</div>';
		
		$args['sec_content'] .= '</div>';

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
		powernodewt_exts_get_template( 'shortcodes/pricing', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_pricing', 'powernodewt_pricing' );