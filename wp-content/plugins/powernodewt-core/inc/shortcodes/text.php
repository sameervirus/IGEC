<?php
/*
Element Description: Text
*/

if ( ! function_exists( 'powernodewt_text' ) ) :

	function powernodewt_text( $atts, $content = null  ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
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
		$args['id']  						= powernodewt_uniqid('powernode-text-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-text';
		$args['wrap_atts']['class'][] 		= 'pnwt-text';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
		
		if( !empty( $animation ) ) {
			$args['wrap_atts']['class'][] = 'wow';
			$args['wrap_atts']['class'][]  = $animation;
			if ( !empty( $animation_delay ) ) $args['wrap_atts']['data-wow-delay'] = $animation_delay;
		}		
	
		// Content -----------------------------------------
		
		if( !empty( $content ) ) {
			$content_attr = array();
			if( ! empty( $wrap_id ) ) $content_attr['id'] = $wrap_id;
			$content_attr['class'] = array( 'text-content' );
			$content_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
			$content_attr['class'][] = ( !in_array( $content_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $content_font_weight : '';
			$content_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
			$content_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
			$content_attr['class'][] = ( !in_array( $content_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $content_alignment_mobile : '';
			$content_attr['class'][] = ( !in_array( $content_alignment_tablet, array( '') ) ) ? 'txt-md-' . $content_alignment_tablet : '';
			$content_attr['class'][] = ( !in_array( $content_alignment, array( '' ) ) ) ? 'txt-' . $content_alignment : '';
			$content_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
			$content_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
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
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .text-content' => $content_css_ar ) );
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
		powernodewt_exts_get_template( 'shortcodes/blockquote', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_text', 'powernodewt_text' );