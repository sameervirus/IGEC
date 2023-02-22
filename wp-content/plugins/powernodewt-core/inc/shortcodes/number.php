<?php
/*
Element Description: Features Box
*/
if ( ! function_exists( 'powernodewt_features_box' ) ) :

	function powernodewt_features_box( $atts = array(), $content = null ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'icon_type'						=> 'flat-icon',
			'flat_icon'						=> '',
			'icon'							=> array(),
			'image'							=> '',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'icon_text'						=> '',
			'title'							=> '',
			'link'							=> '',
			'icon_position'					=> 'left',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'icon_view'						=> 'default',
			'icon_shape'					=> 'circle',
			'icon_size'						=> '',
			'icon_size_custom'				=> '',
			'icon_color'					=> '',
			'icon_color_custom'				=> '',
			'icon_bg_color'					=> '',
			'icon_bg_color_custom'			=> '',
			'icon_alignment'				=> '',
			'icon_alignment_tablet'			=> '',
			'icon_alignment_mobile'			=> '',
			'icon_ver_alignment'			=> '',
			'icon_ver_alignment_tablet'		=> '',
			'icon_ver_alignment_mobile'		=> '',
			'icon_el_classes' 				=> '',
			'icon_wrap_el_classes' 			=> '',
			'image_rounded_cornors'			=> 'rounded',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'hover_overlay'					=> false,
			'image_below_padding'			=> '',
			'image_wrap_el_classes'			=> '',
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
			'title_alignment'				=> 'left',
			'title_alignment_tablet'		=> '',
			'title_alignment_mobile'		=> '',
			'title_el_classes'				=> '',
			'content_size'					=> 'p',
			'content_font_size'				=> 'md',
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
			'content_wrap_el_classes' 		=> '',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode'
		), $atts);
				
		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-features-box-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-features-box';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'pnwt-features-box', 'pnwt-bxim', 'fbox-3' );
		$data_attr['class'][] = ( ! empty( $hover_overlay ) ) ? 'hover-overlay-action' : '';
		$data_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';	
		$data_attr['class'][] = ( !empty( $icon_type ) ) ? 'media-' . $icon_type : '';
		$data_attr['class'][] = ( !empty( $image_position ) ) ? 'bxim-pos-' . $image_position : '';
		$data_attr['class'][] = ( !in_array( $icon_view, array( '', 'default' ) ) ) ? 'bxim-view-' . $icon_view : '';
		$data_attr['class'][] = ( !in_array( $icon_view, array( '', 'default' ) ) && !in_array( $icon_shape, array( '', 'default' ) ) ) ? 'bxim-shape-' . $icon_shape : '';
		$data_attr['class'][] = ( !in_array( $icon_position, array( '', 'default', 'left' ) ) ) ? 'bxim-pos-' . $icon_position : '';
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '<a ' . powernodewt_stringify_atts( powernodewt_get_url_data( $link ) ) . '>';
		}
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';

		// Box Icon ----------------------------------------------
		
		if( $icon_type != 'none' ) {
			
			$icon_image_wrap_attr = array();
			$icon_image_wrap_attr['class'] = array( 'fbox-ico fbx-icons bx-icon-wrap' );
			$icon_image_wrap_attr['class'][] = ( ! empty( $icon_wrap_el_classes ) ) ? $icon_wrap_el_classes : '';
			$icon_image_wrap_attr['class'][] = ( ! empty( $image_wrap_el_classes ) ) ? $image_wrap_el_classes : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_alignment, array( '' ) ) ) ? 'jus-con-' . $icon_alignment  : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_alignment_tablet, array( '' ) ) ) ? 'jus-con-md-' . $icon_alignment_tablet : '';
			$icon_image_wrap_attr['class'][] = ( !in_array( $icon_alignment_mobile, array( '' ) ) ) ? 'jus-con-sm-' . $icon_alignment_mobile : '';
			$icon_image_wrap_attr['class'][] = ( $icon_ver_alignment ) ? 'align-itms-' . $icon_ver_alignment : '';
			$icon_image_wrap_attr['class'][] = ( $icon_ver_alignment_tablet ) ? 'align-items-md-' . $icon_ver_alignment_tablet : '';
			$icon_image_wrap_attr['class'][] = ( $icon_ver_alignment_mobile ) ? 'align-items-sm-' . $icon_ver_alignment_mobile : '';
			
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $icon_image_wrap_attr ) . '>';
						
				$icon_attr = array();
				$icon_attr['class'] = array( 'fbx-icon', 'bx-ico-img' );
				$icon_attr['class'][] = ( !in_array( $icon_color, array( '', 'custom', 'default' ) ) ) ? $icon_color . '-color' : '';
				$icon_attr['class'][] = ( !in_array( $icon_bg_color, array( '', 'custom', 'default' ) ) ) ? 'bg-' . $icon_bg_color : '';
				$icon_attr['class'][] = ( !empty( $icon_size ) && in_array( $icon_type, array( 'flat-icon', 'icon' ) ) ) ? $icon_size : '';
				$icon_attr['class'][] = ( !empty( $icon_el_classes ) ) ? $icon_el_classes : '';
			
				$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $icon_attr ) . '>';
				
				// Icon ---------------------------------------
				
				if( $icon_type == 'icon' && !empty( $atts['icon'] ) ) {
					$args['sec_content'] .= powernodewt_elementor_render_icon( $atts['icon'], array( 'class' => 'list-icon' ), 'span' );
				}
				
				// Flat Icon ---------------------------------------

				if( $icon_type == 'flat-icon' && !empty( $atts['flat_icon'] ) ) {
					$args['sec_content'] .= '<span class="' . esc_attr($atts['flat_icon']) .'"></span>';
				}
				
				// Image ---------------------------------------
		
				if( $icon_type == 'image' && !empty( $image ) ) {
					
					$image_size = '';
					if ( $thumbnail_size == 'custom' && !empty( $thumbnail_custom_dimension['width'] ) && !empty( $thumbnail_custom_dimension['height'] )  ) {
						$image_size = $thumbnail_custom_dimension['width'].'x'.$thumbnail_custom_dimension['height'];
					} else {
						$image_size = $thumbnail_size;
					}
					
					$image_attr = array();
					$image_attr['class'] = array( 'bx-img', 'bx-ico-img' );
					$image_attr['class'][] = ( !in_array( $image_alignment, array( '' ) ) ) ? 'txt-' . $image_alignment : '';
					$image_attr['class'][] = ( !in_array( $image_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $image_alignment_tablet : '';
					$image_attr['class'][] = ( !in_array( $image_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $image_alignment_mobile : '';
					$image_attr['class'][] = ( ! empty( $image_rounded_cornors ) ) ? $image_rounded_cornors : '';
					$image_attr['class'][] = ( ! empty( $hover_overlay ) ) ? 'hover-overlay' : '';
					
					$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $image_attr ) . '>';
					$args['sec_content'] .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'size' => $image_size ) ) :  '<img src="' . $image['url'] . '" />';
					$args['sec_content'] .= '</div>';
					
					$bx_img_css_ar = array();
					if ( !empty(  $image_below_padding ) && $image_below_padding != '30px' ) $bx_img_css_ar['margin-bottom'] = $image_below_padding;
					$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-img' => $bx_img_css_ar ) );			
				}
				
				// Text Icon ---------------------------------------
				
				if( $icon_type == 'text' && $icon_text ) {
					$args['sec_content'] .= '<span class="icon-text">' . $icon_text .'</span>';
				}
				
				$args['sec_content'] .= '</div>';
			$args['sec_content'] .= '</div>';
			
			if ( in_array( $icon_type, array( 'flat-icon', 'icon', 'text', 'number' ) ) ) {
				$icon_css_ar = array();
				if ( ! in_array( $icon_size_custom, array( '', '65px' ) ) ) {
					$icon_css_ar['font-size'] = $icon_size_custom;
					if( !in_array( $icon_view, array( '', 'default' ) ) ) {
						$icon_css_ar['width'] = 'calc(' . $icon_size_custom . '*1.8)';
						$icon_css_ar['height'] = 'calc(' . $icon_size_custom . '*1.8)';
					}
				}
				if( in_array( $icon_color, array( 'custom' ) ) ) $icon_css_ar['color'] = $icon_color_custom;
				if( in_array( $icon_bg_color_custom, array( 'custom' ) ) ) $icon_css_ar['background-color'] = $icon_bg_color_custom;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon' => $icon_css_ar ) );
			}
			
			if ( in_array( $icon_type, array( 'image' ) ) ) {
				$image_css_ar = array();
				if ( ! in_array( $icon_size_custom, array( '', '65px' ) ) ) {
					$image_css_ar['font-size'] = $icon_size_custom;
					if( !in_array( $icon_view, array( '', 'default' ) ) ) {
						$icon_css_ar['width'] = 'calc(' . $icon_size_custom . '*1.8)';
						$icon_css_ar['height'] = 'calc(' . $icon_size_custom . '*1.8)';
					}
				}
				if( in_array( $icon_color, array( 'custom' ) ) ) $image_css_ar['color'] = $icon_color_custom;
				if( in_array( $icon_bg_color_custom, array( 'custom' ) ) ) $image_css_ar['background-color'] = $icon_bg_color_custom;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon' => $image_css_ar ) );
			}
		}
		
		$content_wrap_attr = array();
		$content_wrap_attr['class'] = array( 'fbox-txt' );
		$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_wrap_attr ) . '>';
			
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
				$args['sec_content'] .= '<'. $title_size .' ' . powernodewt_stringify_atts( $title_attr ) . '>' . do_shortcode( $title ) . '</'. $title_size .'>';
			}
			
			$title_css_ar = array();
			if( $title_color == 'custom' ) $title_css_ar['color'] = $title_color_custom;
			if( $title_font_size == 'custom' ) $title_css_ar['font-size'] = $title_custom_font_size;
			if( $title_line_height != '' ) $title_css_ar['line-height'] = $title_line_height;
			if( $title_letter_spacing != '' ) $title_css_ar['letter-spacing'] = $title_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-title' => $title_css_ar ) );
		}
		
		// Content -----------------------------------------
		
		if( !empty( $content ) ) {
			$content_attr = array();
			$content_attr['class'] = array( 'bx-content' );
			$content_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
			$content_attr['class'][] = ( !in_array( $content_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $content_font_weight : '';
			$content_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
			$content_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
			$content_attr['class'][] = ( !in_array( $content_alignment, array( '' ) ) ) ? 'txt-' . $content_alignment : '';
			$content_attr['class'][] = ( !in_array( $content_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $content_alignment_tablet : '';
			$content_attr['class'][] = ( !in_array( $content_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $content_alignment_mobile : '';
			$content_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
			$content_attr['class'][] = ( ! empty( $content_el_classes ) ) ? $content_el_classes : '';
			
			if( in_array( $content_size, array( '', 'p' ) ) ) {
				$args['sec_content'] .= '<p ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</p>';
			} else {
				$args['sec_content'] .= '<'. $content_size .' ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</'. $content_size .'>';
			}
			
			$content_css_ar = array();
			if( $content_color == 'custom' ) $content_css_ar['color'] = $content_color_custom;
			if( $content_font_size == 'custom' ) $content_css_ar['font-size'] = $content_custom_font_size;
			if( $content_line_height != '' ) $content_css_ar['line-height'] = $content_line_height;
			if( $content_letter_spacing != '' ) $content_css_ar['letter-spacing'] = $content_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-content' => $content_css_ar ) );
		}
			
		$args['sec_content'] .= '</div>';
		
		$args['sec_content'] .= '</div>';
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '</a>';
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
		powernodewt_exts_get_template( 'shortcodes/features-box', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_features_box', 'powernodewt_features_box' );