<?php
/**
 * PowerNodeWT Meta Box
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PowerNodeWT_MetaBox' ) ) :

	class PowerNodeWT_MetaBox {
		
		public $post_types;
		public $prefix;
		protected $active = false;
		protected $fields_output = array();
		
		public function setup() {
			
			$this->post_types = apply_filters( 'powernode_main_metaboxes_post_types', array( 'post', 'portfolio', 'page', 'product' ) );
			$this->prefix = POWERNODEWT_PREFIX;

			add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 30 );
			
			add_action( 'rwmb_before', array( $this, 'powernodewt_start_div' ), 1 );
			add_action( 'rwmb_after', array( $this, 'powernodewt_tab_nav' ), 20 );
			add_action( 'rwmb_after', array( $this, 'powernodewt_tab_content' ), 30 );
			add_action( 'rwmb_after', array( $this, 'powernodewt_end_div' ), 101 );
			
			add_filter( 'rwmb_outer_html', array( $this, 'powernodewt_tab_fields' ), 10, 2 );
		}
		
		function powernodewt_meta_boxes() {
			
			$meta_boxes = array();
			
			$layouts = array( 'default' => esc_html__( 'Default', 'powernode' ), 'hidden' => esc_html__( 'Hidden', 'powernode' ) ) + powernodewt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_powernode_layout_page_layout', 'meta_value'   => 'footer', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
			
			// Post format's meta box
			$meta_boxes[] = array(
				'id'      		=> $this->prefix.'pnwt_options',
				'title'    		=> esc_html__( 'PowerNode Options', 'powernode' ),
				'tabs'      	=> array(
									'general'			=> 'General',
									'header'			=> 'Header',
									'page_title'		=> 'Page Title',
									'footer'			=> 'Footer',
								),
				'tab_style' => 'left',
				'tab_wrapper' 	=> true,
				'pages'			=> $this->post_types,
				'context'  		=> 'normal',
				'priority' 		=> 'high',
				'autosave' 		=> true,
				'fields'   		=> array(
					array(
						'type' 			=> 'heading',
						'tab'			=> 'general',
						'name' 			=> 'General Settings',
					),
					array(
						'name'    		=> esc_html__( 'Page Layout', 'powernode' ),
						'id'      		=> $this->prefix.'page_layout',
						'type'    		=> 'select_advanced',
						'std'			=> 'default',
						'options' 		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											'full-width' 	=> esc_html__( 'Full Width', 'powernode' ),
											'left-sidebar' 	=> esc_html__( 'Left Sidebar', 'powernode' ),
											'right-sidebar' => esc_html__( 'Right Sidebar', 'powernode' ),
										),
						'tab'			=> 'general',
					),
					array(
						'name'    		=> esc_html__( 'Sidebar', 'powernode' ),
						'id'      		=> $this->prefix.'sidebar',
						'type'    		=> 'sidebar',
						'std'			=> '',
						'field_type'	=> 'select_advanced',
						'placeholder'	=> 'Default',
						'tab'			=> 'general',
					),
					array(
						'name'			=> esc_html__( 'Page Extra Classes', 'powernode' ),
						'id'      		=> $this->prefix.'page_el_classes',
						'type'    		=> 'text',
						'std'    		=> '',
						'desc'   		=> esc_html__( 'Add a class names and refer to it in custom CSS.', 'powernode' ),
						'tab'			=> 'general',
					),
					// Header
					array(
						'type' 			=> 'heading',
						'tab'			=> 'header',
						'name' 			=> 'Header Settings',
					),
					array(
						'name'			=> esc_html__( 'Display Top Bar', 'powernode' ),
						'id'      		=> $this->prefix.'topbar',
						'type'    		=> 'button_group',
						'std'    		=> 'default',
						'options' 		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											true 			=> esc_html__( 'Enable', 'powernode' ),
											false 			=> esc_html__( 'Disable', 'powernode' ),
										),
						'tab'			=> 'header',
					),
					array(
						'name'			=> esc_html__( 'Header Style', 'powernode' ),
						'id'			=> $this->prefix.'header_style',
						'type'			=> 'select_advanced',
						'std'			=> 'default',
						'options'		=> array_merge( array( 'default' => esc_html__( 'Default', 'powernode' ) ), powernodewt_header_style_list() ),
						'placeholder'	=> 'Default',
						'tab'			=> 'header',
					),
					// Page Title
					array(
						'type' 			=> 'heading',
						'tab'			=> 'page_title',
						'name' 			=> 'Page Title Settings',
					),
					array(
						'name'			=> esc_html__( 'Display Page Title Section', 'powernode' ),
						'id'      		=> $this->prefix.'page_title_section',
						'type'    		=> 'button_group',
						'tab'			=> 'page_title',
						'std'    		=> 'default',
						'options' 		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											true 			=> esc_html__( 'Enable', 'powernode' ),
											false 			=> esc_html__( 'Disable', 'powernode' ),
										),
					),
					array(
						'name'			=> esc_html__( 'Display Page Title Heading', 'powernode' ),
						'id'      		=> $this->prefix.'page_title_title',
						'type'    		=> 'button_group',
						'tab'			=> 'page_title',
						'std'    		=> 'default',
						'options' 		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											true 			=> esc_html__( 'Enable', 'powernode' ),
											false 			=> esc_html__( 'Disable', 'powernode' ),
										),
					),
					array(
						'name'			=> esc_html__( 'Page Title Text', 'powernode' ),
						'id'			=> $this->prefix.'page_title_text',
						'type'			=> 'select_advanced',
						'tab'			=> 'page_title',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											'post_title' 	=> esc_html__( 'Post Title', 'powernode' ),
											'custom' 		=> esc_html__( 'Custom', 'powernode' ),
										),
					),
					array(
						'name'			=> esc_html__( 'Page Title Custom Text', 'powernode' ),
						'id'      		=> $this->prefix.'page_title_custom_text',
						'type'    		=> 'text',
						'tab'			=> 'page_title',
						'std'    		=> '',
						'desc'   		 => esc_html__( 'You can add custom page title and leave blank for the default value.', 'powernode' ),
					),
					array(
						'name'			=> esc_html__( 'Page Title Style', 'powernode' ),
						'id'			=> $this->prefix.'page_title_style',
						'type'			=> 'select_advanced',
						'tab'			=> 'page_title',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											'left' 			=> esc_html__( 'Left Alignment', 'powernode' ),
											'centered' 		=> esc_html__( 'Center Alignment', 'powernode' ),
											'right' 		=> esc_html__( 'Right Alignment', 'powernode' ),
										),
					),
					array(
						'type' 			=> 'heading',
						'tab'			=> 'page_title',
						'name' 			=> 'Page Title Section Background',
					),
					array(
						'name'			=> esc_html__( 'Display Background', 'powernode' ),
						'id'      		=> $this->prefix.'page_title_background',
						'type'    		=> 'button_group',
						'tab'			=> 'page_title',
						'std'    		=> 'default',
						'options' 		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											true 			=> esc_html__( 'Enable', 'powernode' ),
											false 			=> esc_html__( 'Disable', 'powernode' ),
										),
					),
					array(
						'name'				=> esc_html__( 'Background Image', 'powernode' ),
						'id'      			=> $this->prefix.'page_title_bg_image',
						'type'    			=> 'image_advanced',
						'tab'			=> 'page_title',
						'max_file_uploads' 	=> 1,
						'max_status'       	=> false,
						'std'    			=> 'default',
					),
					array(
						'name'			=> esc_html__( 'Background Position', 'powernode' ),
						'id'			=> $this->prefix.'page_title_bg_position',
						'type'			=> 'select_advanced',
						'tab'			=> 'page_title',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											'initial' 		=> esc_html__( 'Initial', 'powernode' ),
											'top left' 		=> esc_html__( 'Top Left', 'powernode' ),
											'top center' 	=> esc_html__( 'Top Center', 'powernode' ),
											'top right' 	=> esc_html__( 'Top Right', 'powernode' ),
											'center left' 	=> esc_html__( 'Center Left', 'powernode' ),
											'center center' => esc_html__( 'Center Center', 'powernode' ),
											'center right' 	=> esc_html__( 'Center Right', 'powernode' ),
											'bottom left' 	=> esc_html__( 'Bottom Left', 'powernode' ),
											'bottom center' => esc_html__( 'Bottom Center', 'powernode' ),
											'bottom right' 	=> esc_html__( 'Bottom Right', 'powernode' ),
										),
					),
					array(
						'name'			=> esc_html__( 'Background Attachment', 'powernode' ),
						'id'			=> $this->prefix.'page_title_bg_attachment',
						'type'			=> 'select_advanced',
						'tab'			=> 'page_title',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											'initial' 		=> esc_html__( 'Initial', 'powernode' ),
											'Fixed' 		=> esc_html__( 'fixed', 'powernode' ),
											'Scroll' 		=> esc_html__( 'scroll', 'powernode' ),
										),
					),
					array(
						'name'			=> esc_html__( 'Background Repeat', 'powernode' ),
						'id'			=> $this->prefix.'page_title_bg_repeat',
						'type'			=> 'select_advanced',
						'tab'			=> 'page_title',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											'initial' 		=> esc_html__( 'Initial', 'powernode' ),
											'no-repeat' 	=> esc_html__( 'No-repeat', 'powernode' ),
											'repeat' 		=> esc_html__( 'Repeat', 'powernode' ),
											'repeat-x' 		=> esc_html__( 'Repeat-x', 'powernode' ),
											'repeat-y' 		=> esc_html__( 'Repeat-y', 'powernode' ),
										),
					),
					array(
						'name'			=> esc_html__( 'Background Size', 'powernode' ),
						'id'			=> $this->prefix.'page_title_bg_size',
						'type'			=> 'select_advanced',
						'tab'			=> 'page_title',
						'std'			=> 'default',
						'options'		=> array(
											'default' 		=> esc_html__( 'Default', 'powernode' ),
											'initial' 		=> esc_html__( 'Initial', 'powernode' ),
											'auto' 			=> __( 'Auto', 'powernode' ),
											'contain' 		=> __( 'Contain', 'powernode' ),
											'cover' 		=> __( 'Cover', 'powernode' ),
											'unset' 		=> __( 'Unset', 'powernode' ),
										),
					),
					array(
						'name'			=> esc_html__( 'Background Overlay Opacity', 'powernode' ),
						'desc'			=> esc_html__( 'Set -1 to the default options.', 'powernode' ),
						'id'			=> $this->prefix.'page_title_bg_overlay_opacity',
						'type'			=> 'slider',
						'tab'			=> 'page_title',
						'std'			=> '',
						'js_options' 	=> array(
											'min'   => -1,
											'max'   => 1,
											'step'  => 0.1,
										),
					),
					array(
						'name'			=> esc_html__( 'Overlay Background Color', 'powernode' ),
						'id'			=> $this->prefix.'page_title_overlay_bg_color',
						'type'			=> 'color',
						'tab'			=> 'page_title',
						'alpha_channel' => true,
					),
					array(
						'type' 			=> 'heading',
						'tab'			=> 'page_title',
						'name' 			=> 'Page Title Section Style',
					),
					array(
						'name'			=> esc_html__( 'Page Title Font Size', 'powernode' ),
						'id'      		=> $this->prefix.'page_title_font_size',
						'type'    		=> 'text',
						'tab'			=> 'page_title',
						'std'    		=> '',
						'desc'   		 => esc_html__( 'You can add size in (px,em,%) and leave blank for the default value.', 'powernode' ),
					),
					array(
						'name'			=> esc_html__( 'Header Background Color', 'powernode' ),
						'id'			=> $this->prefix.'page_title_bg_color',
						'type'			=> 'color',
						'tab'			=> 'page_title',
						'alpha_channel' => true,
					),
					array(
						'name'			=> esc_html__( 'Header Text Color', 'powernode' ),
						'id'			=> $this->prefix.'page_title_text_color',
						'type'			=> 'color',
						'tab'			=> 'page_title',
						'alpha_channel' => true,
					),
					array(
						'name'			=> esc_html__( 'Header Separator Color', 'powernode' ),
						'id'			=> $this->prefix.'page_title_separator_color',
						'type'			=> 'color',
						'tab'			=> 'page_title',
						'alpha_channel' => true,
					),
					array(
						'name'			=> esc_html__( 'Header Link Color', 'powernode' ),
						'id'			=> $this->prefix.'page_title_link_color',
						'type'			=> 'color',
						'tab'			=> 'page_title',
						'alpha_channel' => true,
					),
					array(
						'name'			=> esc_html__( 'Header Link Hover Color', 'powernode' ),
						'id'			=> $this->prefix.'page_title_link_hover_color',
						'type'			=> 'color',
						'tab'			=> 'page_title',
						'alpha_channel' => true,
					),
					array(
						'type' 			=> 'divider',
						'tab'			=> 'page_title',
					),
					// Footer
					array(
						'type' 			=> 'heading',
						'tab'			=> 'footer',
						'name' 			=> 'Footer',
					),
					array(
						'name'			=> esc_html__( 'Footer Layout', 'powernode' ),
						'id'			=> $this->prefix.'footer_layout',
						'type'			=> 'select_advanced',
						'tab'			=> 'footer',
						'std'			=> 'default',
						'options'		=> $layouts,
						'desc'   		=> esc_html__( 'Select custom footer from Layouts Builder. Default : default', 'powernode' ),
					),
				),
			);

			return apply_filters( 'powernode_meta_boxes_content', $meta_boxes );
		}
		
		function register_meta_boxes ( $meta_boxes ) {
			$powernodewt_meta_boxes = $this->powernodewt_meta_boxes();
			if ( !empty( $powernodewt_meta_boxes ) ) {
				$meta_boxes = array_merge( $meta_boxes, $powernodewt_meta_boxes );
			}
			return $meta_boxes;
		}
		
		/**
		 * Load scripts and styles
		 */
		public function enqueue_scripts( $hook ) {
			
			$powernodewt_meta_boxes = $this->powernodewt_meta_boxes();
			$metabox_tab_ids = array();
			if ( !empty( $powernodewt_meta_boxes ) ) {
				foreach( $powernodewt_meta_boxes as $mk => $mv ) {
					$metabox_tab_ids[] = $mv['id'];
				}
			}

			// Only needed on these admin screens
			if ( $hook != 'post.php' && $hook != 'post-new.php' ) {
				return;
			}

			// Get global post
			global $post;

			// Return if post is not object
			if ( ! is_object( $post ) ) {
				return;
			}

			$post_types_scripts = apply_filters( 'powernode_metaboxes_post_types_scripts', $this->post_types );

			if ( ! in_array( $post->post_type, $post_types_scripts ) ) {
				return;
			}
			
			wp_enqueue_script( 'pnwt-metabox-tabs', POWERNODEWT_INC_DIR_URI . 'admin/assets/js/metabox-tabs.js', array( 'jquery' ) );
			wp_enqueue_style( 'pnwt-metabox-tabs', POWERNODEWT_INC_DIR_URI . 'admin/assets/css/metabox-tabs.css', false );
		}
		
		/**
		 * Display srart div for tabs for meta box.
		 */
		public function powernodewt_start_div( RW_Meta_Box $obj ) {
			
			$meta_box = $obj->meta_box;
			
			if ( empty( $meta_box['tabs'] ) ) {
				return;
			}

			$class = 'mb-tabs';
			if ( isset( $meta_box['tab_style'] ) && 'default' !== $meta_box['tab_style'] ) {
				$class .= ' mb-tabs-' . $meta_box['tab_style'];
			}

			if ( isset( $meta_box['tab_wrapper'] ) && false === $obj->meta_box['tab_wrapper'] ) {
				$class .= ' mb-tabs-no-wrapper';
			}

			echo '<div class="' . esc_attr( $class ) . '">';

			$this->active = true;
		}
		
		/**
		 * Display end div for tabs for meta box.
		 */
		public function powernodewt_end_div() {
			if ( ! $this->active ) {
				return;
			}

			echo '</div>';

			$this->active        = false;
			$this->fields_output = array();
		}
		
		/**
		 * Display tab navigation.
		 */
		public function powernodewt_tab_nav( RW_Meta_Box $obj ) {
			if ( ! $this->active ) {
				return;
			}

			$tabs           = $obj->meta_box['tabs'];
			$default_active = $obj->tab_default_active;

			echo '<ul class="mb-tab-nav">';

			$i = 0;
			foreach ( $tabs as $key => $tab_data ) {
				if ( is_string( $tab_data ) ) {
					$tab_data = ['label' => $tab_data];
				}
				$tab_data = wp_parse_args( $tab_data, [
					'icon'  => '',
					'label' => '',
				] );

				if ( filter_var( $tab_data['icon'], FILTER_VALIDATE_URL ) ) { // If icon is an URL.
					$icon = '<img src="' . esc_url( $tab_data['icon'] ) . '">';
				} else { // If icon is icon font.
					// If icon is dashicons, auto add class 'dashicons' for users.
					if ( false !== strpos( $tab_data['icon'], 'dashicons' ) ) {
						$tab_data['icon'] .= ' dashicons';
					}
					// Remove duplicate classes.
					$tab_data['icon'] = array_filter( array_map( 'trim', explode( ' ', $tab_data['icon'] ) ) );
					$tab_data['icon'] = implode( ' ', array_unique( $tab_data['icon'] ) );

					$icon = $tab_data['icon'] ? '<i class="' . esc_attr( $tab_data['icon'] ) . '"></i>' : '';
				}

				$class = "mb-tab-$key";
				if ( ( $default_active && $default_active === $key ) || ( ! $default_active && ! $i ) ) {
					$class .= ' mb-tab-active';
				}

				printf(
					'<li class="%s" data-panel="%s"><a href="#">%s%s</a></li>',
					esc_attr( $class ),
					esc_attr( $key ),
					$icon,
					esc_html( $tab_data['label'] )
				);
				$i ++;
			}

			echo '</ul>';
		}

		/**
		 * Display tab content.
		 */
		public function powernodewt_tab_content( RW_Meta_Box $obj ) {
			if ( ! $this->active ) {
				return;
			}

			// Store all tabs.
			$tabs = $obj->meta_box['tabs'];

			echo '<div class="mb-tab-panels">';
			foreach ( $this->fields_output as $tab => $fields ) {
				// Remove rendered tab.
				if ( isset( $tabs[ $tab ] ) ) {
					unset( $tabs[ $tab ] );
				}

				echo '<div class="mb-tab-panel mb-tab-panel-' . esc_attr( $tab ) . '" data-panel="' . esc_attr( $tab ) . '">';
				echo implode( '', $fields );
				echo '</div>';
			}

			// Print unrendered tabs.
			foreach ( $tabs as $tab_id => $tab_data ) {
				echo '<div class="mb-tab-panel mb-tab-panel-' . esc_attr( $tab_id ) . '">';
				echo '</div>';
			}

			echo '</div>';
		}
		
		/**
		 * Save field output into class variable to output later.
		 */
		public function powernodewt_tab_fields( $output, $field ) {

			if ( ! $this->active || ! isset( $field['tab'] ) ) {
				return $output;
			}

			$tab = $field['tab'];

			if ( ! isset( $this->fields_output[ $tab ] ) ) {
				$this->fields_output[ $tab ] = array();
			}
			$this->fields_output[ $tab ][] = $output;

			return '';
		}
		
		public static function get_instance() {
			static $instance = null;
			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup();
			}
			return $instance;
		}
		
		private function __construct() {}		
	}

endif;

return PowerNodeWT_MetaBox::get_instance();
