<?php
/*
Element Description: Countdown
*/
if ( ! function_exists( 'powernodewt_countdown' ) ) :

	function powernodewt_countdown( $atts = array() ) {
		
		$atts = shortcode_atts(array(
			'display_type'					=> 'shortcode',
			'launch_date'					=> '',
			'days_text'						=> 'DAYS',
			'hours_text'					=> 'HRS',
			'mins_text'						=> 'MIN',
			'secs_text'						=> 'SEC',
			'animation'						=> '',
			'animation_delay'				=> '',
			'el_classes' 					=> '',
			'main_wrap_alignment'			=> '',
			'show_counter_devider'			=> '1',
			'devider_size'					=> '1px',
			'devider_style'					=> 'solid',
			'devider_color_custom'			=> '',
			'number_size'					=> 'h5',
			'number_font_size'				=> '',
			'number_custom_font_size'		=> '',
			'number_font_weight'				=> '',
			'number_font_style'				=> '',
			'number_text_transform'			=> '',
			'number_color'					=> 'default',
			'number_color_custom'			=> '',
			'number_line_height'				=> '',
			'number_letter_spacing'			=> '',
			'number_alignment'				=> 'left',
			'number_alignment_tablet'		=> '',
			'number_alignment_mobile'		=> '',
			'number_el_classes'				=> '',
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
			'wrap_id' 						=> '',
			'wrap_el_classes' 				=> '',
			'css'					   		=> '',
			'shortcode_from'				=> 'shortcode'
		), $atts);
				
		extract($atts);
		
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-countdown-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-countdown';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		$args['wrap_atts']['class'][] 		= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
				
		// Section Content --------------------------
		
		if( ! empty( $wrap_id ) ) $data_attr['id'] = $wrap_id;
		$data_attr['class'] = array( 'pnwt-countdown' );
		$data_attr['class'][] = ( ! empty( $el_classes ) ) ? $el_classes : '';
		
		if( !empty( $animation ) ) {
			$data_attr['class'][] = 'wow';
			$data_attr['class'][] = $animation;
			if ( !empty( $animation_delay ) ) $data_attr['data-wow-delay'] = $animation_delay;
		}
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $data_attr ) . '>';

		$content_wrap_attr = array();
		$content_wrap_attr['class'] = array( 'clock-wrap' );
		$content_wrap_attr['class'][] = ( ! empty( $content_wrap_el_classes ) ) ? $content_wrap_el_classes : '';
		$content_wrap_attr['class'][] = ( ! empty( $show_counter_devider ) ) ? 'clock-devider' : '';
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $content_wrap_attr ) . '>';
		
		$counter_wrap_attr = array();
		$counter_wrap_attr['id'] = 'clock';
		$counter_wrap_attr['class'] = array( 'clock-main' );
		$counter_wrap_attr['class'][] = ( !in_array( $main_wrap_alignment, array( '' ) ) ) ? 'jus-con-' . $main_wrap_alignment : '';
		
		$args['sec_content'] .= '<div ' . powernodewt_stringify_atts( $counter_wrap_attr ) . '>';
		
		$countdowns = array( 
			'days' => array( 'number' => '%D', 'text' => $days_text ),
			'hours' => array( 'number' => '%H', 'text' => $hours_text ), 
			'mins' => array( 'number' => '%M', 'text' => $mins_text ), 
			'secs' => array( 'number' => '%S', 'text' => $secs_text ), 
		);
		$countdown_html = '';
		
		foreach( $countdowns as $k => $countdown  ) {
			
			$item_wrap_attr = array();
			$item_wrap_attr['class'] = array( 'cbox-1 clearfix' );	
			
			$countdown_html .= '<div ' . powernodewt_stringify_atts( $item_wrap_attr ) . '>';
			
			
			
			
			// Number ----------------------------------------
			
			if( !empty( $countdown['number'] ) ) {
				$number_attr = array();
				$number_attr['class'] = array( 'bx-numbers', 'cbox-1-digit' );
				$number_attr['class'][] = ( !in_array( $number_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $number_size, $number_font_size ) : '';
				$number_attr['class'][] = ( !in_array( $number_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $number_font_weight : '';
				$number_attr['class'][] = ( !in_array( $number_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $number_font_style : '';
				$number_attr['class'][] = ( !in_array( $number_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $number_text_transform : '';
				$number_attr['class'][] = ( !in_array( $number_alignment, array( '' ) ) ) ? 'txt-' . $number_alignment : '';
				$number_attr['class'][] = ( !in_array( $number_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $number_alignment_tablet : '';
				$number_attr['class'][] = ( !in_array( $number_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $number_alignment_mobile : '';
				$number_attr['class'][] = ( !in_array( $number_color, array( '', 'custom', 'default' ) ) ) ? $number_color . '-color' : '';
				$number_attr['class'][] = ( ! empty( $number_el_classes ) ) ? $number_el_classes : '';
				
				if( in_array( $number_size, array( '', 'span' ) ) ) {
					$countdown_html .= '<span ' . powernodewt_stringify_atts( $number_attr ) . '>' . wp_kses_post( $countdown['number'] ) . '</span>';
				} else {
					$countdown_html .= '<'. $number_size .' ' . powernodewt_stringify_atts( $number_attr ) . '>' . wp_kses_post( $countdown['number'] ) . '</'. $number_size .'>';
				}
			}
				
			// Title ----------------------------------------
			
			if( !empty( $countdown['text'] ) ) {
				$title_attr = array();
				$title_attr['class'] = array( 'bx-title', 'cbox-1-txt' );
				$title_attr['class'][] = ( !in_array( $title_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $title_size, $title_font_size ) : '';
				$title_attr['class'][] = ( !in_array( $title_font_weight, array( '', 'medium' ) ) ) ? 'fw-' . $title_font_weight : '';
				$title_attr['class'][] = ( !in_array( $title_font_style, array( '', 'normal', 'default' ) ) ) ? 'font-' . $title_font_style : '';
				$title_attr['class'][] = ( !in_array( $title_text_transform, array( '', 'normal' ) ) ) ? 'text-' . $title_text_transform : '';
				$title_attr['class'][] = ( !in_array( $title_alignment, array( '' ) ) ) ? 'txt-' . $title_alignment : '';
				$title_attr['class'][] = ( !in_array( $title_alignment_tablet, array( '' ) ) ) ? 'txt-md-' . $title_alignment_tablet : '';
				$title_attr['class'][] = ( !in_array( $title_alignment_mobile, array( '' ) ) ) ? 'txt-sm-' . $title_alignment_mobile : '';
				$title_attr['class'][] = ( !in_array( $title_color, array( '', 'custom', 'default' ) ) ) ? $title_color . '-color' : '';
				$title_attr['class'][] = ( ! empty( $title_el_classes ) ) ? $title_el_classes : '';
				
				if( in_array( $title_size, array( '', 'span' ) ) ) {
					$countdown_html .= '<span ' . powernodewt_stringify_atts( $title_attr ) . '>' . wp_kses_post( $countdown['text'] ) . '</span>';
				} else {
					$countdown_html .= '<'. $title_size .' ' . powernodewt_stringify_atts( $title_attr ) . '>' . wp_kses_post( $countdown['text'] ) . '</'. $title_size .'>';
				}
			}
			
			$countdown_html .= '</div>';
		}
		
		// General Style --------------------------------------
		if( !empty( $show_counter_devider ) && !empty( $countdown_html ) ) {
			$devider_css_ar = array();
			if( !in_array( $devider_size, array( '', '1px' ) ) ) $devider_css_ar['border-width'] = $devider_size;
			if( !in_array(  $devider_style, array( '', 'default' ) ) ) $devider_css_ar['border-style'] = $devider_style;
			if( !empty( $devider_color_custom ) ) $devider_css_ar['border-color'] = $devider_color_custom;
			$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .cbox-1:after' => $devider_css_ar ) );		
		}
		
		// Number Style ----------------------------------------
		$number_css_ar = array();
		if( $number_color == 'custom' ) $number_css_ar['color'] = $number_color_custom;
		if( $number_font_size == 'custom' ) $number_css_ar['font-size'] = $number_custom_font_size;
		if( $number_line_height != '' ) $number_css_ar['line-height'] = $number_line_height;
		if( $number_letter_spacing != '' ) $number_css_ar['letter-spacing'] = $number_letter_spacing;
		$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-number' => $number_css_ar ) );
		
		// Title Style -----------------------------------------
		$title_css_ar = array();
		if( $title_color == 'custom' ) $title_css_ar['color'] = $title_color_custom;
		if( $title_font_size == 'custom' ) $title_css_ar['font-size'] = $title_custom_font_size;
		if( $title_line_height != '' ) $title_css_ar['line-height'] = $title_line_height;
		if( $title_letter_spacing != '' ) $title_css_ar['letter-spacing'] = $title_letter_spacing;
		$css_output .= powernodewt_output_css( array( '#'. $args['id'] . ' .bx-title' => $title_css_ar ) );
		
		$args['sec_content'] .= '</div>';
		
		if( !empty( $launch_date ) && !empty( $countdown_html ) ) {
			$args['sec_content'] .= "<script>
			jQuery(document).ready(function() {
				jQuery('#" . $args['id'] . " #clock').countdown('". $launch_date ."', function(event) {
				jQuery(this).html( event.strftime('".$countdown_html."'));
				});
			});
			</script>";
		}
		
		
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
		powernodewt_exts_get_template( 'shortcodes/features-box', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_countdown', 'powernodewt_countdown' );