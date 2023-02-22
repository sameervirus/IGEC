<?php
/**
 * Plugin Name:    	PowerNodeWT Core
 * Plugin URI:     	https://powernode.wttechdesign.com/
 * Description:    	Add extra features like VC shortcode, metaboxes, import/export and a panel to activate the premium extensions for PowerNode.
 * Version:        	1.1.0
 * Text Domain: 	powernodewt-core
 * Domain Path: 	/languages
 * Author:         	WebTwine Technologies
 * Author URL:     	https://webtwine.com
 * WC tested up to: 3.6.0
 */

if ( !defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'PowerNodeWT_Core' ) ) {
	
	final class PowerNodeWT_Core {
		
		private static $_instance = null;

		public $token;

		public $version;

		public function __construct () {
			
			global $pnwt_exts_head_css;
			$this->token 			= 'powernodewt-core';
			$this->version 			= '1.0.0';
			$this->plugin_url 		= plugin_dir_url( __FILE__ );
			$this->plugin_dir 		= plugin_dir_path( __FILE__ );
			
			define( 'POWERNODEWT_CORE_VERSION', $this->version );
			define( 'POWERNODEWT_CORE_URL', $this->plugin_url );
			define( 'POWERNODEWT_CORE_DIR', $this->plugin_dir );
			define( 'POWERNODEWT_CORE_FILE', __FILE__ );
			define( 'POWERNODEWT_CORE_INTEGRATIONS_DIR', POWERNODEWT_CORE_DIR . 'integrations/' );
			define( 'POWERNODEWT_CORE_INC_DIR', POWERNODEWT_CORE_DIR . 'inc/' );
			define( 'POWERNODEWT_CORE_ADMIN_DIR', POWERNODEWT_CORE_DIR . 'admin/' );
			
			$this->includes();
			$this->load_plugin_textdomain();
					
			add_action( 'powernode_footer_css', array( $this, 'powernodewt_exts_footer_css' ) );
						
		}

		/**
		 * Main PowerNodeWT_Core Instance
		 *
		 * Ensures only one instance of PowerNodeWT_Core is loaded or can be loaded.
		 */
		public static function instance () {
			if ( ! self::$_instance ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Includes
		 */
		public function includes() {
			
			// Meta Box
			require_once POWERNODEWT_CORE_INTEGRATIONS_DIR . 'meta-box/meta-box.php';
			
			// Shortcodes Elements
			require_once POWERNODEWT_CORE_INC_DIR . 'shortcodes.php';
			
			// Post Types
			require_once POWERNODEWT_CORE_INC_DIR . 'post-types.php';
			
			// Functions
			require_once POWERNODEWT_CORE_INC_DIR . 'functions.php';
			
			// Elementor
			require_once POWERNODEWT_CORE_INTEGRATIONS_DIR . 'elementor/elementor.php';
			
			// Widgets
			require_once POWERNODEWT_CORE_INC_DIR . 'widgets/widget-functions.php';
			
			// Admin
			require_once POWERNODEWT_CORE_ADMIN_DIR . 'classes/class-demo-import.php';
		}
		
		/**
		 * Filter Custom css
		 */
		function powernodewt_exts_footer_css( $output ) {

			$css = powernodewt_exts_css_output();
			$output = ( $css ) ? $output . $css : $output;
			return $output;
			
		}

		/**
		 * Load the localisation file.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'powernodewt-core', false, dirname( plugin_basename( POWERNODEWT_CORE_FILE ) ) . '/languages/' );
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone () {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'powernodewt-core' ), '1.0.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup () {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'powernodewt-core' ), '1.0.0' );
		}
	}
}

/**
 * Returns the main instance of PowerNodeWT_Core to prevent the need to use globals.
 */
function PowerNodeWT_Core() {
	return PowerNodeWT_Core::instance();
}

/*
 * Get Theme
 */
$themeName   = wp_get_theme()->get('TextDomain');


/**
 * Initialise the plugin
 */
if ( in_array( strtolower( $themeName ) , array( 'powernode', 'powernode-child' ) ) ) {
	PowerNodeWT_Core();
}