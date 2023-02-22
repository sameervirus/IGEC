<?php
/**
 * Topbar Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Topbar_Customizer' ) ) :

	class PowerNodeWT_Topbar_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'powernode_head_css', array( $this, 'add_customizer_css' ), 130 );
		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {

			/**
			 * Topbar Panel
			 */
			$wp_customize->add_panel( new PowerNodeWT_Customizer_Module_Panels( $wp_customize, 'powernode_topbar_panel',  array(
				'title' 			=> __( 'Top Bar', 'powernode' ),
				'priority' 			=> '-2900',
				'panel' 			=> 'powernode_options_panel',
			) ) );
			
			/**
			 * General Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_topbar_general' , array(
				'title' 			=> __( 'General', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_topbar_panel',
			) );
			
			/**
			 * Topbar : Enable
			 */
			$wp_customize->add_setting( 'powernode_topbar', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_topbar', array(
				'label'	   				=> __( 'Enable Top Bar', 'powernode' ),
				'section'  				=> 'powernode_topbar_general',
				'settings' 				=> 'powernode_topbar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Topbar : Store Info
			 */
			$store_info = powernodewt_topbar_store_info();
			foreach ( $store_info as $key => $val ) {
			
				$wp_customize->add_setting( 'powernode_topbar_store_info[' . $key .']', array(
					'sanitize_callback' 	=> 'wp_kses_post',
				) );

				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_topbar_store_info[' . $key .']', array(
					'label'	   				=> esc_html( $val['label'] ),
					'type' 					=> 'text',
					'section'  				=> 'powernode_topbar_general',
					'settings' 				=> 'powernode_topbar_store_info[' . $key .']',
					'priority' 				=> 10,
					'active_callback' 		=> 'ctm_powernode_is_topbar_enable',
				) ) );
			}
			
			/**
			 * Topbar : Bg Color
			 */
			$wp_customize->add_setting( 'powernode_topbar_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_topbar_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'powernode' ),
				'section'  			    => 'powernode_topbar_general',
				'settings' 			    => 'powernode_topbar_bg_color',
				'priority'              => 100,
				'active_callback' 		=> 'ctm_powernode_is_topbar_enable',
			) ) );
			
			/**
			 * Topbar : Text Color
			 */
			$wp_customize->add_setting( 'powernode_topbar_text_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_topbar_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'powernode' ),
				'section'  			    => 'powernode_topbar_general',
				'settings' 			    => 'powernode_topbar_text_color',
				'priority'              => 200,
				'active_callback' 		=> 'ctm_powernode_is_topbar_enable',
			) ) );
			

			/**
			 * Topbar : Links Color
			 */
			$wp_customize->add_setting( 'powernode_topbar_links_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_topbar_links_color', array(
				'label'   			    => esc_html__( 'Link Color', 'powernode' ),
				'section'  			    => 'powernode_topbar_general',
				'settings' 			    => 'powernode_topbar_links_color',
				'priority'              => 300,
				'active_callback' 		=> 'ctm_powernode_is_topbar_enable',
			) ) );
			
			
			/**
			 * Topbar : Links Hover Color
			 */
			$wp_customize->add_setting( 'powernode_topbar_links_hover_color', array(
				'default'               => '#fcb80b',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_topbar_links_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'powernode' ),
				'section'  			    => 'powernode_topbar_general',
				'settings' 			    => 'powernode_topbar_links_hover_color',
				'priority'              => 400,
				'active_callback' 		=> 'ctm_powernode_is_topbar_enable',
			) ) );
			
			/**
			 * Topbar : Border Color
			 */
			$wp_customize->add_setting( 'powernode_topbar_border_color', array(
				'default'               => '#eeeeee',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_topbar_border_color', array(
				'label'   			    => esc_html__( 'Border Color', 'powernode' ),
				'section'  			    => 'powernode_topbar_general',
				'settings' 			    => 'powernode_topbar_border_color',
				'priority'              => 500,
				'active_callback' 		=> 'ctm_powernode_is_topbar_enable',
			) ) );
			
			
			/**
			 * Topbar Social Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_topbar_social' , array(
				'title' 			=> __( 'Topbar Social', 'powernode' ),
				'priority' 			=> 20,
				'panel' 			=> 'powernode_topbar_panel',
			) );
			
			$wp_customize->add_setting( 'powernode_topbar_social', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_topbar_social', array(
				'label'	   				=> __( 'Enable Top Bar Social', 'powernode' ),
				'section'  				=> 'powernode_topbar_social',
				'settings' 				=> 'powernode_topbar_social',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_is_topbar_enable',
			) ) );
			
			/**
			 * Topbar Social : Social Links
			 */
			$wp_customize->add_setting( 'powernode_topbar_social_links', array(
				'default'        	    => apply_filters( 'powernode_topbar_social_links_default', array( 'facebook', 'twitter', 'instagram', 'google_plus' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$social_links_data = powernodewt_social_links_data();
			
			$topbar_social_links = array();
			foreach ( $social_links_data as $soc_name => $soc_det ) {
				$topbar_social_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_topbar_social_links', array(
				'label'	   				=> __( 'Social Links', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_topbar_social_links_choices',
												$topbar_social_links
											),
				'section'  				=> 'powernode_topbar_social',
				'settings' 				=> 'powernode_topbar_social_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_display_topbar_social',
			) ) );

		}

		/**
		 * CSS
		 */
		public static function add_customizer_css( $output ) {
			
			$powernode_topbar										= get_theme_mod( 'powernode_topbar', false );
			if( !$powernode_topbar ) return $output;
			$powernode_topbar_bg_color								= get_theme_mod( 'powernode_topbar_bg_color', '' );
			$powernode_topbar_text_color							= get_theme_mod( 'powernode_topbar_text_color', '#ffffff' );
			$powernode_topbar_links_color							= get_theme_mod( 'powernode_topbar_links_color', '#ffffff' );
			$powernode_topbar_links_hover_color						= get_theme_mod( 'powernode_topbar_links_hover_color', '#fcb80b' );
			$powernode_topbar_border_color							= get_theme_mod( 'powernode_topbar_border_color', '#eeeeee' );
			
			
			/**
			* Topbar
			*/
			$output .= powernodewt_output_css( array( '.header-topbar' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_topbar_bg_color, '' ) ) ? $powernode_topbar_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_topbar_text_color, '#ffffff' ) ) ? $powernode_topbar_text_color : '',
			) ) );
			
			$output .= powernodewt_output_css( array( '.topbar-links a, .social-links ' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_topbar_links_color, '#ffffff' ) ) ? $powernode_topbar_links_color : '',
			) ) );
			
			$output .= powernodewt_output_css( array( '.header-topbar a:hover' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_topbar_links_hover_color, '#fcb80b' ) ) ? $powernode_topbar_links_hover_color : '',
			) ) );
			
			$output .= powernodewt_output_css( array( '.header-topbar, .header-topbar ul' => array(
				'border-color' => ( !powernodewt_opt_chk_def_val( $powernode_topbar_border_color, '#eeeeee' ) ) ? $powernode_topbar_border_color : '',
			) ) );
			
			return $output;

		}

	}

endif;

return new PowerNodeWT_Topbar_Customizer();