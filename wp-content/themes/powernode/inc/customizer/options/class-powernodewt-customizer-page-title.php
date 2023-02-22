<?php
/**
 * Header Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Page_Title_Customizer' ) ) :

	class PowerNodeWT_Page_Title_Customizer {

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
			 * Page Title : Section
			 */
			$wp_customize->add_section( 'powernode_paget_title_section' , array(
				'title' 			=> __( 'Page Title', 'powernode' ),
				'priority' 			=> 10,
				'panel' 			=> 'powernode_options_panel',
			) );
			
			/**
			 * Page Title : Show Page Title Section
			 */
			$wp_customize->add_setting( 'powernode_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_page_title_section', array(
				'label'	   				=> __( 'Show Page Title', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Title : Style
			 */
			$wp_customize->add_setting( 'powernode_page_title_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_page_title_style', array(
				'label'	   				=> __( 'Page Title Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 		=> __( 'Default', 'powernode' ),
					'left' 			=> __( 'Left Alignment', 'powernode' ),
					'centered' 		=> __( 'Center Alignment', 'powernode' ),
					'right' 		=> __( 'Right Alignment', 'powernode' ),
					'hidden' 		=> __( 'Hidden', 'powernode' ),
				),
			) ) );

			/**
			 * Page Title : Show Page Title
			 */
			$wp_customize->add_setting( 'powernode_page_title', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_page_title', array(
				'label'	   				=> __( 'Show Page Title Heading', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title',
				'priority' 				=> 10,
			) ) );
			

			/**
			 * Page Title : Padding
			 */
			$wp_customize->add_setting( 'powernode_page_title_desktop_top_padding', array(
				'default' 				=> '170',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_desktop_right_padding', array(
				'default'	 			=> '0',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_desktop_bottom_padding', array(
				'default' 				=> '130',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_desktop_left_padding', array(
				'default'	 			=> '0',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_tablet_top_padding', array(
				'default' 				=> '15',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_tablet_right_padding', array(
				'default'	 			=> '0',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_tablet_bottom_padding', array(
				'default' 				=> '15',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_tablet_left_padding', array(
				'default'	 			=> '0',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_mobile_top_padding', array(
				'default' 				=> '15',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_mobile_right_padding', array(
				'default'	 			=> '0',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_mobile_bottom_padding', array(
				'default' 				=> '15',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );

			$wp_customize->add_setting( 'powernode_page_title_mobile_left_padding', array(
				'default'	 			=> '0',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number',
			) );
			

			$wp_customize->add_control( new PowerNodeWT_Customizer_Dimensions_Control( $wp_customize, 'powernode_page_title_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',				
				'settings'  		    => array(
					'desktop_top' 		=> 'powernode_page_title_desktop_top_padding',
					'desktop_right' 	=> 'powernode_page_title_desktop_right_padding',
					'desktop_bottom' 	=> 'powernode_page_title_desktop_bottom_padding',
					'desktop_left' 		=> 'powernode_page_title_desktop_left_padding',
					'tablet_top' 		=> 'powernode_page_title_tablet_top_padding',
					'tablet_right' 		=> 'powernode_page_title_tablet_right_padding',
					'tablet_bottom' 	=> 'powernode_page_title_tablet_bottom_padding',
					'tablet_left' 		=> 'powernode_page_title_tablet_left_padding',
					'mobile_top' 		=> 'powernode_page_title_mobile_top_padding',
					'mobile_right' 		=> 'powernode_page_title_mobile_right_padding',
					'mobile_bottom' 	=> 'powernode_page_title_mobile_bottom_padding',
					'mobile_left' 		=> 'powernode_page_title_mobile_left_padding',
				),
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Title : Enable Backgournd
			 */
			$wp_customize->add_setting( 'powernode_page_title_background', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_page_title_background', array(
				'label'	   				=> __( 'Enable Backgournd Image', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_background',
				'priority' 				=> 10,
			) ) );

			/**
			 * Page Title : Background Image
			 */
			$wp_customize->add_setting( 'powernode_page_title_bg_image', array(
				'default'				=>  POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
				'transport'				=> 'postMessage'
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'powernode' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Background Position
			 */
			$wp_customize->add_setting( 'powernode_page_title_bg_position', array(
				'default'           	=> 'center center',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
				'transport'				=> 'postMessage'
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_page_title_bg_position', array(
				'label'	   				=> __( 'Background Position', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_bg_position',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'powernode' ),
					'top left' 		=> __( 'Top Left', 'powernode' ),
					'top center' 	=> __( 'Top Center', 'powernode' ),
					'top right' 	=> __( 'Top Right', 'powernode' ),
					'center left' 	=> __( 'Center Left', 'powernode' ),
					'center center' => __( 'Center Center', 'powernode' ),
					'center right' 	=> __( 'Center Right', 'powernode' ),
					'bottom left' 	=> __( 'Bottom Left', 'powernode' ),
					'bottom center' => __( 'Bottom Center', 'powernode' ),
					'bottom right' 	=> __( 'Bottom Right', 'powernode' ),
				),
				'active_callback' 		=> 'ctm_powernode_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Background Attachment
			 */
			$wp_customize->add_setting( 'powernode_page_title_bg_attachment', array(
				'default'           	=> 'initial',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
				'transport'				=> 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_page_title_bg_attachment', array(
				'label'	   				=> __( 'Background Attachment', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_bg_attachment',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'powernode' ),
					'Fixed' 		=> __( 'fixed', 'powernode' ),
					'Scroll' 		=> __( 'scroll', 'powernode' ),
				),
				'active_callback' 		=> 'ctm_powernode_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Repeat
			 */
			$wp_customize->add_setting( 'powernode_page_title_bg_repeat', array(
				'default'           	=> 'no-repeat',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
				'transport'				=> 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_page_title_bg_repeat', array(
				'label'	   				=> __( 'Background Repeat', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_bg_repeat',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'powernode' ),
					'no-repeat' 	=> __( 'No-repeat', 'powernode' ),
					'repeat' 		=> __( 'Repeat', 'powernode' ),
					'repeat-x' 		=> __( 'Repeat-x', 'powernode' ),
					'repeat-y' 		=> __( 'Repeat-y', 'powernode' ),
				),
				'active_callback' 		=> 'ctm_powernode_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Background Size
			 */
			$wp_customize->add_setting( 'powernode_page_title_bg_size', array(
				'default'           	=> 'cover',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
				'transport'				=> 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_page_title_bg_size', array(
				'label'	   				=> __( 'Background Size', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_bg_size',
				'priority' 				=> 10,
				'choices' 				=> array(
					'initial' 		=> __( 'Default', 'powernode' ),
					'auto' 	=> __( 'Auto', 'powernode' ),
					'contain' 		=> __( 'Contain', 'powernode' ),
					'cover' 		=> __( 'Cover', 'powernode' ),
					'unset' 		=> __( 'Unset', 'powernode' ),
				),
				'active_callback' 		=> 'ctm_powernode_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Overlay Opacity
			 */
			$wp_customize->add_setting( 'powernode_page_title_bg_overlay_opacity', array(
				'default'          		=>  '0',
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_page_title_bg_overlay_opacity', array(
				'label'   				=> __( 'Background Overlay Opacity', 'powernode' ),
				'section' 				=> 'powernode_paget_title_section',
				'settings'  			=> 'powernode_page_title_bg_overlay_opacity',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 1,
											'step' => 0.1,
										),
				'active_callback' 		=> 'ctm_powernode_page_title_background_enabled',
			) ) );

			/**
			 * Page Title : Overlay Background Color
			 */
			$wp_customize->add_setting( 'powernode_page_title_overlay_bg_color', array(
				'default'               => '#000000',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_page_title_overlay_bg_color', array(
				'label'   			    => esc_html__( 'Overlay Background Color', 'powernode' ),
				'section'  			    => 'powernode_paget_title_section',
				'settings' 			    => 'powernode_page_title_overlay_bg_color',
				'priority'              => 10,
				'active_callback' 		=> 'ctm_powernode_page_title_background_enabled',
			) ) );
			
			/**
			 * Breadcrumbs Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_page_title_breadcrumbs_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_page_title_breadcrumbs_heading', array(
				'label'	   				=> __( 'Breadcrumbs', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_breadcrumbs_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Breadcrumbs : Enable/Disable
			 */
			$wp_customize->add_setting( 'powernode_page_title_breadcrumbs_display', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_page_title_breadcrumbs_display', array(
				'label'	   				=> __( 'Enable Breadcrumbs', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_breadcrumbs_display',
				'priority' 				=> 10,
			) ) );

			/**
			 * Breadcrumbs : Show Item Title
			 */
			$wp_customize->add_setting( 'powernode_page_title_breadcrumbs_item_title_display', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_page_title_breadcrumbs_item_title_display', array(
				'label'	   				=> __( 'Show Item Title', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_breadcrumbs_item_title_display',
				'priority' 				=> 10,
			) ) );

			/**
			 * Breadcrumbs : Home Item
			 */
			$wp_customize->add_setting( 'powernode_page_title_breadcrumb_home_style', array(
				'default'           	=> 'text',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_page_title_breadcrumb_home_style', array(
				'label'	   				=> __( 'Home Item Style', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_breadcrumb_home_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'icon' 				=> __( 'Icon', 'powernode' ),
											'text' 				=> __( 'Text', 'powernode' ),
										),
				'active_callback' 		=> 'powernodewt_page_title_breadcrumbs_display',
			) ) );

			/**
			 * Page Title : Style Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_page_title_styling_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_page_title_styling_heading', array(
				'label'	   				=> __( 'Styling', 'powernode' ),
				'section'  				=> 'powernode_paget_title_section',
				'settings' 				=> 'powernode_page_title_styling_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Page Title : Font Size
			 */
			$wp_customize->add_setting( 'powernode_page_title_font_size', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> '',
			) );

			$wp_customize->add_control( 'powernode_page_title_font_size', array(
				'label' 			=> esc_html__( 'Page Title Font Size', 'powernode' ),
				'description' 		=> esc_html__( 'You can add size in (px,em,%)', 'powernode' ),
				'section' 			=> 'powernode_paget_title_section',
				'settings' 			=> 'powernode_page_title_font_size',
				'priority' 			=> 10,
			) );

			/**
			 * Page Title : Background Color
			 */
			$wp_customize->add_setting( 'powernode_page_title_bg_color', array(
				'default'               => '#0f0f0f',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_page_title_bg_color', array(
				'label'   			    => esc_html__( 'Background Color', 'powernode' ),
				'section'  			    => 'powernode_paget_title_section',
				'settings' 			    => 'powernode_page_title_bg_color',
				'priority'              => 10,
			) ) );

			/**
			 * Page Title : Text Color
			 */
			$wp_customize->add_setting( 'powernode_page_title_text_color', array(
				'default'               => '#ffffff',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_page_title_text_color', array(
				'label'   			    => esc_html__( 'Text Color', 'powernode' ),
				'section'  			    => 'powernode_paget_title_section',
				'settings' 			    => 'powernode_page_title_text_color',
				'priority'              => 10,
			) ) );

			/**
			 * Page Title : Separator Color
			 */
			$wp_customize->add_setting( 'powernode_page_title_separator_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_page_title_separator_color', array(
				'label'   			    => esc_html__( 'Separator Color', 'powernode' ),
				'section'  			    => 'powernode_paget_title_section',
				'settings' 			    => 'powernode_page_title_separator_color',
				'priority'              => 10,
			) ) );

			/**
			 * Page Title : Link Color
			 */
			$wp_customize->add_setting( 'powernode_page_title_link_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_page_title_link_color', array(
				'label'   			    => esc_html__( 'Link Color', 'powernode' ),
				'section'  			    => 'powernode_paget_title_section',
				'settings' 			    => 'powernode_page_title_link_color',
				'priority'              => 10,
			) ) );
			
			/**
			 * Page Title : Link Hover Color
			 */
			$wp_customize->add_setting( 'powernode_page_title_link_hover_color', array(
				'default'               => '',
				'sanitize_callback'     => 'powernodewt_sanitize_color',
				'transport' 			=> 'postMessage',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Color_Control( $wp_customize, 'powernode_page_title_link_hover_color', array(
				'label'   			    => esc_html__( 'Link Hover Color', 'powernode' ),
				'section'  			    => 'powernode_paget_title_section',
				'settings' 			    => 'powernode_page_title_link_hover_color',
				'priority'              => 10,
			) ) );

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			$powernode_page_title_background						= get_theme_mod( 'powernode_page_title_background', false );
			$powernode_page_title_desktop_top_padding				= get_theme_mod( 'powernode_page_title_desktop_top_padding', '170' );
			$powernode_page_title_desktop_right_padding				= get_theme_mod( 'powernode_page_title_desktop_right_padding', '0' );
			$powernode_page_title_desktop_bottom_padding			= get_theme_mod( 'powernode_page_title_desktop_bottom_padding', '130' );
			$powernode_page_title_desktop_left_padding				= get_theme_mod( 'powernode_page_title_desktop_left_padding', '0' );
			$powernode_page_title_tablet_top_padding				= get_theme_mod( 'powernode_page_title_tablet_top_padding', '150' );
			$powernode_page_title_tablet_right_padding				= get_theme_mod( 'powernode_page_title_tablet_right_padding', '0' );
			$powernode_page_title_tablet_bottom_padding				= get_theme_mod( 'powernode_page_title_tablet_bottom_padding', '100' );
			$powernode_page_title_tablet_left_padding				= get_theme_mod( 'powernode_page_title_tablet_left_padding', '0' );
			$powernode_page_title_mobile_top_padding				= get_theme_mod( 'powernode_page_title_mobile_top_padding', '70' );
			$powernode_page_title_mobile_right_padding				= get_theme_mod( 'powernode_page_title_mobile_right_padding', '0' );
			$powernode_page_title_mobile_bottom_padding				= get_theme_mod( 'powernode_page_title_mobile_bottom_padding', '70' );
			$powernode_page_title_mobile_left_padding				= get_theme_mod( 'powernode_page_title_mobile_left_padding', '0' );
			$powernode_page_title_font_size							= powernodewt_page_title_font_size();
			$powernode_page_title_bg_color							= powernodewt_page_title_bg_color();
			$powernode_page_title_text_color						= powernodewt_page_title_text_color();
			$powernode_page_title_separator_color					= powernodewt_page_title_separator_color();
			$powernode_page_title_link_color						= powernodewt_page_title_link_color();
			$powernode_page_title_link_hover_color					= powernodewt_page_title_link_hover_color();
			$powernode_page_title_bg_image							= powernodewt_page_title_bg_image();
			$powernode_page_title_bg_position						= powernodewt_page_title_bg_position();
			$powernode_page_title_bg_attachment						= powernodewt_page_title_bg_attachment();
			$powernode_page_title_bg_repeat							= powernodewt_page_title_bg_repeat();
			$powernode_page_title_bg_size							= powernodewt_page_title_bg_size();
			$powernode_page_title_bg_overlay_opacity				= powernodewt_page_title_bg_overlay_opacity();
			$powernode_page_title_overlay_bg_color					= powernodewt_page_title_overlay_bg_color();

			/**
			* Desktop Page title padding
			*/
			if ( ((!empty($powernode_page_title_desktop_top_padding) && $powernode_page_title_desktop_top_padding != 170 ))
			||	((!empty($powernode_page_title_desktop_right_padding) && $powernode_page_title_desktop_right_padding != 0 ))
			||	((!empty($powernode_page_title_desktop_bottom_padding) && $powernode_page_title_desktop_bottom_padding != 130 ))
			||	((!empty($powernode_page_title_desktop_left_padding) && $powernode_page_title_desktop_left_padding != 0))
			||	((!empty($powernode_page_title_bg_color) && $powernode_page_title_bg_color != '#0f0f0f'))
			||	((!empty($powernode_page_title_text_color) && $powernode_page_title_text_color != '#ffffff'))
			){
				$output .= powernodewt_output_css( array( '.page-title-wrap' => array(
					'padding' => $powernode_page_title_desktop_top_padding . 'px ' . $powernode_page_title_desktop_right_padding . 'px ' . $powernode_page_title_desktop_bottom_padding . 'px ' . $powernode_page_title_desktop_left_padding . 'px; ',
					'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_bg_color , '' ) ) ? $powernode_page_title_bg_color : '',
					'color' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_text_color , '' ) ) ? $powernode_page_title_text_color : '',
				) ) );
			}

			/**
			* Tablet Page title padding
			*/
			if ( ((!empty($powernode_page_title_tablet_top_padding) && $powernode_page_title_tablet_top_padding != 150))
			||	((!empty($powernode_page_title_tablet_right_padding) && $powernode_page_title_tablet_right_padding != 0))
			||	((!empty($powernode_page_title_tablet_bottom_padding) && $powernode_page_title_tablet_bottom_padding != 100))
			||	((!empty($powernode_page_title_tablet_left_padding) && $powernode_page_title_tablet_left_padding != 0))
			){
				$output .= powernodewt_output_css( array( '.page-title-wrap' => array(
					'padding' => $powernode_page_title_tablet_top_padding . 'px ' . $powernode_page_title_tablet_right_padding . 'px ' . $powernode_page_title_tablet_bottom_padding . 'px ' . $powernode_page_title_tablet_left_padding . 'px;',
				) ), 767, 1024 );

				
			}

			/**
			* Mobile Page title padding
			*/
			if ( ((!empty($powernode_page_title_mobile_top_padding) && $powernode_page_title_mobile_top_padding != 70))
			||	((!empty($powernode_page_title_mobile_right_padding) && $powernode_page_title_mobile_right_padding != 0))
			||	((!empty($powernode_page_title_mobile_bottom_padding) && $powernode_page_title_mobile_bottom_padding != 70))
			||	((!empty($powernode_page_title_mobile_left_padding) && $powernode_page_title_mobile_left_padding != 0))
			){
				$output .= powernodewt_output_css( array( '.page-title-wrap' => array(
					'padding' => $powernode_page_title_mobile_top_padding . 'px ' . $powernode_page_title_mobile_right_padding . 'px ' . $powernode_page_title_mobile_bottom_padding . 'px ' . $powernode_page_title_mobile_left_padding . 'px;',
				) ), '', 768 );
			}

			/**
			* Breadcrumbs : Separator color
			*/
			$output .= powernodewt_output_css( array( '.breadcrumb-sep' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_separator_color, '' ) ) ? $powernode_page_title_separator_color : '',
			) ) );

			/**
			* Page title link color
			*/
			$output .= powernodewt_output_css( array( '.page-title-wrap a:not(:hover)' => array(
				'color' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_link_color, '' ) ) ? $powernode_page_title_link_color : '',
			) ) );

			/**
			* Page Title : Font Size
			*/
			$output .= powernodewt_output_css( array( '.page-header-title' => array(
				'font-size' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_font_size, '' ) ) ? $powernode_page_title_font_size : '',
			) ) );
			
			/**
			* Page Title : Is Background Image
			*/
			if ( $powernode_page_title_background == true ) {
				$output .= powernodewt_output_css( array( '.bgimg-page-header' => array(
					'background-image' => ( !empty( $powernode_page_title_bg_image ) ) ? 'url('.$powernode_page_title_bg_image.')' : '',
					'background-position' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_bg_position , 'center center' ) ) ? $powernode_page_title_bg_position : '',
					'background-attachment' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_bg_attachment, 'initial' ) ) ? $powernode_page_title_bg_attachment : '',
					'background-repeat' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_bg_repeat, 'no-repeat' ) ) ? $powernode_page_title_bg_repeat : '',
					'background-size' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_bg_size, 'cover' ) ) ? $powernode_page_title_bg_size : '',
				) ) );
			}

			/**
			* Page Title : Background Image Overlay
			*/
			if ( $powernode_page_title_background == true ) {
				$output .= powernodewt_output_css( array( '.page-header-bgimg-overlay' => array(
					'background-color' => ( !powernodewt_opt_chk_def_val( $powernode_page_title_overlay_bg_color, '#000000' ) ) ? $powernode_page_title_overlay_bg_color : '',
					'opacity' => ( $powernode_page_title_bg_overlay_opacity != 0 ) ? $powernode_page_title_bg_overlay_opacity : '',
				) ) );
			}
			
			return $output;

		}
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			$posts_id = get_posts( array('post_type' => 'post', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( $posts_id[0] ) ) { ?>
					wp.customize.section( 'powernode_paget_title_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_permalink( $posts_id[0] ) ); ?>" );
							}
						} );
					<?php } ?>
					} );
				} );
			</script>
			<?php
		}

	}

endif;

return new PowerNodeWT_Page_Title_Customizer();