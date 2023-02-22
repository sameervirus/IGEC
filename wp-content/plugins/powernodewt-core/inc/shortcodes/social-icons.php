<?php
/*
Element Description: Social Icons
*/

if ( ! function_exists( 'powernodewt_social_icons' ) ) :

	function powernodewt_social_icons( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'icon_items'					=> array(),
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'main_wrap_alignment' 			=> '',
			'icon_view'						=> 'stacked',
			'icon_shape'					=> 'circle',
			'icon_size'						=> '22px',
			'icon_color'					=> 'default',
			'icon_bg_color'					=> '',
			'icon_text_color'				=> '',
			'icon_border_color'				=> '',
			'icon_hover_color'				=> 'default',
			'icon_bg_hcolor'				=> '',
			'icon_text_hcolor'				=> '',
			'icon_border_hcolor'			=> '',
			'icon_el_classes' 				=> '',
			'icon_wrap_el_classes' 			=> '',
			'wrap_id'						=> '',
			'wrap_el_classes'				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);

		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-social-icons-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element', 'social-links' );
		$args['wrap_atts']['class'][]  		= ( !in_array( $main_wrap_alignment, array( '' ) ) ) ? 'jus-con-' . $main_wrap_alignment : '';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= 'powernode-social-icons';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content -----------------------------------------------------------------------------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 				= array( 'fbx-icons', 'fbx-soc-icons', 'row' );
		$data_attr['class'][] 				= ( !in_array( $icon_view, array( '' ) ) ) ? 'ico-view-' . $icon_view : '';
		$data_attr['class'][] 				= ( !in_array( $icon_view, array( '', 'default' ) ) && !in_array( $icon_shape, array( '', 'default' ) ) ) ? 'bxim-shape-' . $icon_shape : '';
		$data_attr['class'][] 				= ( in_array( $icon_color, array( 'colored' ) ) ) ? 'btn-colored' : '';
		$data_attr['class'][] 				= ( in_array( $icon_hover_color, array( 'colored' ) ) ) ? 'colored-hover' : '';
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] 			= 'wow';
			$data_attr['class'][] 			= $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		// Items --------------------------------------------------
		
		if( !empty( $icon_items ) ) {
			
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
	
			foreach( $icon_items as $k => $item ) {
				
				$icon_attr = array();
				$icon_attr['class'] = array( 'fbx-icon', 'bx-ico-img' );
				$icon_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
				$icon_attr['class'][] = ( !in_array( $icon_color, array( '', 'default', 'colored', 'custom' ) ) || !in_array( $icon_hover_color, array( '', 'default', 'colored', 'custom' ) ) ) ? 'btn' : '';
				$icon_attr['class'][] = ( !empty( $icon_color ) && !in_array( $icon_color, array( 'default', 'colored', 'custom' ) ) ) ? 'btn-' . $icon_color : 'btn-clr-' . $icon_color;
				$icon_attr['class'][] = ( !in_array( $icon_hover_color, array( '', 'default', 'colored', 'custom' ) ) ) ? $icon_hover_color . '-hover' : 'btn-hclr-' . $icon_hover_color;
				$icon_attr['class'][] = ( !in_array( $item['icon'], array( '', 'custom' ) ) ) ? 'ico-'. $item['icon'] : '';
				
				$icon_attr = $icon_attr + powernodewt_get_url_data( $item['link'] );
				
				$args['sec_content'] .= '<a ' . powernodewt_stringify_atts( $icon_attr ) . '>';
				
				if( !empty( $item['icon'] ) ) {
					if( $item['icon'] != 'custom' ) {
						$args['sec_content'] .= '<span class="flaticon-' . esc_attr( $item['icon'] ) .'"></span>';
					} else {
						$args['sec_content'] .= '<span title="' . esc_attr($item['icon_alt_custom']) .'" class="' . esc_attr($item['icon_custom']) .'"></span>';
					}
				}
				
				$args['sec_content'] .= '</a>';
			}
			
			// Icons ----------------------------------------
			$icon_css_ar = array();
			if ( !in_array( $icon_size, array( '', '22px' ) ) ) {
				$icon_css_ar['font-size'] = $icon_size;
				if( !in_array( $icon_view, array( '', 'default' ) ) ) {
					$icon_css_ar['width'] = 'calc(' . $icon_size . '*2.2)';
					$icon_css_ar['height'] = 'calc(' . $icon_size . '*2.2)';
				}
			}
			
			if ( $icon_color == 'custom' ) {
				if( !empty( $icon_bg_color ) && $icon_view == 'stacked' ) $icon_css_ar['background-color'] = $icon_bg_color;
				if( !empty( $icon_text_color ) ) $icon_css_ar['color'] = $icon_text_color;
				if( !empty( $icon_border_color ) ) $icon_css_ar['border-color'] = $icon_border_color;
			}
			
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon' => $icon_css_ar ) );
			
			if ( $icon_hover_color == 'custom' ) {
				$icon_hover_css_ar = array();
				if( !empty( $icon_bg_hcolor ) && $icon_view == 'stacked' ) $icon_hover_css_ar['background-color'] = $icon_bg_hcolor . ' !important';
				if( !empty( $icon_text_hcolor ) ) $icon_hover_css_ar['color'] = $icon_text_hcolor;
				if( !empty( $icon_border_hcolor ) ) $icon_hover_css_ar['border-color'] = $icon_border_hcolor . ' !important';
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .fbx-icon:hover' => $icon_hover_css_ar ) );
			}
							
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
		powernodewt_exts_get_template( 'shortcodes/social-icons', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_social_icons', 'powernodewt_social_icons' );