<?php
/*
Element Description: Collage Box
*/

if ( ! function_exists( 'powernodewt_collage_box' ) ) :

	function powernodewt_collage_box( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'image'							=> '',
			'content_bg_image'				=> '',
			'title'							=> '',
			'inner_title'					=> '',
			'link'							=> '',
			'link_target'					=> 'Yes',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'image_rounded_cornors'			=> '',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'hover_overlay'					=> false,
			'image_el_classes'				=> '',
			'content_bg_size'				=> 'thumbnail',
			'content_bg_custom_dimension'	=> array(),
			'content_bg_image_rounded_cornors' => '',
			'content_bg_image_el_classes'	=> '',
			'title_size'					=> 'h4',
			'title_font_size'				=> 'sm',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> 'white',
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
			'content_color'					=> 'white',
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
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		// Display Type Widget
		if( $display_type == 'widget' ) {
			$image = array( 'id' => preg_replace( '/[^\d]/', '', $image ) );
			$title = $inner_title;
		}
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-collage-box-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-collage-box';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 				= array( 'pnwt-collage-box' );
		$data_attr['class'][] 				= ( ! empty( $el_classes ) ) ? $el_classes : '';
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
				
		if( $link ) {
			$args['sec_content'] .= '<a href="' . $link . '" ' . ( ( $link_target ) ? 'target="_blank"' : '' ) . '/>';
		}
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
		
		// Image ---------------------------------------
		
		if( !empty( $image ) ) {
			
			$image_attr = array();
			$image_attr['class'] = array( 'bx-img', 'bx-ico-img' );
			$image_attr['class'][] = ( !in_array( $image_alignment, array( '' ) ) ) ? 'txt-' . $image_alignment : '';
			$image_attr['class'][] = ( !in_array( $image_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $image_alignment_tablet : '';
			$image_attr['class'][] = ( !in_array( $image_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $image_alignment_mobile : '';
			$image_attr['class'][] = ( ! empty( $image_el_classes ) ) ? $image_el_classes : '';
			
			$image_size = '';
			if ( $thumbnail_size == 'custom' && !empty( $thumbnail_custom_dimension['width'] ) && !empty( $thumbnail_custom_dimension['height'] )  ) {
				$image_size = $thumbnail_custom_dimension['width'].'x'.$thumbnail_custom_dimension['height'];
			} else {
				$image_size = $thumbnail_size;
			}
						
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $image_attr ) . '>';
			$args['sec_content'] .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'size' => $image_size, 'class' => $image_rounded_cornors  ) ) :  '<img src="' . $image['url'] . '" />';
			$args['sec_content'] .= '</div>';
			
			$image_css_ar = array();
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-img' => $image_css_ar ) );			
		}

		$content_wrap_attr = array();
		$content_wrap_attr['class'] = array('content-12-txt', 'fbox-13-txt');
		$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_wrap_attr ) . '>';
		
		// Content BG Image ---------------------------------------
		
		if( !empty( $content_bg_image ) ) {
			
			$content_bg_image_attr = array();
			$content_bg_image_attr['class'] = array( 'bx-img', 'bx-ico-img', 'content-bg' );
			$content_bg_image_attr['class'][] = ( ! empty( $content_bg_el_classes ) ) ? $content_bg_el_classes : '';
			
			$content_bg_image_size = '';
			if ( $content_bg_size == 'custom' && !empty( $content_bg_custom_dimension['width'] ) && !empty( $content_bg_custom_dimension['height'] )  ) {
				$content_bg_image_size = $content_bg_custom_dimension['width'].'x'.$content_bg_custom_dimension['height'];
			} else {
				$content_bg_image_size = $content_bg_size;
			}
						
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_bg_image_attr ) . '>';
			$args['sec_content'] .= ( !empty( $content_bg_image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $content_bg_image['id'], 'size' => $content_bg_image_size, 'class' => $content_bg_image_rounded_cornors  ) ) :  '<img src="' . $content_bg_image['url'] . '" />';
			$args['sec_content'] .= '</div>';
			
			$image_css_ar = array();
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .content-bg' => $image_css_ar ) );			
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
			
			$content_css_ar = array();
			if( $content_color == 'custom' ) $content_css_ar['color'] = $content_color_custom;
			if( $content_font_size == 'custom' ) $content_css_ar['font-size'] = $content_custom_font_size;
			if( $content_line_height != '' ) $content_css_ar['line-height'] = $content_line_height;
			if( $content_letter_spacing != '' ) $content_css_ar['letter-spacing'] = $content_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-content' => $content_css_ar ) );
		}
		
		$args['sec_content'] .= '</div>';
		
		$args['sec_content'] .= '</div>';
		
		if( $link ) {
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
		powernodewt_exts_get_template( 'shortcodes/collage-box', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_collage_box', 'powernodewt_collage_box' );