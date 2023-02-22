<?php
/*
Element Description: Team Member
*/

if ( ! function_exists( 'powernodewt_team_member' ) ) :

	function powernodewt_team_member( $atts = array(), $content = null ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'team_style'					=> 'team-1',
			'icon_type'						=> '',
			'image'							=> '',
			'thumbnail_size'				=> 'thumbnail',
			'thumbnail_custom_dimension'	=> array(),
			'name'							=> '',
			'icon_items'					=> array(),
			'title'							=> '',
			'link'							=> '',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'image_rounded_cornors'			=> 'rounded',
			'image_alignment'				=> '',
			'image_alignment_tablet'		=> '',
			'image_alignment_mobile'		=> '',
			'hover_overlay'					=> true,
			'image_below_padding'			=> '',
			'image_wrap_el_classes'			=> '',
			'content_wrap_bg_color'			=> '',
			'content_wrap_bg_color_custom'	=> '',
			'content_wrap_el_classes'		=> '',
			'name_size'						=> 'h6',
			'name_font_size'				=> '',
			'name_custom_font_size'			=> '',
			'name_font_weight'				=> '',
			'name_font_style'				=> '',
			'name_text_transform'			=> '',
			'name_color'					=> '',
			'name_color_custom'				=> '',
			'name_line_height'				=> '',
			'name_letter_spacing'			=> '',
			'name_alignment'				=> 'left',
			'name_alignment_tablet'			=> '',
			'name_alignment_mobile'			=> '',
			'name_el_classes'				=> '',
			'title_size'					=> 'h5',
			'title_font_size'				=> '',
			'title_custom_font_size'		=> '',
			'title_font_weight'				=> '',
			'title_font_style'				=> '',
			'title_text_transform'			=> '',
			'title_color'					=> '',
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
			'icon_alignment'				=> '',
			'icon_alignment_tablet'			=> '',
			'icon_alignment_mobile'			=> '',
			'icon_ver_alignment'			=> '',
			'icon_ver_alignment_tablet'		=> '',
			'icon_ver_alignment_mobile'		=> '',
			'icon_el_classes' 				=> '',
			'icon_wrap_el_classes' 			=> '',
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
				
		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-team-member-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-team-member';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------
		
		if( !empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 				= array( 'pnwt-team-member', 'pnwt-bxim', 'fbox-10' );
		$data_attr['class'][] = ( !empty( $team_style ) ) ? 'bx-' . $team_style : 'bx-team-1';
		$data_attr['class'][] = ( !empty( $hover_overlay ) ) ? 'hover-overlay-action' : '';
		$data_attr['class'][] = ( !empty( $el_classes ) ) ? $el_classes : '';	
		$data_attr['class'][] = ( !empty( $icon_type ) ) ? 'media-' . $icon_type : '';
		$data_attr['class'][] = ( !in_array( $icon_view, array( '', 'default' ) ) ) ? 'bxim-view-' . $icon_view : '';
		$data_attr['class'][] = ( !in_array( $icon_view, array( '' ) ) ) ? 'ico-view-' . $icon_view : '';
		$data_attr['class'][] = ( !in_array( $icon_view, array( '', 'default' ) ) && !in_array( $icon_shape, array( '', 'default' ) ) ) ? 'bxim-shape-' . $icon_shape : '';
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
		
		
		$data_inner_attr = array();
		$data_inner_attr['class'] 			= array( 'team-member' );
		if( !empty( $link['url'] ) ) {
			$data_inner_attr['role'] 		= 'button';
			$data_inner_attr['onclick'] 	= 'window.location="'.$link['url'].'"';
		}
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_inner_attr ) . '>';
		
		
		// Image ---------------------------------------
		
		if( !empty( $image ) ) {
			
			$image_attr = array();
			$image_attr['class'] = array( 'team-member-photo', 'bx-img' );
			$image_attr['class'][] = ( !in_array( $image_alignment, array( '' ) ) ) ? 'txt-' . $image_alignment : '';
			$image_attr['class'][] = ( !in_array( $image_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $image_alignment_tablet : '';
			$image_attr['class'][] = ( !in_array( $image_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $image_alignment_mobile : '';
			$image_attr['class'][] = ( ! empty( $hover_overlay ) ) ? 'hover-overlay' : '';
			$image_attr['class'][] = ( ! empty( $image_rounded_cornors ) ) ? $image_rounded_cornors : '';
			$image_attr['class'][] = ( ! empty( $image_el_classes ) ) ? $image_el_classes : '';
			
			$image_size = '';
			if ( $thumbnail_size == 'custom' && !empty( $thumbnail_custom_dimension['width'] ) && !empty( $thumbnail_custom_dimension['height'] )  ) {
				$image_size = $thumbnail_custom_dimension['width'].'x'.$thumbnail_custom_dimension['height'];
			} else {
				$image_size = $thumbnail_size;
			}
			
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $image_attr ) . '>';
			$args['sec_content'] .= ( !empty( $image['id'] ) ) ? powernodewt_get_image_html( array( 'attach_id' => $image['id'], 'size' => $image_size ) ) :  '<img src="' . $image['url'] . '" />';
			
			// Icons -----------------------------------------
		
			if( !empty( $icon_items ) ) {
				
				$data_attr = array();
				$data_attr['class'] 				= array( 'fbx-icons', 'fbx-soc-icons', 'row', 'tm-social clearfix text-center' );
				$data_attr['class'][] 				= ( !in_array( $icon_view, array( '', 'default' ) ) ) ? 'bxim-view-' . $icon_view : '';
				$data_attr['class'][] 				= ( !in_array( $icon_view, array( '' ) ) ) ? 'ico-view-' . $icon_view : '';
				$data_attr['class'][] 				= ( !in_array( $icon_view, array( '', 'default' ) ) && !in_array( $icon_shape, array( '', 'default' ) ) ) ? 'bxim-shape-' . $icon_shape : '';
				$data_attr['class'][] 				= ( in_array( $icon_color, array( 'colored' ) ) ) ? 'btn-colored' : '';
				$data_attr['class'][] 				= ( in_array( $icon_hover_color, array( 'colored' ) ) ) ? 'colored-hover' : '';
				
				$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
				$args['sec_content'] .= '<ul>';
		
				foreach( $icon_items as $k => $item ) {
					
					$icon_attr = array();
					$icon_attr['class'] = array( 'fbx-icon', 'bx-ico-img' );
					$icon_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
					$icon_attr['class'][] = ( !in_array( $icon_color, array( '', 'default', 'colored', 'custom' ) ) || !in_array( $icon_hover_color, array( '', 'default', 'colored', 'custom' ) ) ) ? 'btn' : '';
					$icon_attr['class'][] = ( !empty( $icon_color ) && !in_array( $icon_color, array( 'default', 'colored', 'custom' ) ) ) ? 'btn-' . $icon_color : 'btn-clr-custom';
					$icon_attr['class'][] = ( !empty( $icon_hover_color ) && !in_array( $icon_hover_color, array( 'default', 'colored', 'custom' ) ) ) ? $icon_hover_color . '-hover' : 'btn-hclr-custom';
					$icon_attr['class'][] = ( !in_array( $item['icon'], array( '', 'custom' ) ) ) ? 'ico-'. $item['icon'] : '';
					$icon_attr = $icon_attr + powernodewt_get_url_data( $item['link'] );
				
					$args['sec_content'] .= '<li>';
					$args['sec_content'] .= '<a ' . powernodewt_stringify_atts( $icon_attr ) . '>';
					
					if( !empty( $item['icon'] ) ) {
						if( $item['icon'] != 'custom' ) {
							$args['sec_content'] .= '<span class="flaticon-' . esc_attr( $item['icon'] ) .'"></span>';
						} else {
							$args['sec_content'] .= '<span title="' . esc_attr($item['icon_alt_custom']) .'" class="' . esc_attr($item['icon_custom']) .'"></span>';
						}
					}
					
					$args['sec_content'] .= '</a>';
					$args['sec_content'] .= '</li>';
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
					
				$args['sec_content'] .= '</ul>';
				$args['sec_content'] .= '</div>';
			}
			
			$args['sec_content'] .= '</div>';
					
		}
		
		$content_wrap_attr = array();
		$content_wrap_attr['class'] = array( 'tm-meta fbox-txt' );
		$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
		$content_wrap_attr['class'][] = ( !in_array( $content_wrap_bg_color, array( '', 'custom', 'default' ) ) ) ? 'bg-' . $content_wrap_bg_color : '';
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_wrap_attr ) . '>';
		
		$content_wrap_css_ar = array();
		if( $content_wrap_bg_color_custom == 'custom' ) $content_wrap_bg_color['background-color'] = $content_wrap_bg_color;
		$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .tm-meta' => $content_wrap_css_ar ) );
		
		// Name ----------------------------------------
		
		if( !empty( $name ) ) {
			$name_attr = array();
			$name_attr['class'] = array( 'bx-name' );
			$name_attr['class'][] = ( !in_array( $name_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $name_size, $name_font_size ) : '';
			$name_attr['class'][] = ( !in_array( $name_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $name_font_weight : '';
			$name_attr['class'][] = ( !in_array( $name_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $name_font_style : '';
			$name_attr['class'][] = ( !in_array( $name_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $name_text_transform : '';
			$name_attr['class'][] = ( !in_array( $name_alignment, array( '' ) ) ) ? 'txt-' . $name_alignment : '';
			$name_attr['class'][] = ( !in_array( $name_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $name_alignment_tablet : '';
			$name_attr['class'][] = ( !in_array( $name_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $name_alignment_mobile : '';
			$name_attr['class'][] = ( !in_array( $name_color, array( '', 'custom', 'default' ) ) ) ? $name_color . '-color' : '';
			$name_attr['class'][] = ( ! empty( $name_el_classes ) ) ? $name_el_classes : '';
			
			if( in_array( $name_size, array( '', 'h5' ) ) ) {
				$args['sec_content'] .= '<h5 ' . powernodewt_stringify_atts( $name_attr ) . '>' . do_shortcode( $name ) . '</h5>';
			} else {
				$args['sec_content'] .= '<'. $name_size .' ' . powernodewt_stringify_atts( $name_attr ) . '>' . do_shortcode( $name ) . '</'. $name_size .'>';
			}
			
			$name_css_ar = array();
			if( $name_color == 'custom' ) $name_css_ar['color'] = $name_color_custom;
			if( $name_font_size == 'custom' ) $name_css_ar['font-size'] = $name_custom_font_size;
			if( $name_line_height != '' ) $name_css_ar['line-height'] = $name_line_height;
			if( $name_letter_spacing != '' ) $name_css_ar['letter-spacing'] = $name_letter_spacing;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-name' => $name_css_ar ) );
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
		powernodewt_exts_get_template( 'shortcodes/team-member', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_team_member', 'powernodewt_team_member' );