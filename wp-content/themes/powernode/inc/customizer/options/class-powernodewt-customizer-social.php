<?php
/**
 * Social Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Social_Customizer' ) ) :

	class PowerNodeWT_Social_Customizer {

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
			 * Social Panel
			 */
			$wp_customize->add_panel( new PowerNodeWT_Customizer_Module_Panels( $wp_customize, 'powernode_social_panel',  array(
				'title' 				=> __( 'Social', 'powernode' ),
				'priority' 				=> '-2500',
				'panel' 				=> 'powernode_options_panel',
			) ) );
			
			/**
			 * Social Links Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_social_links_section' , array(
				'title' 				=> __( 'Social Links', 'powernode' ),
				'description'	   		=> __( 'Show social links icon on header and footer', 'powernode' ),
				'priority' 				=> 110,
				'panel' 				=> 'powernode_social_panel',
			) );
			
			/**
			 * Social Links : Status
			 */
			$wp_customize->add_setting( 'powernode_social_links', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_social_links', array(
				'label'	   				=> __( 'Enable Social Links', 'powernode' ),
				'section'  				=> 'powernode_social_links_section',
				'settings' 				=> 'powernode_social_links',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Social Links : Links Display Type
			 */
			$wp_customize->add_setting( 'powernode_social_links_display_type', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_links_display_type', array(
				'label'	   				=> __( 'Links Display Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_links_section',
				'settings' 				=> 'powernode_social_links_display_type',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Only Icon ( Default )', 'powernode' ),
												'icon-label'    	=> esc_html__( 'Icon with Label', 'powernode' ),
												'label'    			=> esc_html__( 'Only Label', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Icon Style
			 */
			$wp_customize->add_setting( 'powernode_social_links_icon_style', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_links_icon_style', array(
				'label'	   				=> __( 'Icon Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_links_section',
				'settings' 				=> 'powernode_social_links_icon_style',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'powernode' ),
												'colored'    		=> esc_html__( 'Colored', 'powernode' ),
												'bordered'    		=> esc_html__( 'Bordered', 'powernode' ),
												'fill_colored'     => esc_html__( 'Fill Colored', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Icon Shape
			 */
			$wp_customize->add_setting( 'powernode_social_links_icon_shape', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_links_icon_shape', array(
				'label'	   				=> __( 'Icon Shape', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_links_section',
				'settings' 				=> 'powernode_social_links_icon_shape',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'powernode' ),
												'rounded'    	=> esc_html__( 'Rounded', 'powernode' ),
												'circle'    		=> esc_html__( 'Circle', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Icon Size
			 */
			$wp_customize->add_setting( 'powernode_social_links_icon_size', array(
				'default'        	    => 'md',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_links_icon_size', array(
				'label'	   				=> __( 'Icon Size', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_links_section',
				'settings' 				=> 'powernode_social_links_icon_size',
				'priority' 				=> 10,
				'choices' 				=> array(
												'xs'        		=> esc_html__( 'XSmall', 'powernode' ),
												'sm'    			=> esc_html__( 'Small', 'powernode' ),
												'md'    			=> esc_html__( 'Medium (Default)', 'powernode' ),
												'lg'    			=> esc_html__( 'Large', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Social Links Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_social_links_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_social_links_heading', array(
				'label'	   				=> __( 'Social Links', 'powernode' ),
				'section'  				=> 'powernode_social_links_section',
				'settings' 				=> 'powernode_social_links_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_social_links_enabled',
			) ) );
			
			/**
			 * Social Links : Links
			 */
			$social_links_data = powernodewt_social_links_data();
			foreach ( $social_links_data as $soc_name => $soc_det ) {
				if ( 'email' == $soc_name ) {
					$sanitize = 'sanitize_email';
				} else {
					$sanitize = 'sanitize_text_field';
				}

				$wp_customize->add_setting( 'powernode_social_links_settings[' . $soc_name .']', array(
					'type' 					=> 'theme_mod',
					'sanitize_callback' 	=> $sanitize,
					'transport' 			=> 'postMessage',
					'default' 				=> '#',
				) );

				$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_links_settings[' . $soc_name .']', array(
					'label'	   				=> esc_html( $soc_det['label'] ),
					'description'	   		=> esc_html( $soc_det['description'] ),
					'type' 					=> 'text',
					'section'  				=> 'powernode_social_links_section',
					'settings' 				=> 'powernode_social_links_settings[' . $soc_name .']',
					'priority' 				=> 10,
					'active_callback' 		=> 'ctm_powernode_social_links_enabled',
				) ) );
			}
			
			/**
			 * Social Share Links Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_social_share_links_section' , array(
				'title' 				=> __( 'Social Share Links', 'powernode' ),
				'description'	  	 	=> __( 'Show social share links icon on blog, posts, products, portfolios etc..', 'powernode' ),
				'priority' 				=> 110,
				'panel' 				=> 'powernode_social_panel',
			) );
			
			/**
			 * Social Share Links : Status
			 */
			$wp_customize->add_setting( 'powernode_social_share_links', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_social_share_links', array(
				'label'	   				=> __( 'Enable Social Share Links', 'powernode' ),
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Social Share Links : Show Title
			 */
			$wp_customize->add_setting( 'powernode_social_share_links_title', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_social_share_links_title', array(
				'label'	   				=> __( 'Show Social Title', 'powernode' ),
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links_title',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Links Display Type
			 */
			$wp_customize->add_setting( 'powernode_social_share_links_display_type', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_share_links_display_type', array(
				'label'	   				=> __( 'Links Display Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links_display_type',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Only Icon ( Default )', 'powernode' ),
												'icon-label'    	=> esc_html__( 'Icon with Label', 'powernode' ),
												'label'    			=> esc_html__( 'Only Label', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Icon Style
			 */
			$wp_customize->add_setting( 'powernode_social_share_links_icon_style', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_share_links_icon_style', array(
				'label'	   				=> __( 'Icon Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links_icon_style',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'powernode' ),
												'flat'    			=> esc_html__( 'Flat', 'powernode' ),
												'bordered'    		=> esc_html__( 'Bordered', 'powernode' ),
												'boxed'    			=> esc_html__( 'Boxed', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Icon Shape
			 */
			$wp_customize->add_setting( 'powernode_social_share_links_icon_shape', array(
				'default'        	    => 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_share_links_icon_shape', array(
				'label'	   				=> __( 'Icon Shape', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links_icon_shape',
				'priority' 				=> 10,
				'choices' 				=> array(
												'default'        	=> esc_html__( 'Default', 'powernode' ),
												'rounded'    	=> esc_html__( 'Rounded', 'powernode' ),
												'circle'    	=> esc_html__( 'Circle', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Icon Size
			 */
			$wp_customize->add_setting( 'powernode_social_share_links_icon_size', array(
				'default'        	    => 'md',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_social_share_links_icon_size', array(
				'label'	   				=> __( 'Icon Size', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links_icon_size',
				'priority' 				=> 10,
				'choices' 				=> array(
												'xs'        		=> esc_html__( 'XSmall', 'powernode' ),
												'sm'    			=> esc_html__( 'Small', 'powernode' ),
												'md'    			=> esc_html__( 'Medium (Default)', 'powernode' ),
												'lg'    			=> esc_html__( 'Large', 'powernode' ),
											),
				'active_callback' 		=> 'ctm_powernode_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Social Share Links Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_social_share_links_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_social_share_links_heading', array(
				'label'	   				=> __( 'Social Share Links', 'powernode' ),
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_social_share_links_enabled',
			) ) );
			
			/**
			 * Social Share Links : Links
			 */
			$wp_customize->add_setting( 'powernode_social_share_links_settings', array(
				'default'        	    => apply_filters( 'powernode_topbar_social_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = powernodewt_social_share_links_data();
			
			$social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_social_share_links_settings', array(
				'label'	   				=> __( 'Social Share Links', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_social_share_links_choices',
												$social_share_links
											),
				'section'  				=> 'powernode_social_share_links_section',
				'settings' 				=> 'powernode_social_share_links_settings',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_social_share_links_enabled',
			) ) );
		
			

		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			return $output;

		}
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			
		}
	}

endif;

return new PowerNodeWT_Social_Customizer();