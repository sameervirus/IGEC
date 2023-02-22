<?php
/**
 * Footer Middle Widgets Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Footer_Customizer' ) ) :

	class PowerNodeWT_Footer_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'powernode_head_css', array( $this, 'add_customizer_css' ), 130 );

		}

		public function options_register( $wp_customize ) {
			
			/**
			 * Footer: Sections ----------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_footer_section' , array(
				'title' 				=> __( 'Footer', 'powernode' ),
				'priority' 				=> 10,
				'panel' 				=> 'powernode_options_panel',
			) );
			
			/**
			* Header: Layout
			*/
			$wp_customize->add_setting( 'powernode_footer_layout', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_footer_layout', array(
				'label'	   				=> __( 'Footer Layout', 'powernode' ),
				'type' 					=> 'select',
				'description'	   		=> __( 'Select custom footer from Layouts Builder', 'powernode' ),
				'section'  				=> 'powernode_footer_section',
				'settings' 				=> 'powernode_footer_layout',
				'priority' 				=> 10,
				'choices' 				=> powernodewt_footer_layout_list(),
			) ) );
		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			return $output;
		}
	}

endif;

return new PowerNodeWT_Footer_Customizer();