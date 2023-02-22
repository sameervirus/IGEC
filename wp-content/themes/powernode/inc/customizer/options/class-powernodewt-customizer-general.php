<?php
/**
 * General Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_General_Customizer' ) ) :

	class PowerNodeWT_General_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'powernode_head_css', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_customizer_scripts' ), 30 );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {
			
			/**
			 * General Panel
			 */
			$wp_customize->add_panel( new PowerNodeWT_Customizer_Module_Panels( $wp_customize, 'powernode_general_panel',  array(
				'title' 			=> __( 'General', 'powernode' ),
				'priority' 			=> '-3000',
				'panel' 			=> 'powernode_options_panel',
			) ) );
		
			/**
			 * General Settings: Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_general_settings' , array(
				'title' 			=> __( 'General Settings', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_general_panel',
			) );

			/**
			 * Layouts : Styles
			 */
			$wp_customize->add_setting( 'powernode_main_layout_style', array(
				'default'           	=> 'wide',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_main_layout_style', array(
				'label'	   				=> __( 'Layout Style', 'powernode' ),
				'section'  				=> 'powernode_general_settings',
				'settings' 				=> 'powernode_main_layout_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'wide' 		        => __( 'Wide', 'powernode' ),
					'boxed' 			=> __( 'Boxed', 'powernode' ),
					'predefine' 		=> __( 'Predefine', 'powernode' ),
				),
			) ) );
			
			/**
			 * Layouts : Container Width
			 */
			$wp_customize->add_setting( 'powernode_container_width', array(
				'transport' 			=> 'postMessage',
				'default'          		=>  1170,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_container_width', array(
				'label'   				=> __( 'Container Width (px)', 'powernode' ),
				'section' 				=> 'powernode_general_settings',
				'settings'  			=> 'powernode_container_width',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 1980,
											'step' => 1,
										),
				'active_callback' 		=> 'ctm_powernode_is_container_width_active',
			) ) );
			
			/**
			 * Layouts : Boxed Layout Width
			 */
			$wp_customize->add_setting( 'powernode_boxed_layout_width', array(
				'transport' 			=> 'postMessage',
				'default'          		=>  1170,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_boxed_layout_width', array(
				'label'   				=> __( 'Boxed Width (px)', 'powernode' ),
				'section' 				=> 'powernode_general_settings',
				'settings'  			=> 'powernode_boxed_layout_width',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 1980,
											'step' => 1,
										),
				'active_callback' 		=> 'ctm_powernode_is_boxed_layout_active',
			) ) );
			
			/**
			 * General Settings : Outer Background Color
			 */
			$wp_customize->add_setting( 'powernode_boxed_outer_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_boxed_outer_bg_color', array(
				'label'   			    => esc_html__( 'Outer Background Color', 'powernode' ),
				'section'  			    => 'powernode_general_settings',
				'settings' 			    => 'powernode_boxed_outer_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_powernode_is_boxed_layout_active',
			) ) );
			
			/**
			 * General Settings : Inner Background Color
			 */
			$wp_customize->add_setting( 'powernode_boxed_inner_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_boxed_inner_bg_color', array(
				'label'   			    => esc_html__( 'Inner Background Color', 'powernode' ),
				'section'  			    => 'powernode_general_settings',
				'settings' 			    => 'powernode_boxed_inner_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_powernode_is_boxed_layout_active',
			) ) );
			
			/**
			 * General : Page Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_page_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_page_heading', array(
				'label'	   				=> __( 'Pages', 'powernode' ),
				'section'  				=> 'powernode_general_settings',
				'settings' 				=> 'powernode_page_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Layout
			 */
			$wp_customize->add_setting( 'powernode_page_layout', array(
				'default'        	    => 'full-width',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Radio_Image_Control( $wp_customize, 'powernode_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'powernode' ),
				'choices' 				=> array(
											'full-width'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'powernode_general_settings',
				'settings' 				=> 'powernode_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * General Styling: Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_general_styling' , array(
				'title' 			=> __( 'General Styling', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_general_panel',
			) );
			
			/**
			 * Styling
			 */
			$wp_customize->add_setting( 'powernode_customzer_styling', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'head',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );
			
			$wp_customize->add_control( 'powernode_customzer_styling', array(
				'label'	   				=> esc_html__( 'Styling Options Location', 'powernode' ),
				'description'	   		=> esc_html__( 'If you choose Custom File, a CSS file will be created in your uploads folder.', 'powernode' ),
				'type'              	=> 'radio',
				'section'  				=> 'powernode_general_styling',
				'settings' 				=> 'powernode_customzer_styling',
				'priority'          	=> 10,
				'choices'           	=> array(
					'head' 		=> esc_html__( 'WP Head', 'powernode' ),
					'file' 		=> esc_html__( 'Custom File', 'powernode' ),
				)
			) );
			

			/**
			 * General Styling : General Styling Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_general_styling_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_general_styling_heading', array(
				'label'	   				=> __( 'General Styling', 'powernode' ),
				'section'  				=> 'powernode_general_styling',
				'settings' 				=> 'powernode_general_styling_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * General Styling : Theme Color
			 */
			$wp_customize->add_setting( 'powernode_gen_sty_theme_color', array(
				'default'               => '#fcb80b',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_sty_theme_color', array(
				'label'   			    => esc_html__( 'Theme Color', 'powernode' ),
				'section'  			    => 'powernode_general_styling',
				'settings' 			    => 'powernode_gen_sty_theme_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Theme Text Color
			 */
			$wp_customize->add_setting( 'powernode_gen_sty_theme_text_color', array(
				'default'               => '#333333',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_sty_theme_text_color', array(
				'label'   			    => esc_html__( 'Theme Text Color', 'powernode' ),
				'section'  			    => 'powernode_general_styling',
				'settings' 			    => 'powernode_gen_sty_theme_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Theme Link Color
			 */
			$wp_customize->add_setting( 'powernode_gen_sty_theme_link_color', array(
				'default'               => '#333333',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_sty_theme_link_color', array(
				'label'   			    => esc_html__( 'Link Color', 'powernode' ),
				'section'  			    => 'powernode_general_styling',
				'settings' 			    => 'powernode_gen_sty_theme_link_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Theme Link Hover Color
			 */
			$wp_customize->add_setting( 'powernode_gen_sty_theme_link_hover_color', array(
				'default'               => '#fcb80b',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_sty_theme_link_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'powernode' ),
				'section'  			    => 'powernode_general_styling',
				'settings' 			    => 'powernode_gen_sty_theme_link_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Site Background Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_general_site_bg_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_general_site_bg_heading', array(
				'label'	   				=> __( 'Site Background', 'powernode' ),
				'section'  				=> 'powernode_general_styling',
				'settings' 				=> 'powernode_general_site_bg_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * General Settings : Background Color
			 */
			$wp_customize->add_setting( 'powernode_gen_sty_site_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_sty_site_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'powernode' ),
				'section'  			    => 'powernode_general_styling',
				'settings' 			    => 'powernode_gen_sty_site_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * General Styling : Background Image
			 */
			$wp_customize->add_setting( 'powernode_gen_sty_site_bg_image', array(
				'default'				=>  '',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_gen_sty_site_bg_image', array(
				'label'	   				=> __( 'Background Image', 'powernode' ),
				'description'	   		=> __( 'Select the image to be used for site background', 'powernode' ),
				'section'  				=> 'powernode_general_styling',
				'settings' 				=> 'powernode_gen_sty_site_bg_image',
				'priority' 				=> 10,
			) ) );


			/**
			 * General: Buttons Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_general_buttons' , array(
				'title' 			=> __( 'Buttons', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_general_panel',
			) );

			/**
			 * Buttons : General Buttons Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_general_buttons_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_general_buttons_heading', array(
				'label'	   				=> __( 'General Buttons', 'powernode' ),
				'section'  				=> 'powernode_general_buttons',
				'settings' 				=> 'powernode_general_buttons_heading',
				'priority' 				=> 10,
			) ) );

			/**
			 * Buttons : General Buttons Padding
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_desktop_top_padding', array(
				'default' 				=> '14',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_desktop_right_padding', array(
				'default'	 			=> '30',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_desktop_bottom_padding', array(
				'default' 				=> '14',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_desktop_left_padding', array(
				'default'	 			=> '30',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_tablet_top_padding', array(
				'default' 				=> '10',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_tablet_right_padding', array(
				'default'	 			=> '15',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_tablet_bottom_padding', array(
				'default' 				=> '10',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_tablet_left_padding', array(
				'default'	 			=> '15',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_mobile_top_padding', array(
				'default' 				=> '8',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_mobile_right_padding', array(
				'default'	 			=> '10',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_mobile_bottom_padding', array(
				'default' 				=> '8',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_gen_btns_mobile_left_padding', array(
				'default'	 			=> '10',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );
		
			$wp_customize->add_control( new PowerNodeWT_Customizer_Dimensions_Control( $wp_customize, 'powernode_gen_btns_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'powernode' ),
				'section'  				=> 'powernode_general_buttons',				
				'settings'  		    => array(
					'desktop_top' 		=> 'powernode_gen_btns_desktop_top_padding',
					'desktop_right' 	=> 'powernode_gen_btns_desktop_right_padding',
					'desktop_bottom' 	=> 'powernode_gen_btns_desktop_bottom_padding',
					'desktop_left' 		=> 'powernode_gen_btns_desktop_left_padding',
					'tablet_top' 		=> 'powernode_gen_btns_tablet_top_padding',
					'tablet_right' 		=> 'powernode_gen_btns_tablet_right_padding',
					'tablet_bottom' 	=> 'powernode_gen_btns_tablet_bottom_padding',
					'tablet_left' 		=> 'powernode_gen_btns_tablet_left_padding',
					'mobile_top' 		=> 'powernode_gen_btns_mobile_top_padding',
					'mobile_right' 		=> 'powernode_gen_btns_mobile_right_padding',
					'mobile_bottom' 	=> 'powernode_gen_btns_mobile_bottom_padding',
					'mobile_left' 		=> 'powernode_gen_btns_mobile_left_padding',
				),
				'priority' 				=> 10,
				'input_attrs' 			=> array(
					'min'   => 0,
					'max'   => 100,
					'step'  => 1,
				),
			) ) );

			/**
			 * Buttons : General Buttons Radius
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_radius', array(
				'default'          		=>  4,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_gen_btns_radius', array(
				'label'   				=> __( 'Border Radius (px)', 'powernode' ),
				'section' 				=> 'powernode_general_buttons',
				'settings'  			=> 'powernode_gen_btns_radius',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 100,
											'step' => 1,
										),
			) ) );

			/**
			 * Buttons : Background Color
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_bg_color', array(
				'default'               => '#eeeeee',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_btns_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'powernode' ),
				'section'  			    => 'powernode_general_buttons',
				'settings' 			    => 'powernode_gen_btns_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Background Color:hover
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_bg_hover_color', array(
				'default'               => '#fcb80b',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_btns_bg_hover_color', array(
				'label'   			    => esc_html__( 'Background Hover Color', 'powernode' ),
				'section'  			    => 'powernode_general_buttons',
				'settings' 			    => 'powernode_gen_btns_bg_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Text Color
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_text_color', array(
				'default'               => '#666666',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_btns_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'powernode' ),
				'section'  			    => 'powernode_general_buttons',
				'settings' 			    => 'powernode_gen_btns_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Text Color
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_text_hover_color', array(
				'default'               => '#333333',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_btns_text_hover_color', array(
				'label'   			    => esc_html__( 'Text Hover Color', 'powernode' ),
				'section'  			    => 'powernode_general_buttons',
				'settings' 			    => 'powernode_gen_btns_text_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Border Color
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_border_color', array(
				'default'               => '#eeeeee',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_btns_border_color', array(
				'label'   			    => esc_html__( 'Border Color', 'powernode' ),
				'section'  			    => 'powernode_general_buttons',
				'settings' 			    => 'powernode_gen_btns_border_color',
				'priority'              => 10,
			) ) );

			/**
			 * Buttons : Text Color
			 */
			$wp_customize->add_setting( 'powernode_gen_btns_border_hover_color', array(
				'default'               => '#fcb80b',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_gen_btns_border_hover_color', array(
				'label'   			    => esc_html__( 'Border Hover Color', 'powernode' ),
				'section'  			    => 'powernode_general_buttons',
				'settings' 			    => 'powernode_gen_btns_border_hover_color',
				'priority'              => 10,
			) ) );

			/**
			 * General: Buttons Sections
			 */
			$wp_customize->add_section( 'powernode_general_buttons' , array(
				'title' 			=> __( 'Buttons', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_general_panel',
			) );
			
			
			/**
			 * General: Preloader Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_general_preloader_section' , array(
				'title' 			=> __( 'Preloader', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_general_panel',
			) );
			
			/**
			 * Preloader : Show Preloader
			 */
			$wp_customize->add_setting( 'powernode_general_preloader', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_general_preloader', array(
				'label'	   				=> __( 'Show Preloader', 'powernode' ),
				'section'  				=> 'powernode_general_preloader_section',
				'settings' 				=> 'powernode_general_preloader',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Preloader : Type
			 */
			$wp_customize->add_setting( 'powernode_general_preloader_type', array(
				'default'           	=> 'predefine',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_general_preloader_type', array(
				'label'	   				=> __( 'Preloader Type', 'powernode' ),
				'section'  				=> 'powernode_general_preloader_section',
				'settings' 				=> 'powernode_general_preloader_type',
				'priority' 				=> 10,
				'choices' 				=> array(
											'predefine' => __( 'Predefine', 'powernode' ),
											'custom' => __( 'Custom', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernode_general_preloader',
			) ) );
			
			/**
			 * Preloader : Color
			 */
			$wp_customize->add_setting( 'powernode_general_preloader_color', array(
				'default'               => '#fcb80b',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_general_preloader_color', array(
				'label'   			    => esc_html__( 'Preloader Color', 'powernode' ),
				'section'  			    => 'powernode_general_preloader_section',
				'settings' 			    => 'powernode_general_preloader_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_powernode_general_preloader_type_is_predefine',
			) ) );
			
			/**
			 * Preloader : Custom
			 */
			$wp_customize->add_setting( 'powernode_general_preloader_custom_bg_image', array(
				'default'				=>  '',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_general_preloader_custom_bg_image', array(
				'label'	   				=> __( 'Preloader Image', 'powernode' ),
				'section'  				=> 'powernode_general_preloader_section',
				'settings' 				=> 'powernode_general_preloader_custom_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_general_preloader_type_is_custom',
			) ) );

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {

			$powernode_boxed_layout_width								= get_theme_mod( 'powernode_boxed_layout_width', '1170px' );
			
			$powernode_boxed_outer_bg_color								= get_theme_mod( 'powernode_boxed_outer_bg_color', '' );
			$powernode_boxed_inner_bg_color								= get_theme_mod( 'powernode_boxed_inner_bg_color', '' );
			
			$powernode_gen_sty_theme_color								= powernodewt_theme_mod( 'powernode_gen_sty_theme_color', '#fcb80b' );
			$powernode_gen_sty_theme_text_color							= get_theme_mod( 'powernode_gen_sty_theme_text_color', '#333333' );
			$powernode_gen_sty_site_bg_color							= get_theme_mod( 'powernode_gen_sty_site_bg_color', '' );
			$powernode_gen_sty_site_bg_image							= get_theme_mod( 'powernode_gen_sty_site_bg_image', '' );
			$powernode_gen_sty_theme_link_color							= get_theme_mod( 'powernode_gen_sty_theme_link_color', '#333333' );
			$powernode_gen_sty_theme_link_hover_color					= powernodewt_theme_mod( 'powernode_gen_sty_theme_link_hover_color', '#fcb80b' );

			$powernode_gen_btns_desktop_top_padding						= get_theme_mod( 'powernode_gen_btns_desktop_top_padding', '14' );
			$powernode_gen_btns_desktop_right_padding					= get_theme_mod( 'powernode_gen_btns_desktop_right_padding', '30' );
			$powernode_gen_btns_desktop_bottom_padding					= get_theme_mod( 'powernode_gen_btns_desktop_bottom_padding', '14' );
			$powernode_gen_btns_desktop_left_padding					= get_theme_mod( 'powernode_gen_btns_desktop_left_padding', '30' );
			$powernode_gen_btns_tablet_top_padding						= get_theme_mod( 'powernode_gen_btns_tablet_top_padding', '10' );
			$powernode_gen_btns_tablet_right_padding					= get_theme_mod( 'powernode_gen_btns_tablet_right_padding', '15' );
			$powernode_gen_btns_tablet_bottom_padding					= get_theme_mod( 'powernode_gen_btns_tablet_bottom_padding', '10' );
			$powernode_gen_btns_tablet_left_padding						= get_theme_mod( 'powernode_gen_btns_tablet_left_padding', '15' );
			$powernode_gen_btns_mobile_top_padding						= get_theme_mod( 'powernode_gen_btns_mobile_top_padding', '8' );
			$powernode_gen_btns_mobile_right_padding					= get_theme_mod( 'powernode_gen_btns_mobile_right_padding', '10' );
			$powernode_gen_btns_mobile_bottom_padding					= get_theme_mod( 'powernode_gen_btns_mobile_bottom_padding', '8' );
			$powernode_gen_btns_mobile_left_padding						= get_theme_mod( 'powernode_gen_btns_mobile_left_padding', '10' );
			$powernode_gen_btns_radius									= get_theme_mod( 'powernode_gen_btns_radius', '4' );
			$powernode_gen_btns_bg_color								= get_theme_mod( 'powernode_gen_btns_bg_color', '#eeeeee' );
			$powernode_gen_btns_bg_hover_color							= powernodewt_theme_mod( 'powernode_gen_btns_bg_hover_color', '#fcb80b' );
			$powernode_gen_btns_text_color								= get_theme_mod( 'powernode_gen_btns_text_color', '#666666' );
			$powernode_gen_btns_text_hover_color						= powernodewt_theme_mod( 'powernode_gen_btns_text_hover_color', '#333333' );
			$powernode_gen_btns_border_color							= get_theme_mod( 'powernode_gen_btns_border_color', '#eeeeee' );
			$powernode_gen_btns_border_hover_color						= powernodewt_theme_mod( 'powernode_gen_btns_border_hover_color', '#fcb80b' );

			$powernode_gen_btns2_desktop_top_padding					= get_theme_mod( 'powernode_gen_btns2_desktop_top_padding', '8' );
			$powernode_gen_btns2_desktop_right_padding					= get_theme_mod( 'powernode_gen_btns2_desktop_right_padding', '15' );
			$powernode_gen_btns2_desktop_bottom_padding					= get_theme_mod( 'powernode_gen_btns2_desktop_bottom_padding', '8' );
			$powernode_gen_btns2_desktop_left_padding					= get_theme_mod( 'powernode_gen_btns2_desktop_left_padding', '15' );
			$powernode_gen_btns2_tablet_top_padding						= get_theme_mod( 'powernode_gen_btns2_tablet_top_padding', '8' );
			$powernode_gen_btns2_tablet_right_padding					= get_theme_mod( 'powernode_gen_btns2_tablet_right_padding', '15' );
			$powernode_gen_btns2_tablet_bottom_padding					= get_theme_mod( 'powernode_gen_btns2_tablet_bottom_padding', '8' );
			$powernode_gen_btns2_tablet_left_padding					= get_theme_mod( 'powernode_gen_btns2_tablet_left_padding', '15' );
			$powernode_gen_btns2_mobile_top_padding						= get_theme_mod( 'powernode_gen_btns2_mobile_top_padding', '8' );
			$powernode_gen_btns2_mobile_right_padding					= get_theme_mod( 'powernode_gen_btns2_mobile_right_padding', '15' );
			$powernode_gen_btns2_mobile_bottom_padding					= get_theme_mod( 'powernode_gen_btns2_mobile_bottom_padding', '8' );
			$powernode_gen_btns2_mobile_left_padding					= get_theme_mod( 'powernode_gen_btns2_mobile_left_padding', '15' );
			$powernode_gen_btns2_radius									= get_theme_mod( 'powernode_gen_btns2_radius', '30' );
			$powernode_gen_btns2_bg_color								= get_theme_mod( 'powernode_gen_btns2_bg_color', '#fcb80b' );
			$powernode_gen_btns2_bg_hover_color							= get_theme_mod( 'powernode_gen_btns2_bg_hover_color', '#333e48' );
			$powernode_gen_btns2_text_color								= get_theme_mod( 'powernode_gen_btns2_text_color', '#ffffff' );
			$powernode_gen_btns2_text_hover_color						= get_theme_mod( 'powernode_gen_btns2_text_hover_color', '#ffffff' );
			$powernode_gen_btns2_border_color							= get_theme_mod( 'powernode_gen_btns2_border_color', '#fcb80b' );
			$powernode_gen_btns2_border_hover_color						= get_theme_mod( 'powernode_gen_btns2_border_hover_color', '#333e48' );
			
			$powernode_general_preloader								= ctm_powernode_general_preloader();
			$powernode_general_preloader_color							= powernodewt_theme_mod( 'powernode_general_preloader_color', '#fcb80b' );
			
			$powernode_container_width 									= powernodewt_container_width();
			
			
			/**
			* Preloader
			*/
			if( ctm_powernode_general_preloader() ) {
				
				$output .= powernodewt_output_css( array( '#loader-wrapper #loader' => array(
					'border-top-color' => ( !powernodewt_opt_chk_def_val( $powernode_general_preloader_color ) ) ? $powernode_general_preloader_color : '',
				) ) );
			}
			
			/**
			* General Settings
			*/
			if( powernodewt_main_layout_style() == 'boxed' ) {
				
				$output .= powernodewt_output_css( array( '.boxed-layout .main-wrap' => array(
					'max-width' => ( !powernodewt_opt_chk_def_val( $powernode_boxed_layout_width, '' ) ) ? $powernode_boxed_layout_width.'px' : '',
					'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_boxed_inner_bg_color, '' ) ) ? $powernode_boxed_inner_bg_color : '',
				) ) );
				
				$output .= powernodewt_output_css( array( 'body.boxed-layout' => array(
					'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_boxed_outer_bg_color, '' ) ) ? $powernode_boxed_outer_bg_color : '',
				) ) );
			
			}
			
			/**
			* General Styling
			*/
			$output .= powernodewt_output_css( array( 'body' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_site_bg_color, '' ) ) ? $powernode_gen_sty_site_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_text_color, '#333333' ) ) ? $powernode_gen_sty_theme_text_color : '',
				'background-image' => ( !empty( $powernode_gen_sty_site_bg_image ) && !powernodewt_opt_chk_def_val( $powernode_gen_sty_site_bg_image, '' ) ) ? 'url(' . $powernode_gen_sty_site_bg_image .')' : '',
			) ) );
		
			$output .= powernodewt_output_css( array( 'a' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_link_color, '#333333' ) ) ? $powernode_gen_sty_theme_link_color : '',
			) ) );

			$output .= powernodewt_output_css( array( 'a:hover, a:active, a.active, .product-summary .compare:hover, .product-summary .yith-wcwl-add-to-wishlist [class*=\'yith-wcwl-\'] > a:hover, .tabs-layout ul.tabs li:hover a, .is-active > a, .wsmenu > .wsmenu-list ul.sub-menu li.active > a' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_link_hover_color ) ) ? $powernode_gen_sty_theme_link_hover_color : '',
			) ) );
			$output .= powernodewt_output_css( array( '.tabs-fancy ul.tabs li a:after' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_link_hover_color ) ) ? $powernode_gen_sty_theme_link_hover_color : '',
			) ) );
			
			// Theme color
			$output .= powernodewt_output_css( array( '.theme-color, .theme-color,.theme-color h2, .theme-color h3, .theme-color h4, .theme-color h5, .theme-color h6, .theme-color p, .theme-color a,.theme-color li, .theme-color i,.theme-color span, .white-color .theme-color, .card-2-txt h6 a:hover, .masonry-filter.theme-filter button.is-checked, .masonry-filter.theme-filter button.is-checked:before, .popular-post a::after, .tag-sticky-2 .entry-title:before' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color : '',
			) ) );
			
			// Theme color
			$output .= powernodewt_output_css( array( '.nav-theme-hover .wsmegamenu h5.h5-xs a:hover,.wsmenu > .wsmenu-list.nav-theme-hover > li > ul.sub-menu > li > a:hover,.nav-theme-hover .wsmegamenu .latest-news .post-summary a:hover,.wsmenu > .wsmenu-list.nav-theme-hover > li > .wsmegamenu .link-list li a:hover,.wsmenu > .wsmenu-list.nav-theme-hover > li > .wsmegamenu.halfmenu ul.link-list > li > a:hover ' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color . '!important' : '',
			) ) );
			
			// Theme Background Color
			$output .= powernodewt_output_css( array( '.bg-theme, .loader-ellips__dot, .posttitle:before, .posttitle:after, .fbox-6-hover .fbox-6:hover, .project-link:hover' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color : '',
			) ) );
			
			// Theme Border Color
			$output .= powernodewt_output_css( array( '.bg-lightgrey .blog-3-post.theme-border, .quote p, .tagcloud a:hover, .post-tags-list a:hover, blockquote' => array(
				'border-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color : '',
			) ) );
			
			// Btn Theme color
			$output .= powernodewt_output_css( array( '.btn.btn-theme, .scroll .btn.btn-theme, .white-color .btn.btn-theme, .btn.theme-hover:hover, .scroll .btn.theme-hover:hover, .white-color .btn.theme-hover:hover, .page-link:hover, .page-item.active .page-link, #stlChanger .chBut, .widget_calendar caption' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_text_hover_color ) ) ? $powernode_gen_btns_text_hover_color . ' !important' : '',
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color : '',
				'border-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color . '!important' : '',
			) ) );
			
			// Btn Trans Theme color
			$output .= powernodewt_output_css( array( '.btn.btn-tra-theme, .scroll .btn.btn-tra-theme, .white-color .btn.btn-tra-theme, .btn.tra-theme-hover:hover, .scroll .btn.tra-theme-hover:hover, .white-color .btn.tra-theme-hover:hover' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color . '!important' : '',
				'background-color' => 'transparent',
				'border-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color . '!important' : '',
			) ) );
			
			// Dropdown border top color
			$output .= powernodewt_output_css( array( '.main-wrap li > .pnwt-megamenu, .main-wrap .pnwt-dropdown, .main-wrap .dropdown-menu' => array(
				'border-top-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_sty_theme_color ) ) ? $powernode_gen_sty_theme_color : '',
			) ) );
			
			// Contianer width
			$output .= powernodewt_output_css( array( '.container' => array(
				'max-width' => ( !powernodewt_opt_chk_def_val( $powernode_container_width, '1170' ) ) ? $powernode_container_width.'px;' : '',
			) ) );
			
			/**
			* Buttons: Buttons Classes
			*/
			$buttons_style_classes = '.button, .btn, button, input[type="button"], input[type="submit"], .btn-remove2, .page-numbers li span, .page-numbers li a, .owl-carousel .owl-nav button[class*="owl-"], .slick-slider .slick-arrow';
			
			$buttons_color_classes = '.button, .btn, button, input[type="button"], input[type="submit"], .btn-remove2, .page-numbers li span, .page-numbers li a, .owl-carousel .owl-nav button[class*="owl-"], .slick-slider .slick-arrow';
			

			$buttons_color_hover_classes = '.button:hover, .btn:hover, button:hover, input[type="button"]:hover, input[type="submit"]:hover, .owl-carousel .owl-nav button[class*="owl-"]:hover, .slick-slider .slick-arrow:hover, .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span, .mfp-wrap .mfp-close:hover, .page-numbers li span.current, .page-numbers li a:hover .tra-grey-hover:hover, .page-links span.current, .page-links .post-page-numbers:hover, .scroll .tra-grey-hover:hover, .footer-form .btn:hover, .page-numbers li a:hover';
		
			/**
			* Buttons: Desktop General Buttons
			*/
			$output .= powernodewt_output_css( array( $buttons_style_classes => array(
					'padding' => ( ((!empty($powernode_gen_btns_desktop_top_padding) && $powernode_gen_btns_desktop_top_padding != 14 ))
									||	((!empty($powernode_gen_btns_desktop_right_padding) && $powernode_gen_btns_desktop_right_padding != 30))
									||	((!empty($powernode_gen_btns_desktop_bottom_padding) && $powernode_gen_btns_desktop_bottom_padding != 14))
									||	((!empty($powernode_gen_btns_desktop_left_padding) && $powernode_gen_btns_desktop_left_padding != 30)) 
								 ) ? ($powernode_gen_btns_desktop_top_padding . 'px ' . $powernode_gen_btns_desktop_right_padding . 'px ' . $powernode_gen_btns_desktop_bottom_padding . 'px ' . $powernode_gen_btns_desktop_left_padding . 'px;') : '',
					'border-radius' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_radius, '4px' ) ) ? $powernode_gen_btns_radius.'px' : '',
				) ) );
				
			$output .= powernodewt_output_css( array( $buttons_color_classes => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_bg_color, '#eeeeee' ) ) ? $powernode_gen_btns_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_text_color, '#666666' ) ) ? $powernode_gen_btns_text_color : '',
				'border-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_border_color, '#eeeeee' ) ) ? $powernode_gen_btns_border_color : '',
			) ) );
					
			/**
			* Buttons: Tablet General Buttons
			*/
			if ( ((!empty($powernode_gen_btns_tablet_top_padding) && $powernode_gen_btns_tablet_top_padding != 10 ))
			||	((!empty($powernode_gen_btns_tablet_right_padding) && $powernode_gen_btns_tablet_right_padding != 15))
			||	((!empty($powernode_gen_btns_tablet_bottom_padding) && $powernode_gen_btns_tablet_bottom_padding != 10))
			||	((!empty($powernode_gen_btns_tablet_left_padding) && $powernode_gen_btns_tablet_left_padding != 15))
			){
				$output .= powernodewt_output_css( array( $buttons_style_classes => array(
					'padding' => $powernode_gen_btns_tablet_top_padding . 'px ' . $powernode_gen_btns_tablet_right_padding . 'px ' . $powernode_gen_btns_tablet_bottom_padding . 'px ' . $powernode_gen_btns_tablet_left_padding . 'px; ',
				) ), 576, 768 );
			}

			/**
			* Buttons: Mobile General Buttons
			*/
			if ( ((!empty($powernode_gen_btns_mobile_top_padding) && $powernode_gen_btns_mobile_top_padding != 8 ))
			||	((!empty($powernode_gen_btns_mobile_right_padding) && $powernode_gen_btns_mobile_right_padding != 10))
			||	((!empty($powernode_gen_btns_mobile_bottom_padding) && $powernode_gen_btns_mobile_bottom_padding != 8))
			||	((!empty($powernode_gen_btns_mobile_left_padding) && $powernode_gen_btns_mobile_left_padding != 10))
			){
				$output .= powernodewt_output_css( array( $buttons_style_classes => array(
					'padding' => $powernode_gen_btns_mobile_top_padding . 'px ' . $powernode_gen_btns_mobile_right_padding . 'px ' . $powernode_gen_btns_mobile_bottom_padding . 'px ' . $powernode_gen_btns_mobile_left_padding . 'px; ',
				) ), '', 576 );
			}

			/**
			* Buttons : General Buttons Hover
			*/
			$output .= powernodewt_output_css( array( $buttons_color_hover_classes => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_bg_hover_color ) ) ? $powernode_gen_btns_bg_hover_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_text_hover_color ) ) ? $powernode_gen_btns_text_hover_color : '',
				'border-color' => ( !powernodewt_opt_chk_def_val( $powernode_gen_btns_border_hover_color ) ) ? $powernode_gen_btns_border_hover_color : '',
			) ) );
			
			return $output;
		}
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( get_home_url() ) ) { ?>
					wp.customize.section( 'powernode_general_settings', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_home_url() ); ?>" );
							}
						} );
					} );
					<?php } ?>
				} );
			</script>
			<?php
		}

	}

endif;

return new PowerNodeWT_General_Customizer();