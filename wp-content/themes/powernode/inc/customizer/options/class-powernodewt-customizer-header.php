<?php
/**
 * Header Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Header_Customizer' ) ) :

	class PowerNodeWT_Header_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'powernode_head_css', array( $this, 'add_customizer_css' ), 130 );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {

			/**
			 * Header Panel
			 */
			$wp_customize->add_panel( new PowerNodeWT_Customizer_Module_Panels( $wp_customize, 'powernode_header_panel',  array(
				'title' 			=> __( 'Header', 'powernode' ),
				'priority' 			=> '-2800',
				'panel' 			=> 'powernode_options_panel',
			) ) );
			
			/**
			 * Header Section -----------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_header_general' , array(
				'title' 			=> __( 'Header Settings', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_header_panel',
			) );

			/**
			* Header: Layout
			*/
			$wp_customize->add_setting( 'powernode_header_style', array(
				'default'           	=> 'header_v1',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_header_style', array(
				'label'	   				=> __( 'Header Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_header_general',
				'settings' 				=> 'powernode_header_style',
				'priority' 				=> 10,
				'choices' 				=> powernodewt_header_style_list(),
			) ) );
			
			/**
			* Header: BgColor
			*/
			$wp_customize->add_setting( 'powernode_header_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_header_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'powernode' ),
				'section'  			    => 'powernode_header_general',
				'settings' 			    => 'powernode_header_bg_color',
				'priority'              => 100,
			) ) );
			
			/**
			* Header: Text Color
			*/
			$wp_customize->add_setting( 'powernode_header_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_header_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'powernode' ),
				'section'  			    => 'powernode_header_general',
				'settings' 			    => 'powernode_header_text_color',
				'priority'              => 200,
			) ) );
			
			/**
			 * Sticky Header Section -----------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_header_sticky_section', array(
				'title' 			=> __( 'Sticky Header', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_header_panel',
			) );
			
			/**
			 * Sticky
			 */
			$wp_customize->add_setting( 'powernode_header_sticky', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_header_sticky', array(
				'label'	   				=> __( 'Sticky Header', 'powernode' ),
				'section'  				=> 'powernode_header_sticky_section',
				'settings' 				=> 'powernode_header_sticky',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Sticky : Logo
			 */
			$wp_customize->add_setting( 'powernode_header_sticky_logo', array(
				'default'				=>  POWERNODEWT_IMAGES_DIR_URI . '/logo.png',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_header_sticky_logo', array(
				'label'	   				=> __( 'Sticky Logo', 'powernode' ),
				'section'  				=> 'powernode_header_sticky_section',
				'settings' 				=> 'powernode_header_sticky_logo',
				'priority' 				=> 10
			) ) );
			
			/**
			 * Sticky : BGColor
			 */
			$wp_customize->add_setting( 'powernode_header_sticky_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_header_sticky_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'powernode' ),
				'section'  			    => 'powernode_header_sticky_section',
				'settings' 			    => 'powernode_header_sticky_bg_color',
				'priority'              => 100,
			) ) );
			
			/**
			 * Sticky : Text Color
			 */
			$wp_customize->add_setting( 'powernode_header_sticky_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_header_sticky_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'powernode' ),
				'section'  			    => 'powernode_header_sticky_section',
				'settings' 			    => 'powernode_header_sticky_text_color',
				'priority'              => 200,
			) ) );
			
			
			/**
			 * Menu Section -----------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_header_nav_menu' , array(
				'title' 			=> __( 'Menu', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_header_panel',
			) );
			
			/**
			 * Menu : Show Search Content
			 */
			$wp_customize->add_setting( 'powernode_show_header_search', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_show_header_search', array(
				'label'	   				=> __( 'Show Search Content', 'powernode' ),
				'section'  				=> 'powernode_header_nav_menu',
				'settings' 				=> 'powernode_show_header_search',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Menu : Extra Content
			 */
			$wp_customize->add_setting( 'powernode_header_nav_extra_content', array(
				'default'          		=> '',
				'transport'           	=> 'postMessage',
				'sanitize_callback'		=> 'wp_kses_post',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_header_nav_extra_content', array(
				'label'	   				=> __( 'Menu Extra Content', 'powernode' ),
				'type'       			=> 'textarea',
				'section'  				=> 'powernode_header_nav_menu',
				'settings' 				=> 'powernode_header_nav_extra_content',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Menu Style ================================
			 */
			$wp_customize->add_setting( 'powernode_header_nav_menu_style_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_header_nav_menu_style_heading', array(
				'label'	   				=> __( 'Style', 'powernode' ),
				'section'  				=> 'powernode_header_nav_menu',
				'settings' 				=> 'powernode_header_nav_menu_style_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Menu : Font Size
			 */
			$wp_customize->add_setting( 'powernode_nav_menu_font_size', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> '',
			) );

			$wp_customize->add_control( 'powernode_nav_menu_font_size', array(
				'label' 			=> esc_html__( 'NavBar Menu Font Size', 'powernode' ),
				'description' 		=> esc_html__( 'You can add size in (px,em,%)', 'powernode' ),
				'section' 			=> 'powernode_header_nav_menu',
				'settings' 			=> 'powernode_nav_menu_font_size',
				'priority' 			=> 10,
			) );
			
			/**
			 * Menu : Font Weight
			 */
			$wp_customize->add_setting( 'powernode_nav_menu_font_weight', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( 'powernode_nav_menu_font_weight', array(
				'label' 			=> esc_html__( 'NavBar Menu Font Weight', 'powernode' ),
				'section' 			=> 'powernode_header_nav_menu',
				'settings' 			=> 'powernode_nav_menu_font_weight',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'choices' 			=> array(
					'' => esc_html__( 'Default', 'powernode' ),
					'100' => esc_html__( 'Thin: 100', 'powernode' ),
					'200' => esc_html__( 'Light: 200', 'powernode' ),
					'300' => esc_html__( 'Book: 300', 'powernode' ),
					'400' => esc_html__( 'Normal: 400', 'powernode' ),
					'500' => esc_html__( 'Medium: 500', 'powernode' ),
					'600' => esc_html__( 'Semibold: 600', 'powernode' ),
					'700' => esc_html__( 'Bold: 700', 'powernode' ),
					'800' => esc_html__( 'Extra Bold: 800', 'powernode' ),
					'900' => esc_html__( 'Black: 900', 'powernode' ),
				),
			) );
			
			/**
			 * Menu : Text Transform
			 */
			$wp_customize->add_setting( 'powernode_nav_menu_text_transform', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'powernodewt_sanitize_select',
				'transport' 		=> 'postMessage',
			) );

			$wp_customize->add_control( 'powernode_nav_menu_text_transform', array(
				'label' 			=> esc_html__( 'NavBar Menu Text Transform', 'powernode' ),
				'section' 			=> 'powernode_header_nav_menu',
				'settings' 			=> 'powernode_nav_menu_text_transform',
				'priority' 			=> 10,
				'type' 				=> 'select',
				'choices' 			=> array(
					'' 			 => esc_html__( 'Default', 'powernode' ),
					'capitalize' => esc_html__( 'Capitalize', 'powernode' ),
					'lowercase'  => esc_html__( 'Lowercase', 'powernode' ),
					'uppercase'  => esc_html__( 'Uppercase', 'powernode' ),
					'none'  	 => esc_html__( 'None', 'powernode' ),
				),
			) );
			
			
			/**
			 * Menu : BG Color
			 */
			$wp_customize->add_setting( 'powernode_nav_menu_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_menu_bg_color', array(
				'label'   			    => esc_html__( 'NavBar Background Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_menu_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Menu : Hover BG Color
			 */
			$wp_customize->add_setting( 'powernode_nav_menu_hover_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_menu_hover_bg_color', array(
				'label'   			    => esc_html__( 'NavBar Menu Hover Background Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_menu_hover_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Menu : Text Color
			 */
			$wp_customize->add_setting( 'powernode_nav_menu_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_menu_text_color', array(
				'label'   			    => esc_html__( 'NavBar Text Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_menu_text_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Menu : Text Hover Color
			 */
			$wp_customize->add_setting( 'powernode_nav_menu_text_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_menu_text_hover_color', array(
				'label'   			    => esc_html__( 'NavBar Menu Text Hover Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_menu_text_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_nav_megamenu_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_nav_megamenu_heading', array(
				'label'	   				=> __( 'Megamenu', 'powernode' ),
				'section'  				=> 'powernode_header_nav_menu',
				'settings' 				=> 'powernode_nav_megamenu_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Megamenu : BG Color
			 */
			$wp_customize->add_setting( 'powernode_nav_megamenu_bg_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_megamenu_bg_color', array(
				'label'   			    => esc_html__( 'Megamenu Background Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_megamenu_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Text Color
			 */
			$wp_customize->add_setting( 'powernode_nav_megamenu_text_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_megamenu_text_color', array(
				'label'   			    => esc_html__( 'Megamenu Text Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_megamenu_text_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Columns Heading Color
			 */
			$wp_customize->add_setting( 'powernode_nav_megamenu_cols_heading_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_megamenu_cols_heading_color', array(
				'label'   			    => esc_html__( 'Megamenu Columns Heading Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_megamenu_cols_heading_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Border Color
			 */
			$wp_customize->add_setting( 'powernode_nav_megamenu_border_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_megamenu_border_color', array(
				'label'   			    => esc_html__( 'Megamenu Border Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_megamenu_border_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Link Color
			 */
			$wp_customize->add_setting( 'powernode_nav_megamenu_link_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_megamenu_link_color', array(
				'label'   			    => esc_html__( 'Megamenu Link Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_megamenu_link_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Megamenu : Link Hover Color
			 */
			$wp_customize->add_setting( 'powernode_nav_megamenu_link_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_megamenu_link_hover_color', array(
				'label'   			    => esc_html__( 'Megamenu Link Hover Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_megamenu_link_hover_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Badge Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_nav_badge_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_nav_badge_heading', array(
				'label'	   				=> __( 'Badge', 'powernode' ),
				'section'  				=> 'powernode_header_nav_menu',
				'settings' 				=> 'powernode_nav_badge_heading',
				'priority' 				=> 10,
			) ) );
			 
			/**
			 * New Badge : BG Color
			 */
			$wp_customize->add_setting( 'powernode_nav_new_badge_bg_color', array(
				'default'               => '#2ECC71',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_new_badge_bg_color', array(
				'label'   			    => esc_html__( 'New Badge Background Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_new_badge_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * New Badge : Text Color
			 */
			$wp_customize->add_setting( 'powernode_nav_new_badge_text_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_new_badge_text_color', array(
				'label'   			    => esc_html__( 'New Badge Text Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_new_badge_text_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Sale Badge : BG Color
			 */
			$wp_customize->add_setting( 'powernode_nav_sale_badge_bg_color', array(
				'default'               => '#E59F02',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_sale_badge_bg_color', array(
				'label'   			    => esc_html__( 'Sale Badge Background Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_sale_badge_bg_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Sale Badge : Text Color
			 */
			$wp_customize->add_setting( 'powernode_nav_sale_badge_text_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_nav_sale_badge_text_color', array(
				'label'   			    => esc_html__( 'Sale Badge Text Color', 'powernode' ),
				'section'  			    => 'powernode_header_nav_menu',
				'settings' 			    => 'powernode_nav_sale_badge_text_color',
				'priority'              => 10,
			) ) );

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
				
			$header_layout 											= powernodewt_header_style();
			$powernode_header_height								= get_theme_mod( 'powernode_header_height', '70' );
			$powernode_header_bg_color								= get_theme_mod( 'powernode_header_bg_color', '' );
			$powernode_header_text_color							= get_theme_mod( 'powernode_header_text_color', '' );
			
			$powernode_header_sticky_bg_color						= get_theme_mod( 'powernode_header_sticky_bg_color', '' );
			$powernode_header_sticky_text_color						= get_theme_mod( 'powernode_header_sticky_text_color', '' );
		
			$powernode_nav_menu_font_size							= get_theme_mod( 'powernode_nav_menu_font_size', '' );
			$powernode_nav_menu_font_weight							= get_theme_mod( 'powernode_nav_menu_font_weight', '' );
			$powernode_nav_menu_text_transform						= get_theme_mod( 'powernode_nav_menu_text_transform', '' );
			$powernode_nav_menu_bg_color							= get_theme_mod( 'powernode_nav_menu_bg_color', '' );
			$powernode_nav_menu_text_color							= get_theme_mod( 'powernode_nav_menu_text_color', '' );
			
			$powernode_nav_menu_hover_bg_color						= get_theme_mod( 'powernode_nav_menu_hover_bg_color', '' );
			$powernode_nav_menu_text_hover_color					= get_theme_mod( 'powernode_nav_menu_text_hover_color', '' );
			
			$powernode_nav_megamenu_bg_color						= get_theme_mod( 'powernode_nav_megamenu_bg_color', '' );
			$powernode_nav_megamenu_text_color						= get_theme_mod( 'powernode_nav_megamenu_text_color', '' );
			$powernode_nav_megamenu_border_color					= get_theme_mod( 'powernode_nav_megamenu_border_color', '' );
			
			$powernode_nav_megamenu_cols_heading_color				= get_theme_mod( 'powernode_nav_megamenu_cols_heading_color', '' );
			
			$powernode_nav_megamenu_link_color						= get_theme_mod( 'powernode_nav_megamenu_link_color', '' );
			$powernode_nav_megamenu_link_hover_color				= get_theme_mod( 'powernode_nav_megamenu_link_hover_color', '' );
			
			$powernode_nav_new_badge_bg_color						= get_theme_mod( 'powernode_nav_new_badge_bg_color', '#2ECC71' );
			$powernode_nav_new_badge_text_color						= get_theme_mod( 'powernode_nav_new_badge_text_color', '#ffffff' );
			$powernode_nav_sale_badge_bg_color						= get_theme_mod( 'powernode_nav_sale_badge_bg_color', '#E59F02' );
			$powernode_nav_sale_badge_text_color					= get_theme_mod( 'powernode_nav_sale_badge_text_color', '#ffffff' );
			
			/**
			* Header
			*/
			$output .= powernodewt_output_css( array( '.header-mid-area' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_header_bg_color, '' ) ) ? $powernode_header_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_header_text_color, '' ) ) ? $powernode_header_text_color : '',
			) ) );
			
			/**
			* Sticky Header
			*/
			$output .= powernodewt_output_css( array( '.main-wrap .header-wrap.scroll' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_header_sticky_bg_color, '' ) ) ? $powernode_header_sticky_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_header_sticky_text_color, '' ) ) ? $powernode_header_sticky_text_color : '',
			) ) );
	
			
			/**
			* NavBar Menu Item
			*/
			$output .= powernodewt_output_css( array( '.pnwt-menu > li' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_menu_bg_color, '' ) ) ? $powernode_nav_menu_bg_color : '',
				'font-size' => ( !powernodewt_opt_chk_def_val( $powernode_nav_menu_font_size, '' ) ) ? $powernode_nav_menu_font_size : '',
				'font-weight' => ( !powernodewt_opt_chk_def_val( $powernode_nav_menu_font_weight, '' ) ) ? $powernode_nav_menu_font_weight : '',
				'text-transform' => ( !powernodewt_opt_chk_def_val( $powernode_nav_menu_text_transform, '' ) ) ? $powernode_nav_menu_text_transform : '',
			) ) );
			
			$output .= powernodewt_output_css( array( '.pnwt-menu > li > a' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_menu_text_color, '' ) ) ? $powernode_nav_menu_text_color : '',
			) ) );
			
			/**
			* NavBar Menu Item Hover
			*/
			$output .= powernodewt_output_css( array( '.pnwt-menu > li' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_menu_hover_bg_color, '' ) ) ? $powernode_nav_menu_hover_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_menu_text_hover_color, '' ) ) ? $powernode_nav_menu_text_hover_color : '',
			) ) );
			
			/**
			* Megamenu
			*/
			$output .= powernodewt_output_css( array( '.pnwt-nav ul li > ul, .pnwt-nav .pnwt-megamenu' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_megamenu_bg_color, '' ) ) ? $powernode_nav_megamenu_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_megamenu_text_color, '' ) ) ? $powernode_nav_megamenu_text_color : '',
				'border-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_megamenu_border_color, '' ) ) ? $powernode_nav_megamenu_border_color : '',
			) ) );
			
			/**
			* Megamenu Columns Heading
			*/
			$output .= powernodewt_output_css( array( '.mega-menu.lvl-1 > li > a' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_megamenu_cols_heading_color, '' ) ) ? $powernode_nav_megamenu_cols_heading_color : '',
			) ) );
			
			/**
			* Megamenu Link
			*/
			$output .= powernodewt_output_css( array( '.pnwt-menu a' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_megamenu_link_color, '' ) ) ? $powernode_nav_megamenu_link_color : '',
			) ) );
			
			/**
			* Megamenu Link Hover
			*/
			$output .= powernodewt_output_css( array( '.pnwt-menu a:hover, .pnwt-menu > li:hover > a' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_megamenu_link_hover_color, '' ) ) ? $powernode_nav_megamenu_link_hover_color : '',
			) ) );
						
			/**
			* New Badge
			*/
			$output .= powernodewt_output_css( array( '.badge-menu.badge-new' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_new_badge_bg_color, '#2ECC71' ) ) ? $powernode_nav_new_badge_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_new_badge_text_color, '#ffffff' ) ) ? $powernode_nav_new_badge_text_color : '',
				'border-top-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_new_badge_bg_color, '#2ECC71' ) ) ? $powernode_nav_new_badge_bg_color : '',
			) ) );
			
			/**
			* Sale Badge
			*/
			$output .= powernodewt_output_css( array( '.badge-menu.badge-sale' => array(
				'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_sale_badge_bg_color, '#E59F02' ) ) ? $powernode_nav_sale_badge_bg_color : '',
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_sale_badge_text_color, '#ffffff' ) ) ? $powernode_nav_sale_badge_text_color : '',
				'border-top-color' => ( !powernodewt_opt_chk_def_val( $powernode_nav_sale_badge_bg_color, '#E59F02' ) ) ? $powernode_nav_sale_badge_bg_color : '',
			) ) );
			
			return $output;

		}

	}

endif;

return new PowerNodeWT_Header_Customizer();