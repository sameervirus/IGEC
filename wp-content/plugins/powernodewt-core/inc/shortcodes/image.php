<?php
/*
Element Description: Image Box
*/

if ( ! function_exists( 'powernodewt_image' ) ) :

	function powernodewt_image( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'image'							=> '',
			'thumbnail_size'				=> 'full',
			'thumbnail_custom_dimension'	=> array(),
			'image_alt_text'				=> '',
			'image_rounded_cornors'			=> '',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'link'							=> '',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= powernodewt_uniqid('powernode-image-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-image';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------
		
		$data_attr['class'] = array( 'pnwt-image' );
		$data_attr['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		$data_attr['class'][] = ( !in_array( $image_alignment, array( '' ) ) ) ? 'txt-' . $image_alignment : '';
		$data_attr['class'][] = ( !in_array( $image_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $image_alignment_tablet : '';
		$data_attr['class'][] = ( !in_array( $image_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $image_alignment_mobile : '';
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '<a ' . powernodewt_stringify_atts( powernodewt_get_url_data( $link ) ) . '>';
		}
		
		// Image ---------------------------------------
		
		if( !empty( $image ) ) {
			
			$img_classes = array( $image_rounded_cornors );
			$img_classes[] = ( ! empty( $el_classes ) ) ? $el_classes : '';
			
			$image_size = '';
			if ( $thumbnail_size == 'custom' && !empty( $thumbnail_custom_dimension['width'] ) && !empty( $thumbnail_custom_dimension['height'] )  ) {
				$image_size = $thumbnail_custom_dimension['width'].'x'.$thumbnail_custom_dimension['height'];
			} else {
				$image_size = $thumbnail_size;
			}
			
			$args['sec_content'] .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'alt' => $image_alt_text, 'size' => $image_size, 'class' => powernodewt_stringify_classes( $img_classes )  ) ) :  '<img src="' . $image['url'] . '" />';			
		}
		
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '</a>';
		}
		
		$args['sec_content'] .= '</div>';

		// Output CSS
		if ( ! empty( $css_output ) ) {
			powernodewt_exts_css_output( $css_output, $args );
		}
		
		$html = '';
		ob_start();
		powernodewt_exts_get_template( 'shortcodes/image-box', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_image', 'powernodewt_image' );