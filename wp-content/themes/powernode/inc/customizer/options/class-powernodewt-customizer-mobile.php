<?php
/**
 * Blog/Post Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Mobile_Customizer' ) ) :

	class PowerNodeWT_Mobile_Customizer {

		public function __construct() {

			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'powernode_head_css', array( $this, 'add_customizer_css' ), 130 );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {

			/**
			 * Mobile Section
			 */
			$wp_customize->add_section( 'powernode_mobile_section' , array(
				'title' 			=> __( 'Mobile', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_options_panel',
			) );
			
			/**
			 * Mobile Header Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_mob_header_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_mob_header_heading', array(
				'label'	   				=> __( 'Mobile Header', 'powernode' ),
				'section'  				=> 'powernode_mobile_section',
				'settings' 				=> 'powernode_mob_header_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Mobile : Logo
			 */
			$wp_customize->add_setting( 'powernode_mob_header_logo', array(
				'default'				=>  POWERNODEWT_IMAGES_DIR_URI . 'logo.png',
				'sanitize_callback'		=> 'esc_url_raw',
				'transport'				=> 'postMessage'
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_mob_header_logo', array(
				'label'	   				=> __( 'Mobile Logo', 'powernode' ),
				'description'	   		=> __( 'Select the image to be used for mobile header logo.', 'powernode' ),
				'section'  				=> 'powernode_mobile_section',
				'settings' 				=> 'powernode_mob_header_logo',
				'priority' 				=> 10
			) ) );
			
			/**
			 * Mobile : Background Color
			 */
			$wp_customize->add_setting( 'powernode_mob_header_bg_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_mob_header_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'powernode' ),
				'section'  			    => 'powernode_mobile_section',
				'settings' 			    => 'powernode_mob_header_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * Mobile : Text Color
			 */
			$wp_customize->add_setting( 'powernode_mob_header_text_color', array(
				'default'               => '#333333',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_mob_header_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'powernode' ),
				'section'  			    => 'powernode_mobile_section',
				'settings' 			    => 'powernode_mob_header_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * Mobile : Link Color
			 */
			$wp_customize->add_setting( 'powernode_mob_header_link_color', array(
				'default'               => '#333333',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_mob_header_link_color', array(
				'label'   			    => esc_html__( 'Link Color', 'powernode' ),
				'section'  			    => 'powernode_mobile_section',
				'settings' 			    => 'powernode_mob_header_link_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Mobile : Link Hover Color
			 */
			$wp_customize->add_setting( 'powernode_mob_header_link_hover_color', array(
				'default'               => '#fcb80b',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_mob_header_link_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'powernode' ),
				'section'  			    => 'powernode_mobile_section',
				'settings' 			    => 'powernode_mob_header_link_hover_color',
				'priority'              => 10,
			) ) );
		

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			$powernode_mob_header_bg_color								= get_theme_mod( 'powernode_mob_header_bg_color', '#ffffff' );
			$powernode_mob_header_text_color							= get_theme_mod( 'powernode_mob_header_text_color', '#333333' );
			$powernode_mob_header_link_color							= get_theme_mod( 'powernode_mob_header_link_color', '#333333' );
			$powernode_mob_header_link_hover_color						= get_theme_mod( 'powernode_mob_header_link_hover_color', '#fcb80b' );
			
			/**
			* Mobile Header
			*/
			$output .= powernodewt_output_css( array( '.main-wrap .header-mobile' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_mob_header_bg_color , '#ffffff' ) ) ? $powernode_mob_header_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_mob_header_text_color , '#333333' ) ) ? $powernode_mob_header_text_color : '',
			) ) );
		
			
			/**
			* Page title link color
			*/
			$output .= powernodewt_output_css( array( '.header-mobile a:not(:hover)' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_mob_header_link_color, '#333333' ) ) ? $powernode_mob_header_link_color : '',
			) ) );

			/**
			* Page title link hover color
			*/
			$output .= powernodewt_output_css( array( '.header-mobile a:hover, .header-mobile a:active' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_mob_header_link_hover_color, '#fcb80b' ) ) ? $powernode_mob_header_link_hover_color : '',
			) ) );
			
			return $output;

		}

	}

endif;

return new PowerNodeWT_Mobile_Customizer();