<?php
/**
 * PowerNode functions and definitions
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) die();
	
/**
 * Define Constants
 */
define( 'POWERNODEWT_THEME_DIR', get_template_directory());
define( 'POWERNODEWT_THEME_URI', get_template_directory_uri());

class PowerNodeWT_Theme_Class {
	
	public function __construct() {
	
		// Define constants
		$this->define_constants();
		
		// Includes
		$this->includes();
		
		// Register sidebar
		add_action( 'widgets_init', array( $this, 'register_sidebars' ) );
		
		// Theme setup
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
		
		// Generate Custom CSS
		add_action( 'admin_bar_init', array( $this, 'save_customizer_css_in_file' ), 9999 );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_style' ), 10000 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		
		// Theme CSS
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_css' ), 10000 );
		
		// Head Custom CSS
		add_action( 'wp_head', array( $this, 'powernodewt_head_custom_css' ), 1 );
		
		// Footer Custom CSS
		add_action( 'wp_footer', array( $this, 'powernodewt_footer_custom_css' ), 10 );
		
		// Load his file in last
		add_action( 'wp_enqueue_scripts', array( $this, 'custom_style_css' ), 10000 );
		add_action( 'wp_enqueue_scripts', array( $this, 'theme_js' ), 30 );
			
		// Minify the WP custom CSS
		add_filter( 'wp_get_custom_css', array( $this, 'minify_custom_css' ) );

		add_filter( 'post_class', array( $this, 'post_class' ) );
		
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
		
		remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
	}
	
	/**
	 * Define Constants
	 */
	public static function define_constants() {

		$version = self::theme_version();

		// Theme version
		define( 'POWERNODEWT_VERSION', $version );
		
		// Include paths
		define( 'POWERNODEWT_INC_DIR_URI', POWERNODEWT_THEME_URI . '/inc/' );
		define( 'POWERNODEWT_INC_DIR', POWERNODEWT_THEME_DIR . '/inc/' );

		// Javascript and CSS Paths
		define( 'POWERNODEWT_JS_DIR_URI', POWERNODEWT_THEME_URI . '/assets/js/' );
		define( 'POWERNODEWT_IMAGES_DIR_URI', POWERNODEWT_THEME_URI . '/assets/images/' );
		define( 'POWERNODEWT_CSS_DIR_URI', POWERNODEWT_THEME_URI . '/assets/css/' );
		
		// Compatibility
		define( 'POWERNODEWT_WOOCOMMERCE_ACTIVE', false );
		
		// Other
		if ( !defined( 'POWERNODEWT_PREFIX' ) ) {
			define( 'POWERNODEWT_PREFIX', '_powernode_' );
		}
		
		// Admin
		if ( is_admin() ) {
			define( 'POWERNODEWT_ADMIN', POWERNODEWT_INC_DIR . 'admin/' );
		}
	}
	
	/**
	 * Includes
	 */
	public static function includes() {
	
		require_once POWERNODEWT_INC_DIR . 'helpers.php';
		require_once POWERNODEWT_INC_DIR . 'template-functions.php';
		require_once POWERNODEWT_INC_DIR . 'template-hooks.php';
		require_once POWERNODEWT_INC_DIR . 'walker/class-walker-nav-init.php';
		require_once POWERNODEWT_INC_DIR . 'walker/powernodewt_nav_walker.php';
		require_once POWERNODEWT_INC_DIR . 'customizer/customizer.php';
		require_once POWERNODEWT_INC_DIR . 'customizer/controls/typography/webfonts_functions.php';
		
		if ( is_admin() ) {
			require_once POWERNODEWT_ADMIN . 'admin.php';
			require_once POWERNODEWT_ADMIN . 'classes/class-dashboard.php';
			require_once POWERNODEWT_ADMIN . 'classes/class-import-export.php';
			require_once POWERNODEWT_ADMIN . 'classes/class-updater.php';
			require_once POWERNODEWT_INC_DIR . 'integrations/tgm/plugins-handler.php';
			require_once POWERNODEWT_INC_DIR . 'classes/class-meta-box.php';
		} else {
			require_once POWERNODEWT_INC_DIR . 'classes/breadcrumbs.php';
		}
	}
	
	/**
	 * Theme Defualt Settings
	 */
	public static function theme_setup() {
		
		// Loads wp-content/languages/themes/powernodewt-it_IT.mo.
		load_theme_textdomain( 'powernode', trailingslashit( WP_LANG_DIR ) . 'themes' );

		// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
		load_theme_textdomain( 'powernode', get_stylesheet_directory() . '/languages' );

		// Loads wp-content/themes/powernodewt/languages/it_IT.mo.
		load_theme_textdomain( 'powernode', get_template_directory() . '/languages' );		
		
		/* Theme support */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio', 'quote', 'link' ) );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'wp-block-styles' );
		add_editor_style( 'style-editor.css' );
		
		/**
		 * Register menu locations.
		 */
		register_nav_menus( apply_filters( 'powernode_register_nav_menus', array(
			'topbar-menu' => __( 'Top Bar', 'powernode' ),
			'primary' => __( 'Main Menu', 'powernode' ),
			'one-page-menu' => __( 'One Page Menu', 'powernode' ),
			'mobile-menu' => __( 'Mobile Menu', 'powernode' ),
		) ) );
		
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
		
		// Set the default content width.
		$GLOBALS['content_width'] = 1140;
	}
	
	/**
	 * Load Admin css
	 */
	public static function admin_style( $hook ) {
		
		global $pagenow;

		// Theme Version
		$theme_version = POWERNODEWT_VERSION;
		
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_style( 'powernode-admin-style', POWERNODEWT_INC_DIR_URI . 'admin/assets/css/admin.css', array(), $theme_version);
		wp_enqueue_style( 'magnific-popup', POWERNODEWT_CSS_DIR_URI . 'magnific-popup.css', false, '1.0.0' );
		
		if ( in_array ( $pagenow, array('nav-menus.php') ) ) {
			wp_enqueue_style( 'font-awesome-css', POWERNODEWT_CSS_DIR_URI . 'font-awesome.min.css', false, '4.7.0');
			wp_enqueue_style( 'fonts-style', POWERNODEWT_CSS_DIR_URI . 'fonts-style.css', false, $theme_version );
		}
		
	}
	
	/**
	 * Load Admin js scripts
	 */
	public static function admin_scripts( $hook ) {
		
		global $pagenow;
		
		// Theme Version
		$theme_version = POWERNODEWT_VERSION;
		
		$localize_array = array(
			'ajxUrl'                => admin_url( 'admin-ajax.php' ),
			'wpnonce' 				=> wp_create_nonce( 'pnwt_admin_nonce' ),
			'customizerURL'	 		=> admin_url( 'customize.php' ),
			'exportNonce'	        => wp_create_nonce( 'wt-cie-exporting' ),
			'select_plugins'        => __( 'Please select Plugins you want to install', 'powernode' ),
			'emptyImport'		 	=> __( 'Please choose a file to import.', 'powernode' )
		);
		
		wp_enqueue_media(); 
		wp_enqueue_script( 'wp-color-picker' );
		
		wp_enqueue_script( 'powernode-admin', POWERNODEWT_INC_DIR_URI . 'admin/assets/js/admin.js', array( 'common', 'jquery', 'media-upload', 'thickbox', 'wp-color-picker' ), $theme_version, true );
		wp_enqueue_script( 'magnific-popup', POWERNODEWT_JS_DIR_URI . 'jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );
		wp_localize_script( 'powernode-admin', 'paWT', $localize_array );
		
		if ( in_array ( $pagenow, array('nav-menus.php') ) ) {
			wp_enqueue_script( 'powernode-admin-nav-menus', POWERNODEWT_INC_DIR_URI . 'admin/assets/js/nav-menus.js' );
			wp_localize_script(
				'powernode-admin-nav-menus', 'menuImage', array(
					'l10n'     => array(
						'uploaderTitle'      => __( 'Chose menu image', 'powernode' ),
						'uploaderButtonText' => __( 'Select', 'powernode' ),
					),
					'settings' => array(
						'nonce' => wp_create_nonce( 'update-menu-item' ),
					),
				)
			);
		} else if ( in_array ( $pagenow, array('widgets.php') ) ) {
			wp_enqueue_script( 'powernode-admin-widgets', POWERNODEWT_INC_DIR_URI . 'admin/assets/js/widgets.js', array( 'media-upload', 'wp-color-picker' ), $theme_version, true );
		}
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	
	/**
	 * Load css scripts
	 */
	public static function theme_css() {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.css' : '.min.css';

		// Theme Version
		$theme_version = POWERNODEWT_VERSION;
		
		wp_deregister_style( 'dokan-fontawesome' );
		wp_dequeue_style( 'dokan-fontawesome' );

		wp_deregister_style( 'font-awesome' );
		wp_dequeue_style( 'font-awesome' );

		wp_enqueue_style( 'bootstrap', POWERNODEWT_CSS_DIR_URI . 'bootstrap.min.css', false, '4.6.0' );
		wp_enqueue_style( 'fonts-css', POWERNODEWT_CSS_DIR_URI . 'fonts.css', false, $theme_version );
		wp_enqueue_style( 'powernode-menu', POWERNODEWT_CSS_DIR_URI . 'menu.css', false, $theme_version );
		wp_enqueue_style( 'fadedown-css', POWERNODEWT_CSS_DIR_URI . 'dropdown-effects/fade-down.css', false, $theme_version );
		wp_enqueue_style( 'magnific-popup', POWERNODEWT_CSS_DIR_URI . 'magnific-popup.css', false, $theme_version );
		wp_enqueue_style( 'owl-carousel', POWERNODEWT_CSS_DIR_URI . 'owl.carousel.min.css', false, '2.2.1' );
		wp_enqueue_style( 'slick', POWERNODEWT_CSS_DIR_URI . 'slick.css', false );
		wp_enqueue_style( 'e-animations', POWERNODEWT_CSS_DIR_URI . 'animations.min.css', false, '6.0.0' );
		wp_enqueue_style( 'theme', POWERNODEWT_CSS_DIR_URI . 'theme' . $suffix, false, $theme_version );
		wp_enqueue_style( 'theme-core', POWERNODEWT_CSS_DIR_URI . 'theme-core.css', false, $theme_version );
		wp_enqueue_style( 'responsive', POWERNODEWT_CSS_DIR_URI . 'responsive.css', false, $theme_version );
		
		wp_register_style( 'powernode-head-css', false );
		
		function dequeue_elementor_global__css() {
			wp_dequeue_style('elementor-global');
			wp_deregister_style('elementor-global');
		}
		add_action('wp_print_styles', 'dequeue_elementor_global__css', 9999);
		
	}
	
	/**
	 * Head Custom css
	 */
	public static function powernodewt_head_custom_css( $output = NULL ) {
	
		$output = apply_filters( 'powernode_head_css', $output );
		$head_css_output = false;
		if ( get_theme_mod( 'powernode_customzer_styling', 'head' ) == 'file' ) {
			
			global $wp_customize;
			$upload_dir = wp_upload_dir();
			
			// Render CSS in the head
			if ( ( isset( $wp_customize ) || file_exists( $upload_dir['basedir'] . '/powernodewt/custom-style.css' ) ) ) {
				$head_css_output = true;
			}
		} else {
			$head_css_output = true;
		}
		
		if ( $head_css_output == true && !empty( $output ) ) {
			
			// Output CSS in the wp_head
			wp_enqueue_style( 'powernode-head-css' );
			wp_add_inline_style( 'powernode-head-css', wp_strip_all_tags( powernodewt_minify_css( $output ) ) );
			

		}
	}
	
	/**
	 * Footer Custom CSS
	 */
	public function powernodewt_footer_custom_css( $output = NULL ) {
		
		$output = apply_filters( 'powernode_footer_css', $output );
		
		if ( !empty( $output ) ) {

			// Output CSS in the wp_footer
			wp_register_style( 'powernode-footer-css', false );
			wp_enqueue_style( 'powernode-footer-css' );
			wp_add_inline_style( 'powernode-footer-css', wp_strip_all_tags( powernodewt_minify_css( $output ) ) );
			
		}
	}
	
	/**
	 * Load js scripts
	 */
	public static function theme_js() {
		
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js';
		
		// Theme Version
		$theme_version = POWERNODEWT_VERSION;
		
		// Localized array
		$localize_array = self::localize_array();
		wp_enqueue_script( 'bootstrap', POWERNODEWT_JS_DIR_URI . 'bootstrap.min.js', array( 'jquery' ), $theme_version, true, '4.6.0' );
		wp_enqueue_script( 'modernizr', POWERNODEWT_JS_DIR_URI . 'modernizr.custom.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'jquery-easing', POWERNODEWT_JS_DIR_URI . 'jquery.easing.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'jquery-appear', POWERNODEWT_JS_DIR_URI . 'jquery.appear.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'slick', POWERNODEWT_JS_DIR_URI . 'slick.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'isotope', POWERNODEWT_JS_DIR_URI . 'isotope.pkgd.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'owl-carousel', POWERNODEWT_JS_DIR_URI . 'owl.carousel.min.js', array( 'jquery' ), '2.2.1', true );
		wp_enqueue_script( 'countdown', POWERNODEWT_JS_DIR_URI . 'jquery.countdown.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'magnific-popup', POWERNODEWT_JS_DIR_URI . 'jquery.magnific-popup.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'wow', POWERNODEWT_JS_DIR_URI . 'wow.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'template-app', POWERNODEWT_JS_DIR_URI . 'template-app' . $suffix, array( 'jquery' ), $theme_version, true, '1.0.0' );
		wp_localize_script( 'template-app', 'pnWT', $localize_array );
		
		$style = powernodewt_blog_loop_post_pagination_style();
		if ( in_array( $style, array( 'infinite-scroll', 'load-more' ) ) ) {
			wp_enqueue_script( 'infinite-scroll', POWERNODEWT_JS_DIR_URI . 'third/' . 'infinite-scroll.pkgd.min.js', array( 'jquery' ) );
		}		
	}
	
	/**
	 * Localize array
	 */
	public static function localize_array() {

		$array = array(
			'isRTL'                 => is_rtl(),
			'ajxUrl'                => admin_url( 'admin-ajax.php' ),
		);

		return apply_filters( 'powernode_theme_js_localize', $array );
	}
	
	/**
	 * Remove Customizer style script from front-end
	 */
	public static function remove_customizer_custom_css() {

		// If Custom File is not selected
		if ( get_theme_mod( 'powernode_customzer_styling', 'head' ) != 'file'  ) {
			return;
		}
		
		global $wp_customize;

		// Disable Custom CSS in the frontend head
		remove_action( 'wp_head', 'wp_custom_css_cb', 11 );
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

		// If custom CSS file exists and NOT in customizer screen
		if ( isset( $wp_customize ) ) {
			add_action( 'wp_footer', 'wp_custom_css_cb', 9999 );
		}
	}
	
	/**
	 * Minify Custom CSS
	 */
	public static function minify_custom_css( $css ) {

		return powernodewt_minify_css( $css );

	}
	
	/**
	 * Save Customizer CSS in a file
	 */
	public static function save_customizer_css_in_file( $output = NULL ) {

		// If Custom File is not selected
		if ( get_theme_mod( 'powernode_customzer_styling', 'head' ) != 'file'  ) {
			return;
		}

		// Get all the customier css
	    $output = apply_filters( 'powernode_head_css', $output );

	    // Get Custom Panel CSS
	    $output_custom_css = wp_get_custom_css();

	    // Minified the Custom CSS
		$output .= powernodewt_minify_css( $output_custom_css );
			
		// We will probably need to load this file
		require_once( ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php' );
		
		global $wp_filesystem;
		$upload_dir = wp_upload_dir(); // Grab uploads folder array
		$dir = trailingslashit( $upload_dir['basedir'] ) . 'powernode'. DIRECTORY_SEPARATOR; // Set storage directory path
		
		WP_Filesystem(); // Initial WP file system
		if( !is_dir( $dir ) ) {
			wp_mkdir_p( $dir ); // Make a new folder 'powernodewt' for storing our file if not created already.
		}
		$wp_filesystem->put_contents( $dir . 'custom-style.css', $output, 0644 ); // Store in the file.

	}
	
	/**
	 * Include Custom CSS file if present.
	 */
	public static function custom_style_css( $output = NULL ) {

		// If Custom File is not selected
		if ( get_theme_mod( 'powernode_customzer_styling', 'head' ) != 'file' ) {
			return;
		}

		global $wp_customize;
		$upload_dir = wp_upload_dir();

		// Get all the customier css
	    $output = apply_filters( 'powernode_head_css', $output );

	    // Get Custom Panel CSS
	    $output_custom_css = wp_get_custom_css();

	    // Minified the Custom CSS
		$output .= powernodewt_minify_css( $output_custom_css );

		// Render CSS from the custom file
		if ( ! isset( $wp_customize ) && file_exists( $upload_dir['basedir'] . '/powernode/custom-style.css' ) && !empty( $output ) ) { 
		    wp_enqueue_style( 'powernode-custom', trailingslashit( $upload_dir['baseurl'] ) . 'powernode/custom-style.css', false, null );	    			
		}		
	}
	
	/**
	 * Registers sidebars
	 */
	public static function register_sidebars() {
		
		// Default Sidebar
		register_sidebar( array(
			'name'          => __( 'Default Sidebar', 'powernode' ),
			'id'            => 'sidebar-1',
			'description'   => 'Default Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
			'before_widget' => '<div id="%1$s" class="widget sidebar-widget sidebar-div mb-30 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>'
		) );
		
		// Single Post Sidebar
		register_sidebar( array(
			'name'          => __( 'Single Post Sidebar', 'powernode' ),
			'id'            => 'single-post-sidebar',
			'description'   => 'Single Post Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
			'before_widget' => '<div id="%1$s" class="widget sidebar-widget sidebar-div mb-30 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>'
		) );
		
		// Blog Sidebar
		register_sidebar( array(
			'name'          => __( 'Blog Sidebar', 'powernode' ),
			'id'            => 'blog-sidebar',
			'description'   => 'Blog Sidebar Widget Area will be displayed left or right sidebar if you choose left or right sidebar.',
			'before_widget' => '<div id="%1$s" class="widget sidebar-widget sidebar-div mb-30 %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h6 class="widget-title">',
			'after_title'   => '</h6>'
		) );
	}
	
	/**
	 * Get current theme version
	 */
	public static function theme_version() {

		$theme = wp_get_theme();
		return $theme->get('Version');

	}

	/**
	 * Post Calsses
	 */
	public static function post_class( $classes ) {

		// Get post
		global $post;

		// Add entry class
		$classes[] = 'entry';

		return $classes;

	}
	
	/**
	 * Modify query, limit to one post.
	 *
	 * @param \WP_Query $query The WP_Query instance.
	 */
	public function pre_get_posts( $query ) {

		

		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}
		
		if( in_array( $query->get('post_type'), array( 'portfolio' ) ) ) {
			$query->set( 'posts_per_page', apply_filters( 'powernode_portfolio_loop_post_per_page', absint( get_theme_mod( 'powernode_portfolio_loop_post_per_page', '6' ) ) ) );
		} else if( in_array( $query->get('post_type'), array( 'segment' ) ) ) {
			$query->set( 'posts_per_page', apply_filters( 'powernode_segment_loop_post_per_page', absint( get_theme_mod( 'powernode_segment_loop_post_per_page', '6' ) ) ) );
		}
	}
}
new PowerNodeWT_Theme_Class;