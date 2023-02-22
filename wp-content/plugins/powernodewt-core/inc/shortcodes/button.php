<?php
/*
Element Description: Button
*/

if ( ! function_exists( 'powernodewt_button' ) ) :

	function powernodewt_button( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'button_text'					=> '',
			'icon_type'						=> 'flat-icon',
			'flat_icon'						=> '',
			'icon'							=> array(),
			'image'							=> '',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'icon_text'						=> '',
			'link'							=> '',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'button_style'					=> 'flat',
			'button_ver_alignment'			=> '',
			'button_ver_alignment_tablet'	=> '',
			'button_ver_alignment_mobile'	=> '',
			'button_alignment'				=> '',
			'button_alignment_tablet'		=> '',
			'button_alignment_mobile'		=> '',
			'button_position'				=> 'center',
			'button_size'					=> '',
			'button_custom_font_size'		=> '',
			'button_font_weight'			=> '500',
			'button_font_style'				=> 'default',
			'button_text_transform'			=> 'default',
			'button_line_height'			=> '',
			'button_letter_spacing'			=> '',
			'button_text_alignment'			=> '',
			'button_rounded_cornors'			=> 'rounded',
			'button_custom_radius'			=> '',
			'button_color'					=> 'default',
			'button_bg_color'				=> '',
			'button_text_color'				=> '',
			'button_border_color'			=> '',
			'button_hover_color'			=> 'default',
			'button_bg_hcolor'				=> '',
			'button_text_hcolor'			=> '',
			'button_border_hcolor'			=> '',
			'content_el_classes'			=> '',
			'icon_size'						=> '',
			'icon_color'					=> '',
			'icon_color_custom'				=> '',
			'icon_bg_color'					=> '',
			'icon_bg_color_custom'			=> '',
			'icon_alignment'				=> '',
			'icon_alignment_tablet'			=> '',
			'icon_alignment_mobile'			=> '',
			'icon_el_classes' 				=> '',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-button-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-button';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
		$args['wrap_atts']['class'][] 		= ( $button_alignment ) ? 'txt-' . $button_alignment : '';
		$args['wrap_atts']['class'][] 		= ( $button_alignment_tablet ) ? 'txt-md-' . $button_alignment_tablet : '';
		$args['wrap_atts']['class'][] 		= ( $button_alignment_mobile ) ? 'txt-sm-' . $button_alignment_mobile : '';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
				
		// Section Content --------------------------
		
		$data_attr['class'] = array( 'pnwt-button', 'btn' );
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		$data_attr['class'][] = ( !in_array( $button_style, array( '', 'default' ) ) ) ? 'btn-' . $button_style : '';
		$data_attr['class'][] = ( !in_array( $button_size, array( '', 'default' ) ) ) ? 'btn-' . $button_size : '';
		$data_attr['class'][] = ( !in_array( $button_rounded_cornors, array( '', 'default' ) ) ) ? 'btn-' . $button_rounded_cornors : '';
		$data_attr['class'][] = ( !in_array( $button_font_weight, array( '', 'default' ) ) ) ? 'fw-' . $button_font_weight : '';
		$data_attr['class'][] = ( !in_array( $button_font_style, array( '', 'default' ) ) ) ? 'font-' . $button_font_style : '';
		$data_attr['class'][] = ( !in_array( $button_text_transform, array( '', 'default' ) ) ) ? 'text-' . $button_text_transform : '';
		$data_attr['class'][] = ( !empty( $button_text_alignment ) ) ? 'txt-' . $button_text_alignment : '';
		$data_attr['class'][] = ( $button_ver_alignment ) ? 'align-itms-' . $button_ver_alignment : '';
		$data_attr['class'][] = ( $button_ver_alignment_tablet ) ? 'align-items-md-' . $button_ver_alignment_tablet : '';
		$data_attr['class'][] = ( $button_ver_alignment_mobile ) ? 'align-items-sm-' . $button_ver_alignment_mobile : '';
		$data_attr['class'][] = ( !in_array( $button_color, array( '', 'default', 'custom' ) ) ) ? 'btn-' . $button_color : 'btn-clr-custom';
		$data_attr['class'][] = ( !in_array( $button_hover_color, array( '', 'default', 'custom' ) ) ) ? $button_hover_color . '-hover' : 'btn-hclr-custom';
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';
		
		if( !empty( $link['url'] ) ) {
			$data_attr = $data_attr + powernodewt_get_url_data( $link );
		}
				
		$args['sec_content'] .= ( ( !empty( $link['url'] ) ) ? '<a' : '<button' ) . ' ' .  powernodewt_stringify_atts( $data_attr ) . '>';
		
		if( $icon_type != 'none' ) {
						
			$icon_content = '';
			
			// Icon ---------------------------------------
			
			if( $icon_type == 'icon' && !empty( $icon ) ) {
				$icon_content .= powernodewt_elementor_render_icon( $icon, array( 'class' => 'list-icon' ), 'span' );
			}
			
			// Flat Icon ---------------------------------------
			
			if( $icon_type == 'flat-icon' && !empty( $flat_icon ) ) {
				$icon_content .= '<span class="' . esc_attr( $flat_icon ) .'"></span>';
			}
			
			// Image ---------------------------------------
	
			if( $icon_type == 'image' && !empty( $image ) ) {
				
				$icon_content .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'size' => $image_size, 'class' => ''  ) ) :  '<img src="' . $image['url'] . '" />';
				
				$bx_img_css_ar = array();
				if ( !empty(  $image_below_padding ) && $image_below_padding != '30px' ) $bx_img_css_ar['margin-bottom'] = $image_below_padding;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-ico-img' => $bx_img_css_ar ) );			
			}
			
			// Text Icon ---------------------------------------
			
			if( $icon_type == 'text' && $icon_text ) {
				$icon_content .= '<span class="icon-text">' . $icon_text .'</span>';
			}
			
			if( !empty( $icon_content ) ) {
				
				$icon_attr = array();
				$icon_attr['class'] = array( 'btn-icon', 'fbx-icon' );
				$icon_attr['class'][] = ( !in_array( $icon_color, array( '', 'custom', 'default' ) ) ) ? $icon_color . '-color' : '';
				$icon_attr['class'][] = ( !in_array( $icon_alignment, array( '' ) ) ) ? 'align-itms-' . $icon_alignment : '';
				$icon_attr['class'][] = ( !in_array( $icon_alignment_tablet, array( '' ) ) ) ? 'align-itms-md-' . $icon_alignment_tablet : '';
				$icon_attr['class'][] = ( !in_array( $icon_alignment_mobile, array( '' ) ) ) ? 'align-itms-' . $icon_alignment_mobile : '';
				$icon_attr['class'][] = ( !in_array( $icon_bg_color, array( '', 'custom', 'default' ) ) ) ? 'bg-' . $icon_bg_color : '';
				$icon_attr['class'][] = ( ! empty( $icon_el_classes ) ) ? $icon_el_classes : '';
			
				$args['sec_content'] .= '<span ' . powernodewt_stringify_atts( $icon_attr ) . '>';
				$args['sec_content'] .= $icon_content;
				$args['sec_content'] .= '</span>';
				
				$icon_type_ar[] = $icon_type;
			}
		}
		
		$args['sec_content'] .= $button_text;
		
		$args['sec_content'] .= ( ( !empty( $link['url'] ) ) ? '</a>' : '</button>' );
		
		// Icon Style ------------------------------------
		
		if( $icon_type != 'none' ) {
				
			if ( in_array( $icon_type, array( 'flat-icon', 'icon', 'text' ) ) ) {
				$icon_css_ar = array();
				if ( !empty(  $icon_size ) ) {
					$icon_css_ar['font-size'] = $icon_size;
				}
				if( in_array( $icon_color, array( 'custom' ) ) ) $icon_css_ar['color'] = $icon_color_custom;
				if( in_array( $icon_bg_color_custom, array( 'custom' ) ) ) $icon_css_ar['background-color'] = $icon_bg_color_custom;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon' => $icon_css_ar ) );
			}
			
			if ( in_array( $icon_type, array( 'image' ) ) ) {
				$image_css_ar = array();
				if ( !empty(  $icon_size ) && $icon_size != '65px' ) {
					$image_css_ar['font-size'] = $icon_size;
				}
				if( in_array( $icon_color, array( 'custom' ) ) ) $image_css_ar['color'] = $icon_color_custom;
				if( in_array( $icon_bg_color_custom, array( 'custom' ) ) ) $image_css_ar['background-color'] = $icon_bg_color_custom;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon' => $image_css_ar ) );
			}
		}
				
		// Butto Style  ----------------------------------------
		
		$button_css_ar = $button_hover_css_ar = array();
		if( $button_color == 'custom' ) {
			if( !empty( $button_bg_color ) ) $button_css_ar['background-color'] = $button_bg_color;
			if( !empty( $button_text_color ) ) $button_css_ar['color'] = $button_text_color;
			if( !empty( $button_border_color ) ) $button_css_ar['border-color'] = $button_border_color;
		}
		
		if( $button_size == 'custom' && !empty( $button_custom_font_size ) ) $button_css_ar['font-size'] = $button_custom_font_size;
		if( $button_line_height != '' ) $button_css_ar['line-height'] = $content_line_height;
		if( $button_letter_spacing != '' ) $button_css_ar['letter-spacing'] = $content_letter_spacing;
		
		$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .pnwt-button' => $button_css_ar ) );
		
		if( $button_hover_color == 'custom' ) {
			if( !empty( $button_bg_hcolor ) ) $button_hover_css_ar['background-color'] = $button_bg_hcolor;
			if( !empty( $button_text_hcolor ) ) $button_hover_css_ar['color'] = $button_text_hcolor;
			if( !empty( $button_border_hcolor ) ) $button_hover_css_ar['border-color'] = $button_border_hcolor;
		}
		
		$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .pnwt-button:hover' => $button_hover_css_ar ) );

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
		powernodewt_exts_get_template( 'shortcodes/button', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_button', 'powernodewt_button' );