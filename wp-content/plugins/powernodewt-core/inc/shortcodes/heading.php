<?php
/*
Element Description: Heading
*/

if ( ! function_exists( 'powernodewt_heading' ) ) :

	function powernodewt_heading( $atts, $content = null  ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'content_size'					=> 'h4',
			'content_font_size'				=> 'md',
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
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
			
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= powernodewt_uniqid('powernode-heading-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-heading';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------------------------------------------------------------
		
		$args['wrap_atts']['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'pnwt-heading' );
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		$data_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
		$data_attr['class'][] = ( !in_array( $content_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $content_font_weight : '';
		$data_attr['class'][] = ( !in_array( $content_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $content_font_style : '';
		$data_attr['class'][] = ( !in_array( $content_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $content_text_transform : '';
		$data_attr['class'][] = ( $content_alignment ) ? 'txt-' . $content_alignment : '';
		$data_attr['class'][] = ( $content_alignment_tablet ) ? 'txt-md-' . $content_alignment_tablet : '';
		$data_attr['class'][] = ( $content_alignment_mobile ) ? 'txt-sm-' . $content_alignment_mobile : '';
		$data_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
		$data_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
					
		if( !empty( $content ) ) {
			
			$content_css_ar = array();
			if( $content_color == 'custom' ) $content_css_ar['color'] = $content_color_custom;
			if( $content_font_size == 'custom' ) $content_css_ar['font-size'] = $content_custom_font_size;
			if( $content_line_height != '' ) $content_css_ar['line-height'] = $content_line_height;
			if( !in_array( $content_letter_spacing, array( '' ) ) ) $content_css_ar['letter-spacing'] = $content_letter_spacing;
			
			if( in_array( $content_size, array( '', 'h4' ) ) ) {
				$args['sec_content'] .= '<h4 ' . powernodewt_stringify_atts( $data_attr ) . '>' . do_shortcode( $content ) . '</h4>';
			} else {
				$args['sec_content'] .= '<'. $content_size .' ' . powernodewt_stringify_atts( $data_attr ) . '>' . do_shortcode( $content ) . '</'. $content_size .'>';
			}
			
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .pnwt-heading' => $content_css_ar ) );
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
		powernodewt_exts_get_template( 'shortcodes/heading', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_heading', 'powernodewt_heading' );