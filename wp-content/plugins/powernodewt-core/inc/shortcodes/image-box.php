<?php
/*
Element Description: Image Box
*/

if ( ! function_exists( 'powernodewt_image_box' ) ) :

	function powernodewt_image_box( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'image'							=> '',
			'title'							=> '',
			'inner_title'					=> '',
			'link'							=> '',
			'link_target'					=> 'Yes',
			'image_box_style'				=> 'default',
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
		$args['id']  						= powernodewt_uniqid('powernode-image-box-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-image-box';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 				= array( 'pnwt-image-box', 'fbox-10' );
		$data_attr['class'][] 				= 'imgbx-s-' . ( ( !empty( $image_box_style ) ) ? $image_box_style : 'default' );
		$data_attr['class'][] 				= ( ! empty( $el_classes ) ) ? $el_classes : '';
		$data_attr['class'][] 				= ( ! empty( $hover_overlay ) ) ? 'hover-overlay-action' : '';
		$data_attr['class'][] 				= ( in_array( $image_box_style, array( 'style-2' ) ) ) ? 'gallery-image' : '';
				
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
				
		if( !empty( $link['url'] ) ) {
			$args['sec_content'] .= '<a ' . powernodewt_stringify_atts( powernodewt_get_url_data( $link ) ) . '>';
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
			
			if ( $hover_overlay ) {
				$image_attr['class'][] = 'hover-overlay';
			}
			
			$image_size = '';
			
			if ( $thumbnail_size == 'custom' && !empty( $thumbnail_custom_dimension['width'] ) && !empty( $thumbnail_custom_dimension['height'] )  ) {
				$image_size = $thumbnail_custom_dimension['width'].'x'.$thumbnail_custom_dimension['height'];
			} else {
				$image_size = $thumbnail_size;
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
		powernodewt_exts_get_template( 'shortcodes/image-box', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_image_box', 'powernodewt_image_box' );