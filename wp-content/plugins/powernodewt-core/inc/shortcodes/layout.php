<?php
/*
Element Description: Layout
*/

if ( ! function_exists( 'powernodewt_layout' ) ) :

	function powernodewt_layout( $atts, $content = null  ) {
		
		$atts = shortcode_atts(array(
			'id'					=> '',
			'content_size'			=> 'div',
			'content_font_size'		=> '',
			'content_el_classes' 	=> '',
		), $atts);
				
		extract($atts);
		
		if( !empty( $id ) ) {
			if ( class_exists( 'Elementor\Plugin' ) ) {
				$content   = Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id );
			} else {
				$content   = do_shortcode( get_post_field( 'post_content', $id ) );
			}
		}
			
		$args = $data_attr 					= array();
		$css_output							= '';
		$args								= $atts;
		$args['id']  						= powernodewt_uniqid('powernode-layout-');
		$args['wrap_atts'] 					= array();
		$args['wrap_style_css'] 			= array();
		$args['sec_content'] 	    		= '';
		
		$args['wrap_atts']['id'] 			= $args['id'];
		$args['wrap_atts']['class'] 		= array( 'powernode-element' );
		$args['wrap_atts']['class'][] 		= 'powernode-layout';
		$args['wrap_atts']['class'][] 		= 'pnwt-layout';
		$args['wrap_atts']['class'][] 		= ( ! empty( $wrap_el_classes ) ) ? $wrap_el_classes : '';
		
		if( !empty( $animation ) ) {
			$args['wrap_atts']['class'][] = 'wow';
			$args['wrap_atts']['class'][]  = $animation;
			if ( !empty( $animation_delay ) ) $args['wrap_atts']['data-wow-delay'] = $animation_delay;
		}		
	
		// Content -----------------------------------------
		
		if( !empty( $content ) ) {
			$content_attr = array();
			$content_attr['class'] = array( 'layout-content' );
			$content_attr['class'][] = ( !in_array( $content_font_size, array( '', 'custom' ) ) ) ? powernodewt_font_size_class( $content_size, $content_font_size ) : '';
			$content_attr['class'][] = ( ! empty( $content_el_classes ) ) ? $content_el_classes : '';
			
			if( in_array( $content_size, array( '', 'p' ) ) ) {
				$args['sec_content'] .= '<p ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</p>';
			} else {
				$args['sec_content'] .= '<'. $content_size .' ' . powernodewt_stringify_atts( $content_attr ) . '>' . do_shortcode( $content ) . '</'. $content_size .'>';
			}
		}
		
		if ( ! empty( $args['wrap_style_css'] ) ) {
			$args['wrap_atts']['style'] = powernodewt_stringify_classes( $args['wrap_style_css'] );
			unset( $args['wrap_style_css'] );
		}

		$html = '';
		ob_start();
		powernodewt_exts_get_template( 'shortcodes/layout', $args );
		$html = ob_get_clean();
		
	    return $html;
	}
endif;

add_shortcode( 'powernode_layout', 'powernodewt_layout' );