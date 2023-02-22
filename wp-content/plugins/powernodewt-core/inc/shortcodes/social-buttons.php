<?php
/*
Element Description: Social Buttons
*/

if ( ! function_exists( 'social_buttons' ) ) :

	function social_buttons( $atts = array() ) {

		$wrapperClass = $css = $el_classes = '';

		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'title'							=> '',
			'social_type'					=> powernodewt_social_type(),
			'social_display_type' 			=> powernodewt_social_links_display_type(),
			'social_icon_style' 			=> powernodewt_social_links_icon_style(),
			'social_icon_shape'  	   		=> powernodewt_social_links_icon_shape(),
			'social_icon_size'  	   		=> powernodewt_social_links_icon_size(),
			'social_links' 	 		  		=> array(),
			'social_share_links' 	 		=> array(),
			'social_profiles_links' 	 	=> array(),
			'social_links_data' 	   		=> powernodewt_social_links_data(),
			'social_icon_settings' 	   		=> powernodewt_social_links_settings(),
			'el_classes' 						=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode',
		), $atts);
		
		if ( $atts['social_type'] == 'share' ) {
			$atts['social_display_type'] 	= powernodewt_social_share_links_display_type();
			$atts['social_icon_style'] 		= powernodewt_social_share_links_icon_style();
			$atts['social_icon_shape'] 		= powernodewt_social_share_links_icon_shape();
			$atts['social_icon_size'] 		= powernodewt_social_share_links_icon_size();
			$atts['social_links_data'] 		= powernodewt_social_share_links_data();
			$atts['social_icon_settings'] 	= powernodewt_social_share_links_settings();
		}
		
		if ( $atts['shortcode_from'] == 'vc' ) {

			$vc_social_links = ( $atts['social_type'] == 'share' ) ? $atts['social_share_links'] : $atts['social_profiles_links'];
			$share_link = explode( ',', $vc_social_links );
			$atts['social_links'] = $share_link;
		}
				
		extract($atts);
			
		$args = $data_attr = array();
		$css_output					= '';
		$args						= $atts;
		$args['id']  				= powernodewt_uniqid('powernode-social-buttons-');
		$args['wrap_atts'] 			= array();
		$args['wrap_style_css'] 	= array();
		$args['sec_content'] 	    = '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-social-buttons';
		$args['wrap_atts']['class'][] 		= 'pnwt-social-btns';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
		
		// Section Heading --------------------------
		if ( $title != '' ) {
			$args['wrap_atts']['class'][] = 'sec-title';
			$args['sec_heading'] =  ( $title != '' ) ? '<h2 class="sec-title">' . powernodewt_js_remove_wpautop( $title, true ) . '</h2>' : '';
		}
		
		// Section Content --------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] 				= array( 'social-links' );
		$data_attr['class'][] 				= ( ! empty( $el_classes ) ) ? $el_classes : '';
		
		$data_attr['class'][] 				= 'social-links-'.$social_display_type;
		if ( $social_type == 'share' ) {
			$data_attr['class'][] 			= 'social-share-links';
		} else {
			$data_attr['class'][] 			= 'social-icons';
		}
		$data_attr['class'][] 				= 'social-icon-style-'.$social_icon_style;
		$data_attr['class'][] 				= 'social-icon-shape-'.$social_icon_shape;
		$data_attr['class'][] 				= 'social-icon-size-'.$social_icon_size;
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
	
		$social_html = '';
		if ( ! empty( $social_links_data ) ) {
			
			$social_links_loop = array();
			if ( !empty( $social_links ) ) {
				foreach( $social_links as $key => $icon_name ) {
					if ( !empty( $social_links_data[$icon_name] ) ) {
						$social_links_loop[$icon_name] = $social_links_data[$icon_name];
					}
				}
				
				if ( !empty( $social_links_loop ) ) {
					$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';
					foreach ( $social_links_loop as $icon_name => $icon_det ) {
						$href = '';
						if ( $social_type == 'share' ) {
							$href = $social_links_loop[$icon_name]['url'];
							if ( !empty( $href ) ) {
								preg_match_all( '/{[^}]*}/', $href, $matches );
								if ( !empty( $matches[0] ) ) {
									foreach( $matches[0] as $pram_key => $social_param ) {
										switch ( $social_param ) {
											case '{url}':
												$href = str_replace( $social_param, urlencode(get_the_permalink()), $href );
												break;
											case '{title}':
											case '{description}':
												$post_title = html_entity_decode( esc_attr( rawurlencode( get_the_title() ) ), ENT_COMPAT, 'UTF-8');
												$href = str_replace( $social_param, $post_title, $href );
												break;
											case '{thumb_url}':
												$thumb_id = get_post_thumbnail_id();
												$thumb_url = wp_get_attachment_image_src( $thumb_id, 'thumbnail-size', true );
												$href = str_replace( $social_param, $thumb_url[0], $href );
												break;
										}
									}
								}
							}
							
						} else {
							if ( !empty( $social_icon_settings[$icon_name] ) ) {
								if ( $icon_name == 'email' ) {
									$href = 'mailto:'.$social_icon_settings[$icon_name];
								} else {
									$href = $social_icon_settings[$icon_name];
								}
							}
						}
						if ( isset( $icon_det['icon_class'] ) ) {
							$icon_det['icon_class'] .= ' btn-' . $social_icon_size;
						}
						$args['sec_content'] .= '<a href="'.esc_attr( $href ).'" class="social-link social-'.$icon_name.'" title = "'.esc_attr( $icon_det['label'] ).'" target="_blank">';
						
						if ( in_array( $social_display_type, array( 'default', 'icon-label' ) ) ) {
							$args['sec_content'] .= '<span class="icon"><i class="'.esc_attr( $icon_det['icon_class'] ).'"></i></span>';
						}
						if ( in_array( $social_display_type, array( 'label', 'icon-label' ) ) ) {
							$args['sec_content'] .= '<span class="text">'.esc_attr( $icon_det['label'] ).'</span>';
						}
						$args['sec_content'] .= '</a>';
					}
					$args['sec_content'] .= '</div>';
				}
			}
		}

		if ( ! empty( $args['wrap_style_css'] ) ) {
			$args['wrap_atts']['style'] = powernodewt_stringify_classes( $args['wrap_style_css'] );
			unset( $args['wrap_style_css'] );
		}

		// Output Css
		if ( ! empty( $css_output ) ) {
			powernodewt_exts_css_output( $css_output, $args );
		}
		
		$html = '';
		ob_start();
		powernodewt_exts_get_template( 'shortcodes/social-buttons', $args );
		$html = ob_get_clean();
		
	    return $html;
		 	 
	}
endif;

add_shortcode( 'powernode_social_buttons', 'social_buttons' );