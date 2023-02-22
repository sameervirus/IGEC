<?php
/*
Element Description: Icon List
*/

if ( ! function_exists( 'powernodewt_icon_list' ) ) :

	function powernodewt_icon_list( $atts = array() ) {

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'items'							=> array(),
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'wrap_el_classes' 				=> '',
			'list_item_gap'					=> '',
			'list_item_alignment'			=> 'ver',
			'list_item_ver_alignment'		=> 'start',
			'list_item_ver_alignment_tablet' => '',
			'list_item_ver_alignment_mobile' => '',
			'list_item_hor_alignment'		=> '',
			'list_item_hor_alignment_tablet'=> '',
			'list_item_hor_alignment_mobile'=> '',
			'show_list_item_devider'		=> 0,
			'list_item_color'				=> '',
			'list_item_color_custom'		=> '',
			'list_item_el_classes'			=> '',
			'devider_size'					=> '1px',
			'devider_style'					=> 'solid',
			'devider_color_custom'			=> '',
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
			'content_size'					=> 'div',
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
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-list-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-list';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content -----------------------------------------------------------------------------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 				= array( 'list-section', 'division' );
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] 			= 'wow';
			$data_attr['class'][] 			= $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		// Items --------------------------------------------------
		
		if( !empty( $items ) ) {
			
			$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
			
			$items_car_atts = array();
			$items_car_atts['class'][] = 'pnwt-list simple-list';
			
			// Content Style
			$items_car_atts['class'][] = 'list-align-' . $list_item_alignment;
			$items_car_atts['class'][] = ( !in_array( $list_item_ver_alignment, array( '' ) ) ) ? 'align-itms-' . $list_item_ver_alignment : '';
			$items_car_atts['class'][] = ( !in_array( $list_item_ver_alignment_tablet, array( '' ) ) ) ? 'align-itms-md-' . $list_item_ver_alignment_tablet : '';
			$items_car_atts['class'][] = ( !in_array( $list_item_ver_alignment_mobile, array( '' ) ) ) ? 'align-itms-sm-' . $list_item_ver_alignment_mobile : '';
			$items_car_atts['class'][] = ( !in_array( $list_item_hor_alignment, array( '' ) ) ) ? 'jus-con-' . $list_item_hor_alignment : '';
			$items_car_atts['class'][] = ( !in_array( $list_item_hor_alignment_tablet, array( '' ) ) ) ? 'jus-con-md-' . $list_item_hor_alignment_tablet : '';
			$items_car_atts['class'][] = ( !in_array( $list_item_hor_alignment_mobile, array( '' ) ) ) ? 'jus-con-sm-' . $list_item_hor_alignment_mobile : '';
			$items_car_atts['class'][] = ( !in_array( $list_item_color, array( '', 'custom', 'default' ) ) ) ? $list_item_color . '-color' : '';
			$items_car_atts['class'][] = ( $show_list_item_devider == 1 ) ? 'item-devider' : '';
			$items_car_atts['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
			
			
			$args['sec_content'] .= '<ul ' . powernodewt_stringify_atts( $items_car_atts ) . '>';
			
				
				$icon_type_ar = array();
				
				foreach( $items as $k => $item ) {
					
					$icon_type = $item['icon_type'];
					$flat_icon 	= $item['flat_icon'];
					$icon 		= $item['icon'];
					$image 		= $item['image'];
					$title 		= $item['title'];
					$content 	= $item['content'];
					
					$image_size = '150x150';
					
					if( $icon_type == 'image' ) {
						$image = ( !empty( $item['image']['url'] ) ) ? $item['image'] : $atts['image'];
						if ( $item['thumbnail_size'] == 'custom' && !empty( $item['thumbnail_custom_dimension']['width'] ) && !empty( $item['thumbnail_custom_dimension']['height'] )  ) {
							$image_size = $item['thumbnail_custom_dimension']['width'].'x'.$item['thumbnail_custom_dimension']['height'];
						} else {
							$image_size = $item['thumbnail_size'];
						}
					}
											
					$item_attr = array();
					$item_attr['class'] = array( 'list-item');
					$item_attr['class'][] = ( !empty( $icon_type ) ) ? 'icon-type-'. $icon_type : '';
					$item_attr['class'][] = ( ! empty( $list_item_el_classes ) ) ? $list_item_el_classes : '';
					
					$args['sec_content'] .= '<li ' . powernodewt_stringify_atts( $item_attr ) . '>';
					
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
							$icon_attr['class'] = array( 'fbx-icon', 'bx-icon-wrap', 'bx-ico-img' );
							$icon_attr['class'][] = ( !in_array( $icon_color, array( '', 'custom', 'default' ) ) ) ? $icon_color . '-color' : '';
							$icon_attr['class'][] = ( !in_array( $icon_bg_color, array( '', 'custom', 'default' ) ) ) ? 'bg-' . $icon_bg_color : '';
							$icon_attr['class'][] = ( ! empty( $icon_el_classes ) ) ? $icon_el_classes : '';
						
							$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $icon_attr ) . '>';
							$args['sec_content'] .= $icon_content;
							$args['sec_content'] .= '</div>';
							
							$icon_type_ar[] = $icon_type;
						}
					}
					
					$content_wrap_attr = array();
					$content_wrap_attr['class'] = array( 'fbox-list-txt' );
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
						
						if( !empty( $item['link']['url'] ) ) {
							if( $title_size == 'a' ) {
								$title_attr = $title_attr + powernodewt_get_url_data( $item['link'] );
							} else {
								$args['sec_content'] .= '<a ' . powernodewt_stringify_atts( powernodewt_get_url_data( $item['link'] ) ) . '>';
							}
						}
						
						if( in_array( $title_size, array( '', 'h5' ) ) ) {
							$args['sec_content'] .= '<h5 ' . powernodewt_stringify_atts( $title_attr ) . '>' . wp_kses_post( $title ) . '</h5>';
						} else {
							$args['sec_content'] .= '<'. $title_size .' ' . powernodewt_stringify_atts( $title_attr ) . '>' . wp_kses_post( $title ) . '</'. $title_size .'>';
						}
						
						if( !empty( $item['link']['url'] ) && $title_size != 'a' ) {
							$args['sec_content'] .= '</a>';
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
						$content_attr['class'][] = ( !in_array( $content_alignment, array( '' ) ) ) ? 'txt-' . $content_alignment : '';
						$content_attr['class'][] = ( !in_array( $content_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $content_alignment_tablet : '';
						$content_attr['class'][] = ( !in_array( $content_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $content_alignment_mobile : '';
						$content_attr['class'][] = ( !in_array( $content_color, array( '', 'custom', 'default' ) ) ) ? $content_color . '-color' : '';
						$content_attr['class'][] = ( !empty( $content_el_classes ) ) ? $content_el_classes : '';
						
						if( in_array( $content_size, array( '', 'div' ) ) ) {
							$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</div>';
						} else {
							$args['sec_content'] .= '<'. $content_size .' ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</'. $content_size .'>';
						}
					}
					
					$args['sec_content'] .= '</div>';
					
					$args['sec_content'] .= '</li>';						
				}
				
				// General Style --------------------------------------
	
				$general_css_ar = array();
				if ( !empty(  $list_item_gap ) ) $general_css_ar['margin-bottom'] = $list_item_gap;
				if( !empty( $list_item_color == 'custom' && !empty( $list_item_color_custom ) ) ) $general_css_ar['color'] = $list_item_color_custom;
				if ( !empty(  $list_item_gap ) ) $general_css_ar['margin-bottom'] = $list_item_gap;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .pnwt-list li' => $general_css_ar ) );
				
				// Devider Style --------------------------------------
				
				if( !empty( $show_list_item_devider ) ) {
					$devider_css_ar = array();
					
					if ( $list_item_alignment == 'hor' ) {
						if( !empty( $devider_color_custom ) ) $devider_css_ar['color'] = $devider_color_custom;
						$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .item-devider.list-align-hor li:after' => $devider_css_ar ) );
					}
					
					if ( $list_item_alignment == 'ver' ) {
						if( !in_array( $devider_size, array( '', '1px' ) ) ) $devider_css_ar['border-width'] = $devider_size;
						if( !in_array(  $devider_style, array( '', 'default' ) ) ) $devider_css_ar['border-style'] = $devider_style;
						if( !empty( $devider_color_custom ) ) $devider_css_ar['border-color'] = $devider_color_custom;
						$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .item-devider.list-align-ver li:after' => $devider_css_ar ) );
					}
				}
				
				
				// Icon Style --------------------------------------
				
				if( !empty( $icon_type_ar ) ) {
					
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
				
				// Title ------------------------------------------
				
				$title_css_ar = array();
				if( $title_color == 'custom' ) $title_css_ar['color'] = $title_color_custom;
				if( $title_font_size == 'custom' ) $title_css_ar['font-size'] = $title_custom_font_size;
				if( $title_line_height != '' ) $title_css_ar['line-height'] = $title_line_height;
				if( $title_letter_spacing != '' ) $title_css_ar['letter-spacing'] = $title_letter_spacing;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-title' => $title_css_ar ) );
				
				// Content -----------------------------------------
				
				$content_css_ar = array();
				if( $content_color == 'custom' ) $content_css_ar['color'] = $content_color_custom;
				if( $content_font_size == 'custom' ) $content_css_ar['font-size'] = $content_custom_font_size;
				if( $content_line_height != '' ) $content_css_ar['line-height'] = $content_line_height;
				if( $content_letter_spacing != '' ) $content_css_ar['letter-spacing'] = $content_letter_spacing;
				$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-content' => $content_css_ar ) );
					
				$args['sec_content'] .= '</ul>';
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
		powernodewt_exts_get_template( 'shortcodes/image-carousel', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_icon_list', 'powernodewt_icon_list' );