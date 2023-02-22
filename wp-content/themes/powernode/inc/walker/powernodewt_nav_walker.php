<?php
/**
 * PowerNodeWT Navigation Walker
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'PowerNodeWT_Nav_Walker' ) ) :

	class PowerNodeWT_Nav_Walker extends Walker_Nav_Menu {

		protected $menu_type;
		protected $megamenu_layout;
		protected $megamenu_width;
		protected $megamenu_height;
		protected $megamenu_columns;
		protected $megamenu_custom_layout;
		
		public function __construct() {
						
			// add the column classes
			add_filter("wp_nav_menu_args", function($args) {
				if ( $args["walker"] instanceof megaMenuWalker ) {
				}
				return $args;
			});

			// stop the column classes function
			add_filter('wp_nav_menu', function( $nav_menu ) {
				return $nav_menu;
			});
		
		}
		
		/**
		 * Starts the list before the elements are added.
		 *
		 * @since 3.0.0
		 *
		 * @see Walker::start_lvl()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = str_repeat( $t, $depth );
	 
			// Default class.
			$classes = array();
			$classes[] = 'sub-menu pnwt-dropdown link-list';
			$classes[] = 'lvl-'.($depth+1);
			
			if ( $depth > 2 ) {
				$classes[] = 'to-right';
			}
	 
			/**
			 * Filters the CSS class(es) applied to a menu list element.
			 *
			 * @since 4.8.0
			 *
			 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
			 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$class_names = implode( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			
			/** Custom Layout **/
			if ( $depth == 0 && in_array( $this->menu_type, array( 'megamenu-columns' ) ) ) {
				
				$atts = array();
				if ( $this->megamenu_layout == 'full-width' ) {
					$atts['style'][] = 'width:100%;';
				} else {
					$atts['style'][] = ( $this->megamenu_width ) ? 'width:' . $this->megamenu_width . 'px;' : '';
					$atts['style'][] = ( $this->megamenu_height ) ? 'min-height:' . $this->megamenu_height . 'px;' : '';
				}
				
				$output .= "{$n}{$indent}<div class='pnwt-megamenu pnwt-dropdown wsmegamenu clearfix'>{$n}";
				$output .= "{$n}{$indent}<div class='pnwt-megamenu-inside' ". powernodewt_stringify_atts( $atts ) .">{$n}";
				$output .= "{$n}{$indent}<ul$class_names>{$n}";
				
			} else {
				$output .= "{$n}{$indent}<ul$class_names>{$n}";
			}
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @since 3.0.0
		 *
		 * @see Walker::end_lvl()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 */
		public function end_lvl( &$output, $depth = 0, $args = null ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent  = str_repeat( $t, $depth );
			
			/** Custom Layout **/
			if ( $depth == 0 && in_array( $this->menu_type, array( 'megamenu-columns' ) ) ) {
				$output .= "$indent</ul>{$n}";
				$output .= "$indent</div>{$n}";
				$output .= "$indent</div>{$n}";
			} else {
				$output .= "$indent</ul>{$n}";
			}
		}

		/**
		 * Starts the element output.
		 *
		 * @since 3.0.0
		 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
		 *
		 * @see Walker::start_el()
		 *
		 * @param string   $output Used to append additional content (passed by reference).
		 * @param WP_Post  $item   Menu item data object.
		 * @param int      $depth  Depth of menu item. Used for padding.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 * @param int      $id     Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			
			$item_id		=  $item->ID;
			$menu_type 		= ( !empty( $args->menu_type ) ) ? $args->menu_type : 'main-menu';
		
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item_id;
			
			
			if ( $depth == 0 ) {
				$this->megamenu_item_id 		= $item_id;
				$this->menu_type 				= get_post_meta( $item_id, '_menu_item_powernode_menu-type', true );
				$this->megamenu_layout 			= get_post_meta( $item_id, '_menu_item_powernode_megamenu-layout', true );
				$this->megamenu_width			= get_post_meta( $item_id, '_menu_item_powernode_megamenu-width', true );
				$this->megamenu_height 			= get_post_meta( $item_id, '_menu_item_powernode_megamenu-height', true );
				$this->megamenu_columns 		= get_post_meta( $item_id, '_menu_item_powernode_megamenu-columns', true );
				$this->megamenu_custom_layout 	= get_post_meta( $item_id, '_menu_item_powernode_custom-layout', true );
				
				if ( in_array( $this->menu_type, array( 'megamenu-columns', 'megamenu-layout' ) ) && !empty( $this->megamenu_custom_layout ) ) { 
				
					$classes[] = 'has-mega-menu';
					
					if ( $this->megamenu_layout == 'full-width' ) {
						$classes[] = 'mega-menu-full-width';
					} else if ( $this->megamenu_layout == 'custom-size' ) {
						$classes[] = 'mega-menu-custom-size';
					}
					
				} else {
					$classes[] = 'has-simple-menu';
				}
			}
			
			/** Megamenu Columns **/
			if ( $depth == 1 ) {
				if ( in_array( $this->menu_type, array( 'megamenu-columns' ) ) ) {
					$classes[] = powernodewt_cols_class( 'md', str_replace( 'col-', '', $this->megamenu_columns ) );
				}
			}
		
			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @since 4.4.0
			 *
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param WP_Post  $item  Menu item data object.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			/**
			 * Filters the CSS classes applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
			 * @param WP_Post  $item    The current menu item.
			 * @param stdClass $args    An object of wp_nav_menu() arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param WP_Post  $item    The current menu item.
			 * @param stdClass $args    An object of wp_nav_menu() arguments.
			 * @param int      $depth   Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item_id, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$atts           = array();
			
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			if ( '_blank' === $item->target && empty( $item->xfn ) ) {
				$atts['rel'] = 'noopener noreferrer';
			} else {
				$atts['rel'] = $item->xfn;
			}
			$atts['href']         = ! empty( $item->url ) ? $item->url : '';
			$atts['aria-current'] = $item->current ? 'page' : '';

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts {
			 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 *     @type string $title        Title attribute.
			 *     @type string $target       Target attribute.
			 *     @type string $rel          The rel attribute.
			 *     @type string $href         The href attribute.
			 *     @type string $aria_current The aria-current attribute.
			 * }
			 * @param WP_Post  $item  The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item_id );

			/**
			 * Filters a menu item's title.
			 *
			 * @since 4.4.0
			 *
			 * @param string   $title The menu item's title.
			 * @param WP_Post  $item  The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int      $depth Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output  = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';
			
			/** Custom Layout **/
			if ( $depth == 0 && $this->megamenu_custom_layout != '' && in_array( $this->menu_type, array( 'megamenu-layout' ) ) && !$args->walker->has_children ) {
				
				$atts = array();
				if ( $this->megamenu_layout == 'full-width' ) {
					$atts['style'][] = 'width:100%;';
				} else {
					$atts['style'][] = ( $this->megamenu_width ) ? 'width:' . $this->megamenu_width . 'px;' : '';
					$atts['style'][] = ( $this->megamenu_height ) ? 'min-height:' . $this->megamenu_height . 'px;' : '';
				}
				
				$item_output .= "{$n}{$indent}<div class='pnwt-megamenu pnwt-dropdown wsmegamenu clearfix'>{$n}";
				$item_output .= "{$n}{$indent}<div class='pnwt-megamenu-inside' ". powernodewt_stringify_atts( $atts ) .">{$n}";
				$item_output .= powernodewt_do_shortcode( 'powernode_layout', array( 'id' => $this->megamenu_custom_layout ) );
				$item_output .= "{$n}$indent</div>{$n}";
				$item_output .= "{$n}$indent</div>{$n}";
			}
			
			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string   $item_output The menu item's starting HTML output. 
			 * @param WP_Post  $item        Menu item data object.
			 * @param int      $depth       Depth of menu item. Used for padding.
			 * @param stdClass $args        An object of wp_nav_menu() arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Ends the element output, if needed.
		 *
		 * @since 3.0.0
		 * @since 5.9.0 Renamed `$item` to `$data_object` to match parent class for PHP 8 named parameter support.
		 *
		 * @see Walker::end_el()
		 *
		 * @param string   $output      Used to append additional content (passed by reference).
		 * @param WP_Post  $data_object Menu item data object. Not used.
		 * @param int      $depth       Depth of page. Not Used.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
			
			$menu_type = ( !empty( $args->menu_type ) ) ? $args->menu_type : 'main-menu';
			
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$output .= "</li>{$n}";
		}
	}
	
endif;