<?php
/**
 * PowerNodeWT Plugins
 *
 * @package powernodewt
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class PowerNodeWT_Plugins_Setup {
	
	static $instance = null;
	protected $plugin_path = '';
	protected $plugin_url = '';
	
	private function __construct() {
		$this->plugin_path = trailingslashit( $this->cleanFilePath( dirname( __FILE__ ) ) );
		$relative_url      = str_replace( $this->cleanFilePath( get_template_directory() ), '', $this->plugin_path );
		$this->plugin_url  = trailingslashit( get_template_directory_uri() . $relative_url );
		$this->init_actions();
	}
	
	public function init_actions() {
		if ( current_user_can( 'manage_options' ) ) {
			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
			}
			add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
			add_action( 'wp_ajax_envato_setup_plugins', array( $this, 'ajax_plugins' ) );
		}
	}
	
	public static function cleanFilePath( $path ) {
		$path = str_replace( '', '', str_replace( array( '\\', '\\\\', '//' ), '/', $path ) );
		if ( $path[ strlen( $path ) - 1 ] === '/' ) {
			$path = rtrim( $path, '/' );
		}

		return $path;
	}
	
	public function admin_menu_page() {
		
		if ( !current_user_can( 'administrator' ) ) {
			return;
		}
		
		add_menu_page( 'PowerNode', 'administrator', 'powernode', array( $this, 'dashboard_page' ), 'dashicons-powernode-icon', 90 );
		
		//$this->post_types = apply_filters( 'powernode_main_metaboxes_post_types', array( 'post', 'page', 'product' ) );
		//$this->prefix = POWERNODEWT_PREFIX;

		//add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );
		
	}
	
	public function dashboard_page() {
		$this->header_page_section();
		require_once POWERNODEWT_ADMIN . '/dashboard/dashboard.php';
		$this->footer_page_section();
	}
	
	public function header_page_section() {
		require_once POWERNODEWT_ADMIN . '/dashboard/header.php';
	}
	
	public function footer_page_section() {
		require_once POWERNODEWT_ADMIN . '/dashboard/footer.php';
	}
	
	public function setup() {
		
		$this->post_types = apply_filters( 'powernode_main_metaboxes_post_types', array( 'post', 'page', 'product' ) );
		$this->prefix = POWERNODEWT_PREFIX;

		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );
		
	}
	
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

add_action( 'after_setup_theme', 'powernodewt_plugins_setup_wizard', 10 );
if ( ! function_exists( 'powernodewt_plugins_setup_wizard' ) ) :
	function powernodewt_plugins_setup_wizard() {
		PowerNodeWT_Plugins_Setup::get_instance();
	}
endif;