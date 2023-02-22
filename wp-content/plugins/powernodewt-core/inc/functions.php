<?php
/**
 * Custom Theme Css
 */
if ( ! function_exists( 'powernodewt_exts_css_output' ) ) {
	
	function powernodewt_exts_css_output( $output = '', &$args = array() ) {
		
		global $pnwt_exts_head_css;
		if ( $output != '' ) {
			$pnwt_exts_head_css .= $output;
			if( \Elementor\Plugin::$instance->editor->is_edit_mode() && !empty( $args['sec_content'] ) ) {
				$args['sec_content'] .= '<style>' . $output . '</style>';
			}
		}
		return $pnwt_exts_head_css;
	}
}

/**
 * Templates
 */
function powernodewt_exts_get_template( $slug, $args = array() ) {
	
	$template = '';
	
	$template_path = 'template-parts/';
	$plugin_path = trailingslashit( POWERNODEWT_CORE_DIR );
	
	// If template file doesn't exist, look in yourtheme/template-parts/shortcodes/slug.php
	if ( ! $template ) {
		$template = locate_template( array(
			$template_path . "{$slug}.php"
		) );
	}
	
	// Get default slug.php
	if ( ! $template && file_exists( $plugin_path . "/templates/{$slug}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}.php";
	}
	
	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'powernodewt_exts_get_template', $template, $slug);	
	extract( $args );
	if ( !empty( $template ) ) {		
		include $template;
	}
}

/**
 * Alignment Array
 */
if ( ! function_exists( 'powernodewt_alignment_array' ) ) {

	function powernodewt_alignment_array() {		
		return array(
			esc_html__( 'Verticle (default)', 'powernodewt-core' ) => 'ver',
			esc_html__( 'Horizontal', 'powernodewt-core' ) => 'hor',
		);
	}
}

/**
 * Text Alignment Array
 */
if ( ! function_exists( 'powernodewt_text_alignment_array' ) ) {

	function powernodewt_text_alignment_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'Left', 'powernodewt-core' ) => 'left',
			esc_html__( 'Center', 'powernodewt-core' ) => 'center',
			esc_html__( 'Right', 'powernodewt-core' ) => 'right',
			esc_html__( 'Justified', 'powernodewt-core' ) => 'justify',
		);
	}
}

/**
 * Vertical Alignment Array
 */
if ( ! function_exists( 'powernodewt_vertical_alignment_array' ) ) {

	function powernodewt_vertical_alignment_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'Top', 'powernodewt-core' ) => 'start',
			esc_html__( 'Middle', 'powernodewt-core' ) => 'center',
			esc_html__( 'Bottom', 'powernodewt-core' ) => 'end',
		);
	}
}

/**
 * Horizontal Alignment Array
 */
if ( ! function_exists( 'powernodewt_horizontal_alignment_array' ) ) {

	function powernodewt_horizontal_alignment_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'Left', 'powernodewt-core' ) => 'start',
			esc_html__( 'Center', 'powernodewt-core' ) => 'center',
			esc_html__( 'Right', 'powernodewt-core' ) => 'end',
			esc_html__( 'Between', 'powernodewt-core' ) => 'between',
			esc_html__( 'Around', 'powernodewt-core' ) => 'around',
		);
	}
}


/**
 * Font Weight Array
 */
if ( ! function_exists( 'powernodewt_font_weight_array' ) ) {

	function powernodewt_font_weight_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'Thin: 100', 'powernodewt-core' ) => 'thin',
			esc_html__( 'Light: 200', 'powernodewt-core' ) => 'light',
			esc_html__( 'Book: 300', 'powernodewt-core' ) => 'book',
			esc_html__( 'Normal: 400', 'powernodewt-core' ) => 'normal',
			esc_html__( 'Medium: 500', 'powernodewt-core' ) => 'medium',
			esc_html__( 'Semibold: 600', 'powernodewt-core' ) => 'semibold',
			esc_html__( 'Bold: 700', 'powernodewt-core' ) => 'bold',
			esc_html__( 'Extra Bold: 800', 'powernodewt-core' ) => 'extra-bold',
			esc_html__( 'Bolder: 900', 'powernodewt-core' ) => 'bolder',
		);
	}
}

/**
 * Font Size Array
 */
if ( ! function_exists( 'powernodewt_font_size_array' ) ) {

	function powernodewt_font_size_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'XSmall', 'powernodewt-core' ) => 'xs',
			esc_html__( 'Small', 'powernodewt-core' ) => 'sm',
			esc_html__( 'Medium', 'powernodewt-core' ) => 'md',
			esc_html__( 'Large', 'powernodewt-core' ) => 'lg',
			esc_html__( 'XL', 'powernodewt-core' ) => 'xl',
			esc_html__( 'Custom', 'powernodewt-core' ) => 'custom',
		);
	}
}


/**
 * Font Style Array
 */
if ( ! function_exists( 'powernodewt_font_style_array' ) ) {

	function powernodewt_font_style_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'Normal', 'powernodewt-core' ) => 'normal',
			esc_html__( 'Italic', 'powernodewt-core' ) => 'italic',
		);
	}
}

/**
 * Font Style Array
 */
if ( ! function_exists( 'powernodewt_text_transform_array' ) ) {

	function powernodewt_text_transform_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'None', 'powernodewt-core' ) => 'none',
			esc_html__( 'Capitalize', 'powernodewt-core' ) => 'capitalize',
			esc_html__( 'Lowercase', 'powernodewt-core' ) => 'lowercase',
			esc_html__( 'Uppercase', 'powernodewt-core' ) => 'uppercase',
		);
	}
}

/**
 * Animations Array
 */
if ( ! function_exists( 'powernodewt_animations_array' ) ) {

	function powernodewt_animations_array() {		
		return array(
			esc_html__( 'None', 'powernodewt-core' ) => '',
			esc_html__( 'Fade In', 'powernodewt-core' ) => 'fadeIn',
			esc_html__( 'Fade In Up', 'powernodewt-core' ) => 'fadeInUp',
			esc_html__( 'Fade In Down', 'powernodewt-core' ) => 'fadeInDown',
			esc_html__( 'Fade In Left', 'powernodewt-core' ) => 'fadeInLeft',
			esc_html__( 'Fade In Right', 'powernodewt-core' ) => 'fadeInRight',
			esc_html__( 'Slide In Up', 'powernodewt-core' ) => 'slideInUp',
			esc_html__( 'Slide In Down', 'powernodewt-core' ) => 'slideInDown',
			esc_html__( 'Slide In Left', 'powernodewt-core' ) => 'slideInLeft',
			esc_html__( 'Slide In Right', 'powernodewt-core' ) => 'slideInRight',
			
		);
	}
}

/**
 * Social Icons Array
 */
if ( ! function_exists( 'powernodewt_social_icons_array' ) ) {

	function powernodewt_social_icons_array() {		
		return array(
			esc_html__( 'Facebook', 'powernodewt-core' ) => 'facebook',
			esc_html__( 'Twitter', 'powernodewt-core' ) => 'twitter',
			esc_html__( 'Instagram', 'powernodewt-core' ) => 'instagram',
			esc_html__( 'WhatsApp', 'powernodewt-core' ) => 'whatsapp',
			esc_html__( 'Linkedin', 'powernodewt-core' ) => 'linkedin',
			esc_html__( 'Pinterest', 'powernodewt-core' ) => 'pinterest',
			esc_html__( 'Youtube', 'powernodewt-core' ) => 'youtube',
			esc_html__( 'Telegram', 'powernodewt-core' ) => 'telegram',
			esc_html__( 'Email', 'powernodewt-core' ) => 'email',
			esc_html__( 'Github', 'powernodewt-core' ) => 'github',
			esc_html__( 'Google Plus', 'powernodewt-core' ) => 'google-plus',
			esc_html__( 'Dribbble', 'powernodewt-core' ) => 'dribbble',
			esc_html__( 'Behance', 'powernodewt-core' ) => 'behance',
			esc_html__( 'VK', 'powernodewt-core' ) => 'vk',
			esc_html__( 'Custom', 'powernodewt-core' ) => 'custom',
			
		);
	}
}

/**
 * Color Array
 */
if ( ! function_exists( 'powernodewt_color_array' ) ) {

	function powernodewt_color_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => 'default',
			esc_html__( 'Theme', 'powernodewt-core' ) => 'theme',
			esc_html__( 'Grey', 'powernodewt-core' ) => 'grey',
			esc_html__( 'Grey - 1', 'powernodewt-core' ) => 'grey-1',
			esc_html__( 'White', 'powernodewt-core' ) => 'white',
			esc_html__( 'Lightgrey', 'powernodewt-core' ) => 'lightgrey',
			esc_html__( 'Azure', 'powernodewt-core' ) => 'azure',
			esc_html__( 'Brown', 'powernodewt-core' ) => 'brown',
			esc_html__( 'Deepgrey', 'powernodewt-core' ) => 'deepgrey',
			esc_html__( 'Gold', 'powernodewt-core' ) => 'gold',
			esc_html__( 'Navy', 'powernodewt-core' ) => 'navy',
			esc_html__( 'Rose', 'powernodewt-core' ) => 'rose',
			esc_html__( 'Salmon', 'powernodewt-core' ) => 'salmon',
			esc_html__( 'Silk', 'powernodewt-core' ) => 'silk',
			esc_html__( 'Skyblue', 'powernodewt-core' ) => 'skyblue',
			esc_html__( 'Steelblue', 'powernodewt-core' ) => 'steelblue',
			esc_html__( 'Purple', 'powernodewt-core' ) => 'purple',
			esc_html__( 'Yellow', 'powernodewt-core' ) => 'yellow',
			esc_html__( 'Custom', 'powernodewt-core' ) => 'custom'
		);
	}
}

/**
 * BG Color Array
 */
if ( ! function_exists( 'powernodewt_bg_color_array' ) ) {

	function powernodewt_bg_color_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => 'default',
			esc_html__( 'Theme', 'powernodewt-core' ) => 'theme',
			esc_html__( 'Grey', 'powernodewt-core' ) => 'grey',
			esc_html__( 'Lightgrey', 'powernodewt-core' ) => 'lightgrey',
			esc_html__( 'White', 'powernodewt-core' ) => 'white',
			esc_html__( 'Dark', 'powernodewt-core' ) => 'dark',
			esc_html__( 'Deepdark', 'powernodewt-core' ) => 'deepdark',
			esc_html__( 'Azure', 'powernodewt-core' ) => 'azure',
			esc_html__( 'Lightazure', 'powernodewt-core' ) => 'lightazure',
			esc_html__( 'Brown', 'powernodewt-core' ) => 'brown',
			esc_html__( 'Denim', 'powernodewt-core' ) => 'denim',
			esc_html__( 'Gold', 'powernodewt-core' ) => 'gold',
			esc_html__( 'Lightgreen', 'powernodewt-core' ) => 'lightgreen',
			esc_html__( 'Navy', 'powernodewt-core' ) => 'navy',
			esc_html__( 'Salmon', 'powernodewt-core' ) => 'salmon',
			esc_html__( 'Sapphire', 'powernodewt-core' ) => 'sapphire',
			esc_html__( 'Silk', 'powernodewt-core' ) => 'silk',
			esc_html__( 'DarkBlue', 'powernodewt-core' ) => 'darkblue',
			esc_html__( 'SkyBlue', 'powernodewt-core' ) => 'skyblue',
			esc_html__( 'Steel', 'powernodewt-core' ) => 'steel',
			esc_html__( 'Steelblue', 'powernodewt-core' ) => 'steelblue',
			esc_html__( 'Rose', 'powernodewt-core' ) => 'rose',
			esc_html__( 'Yellow', 'powernodewt-core' ) => 'yellow',
			esc_html__( 'Custom', 'powernodewt-core' ) => 'custom'
		);
	}
}

/**
 * Icon Size
 */
if ( ! function_exists( 'powernodewt_icon_size_array' ) ) {

	function powernodewt_icon_size_array() {		
		return array(
			esc_html__( 'Default', 'powernodewt-core' ) => '',
			esc_html__( 'Icon-15', 'powernodewt-core' ) => 'ico-15',
			esc_html__( 'Icon-20', 'powernodewt-core' ) => 'ico-20',
			esc_html__( 'Icon-25', 'powernodewt-core' ) => 'ico-25',
			esc_html__( 'Icon-30', 'powernodewt-core' ) => 'ico-30',
			esc_html__( 'Icon-35', 'powernodewt-core' ) => 'ico-35',
			esc_html__( 'Icon-40', 'powernodewt-core' ) => 'ico-40',
			esc_html__( 'Icon-45', 'powernodewt-core' ) => 'ico-45',
			esc_html__( 'Icon-50', 'powernodewt-core' ) => 'ico-50',
			esc_html__( 'Icon-55', 'powernodewt-core' ) => 'ico-55',
			esc_html__( 'Icon-60', 'powernodewt-core' ) => 'ico-60',
			esc_html__( 'Icon-65', 'powernodewt-core' ) => 'ico-65',
			esc_html__( 'Icon-70', 'powernodewt-core' ) => 'ico-70',
			esc_html__( 'Icon-75', 'powernodewt-core' ) => 'ico-75',
			esc_html__( 'Icon-80', 'powernodewt-core' ) => 'ico-80',
			esc_html__( 'Icon-85', 'powernodewt-core' ) => 'ico-85',
			esc_html__( 'Icon-90', 'powernodewt-core' ) => 'ico-90',
			esc_html__( 'Icon-95', 'powernodewt-core' ) => 'ico-95',
			esc_html__( 'Icon-100', 'powernodewt-core' ) => 'ico-100',
			esc_html__( 'Custom', 'powernodewt-core' ) => 'ico-custom',
		);
	}
}

/**
 * Button Color Array
 */
if ( ! function_exists( 'powernodewt_button_color_array' ) ) {

	function powernodewt_button_color_array() {		
		return array(
			'theme'   => __('Theme', 'powernodewt'),
			'tra-theme'   => __('Transparent Theme', 'powernodewt'),
			'grey'   => __('Grey', 'powernodewt'),
			'tra-grey'   => __('Transparent Grey', 'powernodewt'),
			'white'   => __('White', 'powernodewt'),
			'tra-white'   => __('Transparent White', 'powernodewt'),
			'black'   => __('Black', 'powernodewt'),
			'tra-black'   => __('Transparent Black', 'powernodewt'),
			'azure'   => __('Azure', 'powernodewt'),
			'tra-azure'   => __('Transparent Azure', 'powernodewt'),
			'brown'   => __('Brown', 'powernodewt'),
			'tra-brown'   => __('Transparent Brown', 'powernodewt'),
			'gold'   => __('Gold', 'powernodewt'),
			'tra-gold'   => __('Transparent Gold', 'powernodewt'),
			'navy'   => __('Navy', 'powernodewt'),
			'tra-navy'   => __('Transparent Navy', 'powernodewt'),
			'purple'   => __('Purple', 'powernodewt'),
			'tra-purple'   => __('Transparent Purple', 'powernodewt'),
			'rose'   => __('Rose', 'powernodewt'),
			'tra-rose'   => __('Transparent Rose', 'powernodewt'),
			'salmon'   => __('Salmon', 'powernodewt'),
			'tra-salmon'   => __('Transparent Salmon', 'powernodewt'),
			'silk'   => __('Silk', 'powernodewt'),
			'tra-silk'   => __('Transparent Silk', 'powernodewt'),
			'skyblue'   => __('SkyBlue', 'powernodewt'),
			'tra-skyblue'   => __('Transparent SkyBlue', 'powernodewt'),
			'steel'   => __('Steel', 'powernodewt'),
			'tra-steel'   => __('Transparent Steel', 'powernodewt'),
			'steelblue'   => __('SteelBlue', 'powernodewt'),
			'tra-steelblue'   => __('Transparent SteelBlue', 'powernodewt'),
			'yellow'   => __('Yellow', 'powernodewt'),
			'tra-yellow'   => __('Transparent Yellow', 'powernodewt'),
		);
	}
}

/**
 * Button Hover Color Array
 */
if ( ! function_exists( 'powernodewt_button_hover_color_array' ) ) {

	function powernodewt_button_hover_color_array() {		
		return array(
			'theme'   => __('Theme', 'powernodewt'),
			'tra-theme'   => __('Transparent Theme', 'powernodewt'),
			'grey'   => __('Grey', 'powernodewt'),
			'tra-grey'   => __('Transparent Grey', 'powernodewt'),
			'white'   => __('White', 'powernodewt'),
			'tra-white'   => __('Transparent White', 'powernodewt'),
			'black'   => __('Black', 'powernodewt'),
			'tra-black'   => __('Transparent Black', 'powernodewt'),
		);
	}
}

/**
 * Get font size class
 */
if ( ! function_exists( 'powernodewt_font_size_class' ) ) {

	function powernodewt_font_size_class( $type, $font_size ) {
		
		$class = '';
		if( in_array( $type, array( 'span', 'div' ) ) ) {
			$class = 'fs-' . $font_size;
		} else {
			$class = $type . '-' . $font_size;
		}
		
		return $class;
	}
}

/**
 * Extract width/height from string
 *
 * @param string $dimensions WxH
 *
 * @return mixed array(width, height) or false
 *
 */
function powernodewt_exts_extract_dimensions( $dimensions ) {
	$dimensions = str_replace( ' ', '', $dimensions );
	$matches = null;

	if ( preg_match( '/(\d+)x(\d+)/', $dimensions, $matches ) ) {
		return array(
			$matches[1],
			$matches[2],
		);
	}

	return false;
}

/**
 * @param $param_value
 * @param string $prefix
 *
 * @return string
 */
function powernodewt_vc_shortcode_custom_css_class( $param_value, $prefix = '' ) {
	$css_class = preg_match( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', $param_value ) ? $prefix . preg_replace( '/\s*\.([^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/', '$1', $param_value ) : '';

	return $css_class;
}

if ( ! function_exists( 'getCategoryChildsFull' ) ) {
	/**
	 * Get lists of categories.
	 * @param $parent_id
	 * @param array $array
	 * @param $level
	 * @param array $dropdown - passed by  reference
	 * @return array
	 * @since 4.5.3
	 *
	 */
	function getCategoryChildsFull( $parent_id, $array, $level, &$dropdown ) {
		$keys = array_keys( $array );
		$i = 0;
		while ( $i < count( $array ) ) {
			$key = $keys[ $i ];
			$item = $array[ $key ];
			$i ++;
			if ( $item->category_parent == $parent_id ) {
				$name = str_repeat( '- ', $level ) . $item->name;
				$value = $item->slug;
				$dropdown[] = array(
					'label' => $name . '(' . $item->term_id . ')',
					'value' => $value,
				);
				unset( $array[ $key ] );
				$array = getCategoryChildsFull( $item->term_id, $array, $level + 1, $dropdown );
				$keys = array_keys( $array );
				$i = 0;
			}
		}

		return $array;
	}

}

/**
 * @param $content
 * @param bool $autop
 *
 * @return string
 */
function powernodewt_js_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) {
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}

/**
 * Social Share
 */
if ( ! function_exists( 'powernodewt_social_links' ) ) :

	function powernodewt_social_links( $atts = array() ) {
		
		if( ! powernodewt_social_share_enable() ) false;
		
		$atts = shortcode_atts(array(
			'type' 			=> 'share',			
			'style' 		=> 'icon-bordered',
			'shape' 		=> 'icons-shape-circle',
			'size' 			=> 'icons-size-default',
			'css' 			=> '',
			'el_classes' 		=> '',
			'echo' 			=> true,
		), $atts );
		
		extract($atts);
		
		$classes []= 'powernode-social';
		$classes []= $style;
		$classes []= $shape;
		$classes []= $size;
		$classes []= ( $el_classes ) ? $el_classes : '';
		$classes []= powernodewt_vc_shortcode_custom_css_class( $css, ' ' );
		$classes = implode( ' ', $classes );
		
		$post_title = '';
		$post_link = '';
		$share_twitter_username = '';
		$thumb_id = '';
		$thumb_url = array(0=>'');
		$enabled_social_networks = array();
		if($type == 'share' && powernodewt_get_option('show-social-sharing', 1) ){
			$post_title   = htmlspecialchars( urlencode( html_entity_decode( esc_attr( get_the_title() ), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
			$post_link = get_the_permalink();
			// Twitter username
			$share_twitter_username = powernodewt_get_option( 'share_twitter_username', '' ) ? ' via %40'.powernodewt_get_option( 'share_twitter_username','' ) : '';
			$thumb_id = get_post_thumbnail_id();
			$thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
			$social_networks = powernodewt_get_option('social-share-manager', array(
                    'enabled'  =>array(
				'facebook' 		=> 'Facebook',
				'twitter'     	=> 'Twitter',
				'linkedin'   	=> 'Linkedin',
				'telegram'		=> 'Telegram',
				'pinterest'		=> 'Pinterest',
			)));
			$enabled_social_networks = $social_networks['enabled'];			
		}
		
		// Buttons array
		$share_buttons = array(

			'facebook' => array(
				'url'  => 'https://www.facebook.com/sharer/sharer.php?u='. $post_link,
				'text' => esc_html__( 'Facebook', 'powernodewt' ),
				'icon' => 'fa fa-facebook',
			),
			'twitter' => array(
				'url'   => 'https://twitter.com/share?url='. $post_title . $share_twitter_username .'&amp;url='. $post_link,
				'text'  => esc_html__( 'Twitter', 'powernodewt' ),
				'icon' => 'fa fa-twitter',
			),
			'linkedin' => array(
				'url'  => 'https://www.linkedin.com/shareArticle?mini=true&url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'LinkedIn', 'powernodewt' ),
				'icon' => 'fa fa-linkedin',
			),
			'stumbleupon' => array(
				'url'  => 'http://www.stumbleupon.com/submit?url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'StumbleUpon', 'powernodewt' ),
				'icon' => 'fa fa-stumbleupon',
			),
			'tumblr' => array(
				'url'  => 'https://tumblr.com/widgets/share/tool?canonicalUrl='. $post_link .'&amp;name='. $post_title,
				'text' => esc_html__( 'Tumblr', 'powernodewt' ),
				'icon' => 'fa fa-tumblr',
			),
			'pinterest' => array(
				'url'  => 'https://pinterest.com/pin/create/button/?url='. $post_link .'&amp;description='. $post_title .'&amp;media='. $thumb_url[0],
				'text' => esc_html__( 'Pinterest', 'powernodewt' ),
				'icon' => 'fa fa-pinterest',
			),
			'reddit' => array(
				'url'  => 'https://reddit.com/submit?url='. $post_link .'&amp;title='. $post_title,
				'text' => esc_html__( 'Reddit', 'powernodewt' ),
				'icon' => 'fa fa-reddit',
			),
			'vk' => array(
				'url'  => 'https://vk.com/share.php?url='. $post_link,
				'text' => esc_html__( 'VKontakte', 'powernodewt' ),
				'icon' => 'fa fa-vk',
			),
			'odnoklassniki' => array(
				'url'  => 'https://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl='. $post_link .'&amp;description='. $post_title .'&amp;media='. $thumb_url[0],
				'text' => esc_html__( 'Odnoklassniki', 'powernodewt' ),
				'icon' => 'fa fa-odnoklassniki',
			),
			'pocket' => array(
				'url'  => 'https://getpocket.com/save?title='. $post_title .'&amp;url='.$post_link,
				'text' => esc_html__( 'Pocket', 'powernodewt' ),
				'icon' => 'fa fa-get-pocket',
			),
			'whatsapp' => array(
				'url'   => 'https://wa.me/?text='. $post_link,
				'text'  => esc_html__( 'WhatsApp', 'powernodewt' ),
				'icon' => 'fa fa-whatsapp',
				'avoid_esc' => true,
			),
			'telegram' => array(
				'url'   => 'https://telegram.me/share/url?url='.$post_link,
				'text'  => esc_html__( 'Telegram', 'powernodewt' ),
				'icon'  => 'fa fa-telegram',
				'avoid_esc' => true,
			),	
			'email' => array(
				'url'  => 'mailto:?subject='. $post_title .'&amp;body='. $post_link,
				'text' => esc_html__( 'Email', 'powernodewt' ),
				'icon' => 'fa fa-envelope',
			),
			'print' => array(
				'url'  => '#',
				'text' => esc_html__( 'Print', 'powernodewt' ),
				'icon' => 'fa fa-print',
				'check'=> powernodewt_get_option('share-print', 0 ),
			),
			'instagram' => array(
				'url'  => '#',
				'text' => esc_html__( 'Instagram', 'powernodewt' ),
				'icon' => 'fa fa-instagram',
			),
			'flickr' => array(
				'url'  => '#',
				'text' => esc_html__( 'Flickr', 'powernodewt' ),
				'icon' => 'fa fa-flickr',
			),
			'rss' => array(
				'url'  => '#',
				'text' => esc_html__( 'RSS', 'powernodewt' ),
				'icon' => 'fa fa-rss',
			),
			'youtube' => array(
				'url'  => '#',
				'text' => esc_html__( 'Youtube', 'powernodewt' ),
				'icon' => 'fa fa-youtube',
			),
			'github' => array(
				'url'  => '#',
				'text' => esc_html__( 'Github', 'powernodewt' ),
				'icon' => 'fa fa-github',
			),			
		);
		
		$share_buttons = apply_filters( 'powernodewt_social_share_buttons', $share_buttons );
		
		$active_share_buttons = array();
		
		foreach ( $share_buttons as $network => $button ){
			$social_link = '';
			
			if($type == 'share' && powernodewt_get_option('show-social-share', 1) && array_key_exists($network,$enabled_social_networks)){
				$social_link = $button['url'];
			}elseif($type == 'profile' && powernodewt_get_option('show-social-profile', 1) && powernodewt_get_option($network.'-link','')){
				$social_link = powernodewt_get_option($network.'-link','');
			}
			if( !empty($social_link)  && ! isset( $button['avoid_esc'] )){
				$button['url'] = esc_url( $social_link );
			}
			if(!empty($social_link)){
				$active_share_buttons[$network] = '<a href="'. $social_link .'" rel="external" target="_blank" class="social-'. $network.'"><i class="'. $button['icon'] .'"></i> <span class="social-text">'. $button['text'] .'</span></a>';
			}
		}
		
		/**
		* social share icon order
		*/
		$active_share = array();
		if(!empty($enabled_social_networks)){
			foreach($enabled_social_networks as $social_key => $value){
				if(isset($active_share_buttons[$social_key]))
				$active_share[$social_key] =  $active_share_buttons[$social_key]; 
			}
			$active_share_buttons = array_merge($active_share,$active_share_buttons);
		}
		if( is_array( $active_share_buttons ) && ! empty( $active_share_buttons ) ){
			if($echo){	?>
				<div class="<?php echo esc_attr($classes);?>">
					<?php echo implode( '', $active_share_buttons ); ?>
				</div>
			<?php			
			}else{
				return implode( '', $active_share_buttons );
			}		
		}		
	}
endif;

/*
 * Get Categories
 */
function powernodewt_categories( $category, $field_key_return = '' ) {
	
	$categories = get_categories( array( 'taxonomy' => $category ));
	$array = array( '' => 'All');
	foreach( $categories as $cat ){
		if( $field_key_return == 'id' ) {
			$cat_key = $cat->term_id;
		} else {
			$cat_key = $cat->slug;
		}
	
		if( is_object($cat) ) $array[$cat_key] = $cat->slug;
	}

	return $array;
}

/**
* Get server info
*/
if( ! function_exists( 'powernodewt_get_server_info' ) ) {
	function powernodewt_get_server_info(){
		return $_SERVER['SERVER_SOFTWARE'];
	}
}

/**
* Get Url Data
*/
if( ! function_exists( 'powernodewt_get_url_data' ) ) {
	function powernodewt_get_url_data( $atts ) {
		$link_atts = array();
		if( !empty( $atts ) ) {
			if( $atts['url'] ) $link_atts['href'] = $atts['url'];
			if( $atts['is_external'] ) $link_atts['target'] = 'target="_blank"';
			if( $atts['nofollow'] ) $link_atts['rel'] = 'nofollow';
			if( isset( $atts['custom_attributes'] ) ) {
				$custom_attributes = Elementor\Utils::parse_custom_attributes( $atts['custom_attributes'] );
				foreach ( $custom_attributes as $key => $value ) {
					$link_atts[$key] = $value;
				}
			}
		}
		return $link_atts;
	}
}


/**
* powernodewt_debug_to_console
*/
if( ! function_exists( 'powernodewt_debug_to_console' ) ) {
	function powernodewt_debug_to_console($data) {
		$output = $data;
		if (is_array($output))
			$output = implode(',', $output);
	
		echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
	}
}