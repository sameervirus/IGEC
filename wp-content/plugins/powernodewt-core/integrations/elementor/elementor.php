<?php
namespace PowerNodeElementor;
use Elementor\Controls_Manager;

/**
 * Modules : PowerNode Elementor
 * Description : Add elementor elements and fields for powernode theme.
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PowerNode_Elementor' ) ) {
	
	final class PowerNode_Elementor {
		
		public function __construct () {
		
			$this->init();
			
			define( 'POWERNODE_ELEXTS_DIR', plugin_dir_path( __FILE__ ) );
			define( 'POWERNODE_ELEXTS_URL', plugin_dir_url( __FILE__ ) );
			define( 'POWERNODE_ELEXTS_FILE', __FILE__ );
			define( 'POWERNODE_ELEXTS_WIDGETS_DIR', POWERNODE_ELEXTS_DIR.'/widgets' );
			
			// Register categories
			add_action( 'elementor/elements/categories_registered', [ $this, 'categories_registered' ] );
			
			// Register controls
			add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
			
			// Register widgets
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
			
			// Add Styles/Scripts
			add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'before_enqueue_styles' ], 1000 );
			
		}
		
		/**
		 * Initialize the plugin
		 */
		public function init() {
			
			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}
		}
		
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'powernodewt-core' ),
				'<strong>' . esc_html__( 'Hub Elementor Addons', 'powernodewt-core' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'powernodewt-core' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}
		
		/**
		 * Categories Register
		 */
		public function categories_registered( $elements_manager ) {
			$elements_manager->add_category (
				'powernode-elements',
				[
				  'title' => esc_attr('PowerNode Elements', 'powernodewt-core'),
				  'icon' => 'fa fa-plug',
				]
			);
		}
		
		/**
		 * Register Controls
		 */
		public function register_controls() {
			$this->include_controls();
			$controls_manager = \Elementor\Plugin::$instance->controls_manager;
			$controls_manager->register_control(\PowerNodeElementor\IconSelector_Control::IconSelector, new \PowerNodeElementor\IconSelector_Control());
		}
		
		/**
		 * Register Widgets
		 */
		public function register_widgets() {
			$this->includes();
			$this->register_widget();
		}
		
		/**
		 * Add Controls
		 */
		private function include_controls() {
			require_once( __DIR__ . '/controls/iconSelector-control.php' );
		}
		
		/**
		 * Includes
		 */
		private function includes() {
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/heading.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/text.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/image.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/button.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/features-box.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/image-box.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/image-carousel.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/counter.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/blog.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/reviews-carousel.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/gallery.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/social-icons.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/icon-list.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/portfolio.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/segment.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/team-member.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/pricing.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/blockquote.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/posts.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/collage-box.php';
			require POWERNODE_ELEXTS_WIDGETS_DIR . '/countdown.php';
		}

		/**
		 * Register Widget
		 */
		private function register_widget() {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Heading() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Text() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Image() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Button() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\FeaturesBox() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ImageBox() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ImageCarousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Counter() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blog() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ReviewsCarousel() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Gallery() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SocialIcons() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\IconList() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Portfolio() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Segment() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\TeamMember() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blockquote() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Posts() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CollageBox() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Countdown() );
		}
		
		/**
		 * Before Qequeue Style
		 */
		public function before_enqueue_styles() {
			
			wp_register_style( 'flaticon-icons', POWERNODEWT_CSS_DIR_URI . 'fonts.css' );
			wp_enqueue_style( 'flaticon-icons' );
		}
	}
}
new PowerNode_Elementor();