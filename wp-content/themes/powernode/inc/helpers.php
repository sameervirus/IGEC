<?php
/**
 * Helpers
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! function_exists( 'powernodewt_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function powernodewt_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}


if( ! function_exists( 'powernodewt_is_blog_archive' ) ) {
	function powernodewt_is_blog_archive() {
		return ( is_home() || is_search() || is_tag() || is_archive() || is_category() || is_date() || is_author() );
	}
}

/*-----------------------------------------------
 * General
 *----------------------------------------------*/

if ( ! function_exists( 'powernodewt_get_post_meta' ) ) {

	function powernodewt_get_post_meta( $meta ) {
		
		if ( empty( $meta ) ) return;
		
		$prefix = POWERNODEWT_PREFIX;
				
		$post_meta = get_post_meta( powernodewt_post_id(), $prefix.$meta, true );
		$post_meta = ( empty( $post_meta ) && $post_meta != false  ) ? '' : $post_meta;
		
		return apply_filters( 'powernode_get_post_meta', $post_meta );
		
	}
}

if ( ! function_exists( 'powernodewt_check_not_def_empty' ) ) {

	function powernodewt_is_not_def_empty( $value ) {
		
		if ( $value != '' && $value != 'default' ) {
			return true;
		}
		return false;
		
	}

}

/**
 * Minify CSS
 */
if ( ! function_exists( 'powernodewt_minify_css' ) ) {

	function powernodewt_minify_css( $css = '' ) {

		// Return if no CSS
		if ( ! $css ) return;

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Trim
		$css = trim( $css );

		// Return minified CSS
		return $css;
		
	}

}

/**
 * Minify CSS
 */
if ( ! function_exists( 'powernodewt_minify_css' ) ) {

	function powernodewt_minify_css( $css = '' ) {

		// Return if no CSS
		if ( ! $css ) return;

		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove ; before }
		$css = preg_replace( '/;(?=\s*})/', '', $css );

		// Remove space after , : ; { } */ >
		$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Trim
		$css = trim( $css );

		// Return minified CSS
		return $css;
		
	}

}
 
/**
 * Container Width
 */
if ( ! function_exists( 'powernodewt_container_width' ) ) {

	function powernodewt_container_width() {

		$container_width = get_theme_mod( 'powernode_container_width', '1170' );
		$container_width = ($container_width) ? $container_width : 1170;

		return apply_filters( 'powernode_container_width', $container_width );

	}

}

/**
 * @param array $params
 */
function powernodewt_get_image_html( $params = array() ) {
	$params = array_merge( array(
		'post_id' => null,
		'attach_id' => null,
		'alt' => null,
		'title' => null,
		'size' => 'thumbnail',
		'class' => '',
		'atts' => false
	), $params );

	if ( ! $params['size'] ) {
		$params['size'] = 'thumbnail';
	}

	if ( ! $params['attach_id'] && ! $params['post_id'] ) {
		return false;
	}

	$post_id = $params['post_id'];

	$attach_id = $post_id ? get_post_thumbnail_id( $post_id ) : $params['attach_id'];
	$attach_id = apply_filters( 'powernode_object_id', $attach_id );
	$size = $params['size'];
	$thumb_class = ( isset( $params['class'] ) && '' !== $params['class'] ) ? $params['class'] . ' ' : '';

	global $_wp_additional_image_sizes;
	$html = '';

	$sizes = array(
		'thumbnail',
		'thumb',
		'medium',
		'large',
		'full',
	);
	
	if ( is_string( $size ) && ( ( ! empty( $_wp_additional_image_sizes[ $size ] ) && is_array( $_wp_additional_image_sizes[ $size ] ) ) || in_array( $size, $sizes, true ) ) ) {
		$attributes = array( 'class' => $thumb_class . 'attachment-' . $size );
		if ( !empty( $params['alt'] ) ) { $attributes['alt'] = $params['alt'];}
		if ( !empty( $params['title'] ) ) {	$attributes['title'] = $params['title']; }
		$html = wp_get_attachment_image( $attach_id, $size, false, $attributes );
	} elseif ( $attach_id ) {
		if ( is_string( $size ) ) {
			preg_match_all( '/\d+/', $size, $thumb_matches );
			if ( isset( $thumb_matches[0] ) ) {
				$size = array();
				$count = count( $thumb_matches[0] );
				if ( $count > 1 ) {
					$size[] = $thumb_matches[0][0]; // width
					$size[] = $thumb_matches[0][1]; // height
				} elseif ( 1 === $count ) {
					$size[] = $thumb_matches[0][0]; // width
					$size[] = $thumb_matches[0][0]; // height
				} else {
					$size = false;
				}
			}
		}
		if ( is_array( $size ) ) {
			// Resize image to custom size
			$p_img = powernodewt_resize( $attach_id, null, $size[0], $size[1], true );
			$alt = trim( wp_strip_all_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) ) );
			$attachment = get_post( $attach_id );
			if ( ! empty( $attachment ) ) {
				$title = trim( wp_strip_all_tags( $attachment->post_title ) );

				if ( empty( $alt ) ) {
					$alt = trim( wp_strip_all_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
				}

				if ( empty( $alt ) ) {
					$alt = $title;
				}

				if ( ! $params['alt'] ) {
					$alt = $params['alt'];
				}

				if ( ! $params['title'] ) {
					$title = $params['title'];
				}

				if ( $p_img ) {
					$attributes = array(
						'class' => $thumb_class,
						'src' => $p_img['url'],
						'width' => $p_img['width'],
						'height' => $p_img['height'],
						'alt' => $alt,
						'title' => $title,
					);
					if ( !empty( $params['atts'] ) ) {
						$attributes = array_merge( $attributes, $params['atts'] );
					}
					$attributes = powernodewt_stringify_atts( $attributes );
					$html = '<img ' . $attributes . ' />';
				}
			}
		}
	}

	return apply_filters( 'powernodewt_get_image_html', $html );
}

/*
* Resize images dynamically using wp built in functions
* Victor Teixeira
*/
if ( ! function_exists( 'powernodewt_resize' ) ) {

	function powernodewt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {
		// this is an attachment, so we have the ID
		$image_src = array();
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$actual_file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} elseif ( $img_url ) {
			$file_path = wp_parse_url( $img_url );
			$actual_file_path = rtrim( ABSPATH, '/' ) . $file_path['path'];
			$orig_size = getimagesize( $actual_file_path );
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
		if ( ! empty( $actual_file_path ) ) {
			$file_info = pathinfo( $actual_file_path );
			$extension = '.' . $file_info['extension'];

			// the image path without the extension
			$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

			$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

			// checking if the file size is larger than the target size
			// if it is smaller or the same size, stop right here and return
			if ( $image_src[1] > $width || $image_src[2] > $height ) {

				// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
				if ( file_exists( $cropped_img_path ) ) {
					$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
					$vt_image = array(
						'url' => $cropped_img_url,
						'width' => $width,
						'height' => $height,
					);

					return $vt_image;
				}

				if ( ! $crop ) {
					// calculate the size proportionaly
					$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
					$resized_img_path = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

					// checking if the file already exists
					if ( file_exists( $resized_img_path ) ) {
						$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

						$vt_image = array(
							'url' => $resized_img_url,
							'width' => $proportional_size[0],
							'height' => $proportional_size[1],
						);

						return $vt_image;
					}
				}

				// no cache files - let's finally resize it
				$img_editor = wp_get_image_editor( $actual_file_path );

				if ( is_wp_error( $img_editor ) || is_wp_error( $img_editor->resize( $width, $height, $crop ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => '',
					);
				}

				$new_img_path = $img_editor->generate_filename();

				if ( is_wp_error( $img_editor->save( $new_img_path ) ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => '',
					);
				}
				if ( ! is_string( $new_img_path ) ) {
					return array(
						'url' => '',
						'width' => '',
						'height' => '',
					);
				}

				$new_img_size = getimagesize( $new_img_path );
				$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				// resized output
				$vt_image = array(
					'url' => $new_img,
					'width' => $new_img_size[0],
					'height' => $new_img_size[1],
				);

				return $vt_image;
			}

			// default output - without resizing
			$vt_image = array(
				'url' => $image_src[0],
				'width' => $image_src[1],
				'height' => $image_src[2],
			);

			return $vt_image;
		}

		return false;
	}
}

/**
 * Get the placeholder image URL either from media, or use the fallback image.
 *
 * @param string $size Thumbnail size to use.
 * @return string
 */
if ( ! function_exists( 'powernodewt_placeholder_img_src' ) ) {
	
	function powernodewt_placeholder_img_src( $size = 'thumbnail', $src = '' ) {
		$src = ( empty( !$src ) ) ? $src : POWERNODEWT_CORE_URL . 'assets/images/placeholder.png';
		$placeholder_image = get_option( 'powernodewt_placeholder_image', 0 );

		if ( ! empty( $placeholder_image ) ) {
			if ( is_numeric( $placeholder_image ) ) {
				$image = wp_get_attachment_image_src( $placeholder_image, $size );

				if ( ! empty( $image[0] ) ) {
					$src = $image[0];
				}
			} else {
				$src = $placeholder_image;
			}
		}

		return apply_filters( 'powernodewt_placeholder_img_src', $src );
	}
}

/**
 * Default color picker palettes
 */
if ( ! function_exists( 'powernodewt_default_color_palettes' ) ) {

	function powernodewt_default_color_palettes() {

		$palettes = array(
			'#000000',
			'#ffffff',
			'#dd3333',
			'#dd9933',
			'#eeee22',
			'#81d742',
			'#1e73be',
			'#8224e3',
		);

		// Apply filters and return
		return apply_filters( 'powernode_default_color_palettes', $palettes );
	}
}

/**
 * Get current url
 */
if ( ! function_exists( 'powernodewt_get_current_url' ) ) {
	function powernodewt_get_current_url() {
		return esc_url( add_query_arg( NULL, NULL ) );
	}
}

/**
 * Get Main Layout
 */
if ( ! function_exists( 'powernodewt_main_layout_style' ) ) {
	function powernodewt_main_layout_style() {
		return get_theme_mod( 'powernode_main_layout_style', 'wide' );
	}
}
 
/**
 * Adds classes to the body tag
 */
if ( ! function_exists( 'powernodewt_body_classes' ) ) {
	
	function powernodewt_body_classes( $classes ) {

		$post_layout  = powernodewt_get_layout();
		$main_layout_style = powernodewt_main_layout_style();

		// RTL
		if ( is_rtl() ) {
			$classes[] = 'rtl';
		}
		
		// Main class
		$classes[] = 'powernodewt-theme';

		// Boxed layout
		if ( $main_layout_style == 'boxed' ) {
			$classes[] = 'boxed-layout';
		}

		// Predefine layout
		if ( $main_layout_style == 'predefine' ) {
			$classes[] = 'predefine-layout';
		}

		// If separate style nad blog page
		if ( $main_layout_style == 'predefine'
			&& ( is_home()
				|| is_category()
				|| is_tag()
				|| is_date()
				|| is_author() ) ) {
			$classes[] = 'predefine-blg';
		}

		// Sidebar enabled
		if ( in_array( $post_layout, array('left-sidebar', 'right-sidebar', 'both-sidebar')) ) {
			$classes[] = 'has-sidebar';
		}

		// Content layout
		if ( $post_layout ) {
			$classes[] = 'content-'. $post_layout;
		}
		
		return $classes;

	}
	add_filter( 'body_class', 'powernodewt_body_classes' );
}

/**
 * Retrun post id
 */
if ( ! function_exists( 'powernodewt_post_id' ) ) {

	function powernodewt_post_id() {

		$id = '';

		if ( is_singular() ) {
			$id = get_the_ID();
		} else if ( POWERNODEWT_WOOCOMMERCE_ACTIVE && is_shop() ) {
			$shop_id = wc_get_page_id( 'shop' );
			if ( isset( $shop_id ) ) {
				$id = $shop_id;
			}
		} else if ( is_home() && $page_for_posts = get_option( 'page_for_posts' ) ) {
			$id = $page_for_posts;
		}

		$id = apply_filters( 'powernode_post_id', $id );

		$id = $id ? $id : '';

		return $id;

	}
}

if ( ! function_exists( 'powernodewt_cols_class' ) ) {
	
	function powernodewt_cols_class( $d, $num ) {
		if($num==''){ return '';}
		$numcol=12/$num;
		$class='';
		if (in_array($num,array(1,2,3,4,6))) {
			$class='col-'.$d.'-'.$numcol;
		} else if ($num==8) {
			$class='col-'.$d.'-wt-8';
		} else if ($num==7) {
			$class='col-'.$d.'-wt-7';
		} else if ($num==5) {
			$class='col-'.$d.'-wt-5';
		}
		
		$class = str_replace('xs-', '', $class);
		
		return $class;
	}
}

/**
 * Get Unique ID
 */
if ( ! function_exists( 'powernodewt_uniqid' ) ) :
	function powernodewt_uniqid( $prefix = '' ) {		
		return $prefix.uniqid();
	}
endif;

/**
 * Font Weight Class
 */
if ( ! function_exists( 'powernodewt_font_weight_class' ) ) {
	function powernodewt_font_weight_class( $weight = '' ) {

		switch ( $weight ) {
			case 100 : 
				return 'font-weight-thin';
				break;
			case 200 : 
				return 'font-weight-extralight';
				break;
			case 300 : 
				return 'font-weight-light';
				break;
			case 400 : 
				return 'font-weight-normal';
				break;
			case 500 : 
				return 'font-weight-medium';
				break;
			case 600 : 
				return 'font-weight-semibold';
				break;
			case 700 : 
				return 'font-weight-bold';
				break;
			case 800 : 
				return 'font-weight-extrabold';
				break;
			case 900 : 
				return 'font-weight-ultrabold';
				break;
				
		}

		return false;
	}
}

/**
 * Convert array of named params to string version
 * All values will be escaped
 *
 * E.g. f(array('name' => 'foo', 'id' => 'bar')) -> 'name="foo" id="bar"'
 *
 * @param $attributes
 *
 * @return string
 */
if ( ! function_exists( 'powernodewt_stringify_atts' ) ) {

	function powernodewt_stringify_atts( $attributes ) {

		if ( !empty( $attributes ) ) { 
			$atts = array();
			
			foreach ( $attributes as $name => $value ) {
				if ( !empty( $name ) ) {
					$value = ( is_array( $value ) ) ? powernodewt_stringify_classes(  array_filter( $value ) ) : $value;
					$atts[] = $name . '="' . esc_attr( $value ) . '"';
				}
			}

			return implode( ' ', $atts );
		}
		return;
	}

}


/**
 * Convert array of classes to string
 */
if ( ! function_exists( 'powernodewt_stringify_classes' ) ) {

	function powernodewt_stringify_classes( $classes ) {
		
		if ( is_array($classes) ) {
			$classes = array_unique( $classes );
			$classes = esc_attr( trim( implode( ' ', $classes ) ) );
		}

		return $classes;
	}

}

/**
 * Parse CSS
 */
if ( ! function_exists( 'powernodewt_output_css' ) ) {

	/**
	 * Parse CSS
	 *
	 * Recursive function that generates from a a multidimensional array of CSS rules, a valid CSS string.
	 *
	 * @param array $rules
     *   An array of CSS rules in the form of:
	 *   array('selector'=>array('property' => 'value')). Also supports selector
	 *   nesting, e.g.,
	 *   array('selector' => array('selector'=>array('property' => 'value'))).
	 */
	function powernodewt_output_css( $output_ar = array(), $min_width = '',  $max_width = '') {
		$css_output = $media_output = '';
		$indent = 0;
		$prefix = str_repeat('', $indent);
		if ( !empty( $output_ar ) ) {
			foreach ($output_ar as $key => $value) {
				if ( is_array( $value ) ) {
					$selector = $key;
					$properties = array_filter( $value, 'strlen' );
					if ( !empty( $properties ) ) {
						$css_output .= $prefix . "$selector {";
						$css_output .= $prefix . powernodewt_output_css($properties);
						$css_output .= $prefix . "}";
					}
				} else {
					$property = $key;
					if ( $property != '' ) {
						$css_output .= $prefix . "$property: $value;";
					}
				}
			}

			if ( $css_output != '' && ( $min_width != '' || $max_width != '' ) ) {
				$media_output .= '@media';
				$media_output .= ( $min_width != '' ) ? '(min-width:' . $min_width . 'px)' : '';
				$media_output .= ( $min_width != '' && $max_width != '') ? ' and ' : '';
				$media_output .= ( $max_width != '' ) ? '(max-width:' . $max_width . 'px)' : '';
				$media_output .= '{' . $css_output . '}';
			} else {
				$media_output = $css_output;
			}
	
		}
	
		return $media_output;
	}
}

/**
 * Get PowerNode Templates
 */
if ( ! function_exists( 'powernodewt_get_template' ) ) {
	
	function powernodewt_get_template( $templates, $args = array() ) {
		
		if( strpos( $templates, '.php' ) === false) {
			$templates = "{$templates}.php";
		}
		
		//Located files
		$located = locate_template( $templates, false );
		
		//Filter get template
		$located = apply_filters( 'powernode_get_template', $located, $templates, $args);
		
		if ( !file_exists ( $located ) ) {
			echo sprintf( '%s does not exist.', '<code>' . $located . '</code>' );
			return;
		}
		
		//Filter arguments
		$args = apply_filters( "powernode_get_template-{$templates}", $args );
		
		if ( !empty( $args ) ) {
			extract( $args );
		}
		
		do_action( "powernode_before_get_template", $located, $templates, $args );
		
		include_once $located;
		
		do_action( "powernode_after_get_template", $located, $templates, $args );
	}
}

if ( ! function_exists( 'powernodewt_elementor_render_icon' ) ) {

	function powernodewt_elementor_render_icon( $icon, $attributes = [], $tag = 'i' ) {
		ob_start();
		\Elementor\Plugin::instance()->icons_manager->render_icon( $icon, $attributes, $tag );
		return ob_get_clean();
	}
}

/**
 * Numbered Pagination
 */
if ( ! function_exists( 'powernodewt_pagination') ) {

	function powernodewt_pagination( $query = '', $echo = true ) {
		
		if ( ! $query ) {
			global $wp_query;
			$query = $wp_query;
		}

		// Set vars
		$total  = $query->max_num_pages;
		$big    = 999999999;

		// Display pagination if total var is greater then 1 ( current query is paginated )
		if ( $total > 1 ) {

			if ( $current_page = get_query_var( 'paged' ) ) {
				$current_page = $current_page;
			} elseif ( $current_page = get_query_var( 'page' ) ) {
				$current_page = $current_page;
			} else {
				$current_page = 1;
			}
			
			// Get permalink structure
			if ( get_option( 'permalink_structure' ) ) {
				if ( is_page() ) {
					$format = 'page/%#%/';
				} else {
					$format = '/%#%/';
				}
			} else {
				$format = '&paged=%#%';
			}

			$args = apply_filters( 'powernode_pagination_args', array(
				'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
				'format'    => $format,
				'current'   => max( 1, $current_page ),
				'total'     => $total,
				'mid_size'  => 3,
				'type'      => 'list',
				'prev_text'    => '<span class="text">' . esc_html__('Previous','powernode') . '</span>',
				'next_text'    => '<span class="text">' . esc_html__('Next','powernode') . '</span>',
			) );

			// Output pagination
			if ( $echo ) {
				echo '<div class="pnwt-pagination pagination icon-20">'. wp_kses_post( paginate_links( $args ) ) .'</div>';
			} else {
				return '<div class="pnwt-pagination pagination icon-20">'. wp_kses_post( paginate_links( $args ) ) .'</div>';
			}
		}
	}

}

/**
 * Translation support
 */
if ( ! function_exists( 'powernodewt_tm_translation' ) ) {

	function powernodewt_tm_translation( $id, $val = '' ) {

		// Translate theme mod val
		if ( $val ) {

			// Polylang Translation
			if ( function_exists( 'pll__' ) && $id ) {
				$val = pll__( $val );
			}

			// Return the value
			return $val;

		}

	}
}

if ( ! function_exists( 'powernodewt_bool_text' ) ) {

	function powernodewt_bool_text( $val = '' ) {
		return ( !empty( $val ) && ( $val == 'yes' || $val == true ) ) ? 'true' : 'false';
	}
}

/**
 * Infinite Scroll Pagination
 */
if ( ! function_exists( 'powernodewt_infinite_scroll' ) ) {

	function powernodewt_infinite_scroll( $args = array() ) {

		// Load infinite scroll script
		wp_enqueue_script( 'infinite-scroll' );

		// Error text
		$error = esc_html__( 'No more pages to load', 'powernode' );
		
		$prev_posts = get_previous_posts_link( '<span aria-hidden="true">&larr;</span> '. esc_html__( 'Prev Posts', 'powernode' ) );
		$next_posts = get_next_posts_link( esc_html__( 'Next Posts', 'powernode' ) .' <span aria-hidden="true">&rarr;</span>' );
		
		// Output pagination HTML
		$output = '';
		$output .= '<div class="pnwt-pagination pagination icon-20 '.( empty( $next_posts ) ? 'last-posts' : 'next-posts' ).'">';
			$output .= '<div class="infinite-pagination" data-style="'.$args['style'].'" data-item-selector="'.$args['item-selector'].'">';
				$output .= '<div class="loader-ellips infinite-scroll-request">';
					$output .= '<span class="loader-ellips__dot"></span>';
					$output .= '<span class="loader-ellips__dot"></span>';
					$output .= '<span class="loader-ellips__dot"></span>';
					$output .= '<span class="loader-ellips__dot"></span>';
				$output .= '</div>';
				$output .= '<p class="infinite-scroll-last">'. $args['last'] .'</p>';
				$output .= '<p class="infinite-scroll-error">'. $error .'</p>';
				$output .= '<div class="infinite-scroll-nav">';
					$output .= '<div class="prev-posts">'. $prev_posts .'</div>';
					$output .= '<div class="next-posts">'. $next_posts .'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';
		
		// Load More
		if ( !empty( $next_posts ) && $args['style'] == 'load-more' ) {

			$output .= '<div class="load-more-nav text-center">';
				$output .= '<button class="button button2 load-more-button">' . $args['load_more'] . '</button>';
			$output .= '</div>';
			
		}

		echo wp_kses_post( $output );
	}
}

/**
 * Slider options
 */
if ( ! function_exists( 'powernodewt_slider_options' ) ) {

	function powernodewt_slider_options( $options = array() ) {
		
		$out_options = shortcode_atts ( array (
			'view_type' 		=> 'slider',
			'slider_nav' 		=> true,
			'slider_nav_style' 	=> 'cir',
			'slider_nav_position' => 'slider-middle',
			'slider_autoplay' => true,
			'slider_dots' => false,
		), $options );

		return apply_filters( 'powernode_slider_options', $out_options );
	}
}

/**
 * Loop attributes
 */
if ( ! function_exists( 'powernodewt_loop_atts' ) ) {

	function powernodewt_loop_atts( $atts = array() ) {
		
		$l_atts = array();
		$view_type = ( !empty( $atts['view_type'] ) ) ? $atts['view_type'] : '';
					
		if ( !empty( $atts['items_col_lg'] ) ) $l_atts['data-items'] = $atts['items_col_lg'];
		if ( !empty( $atts['items_col_lg'] ) ) $l_atts['data-items-lg'] = $atts['items_col_lg'];
		if ( !empty( $atts['items_col_md'] ) ) $l_atts['data-items-md'] = $atts['items_col_md'];
		if ( !empty( $atts['items_col_sm'] ) ) $l_atts['data-items-sm'] = $atts['items_col_sm'];
		if ( !empty( $atts['items_col_xs'] ) ) $l_atts['data-items-xs'] = $atts['items_col_xs'];
		if ( !empty( $atts['items_col_xxs'] ) ) $l_atts['data-items-xxs'] = $atts['items_col_xxs'];
		
		if ( in_array( $view_type, array( 'slider', 'micro_slider' ) ) ) {
			if ( !empty( $atts['slider_nav'] ) ) $l_atts['data-nav'] = $atts['slider_nav'];
			if ( !empty( $atts['slider_loop'] ) ) $l_atts['data-loop'] = $atts['slider_loop'];	
			if ( !empty( $atts['slider_autoplay'] ) ) $l_atts['data-auto'] = $atts['slider_autoplay'];	
			if ( !empty( $atts['slider_dots'] ) ) $l_atts['data-dots'] = $atts['slider_dots'];	
		}
		
		return $l_atts;
	}
}

if ( ! function_exists( 'powernodewt_get_nav_classes' ) ) {
	function powernodewt_get_nav_classes( $atts = array() ) {
		$classes = array();
		if ( !empty( $atts['slider_nav'] ) ) {
			$classes[] = ( !empty( $atts['slider_nav_style'] ) ) ? 'owl-nav-'.$atts['slider_nav_style'] : '';
			$classes[] = ( !empty( $atts['slider_nav_position'] ) && $atts['slider_nav_position'] == 'title-right' ) ? 'owl-nav-title-right owl-nav-small' : 'nav-slider-middle';	
		}
		return $classes;
	}
}

/*-----------------------------------------------
 * Page Layouts
 *----------------------------------------------*/

if ( ! function_exists( 'powernodewt_get_layout' ) ) {

	function powernodewt_get_layout() {
		
		$layout = get_theme_mod( 'powernode_blog_loop_post_page_layout', 'right-sidebar' );
		$sidebar = powernodewt_get_sidebar_name();
		
		$pm_layout = powernodewt_get_post_meta( 'page_layout' );
		if ( powernodewt_is_not_def_empty( $pm_layout ) ) {
			$layout = $pm_layout;
		} else if ( powernodewt_is_portfolio_archive() ) {
			$layout = get_theme_mod( 'powernode_portfolio_loop_post_page_layout', 'full-width' );
		} else if ( is_singular( 'portfolio' ) ) {
			$layout = get_theme_mod( 'powernode_portfolio_single_post_page_layout', 'right-sidebar' );
		} else if ( powernodewt_is_segment_archive() ) {
			$layout = get_theme_mod( 'powernode_segment_loop_post_page_layout', 'full-width' );
		} else if ( is_singular( 'segment' ) ) {
			$layout = get_theme_mod( 'powernode_segment_single_post_page_layout', 'right-sidebar' );
		} else if ( is_singular( 'post' ) ) {
			$layout = get_theme_mod( 'powernode_blog_single_post_page_layout', 'right-sidebar' );
	 	} else if ( is_page() ) {
			$layout = get_theme_mod( 'powernode_page_layout', 'full-width' );
	 	}

		$layout = ( !empty( $layout ) && !empty( $sidebar ) ) ? $layout : 'full-width';

		return apply_filters( 'powernode_post_page_layout', $layout );
	}
}

if ( ! function_exists( 'powernodewt_primary_columns' ) ) {

	function powernodewt_primary_columns( $classes = '' ) {

		$post_layout = powernodewt_get_layout();

		$classes = array();

		if ( $post_layout == 'full-width' ) {
			$classes = array( 'col-12', 'aside' );
		} else {
			$classes = array( 'col-12', 'col-lg-9', 'col-xl-9', 'aside' );
		}
		
		return apply_filters( 'powernode_primary_columns', $classes );
	}
}


if ( ! function_exists( 'powernodewt_sidebar_columns' ) ) {

	function powernodewt_sidebar_columns( $classes = '' ) {

		$post_layout = powernodewt_get_layout();

		$classes = array( 'col-12', 'col-lg-3', 'col-xl-3' );

		if ( $post_layout == 'left-sidebar' ) {
			$classes[] = 'aside--left';
		} else if ( $post_layout == 'right-sidebar' ) {
			$classes[] = 'aside--right';
		}

		return apply_filters( 'powernode_sidebar_columns', $classes );
	}
}

/**
 * Start Wrapper
 * Wraps all content in wrappers which match the theme markup
 */
function powernodewt_start_wrapper() {
	get_template_part( 'template-parts/powernodewt-start-wrapper' );
}

/**
 * End Wrapper
 * Closes the wrapping divs
 */
function powernodewt_end_wrapper() {
	get_template_part( 'template-parts/powernodewt-end-wrapper' );
}

/**
 * Display Topbar
 */
if ( ! function_exists( 'powernodewt_display_topbar' ) ) {
	
	function powernodewt_display_topbar() {
		
		$pm_topbar = powernodewt_get_post_meta( 'topbar' );
		if ( powernodewt_is_not_def_empty( $pm_topbar ) ) {
			$return = $pm_topbar; 
		} else {
			$return = get_theme_mod( 'powernode_topbar', false );	
		}
		$return = ( !$return ) ? false : true;
		return apply_filters( 'powernode_display_topbar', $return );
		
	}
}

/*-----------------------------------------------
 * Top Bar
 *----------------------------------------------*/
 
if ( ! function_exists( 'powernodewt_preloader' ) ) {
	
	function powernodewt_preloader() {
		
		$status = get_theme_mod( 'powernode_general_preloader', false );
		if( $status == false ) return;
		
		$html = '<div id="loader-wrapper">';
		$type = get_theme_mod( 'powernode_general_preloader_type', 'predefine' );
		$loader_img = get_theme_mod( 'powernode_general_preloader_custom_bg_image' );
		if( $type == 'custom' && !empty( $loader_img ) ) {
			$html .= '<div id="custom-loader">' . '<img src="' . $loader_img . '" />' . '</div>';
		} else {
			$html .= '<div id="loader"></div>';
		}
		
		$html .= '</div>';
		
		echo apply_filters( 'powernode_preloader', $html );
	}
	
	add_action( 'powernode_before_site', 'powernodewt_preloader' );
}

/**
 * Display top bar templates
 */

if ( ! function_exists( 'powernodewt_topbar_template' ) ) {

	function powernodewt_topbar_template() {

		// Return if no top bar
		if ( !powernodewt_display_topbar() ) {
			return;
		}

		get_template_part( 'template-parts/topbar/layout' );
	}

	add_action( 'powernode_topbar', 'powernodewt_topbar_template' );
}

/**
 * Top Bar Store Info
 */
if ( ! function_exists( 'powernodewt_topbar_store_info' ) ) {

	function powernodewt_topbar_store_info() {
		return apply_filters( 'powernode_topbar_store_info', array(
			'phone' => array(
				'label' => esc_html__( 'Contact Number', 'powernode' ),
				'icon_class' => 'flaticon-telephone',
			),
			'time' => array(
				'label' => esc_html__( 'Email', 'powernode' ),
				'icon_class' => 'flaticon-email',
			),
		) );
	}
}


/**
 * Display top bar social
 */
if ( ! function_exists( 'powernodewt_display_topbar_social' ) ) {
	
	function powernodewt_display_topbar_social() {
	
		$return = ( get_theme_mod( 'powernode_topbar_social', true ) != true ) ? false : true;
		
		return apply_filters( 'powernode_display_topbar_social', $return );
	}
}

/**
 * Topbar Social Links
 */
if ( ! function_exists( 'powernodewt_topbar_social_links' ) ) {
	
	function powernodewt_topbar_social_links() {
		
		return apply_filters( 'powernode_topbar_social_links', get_theme_mod( 'powernode_topbar_social_links') );
	}
}


/*-----------------------------------------------
 * Header
 *----------------------------------------------*/

/**
 * Header Style
 */
if ( ! function_exists( 'powernodewt_header_style_list' ) ) {

	function powernodewt_header_style_list() {

		return apply_filters( 'powernode_header_style_list', array(
					'header_v1' 		=> __( 'Header - v1 ( Transparent Light Menu )', 'powernode' ),
					'header_v2' 		=> __( 'Header - v2 ( White Menu )', 'powernode' ),
					'header_v3' 		=> __( 'Header - v3 ( Dark Menu )', 'powernode' ),
					'hidden' 			=> __( 'Hidden', 'powernode' ),
				) );
	}
}

/**
 * Header Style
 */
if ( ! function_exists( 'powernodewt_header_style' ) ) {

	function powernodewt_header_style() {
		
		$pm_style = powernodewt_get_post_meta( 'header_style' );
		if ( powernodewt_is_not_def_empty( $pm_style ) ) {
			$style = $pm_style;
		} else {
			$style = get_theme_mod( 'powernode_header_style', 'header_v2' );	
		}
		$style = ($style) ? $style : 'header_v2';

		return apply_filters( 'powernode_header_style', $style );
	}
}

/**
 * Header Classes Filter
 */
if ( ! function_exists( 'powernodewt_header_classes' ) ) {

	function powernodewt_header_classes( $classes ) {

		if ( is_array( $classes ) ) {
			$style = powernodewt_header_style();
			$is_sticky = get_theme_mod( 'powernode_header_sticky', false );
			if ( $style == 'header_v1' && $is_sticky == true && !is_404() ) {
				$classes[] = 'tra-menu navbar-light';
			} else if ( $style == 'header_v2' ) {
				$classes[] = 'tra-menu navbar-dark';
			} else if ( $style == 'header_v3' ) {
				$classes[] = 'dark-menu navbar-light';
			} else {
				$classes[] = 'white-menu navbar-dark';
			}
			$classes[] = ( powernodewt_mob_header_search_style() == 'fixed' ) ? 'fixed-mob-header-search' : '';
			$classes[] = ( $is_sticky == false ) ? 'no-sticky' : '';
		}
		
		$classes[] = 'header-search';

		return $classes;
	}
	
	add_filter( 'powernode_header_classes', 'powernodewt_header_classes' );
}

/**
 * Header template
 */
if ( ! function_exists( 'powernodewt_header_template' ) ) {

	function powernodewt_header_template() {
		
		$header_style = powernodewt_header_style();
		if ( $header_style == 'hidden' ) return;
		
		$args = array();
		$args['classes'] = array('header-wrap');
		$args['classes'][] = str_replace( '_', '-', $header_style );
		$args['classes'][] = 'header-search';
		
		powernodewt_get_template( 'template-parts/header/'.$header_style , $args );
		
	}
	add_action( 'powernode_header', 'powernodewt_header_template' );
}

/**
 * Header Logo
 */
if ( ! function_exists( 'powernodewt_header_logo' ) ){
	
	function powernodewt_header_logo() {
		$html = '<div class="desktoplogo logo-white">';
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			$html .= is_home() ? '<div class="logo logo-white">' . $logo . '</div>' : $logo;
		} else {
			$html .= '<a href="'.esc_url( home_url( '/' ) ).'" rel="home" class="site-title site-logo-text">'.esc_html( get_bloginfo( 'name' ) ).'</a>';
		}
		$html .= '</div>';
		
		echo apply_filters( 'powernode_header_logo_html', $html );
	}
	add_action( 'powernode_header_logo', 'powernodewt_header_logo' );
}

/**
 * Header Logo
 */
if ( ! function_exists( 'powernodewt_mob_header_logo_display' ) ) {
	
	function powernodewt_mob_header_logo_display () { 
	
		$mob_header_logo = get_theme_mod( 'powernode_mob_header_logo', POWERNODEWT_IMAGES_DIR_URI . 'logo.png' );
		$mob_header_logo = apply_filters ( 'powernode_mob_header_logo', $mob_header_logo );
		$site_title 	 = get_bloginfo( 'name', 'display' );
		
		$html = '<div class="logo">';
		if ( !empty( $mob_header_logo ) ) {
			$html .= '<a href="'.esc_url( home_url( '/' ) ).'" rel="home"><img class="mob-logo" src="'.$mob_header_logo.'" alt="' . esc_attr( $site_title ) . '" /></a>';
		} else {
			$html .= '<a href="'.esc_url( home_url( '/' ) ).'" rel="home" class="site-title site-logo-text">' . esc_html( get_bloginfo( 'name' ) ) . '</a>';
		}
		$html .= '</div>';
		
		echo apply_filters( 'powernode_mob_header_logo_html', $html );
	}
	add_action( 'powernode_mob_header_logo_display', 'powernodewt_mob_header_logo_display' );
}

/**
 * Header Primary Navigation
 */
if ( ! function_exists( 'powernodewt_mob_header_navigation' ) ) {
	
	function powernodewt_mob_header_navigation(){ ?>
	
		<nav id="site-navigation" class="wsmenu clearfix" role="navigation">
			<?php
			$ext_nav_list = '';
			if ( has_nav_menu( 'mobile-menu') ) {
				
				wp_nav_menu(array(
					'theme_location'    =>  'mobile-menu',
					'menu_type'         =>  'mobile-menu',
					'item_spacing'      =>  'discard',
					'menu_class'        =>  'pnwt-menu nav navbar-nav wsmenu-list nav-theme-hover',
					'items_wrap'      	=>  '<ul id="%1$s" class="%2$s">%3$s'. apply_filters ( 'powernode_header_extra_navigation', $ext_nav_list ) .'</ul>',
					'container'         => 	false,
					'fallback_cb' 		=>  'PowerNodeWT_Nav_Walker::fallback',
					'walker' 			=>  new PowerNodeWT_Nav_Walker(),
				) );
			}
			
			?>
		</nav>
		<?php
	}
	add_action( 'powernode_mob_header_navigation', 'powernodewt_mob_header_navigation' );
}

/**
 * Header Primary Navigation
 */
if ( ! function_exists( 'powernodewt_header_main_menu' ) ) {
	
	function powernodewt_header_main_menu(){ ?>
	
		<nav id="site-navigation" class="wsmenu clearfix" role="navigation">
			<?php
			$ext_nav_list = '';
			if ( is_page_template( 'page-templates/one-page.php' ) ) {
				if ( has_nav_menu( 'primary') ) {
					
					wp_nav_menu(array(
						'theme_location'    =>  'one-page-menu',
						'menu_type'         =>  'main-menu',
						'item_spacing'      =>  'discard',
						'menu_class'        =>  'pnwt-menu nav navbar-nav wsmenu-list nav-theme-hover',
						'items_wrap'     	=>  '<ul id="%1$s" class="%2$s">%3$s'. apply_filters ( 'powernode_header_extra_navigation', $ext_nav_list  ) .'</ul>',
						'container'         => 	false,
						'fallback_cb' 		=>  'PowerNodeWT_Nav_Walker::fallback',
						'walker' 			=>  new PowerNodeWT_Nav_Walker(),
					) );
				}
			} else {
				if ( has_nav_menu( 'primary') ) {
					
					wp_nav_menu(array(
						'theme_location'    =>  'primary',
						'menu_type'         =>  'main-menu',
						'item_spacing'      =>  'discard',
						'menu_class'        =>  'pnwt-menu nav navbar-nav wsmenu-list nav-theme-hover',
						'items_wrap'      	=>  '<ul id="%1$s" class="%2$s">%3$s'. apply_filters ( 'powernode_header_extra_navigation', $ext_nav_list ) .'</ul>',
						'container'         => 	false,
						'fallback_cb' 		=>  'PowerNodeWT_Nav_Walker::fallback',
						'walker' 			=>  new PowerNodeWT_Nav_Walker(),
					) );
				}
			}
			?>
		</nav>
		<?php
	}
	add_action( 'powernode_header_primary_navigation', 'powernodewt_header_main_menu' );
}

/**
 * Header Primary Navigation
 */
if ( ! function_exists( 'powernodewt_header_search_icon' ) ) {
	
	function powernodewt_header_search_icon( $items ) {
		
		$status = get_theme_mod( 'powernode_show_header_search', false );
		if( $status == false ) return $items;
			
		$items .= '<li class="menu-item item-search"><a href="javascript:void(0);" class="search-action nav-menu-icon"><span class="search-icon"><span class="flaticon-magnifying-glass"></span></span><span class="search-close">x</span></a></li>';
			
		return $items;
	}
	add_filter( 'powernode_header_extra_navigation', 'powernodewt_header_search_icon' );
}

/**
 * Header Primary Navigation Extra Content
 */
if ( ! function_exists( 'powernodewt_header_primary_extra_content' ) ) {
	
	function powernodewt_header_primary_extra_content( $items ) {
		
		$content = get_theme_mod( 'powernode_header_nav_extra_content' );
		if( empty( $content ) ) return $items;
			
		$items .= $content;
			
		return apply_filters( 'powernode_header_primary_extra_content', $items );
	}
	add_filter( 'powernode_header_extra_navigation', 'powernodewt_header_primary_extra_content' );
}

/**
 * Mobile Header Search Style
 */
if ( ! function_exists( 'powernodewt_mob_header_search_style' ) ) {

	function powernodewt_mob_header_search_style() {

		$style = get_theme_mod( 'powernode_mob_header_search_style', 'toggle' );
		$style = ($style) ? $style : 'toggle';

		return apply_filters( 'powernode_mob_header_search_style', $style );

	}

}

/**
 * Sticky Logo
 */
if ( ! function_exists( 'powernodewt_sticky_header_logo' ) ) {
	
	function powernodewt_sticky_header_logo () { 
	
		$sticky_header_logo = get_theme_mod( 'powernode_header_sticky_logo', POWERNODEWT_IMAGES_DIR_URI . '/logo.png' );
		$sticky_header_logo = apply_filters ( 'powernode_header_sticky_logo', $sticky_header_logo );
		$site_title 		= get_bloginfo( 'name', 'display' );
		$html = '<div class="desktoplogo">';
		if ( !empty( $sticky_header_logo ) ) {
			$html .= '<a class="logo-black" href="'.esc_url( home_url( '/' ) ).'" rel="home"><img class="sticky-logo" src="'.$sticky_header_logo.'" alt="' . esc_attr( $site_title ) . '" /></a>';
		} else {
			$html .= '<a href="'.esc_url( home_url( '/' ) ).'" rel="home" class="site-title site-logo-text">'.esc_html( get_bloginfo( 'name' ) ).'</a>';
		}
		
		$html .= '</div>';
	
		echo apply_filters( 'powernode_sticky_header_logo_html', $html );
	}
	add_filter( 'powernode_header_logo', 'powernodewt_sticky_header_logo' );
}

/*-----------------------------------------------
 * Page Header
 *----------------------------------------------*/

/**
 * Page header template
 */
if ( ! function_exists( 'powernodewt_page_header_template' ) ) {

	function powernodewt_page_header_template() {

		get_template_part( 'template-parts/header/page-header' );

	}

	add_action( 'powernode_before_main', 'powernodewt_page_header_template' );
}

/**
 * Return page title style
 */
if ( ! function_exists( 'powernodewt_page_title_style' ) ) {

	function powernodewt_page_title_style() {
		
		$style = get_theme_mod( 'powernode_page_title_style' );
		$pm_style = powernodewt_get_post_meta( 'page_title_style' );
		if ( powernodewt_is_not_def_empty( $pm_style ) ) {
			$style = $pm_style;
		} else if ( is_front_page() ) {
			$style = 'hidden';
		} else if ( powernodewt_is_portfolio_archive() ) {
			$style = get_theme_mod( 'powernode_portfolio_loop_post_page_title_alignment', 'centered' );
		} else if ( is_singular( 'portfolio' ) ) {
			$style = get_theme_mod( 'powernode_portfolio_single_post_page_title_alignment', 'centered' );
		} else if ( powernodewt_is_segment_archive() ) {
			$style = get_theme_mod( 'powernode_segment_loop_post_page_title_alignment', 'centered' );
		} else if ( is_singular( 'segment' ) ) {
			$style = get_theme_mod( 'powernode_segment_single_post_page_title_alignment', 'centered' );
		} else if ( powernodewt_is_blog_archive() ) {
			$style = get_theme_mod( 'powernode_blog_loop_post_page_title_alignment', 'centered' );
		} else if ( is_singular( 'post' ) ) {
			$style = get_theme_mod( 'powernode_blog_single_post_page_title_alignment', 'centered' );
		}
		
		$style = ( $style == 'default' ) ? '' : $style;
		return apply_filters( 'powernode_page_title_style', $style );

	}
}

/**
 * Display Page title
 */
if ( ! function_exists( 'powernodewt_display_page_title' ) ) {

	function powernodewt_display_page_title() {
		
		$return = true;
		$title = powernodewt_get_post_meta( 'page_title_section' );
		if ( !powernodewt_is_not_def_empty( $title ) ) {
			$title = get_theme_mod( 'powernode_page_title_section', true );
		}

		if ( powernodewt_is_portfolio_archive() ) {
			$title = get_theme_mod( 'powernode_portfolio_loop_post_page_title_section', true );
		} else if ( is_singular( 'portfolio' ) ) {
			$title = get_theme_mod( 'powernode_portfolio_single_post_page_title_section', true );
		} else if ( powernodewt_is_segment_archive() ) {
			$title = get_theme_mod( 'powernode_segment_loop_post_page_title_section', true );
		} else if ( is_singular( 'segment' ) ) {
			$title = get_theme_mod( 'powernode_segment_single_post_page_title_section', true );
		} else if ( powernodewt_is_blog_archive() ) {
			$title = get_theme_mod( 'powernode_blog_loop_post_page_title_section', true );
		} else if ( is_singular( 'post' ) ) {
			$title = get_theme_mod( 'powernode_blog_single_post_page_title_section', true );
		}
		
		if ( empty( $title ) || is_front_page() || is_page_template( 'templates/landing.php' ) || is_404() ) {
			$return = false;
		}

		return apply_filters( 'powernode_display_page_title', $return );
	}
}

/**
 * Page title
 */
if ( ! function_exists( 'powernodewt_page_title' ) ) {

	function powernodewt_page_title() {
		
		$pm_page_title = powernodewt_get_post_meta( 'page_title_title' );
		if ( powernodewt_is_not_def_empty( $pm_page_title ) ) {
			$page_title = $pm_page_title;
		} else {
			$page_title = get_theme_mod( 'powernode_page_title', true );
		}
		
		if ( ! $page_title
			|| is_front_page() ) {
			return;
		}

		$title = '';
		$post_id = powernodewt_post_id();
		
		if ( powernodewt_is_portfolio_archive() ) {
			
			$title = get_theme_mod( 'powernode_portfolio_loop_post_page_title', 'post_title' );
			if ( $title == 'hidden' ) return;
			
			if ( $title == 'custom' ) {
				$title = get_theme_mod( 'powernode_portfolio_loop_post_page_title_custom', 'Portfolio' );
			} else {
				
				if ( is_author() ) {
					$title = get_the_archive_title();
				} else if ( is_post_type_archive() ) {
					$title = post_type_archive_title( '', false );
				} else if ( is_day() ) {
					$title = sprintf( esc_html__( 'Daily Archives: %s', 'powernode' ), get_the_date() );
				} else if ( is_month() ) {
					$title = sprintf( esc_html__( 'Monthly Archives: %s', 'powernode' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'powernode' ) ) );
				} else if ( is_year() ) {
					$title = sprintf( esc_html__( 'Yearly Archives: %s', 'powernode' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'powernode' ) ) );
				} else {
					$title = single_term_title( '', false );
					if ( ! $title ) {
						global $post;
						$title = get_the_title( $post_id );
					}
				}
				
			}
		} else if ( powernodewt_is_segment_archive() ) {
			
			$title = get_theme_mod( 'powernode_segment_loop_post_page_title', 'post_title' );
			if ( $title == 'hidden' ) return;
			
			if ( $title == 'custom' ) {
				$title = get_theme_mod( 'powernode_segment_loop_post_page_title_custom', 'Portfolio' );
			} else {
				
				if ( is_author() ) {
					$title = get_the_archive_title();
				} else if ( is_post_type_archive() ) {
					$title = post_type_archive_title( '', false );
				} else if ( is_day() ) {
					$title = sprintf( esc_html__( 'Daily Archives: %s', 'powernode' ), get_the_date() );
				} else if ( is_month() ) {
					$title = sprintf( esc_html__( 'Monthly Archives: %s', 'powernode' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'powernode' ) ) );
				} else if ( is_year() ) {
					$title = sprintf( esc_html__( 'Yearly Archives: %s', 'powernode' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'powernode' ) ) );
				} else {
					$title = single_term_title( '', false );
					if ( ! $title ) {
						global $post;
						$title = get_the_title( $post_id );
					}
				}
				
			}
		} else if ( is_search() ) {
			global $wp_query;
			$title = '<span id="search-results-count">'. $wp_query->found_posts .'</span> '. esc_html__( 'Search Results Found', 'powernode' );
		} else if ( powernodewt_is_blog_archive() ) {
			
			$title = get_theme_mod( 'powernode_blog_loop_post_page_title', 'post_title' );
			if ( $title == 'hidden' ) return;
			
			if ( $title == 'custom' ) {
				$title = get_theme_mod( 'powernode_blog_loop_post_page_title_custom', 'Blog' );
			} else {
				
				if ( is_author() ) {
					$title = get_the_archive_title();
				} else if ( is_post_type_archive() ) {
					$title = post_type_archive_title( '', false );
				} else if ( is_day() ) {
					$title = sprintf( esc_html__( 'Daily Archives: %s', 'powernode' ), get_the_date() );
				} else if ( is_month() ) {
					$title = sprintf( esc_html__( 'Monthly Archives: %s', 'powernode' ), get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'powernode' ) ) );
				} else if ( is_year() ) {
					$title = sprintf( esc_html__( 'Yearly Archives: %s', 'powernode' ), get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'powernode' ) ) );
				} else {
					$title = single_term_title( '', false );
					if ( ! $title ) {
						global $post;
						$title = get_the_title( $post_id );
					}
				}
			}
		} else if ( is_404() ) {
			$title = esc_html__( '404: Page Not Found', 'powernode' );
		} else if ( $post_id ) {
			
			// Single Pages
			$pm_page_title_text = powernodewt_get_post_meta( 'page_title_text' );
			if( !empty( $pm_page_title_text ) && $pm_page_title_text == 'custom' ) {
				$title = powernodewt_get_post_meta( 'page_title_custom_text' );
			} else {
				if ( is_singular( 'page' ) || is_singular( 'attachment' ) ) {
					$title = get_the_title( $post_id );
				} else if ( is_singular( 'portfolio' ) ) {
					$title = ( in_array( $pm_page_title_text, array( '', 'default' ) ) ) ? get_theme_mod( 'powernode_portfolio_single_post_page_title', 'custom' ) : $pm_page_title_text;
					if ( $title == 'post_title' ) {
						$title = get_the_title( $post_id );
					} else if ( $title == 'custom' ) {
						$title = get_theme_mod( 'powernode_portfolio_single_post_page_title_custom', esc_html__( 'Our Portfolio', 'powernode' ) );
					}
				} else if ( is_singular( 'segment' ) ) {
					$title = ( in_array( $pm_page_title_text, array( '', 'default' ) ) ) ? get_theme_mod( 'powernode_segment_single_post_page_title', 'custom' ) : $pm_page_title_text;
					if ( $title == 'post_title' ) {
						$title = get_the_title( $post_id );
					} else if ( $title == 'custom' ) {
						$title = get_theme_mod( 'powernode_segment_single_post_page_title_custom', esc_html__( 'Our Portfolio', 'powernode' ) );
					}
				} else if ( is_singular( 'post' ) ) {
					$title = ( in_array( $pm_page_title_text, array( '', 'default' ) ) ) ? get_theme_mod( 'powernode_blog_single_post_page_title', 'custom' ) : $pm_page_title_text;
					if ( $title == 'post_title' ) {
						$title = get_the_title( $post_id );
					} else if ( $title == 'custom' ) {
						$title = get_theme_mod( 'powernode_blog_single_post_page_title_custom', esc_html__( 'Our Blog', 'powernode' ) );
					}
				}
			}
		}
		
		$title = $title ? $title : $title = get_the_title( $post_id );;
		
		return apply_filters( 'powernode_page_title', $title );
	}
}

/**
 * Display breadcrumbs
 */
if ( ! function_exists( 'powernodewt_page_title_breadcrumbs_display' ) ) {

	function powernodewt_page_title_breadcrumbs_display() {

		$display = get_theme_mod( 'powernode_page_title_breadcrumbs_display', true );
		
		if ( powernodewt_is_portfolio_archive() ) {
			$display = get_theme_mod( 'powernode_portfolio_loop_post_page_header_breadcrumb', true );
		} else if ( is_singular( 'portfolio' ) ) {
			$display = get_theme_mod( 'powernode_portfolio_single_post_page_header_breadcrumb', true );
		} else if ( powernodewt_is_segment_archive() ) {
			$display = get_theme_mod( 'powernode_segment_loop_post_page_header_breadcrumb', true );
		} else if ( is_singular( 'segment' ) ) {
			$display = get_theme_mod( 'powernode_segment_single_post_page_header_breadcrumb', true );
		} else if ( powernodewt_is_blog_archive() ) {
			$display = get_theme_mod( 'powernode_blog_loop_post_page_header_breadcrumb', true );
		} else if ( is_singular( 'post' ) ) {
			$display = get_theme_mod( 'powernode_blog_single_post_page_header_breadcrumb', true );
		}
		
		return apply_filters( 'powernode_page_title_breadcrumbs_display', $display );
	}
}

/**
 * Return Background Show
 */
if ( ! function_exists( 'powernodewt_page_title_background' ) ) {

	function powernodewt_page_title_background() {
		
		$pm_background = powernodewt_get_post_meta( 'page_title_background' );
		if ( powernodewt_is_not_def_empty( $pm_background ) ) {
			$background = $pm_background;
		} else if ( powernodewt_is_portfolio_archive() ) {
			$background = ( powernodewt_portfolio_loop_post_page_title_background() != 'hidden' ) ? true : false;
		} else if ( is_singular( 'portfolio' ) ) {
			$background = ( powernodewt_portfolio_single_post_page_title_background() != 'hidden' ) ? true : false;
		} else if ( powernodewt_is_segment_archive() ) {
			$background = ( powernodewt_segment_loop_post_page_title_background() != 'hidden' ) ? true : false;
		} else if ( is_singular( 'segment' ) ) {
			$background = ( powernodewt_segment_single_post_page_title_background() != 'hidden' ) ? true : false;
		} else if ( powernodewt_is_blog_archive() ) {
			$background = ( powernodewt_blog_loop_post_page_title_background() != 'hidden' ) ? true : false;
		} else if ( is_singular( 'post' ) ) {
			$background = ( powernodewt_blog_single_post_page_title_background() != 'hidden' ) ? true : false;
		} else {
			$background = get_theme_mod( 'powernode_page_title_background', false );
		}
		
		return apply_filters( 'powernodewt_page_title_background', $background ); 
	}
}

/**
 * Background image
 */
if ( ! function_exists( 'powernodewt_page_title_bg_image' ) ) {

	function powernodewt_page_title_bg_image() {
		
		if ( !powernodewt_page_title_background() ) {
			return;
		}
		
		$bg_image = get_theme_mod( 'powernode_page_title_bg_image', POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
	
		if ( $pm_bg_image = powernodewt_get_post_meta( 'page_title_bg_image' ) ) {
			$bg_image = wp_get_attachment_url( $pm_bg_image );
		} else if ( powernodewt_is_portfolio_archive() ) {
			if ( get_theme_mod( 'powernode_portfolio_loop_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'powernode_portfolio_loop_post_page_title_bg_image', POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			}
		} else if ( is_singular( 'portfolio' ) ) {
			if ( get_theme_mod( 'powernode_portfolio_single_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'powernode_portfolio_single_post_page_title_bg_image', POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			} else if ( get_theme_mod( 'powernode_portfolio_single_post_page_title_background', 'default' ) == 'featured_image' ) {
				$bg_image = get_the_post_thumbnail_url();
			}
		} else if ( powernodewt_is_segment_archive() ) {
			if ( get_theme_mod( 'powernode_segment_loop_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'powernode_segment_loop_post_page_title_bg_image', POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			}
		} else if ( is_singular( 'segment' ) ) {
			if ( get_theme_mod( 'powernode_segment_single_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'powernode_segment_single_post_page_title_bg_image', POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			} else if ( get_theme_mod( 'powernode_segment_single_post_page_title_background', 'default' ) == 'featured_image' ) {
				$bg_image = get_the_post_thumbnail_url();
			}
		} else if ( powernodewt_is_blog_archive() ) {
			if ( get_theme_mod( 'powernode_blog_loop_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'powernode_blog_loop_post_page_title_bg_image', POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			}
		} else if ( is_singular( 'post' ) ) {
			if ( get_theme_mod( 'powernode_blog_single_post_page_title_background', 'default' ) == 'custom' ) {
				$bg_image = get_theme_mod( 'powernode_blog_single_post_page_title_bg_image', POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg' );
			} else if ( get_theme_mod( 'powernode_blog_single_post_page_title_background', 'default' ) == 'featured_image' ) {
				$bg_image = get_the_post_thumbnail_url();
			}
		} else if ( has_post_thumbnail() ) {
			$bg_image = get_the_post_thumbnail_url();
		}
		
		return apply_filters( 'powernode_page_title_bg_image', $bg_image ); 
	}
}

/**
 * Background position
 */
if ( ! function_exists( 'powernodewt_page_title_bg_position' ) ) {

	function powernodewt_page_title_bg_position() {
		
		if ( !powernodewt_page_title_background() ) {
			return;
		}
		
		$position = get_theme_mod( 'powernode_page_title_bg_position', 'center center' );
		
		$pm_position = powernodewt_get_post_meta( 'page_title_bg_position' );
		if ( powernodewt_is_not_def_empty( $pm_position ) ) {
			$position = $pm_position;
		}
		
		return apply_filters( 'powernode_page_title_bg_position', $position ); 
	}
}

/**
 * Background attachment
 */
if ( ! function_exists( 'powernodewt_page_title_bg_attachment' ) ) {

	function powernodewt_page_title_bg_attachment() {
		
		if ( !powernodewt_page_title_background() ) {
			return;
		}
		
		$attachment = get_theme_mod( 'powernode_page_title_bg_attachment', 'initial' );
		
		$pm_attachment = powernodewt_get_post_meta( 'page_title_bg_attachment' );
		if ( powernodewt_is_not_def_empty( $pm_attachment ) ) {
			$attachment = $pm_attachment;
		}
		
		return apply_filters( 'powernode_page_title_bg_attachment', $attachment ); 
	}
}

/**
 * Background repeat
 */
if ( ! function_exists( 'powernodewt_page_title_bg_repeat' ) ) {

	function powernodewt_page_title_bg_repeat() {
		
		if ( !powernodewt_page_title_background() ) {
			return;
		}
		
		$repeat = get_theme_mod( 'powernode_page_title_bg_repeat', 'no-repeat' );
		
		$pm_repeat = powernodewt_get_post_meta( 'page_title_bg_repeat' );
		if ( powernodewt_is_not_def_empty( $pm_repeat ) ) {
			$repeat = $pm_repeat;
		}
		
		return apply_filters( 'powernode_page_title_bg_repeat', $repeat ); 
	}
}

/**
 * Background size
 */
if ( ! function_exists( 'powernodewt_page_title_bg_size' ) ) {

	function powernodewt_page_title_bg_size() {
		
		if ( !powernodewt_page_title_background() ) {
			return;
		}
		
		$size = get_theme_mod( 'powernode_page_title_bg_size', 'cover' );
		
		$pm_size = powernodewt_get_post_meta( 'page_title_bg_size' );
		if ( powernodewt_is_not_def_empty( $pm_size ) ) {
			$size = $pm_size;
		}
		
		return apply_filters( 'powernode_page_title_bg_size', $size ); 
	}
}


/**
 * Background image overlay
 */
if ( ! function_exists( 'powernodewt_page_title_bgimg_overlay' ) ) {

	function powernodewt_page_title_bgimg_overlay() {

		if ( powernodewt_page_title_background() ) {
			
			echo '<span class="page-header-bgimg-overlay"></span>';
			
		}
	}
	add_filter( 'powernode_after_page_header', 'powernodewt_page_title_bgimg_overlay' );
}


/**
 * Background overlay color
 */
if ( ! function_exists( 'powernodewt_page_title_overlay_bg_color' ) ) {

	function powernodewt_page_title_overlay_bg_color() {
		
		if ( !powernodewt_page_title_background() ) {
			return;
		}
		
		$color = get_theme_mod( 'powernode_page_title_overlay_bg_color', '' );
		
		$pm_color = powernodewt_get_post_meta( 'page_title_overlay_bg_color' );
		if ( powernodewt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'powernode_page_title_overlay_bg_color', $color ); 
	}
}

/**
 * Background overlay opacity
 */
if ( ! function_exists( 'powernodewt_page_title_bg_overlay_opacity' ) ) {

	function powernodewt_page_title_bg_overlay_opacity() {
		
		if ( !powernodewt_page_title_background() ) {
			return;
		}
		
		$opacity = get_theme_mod( 'powernode_page_title_bg_overlay_opacity', '0' );
		
		$pm_opacity = powernodewt_get_post_meta( 'page_title_bg_overlay_opacity' );
		if ( powernodewt_is_not_def_empty( $pm_opacity ) && $pm_opacity != -1 ) {
			$opacity = $pm_opacity;
		}
		
		return apply_filters( 'powernode_page_title_bg_overlay_opacity', $opacity ); 
	}
}

/**
 * Page title font size
 */
if ( ! function_exists( 'powernodewt_page_title_font_size' ) ) {

	function powernodewt_page_title_font_size() {
		
		if ( !powernodewt_page_title() ) {
			return;
		}
		
		$fontsize = get_theme_mod( 'powernode_page_title_font_size', '' );
		
		$pm_fontsize = powernodewt_get_post_meta( 'page_title_font_size' );
		if ( powernodewt_is_not_def_empty( $pm_fontsize ) ) {
			$fontsize = $pm_fontsize;
		}
		
		return apply_filters( 'powernode_page_title_font_size', $fontsize ); 
	}
}

/**
 * Page title background color
 */
if ( ! function_exists( 'powernodewt_page_title_bg_color' ) ) {

	function powernodewt_page_title_bg_color() {
		
		if ( !powernodewt_display_page_title() ) {
			return;
		}
		
		$bgcolor = get_theme_mod( 'powernode_page_title_bg_color', '' );
		
		$pm_bgcolor = powernodewt_get_post_meta( 'page_title_bg_color' );
		if ( powernodewt_is_not_def_empty( $pm_bgcolor ) ) {
			$bgcolor = $pm_bgcolor;
		}
		
		return apply_filters( 'powernode_page_title_bg_color', $bgcolor ); 
		
	}

}

/**
 * Page title text color
 */
if ( ! function_exists( 'powernodewt_page_title_text_color' ) ) {

	function powernodewt_page_title_text_color() {
		
		if ( !powernodewt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'powernode_page_title_text_color', '' );
		
		$pm_color = powernodewt_get_post_meta( 'page_title_text_color' );
		if ( powernodewt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'powernode_page_title_text_color', $color ); 
	}
}

/**
 * Page title separator color
 */
if ( ! function_exists( 'powernodewt_page_title_separator_color' ) ) {

	function powernodewt_page_title_separator_color() {
		
		if ( !powernodewt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'powernode_page_title_separator_color', '' );
		
		$pm_color = powernodewt_get_post_meta( 'page_title_separator_color' );
		if ( powernodewt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}

		return apply_filters( 'powernode_page_title_separator_color', $color ); 
	}
}

/**
 * Page title link color
 */
if ( ! function_exists( 'powernodewt_page_title_link_color' ) ) {

	function powernodewt_page_title_link_color() {
		
		if ( !powernodewt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'powernode_page_title_link_color', '' );
		
		$pm_color = powernodewt_get_post_meta( 'page_title_link_color' );
		if ( powernodewt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'powernode_page_title_link_color', $color ); 
	}
}

/**
 * Page title link hover color
 */
if ( ! function_exists( 'powernodewt_page_title_link_hover_color' ) ) {

	function powernodewt_page_title_link_hover_color() {
		
		if ( !powernodewt_display_page_title() ) {
			return;
		}
		
		$color = get_theme_mod( 'powernode_page_title_link_hover_color', '' );
		
		$pm_color = powernodewt_get_post_meta( 'page_title_link_color' );
		if ( powernodewt_is_not_def_empty( $pm_color ) ) {
			$color = $pm_color;
		}
		
		return apply_filters( 'powernode_page_title_link_hover_color', $color ); 
	}
}

/*-----------------------------------------------
 * Footer
 *----------------------------------------------*/
 
/**
 * Footer Layout List
 */
if ( ! function_exists( 'powernodewt_footer_layout_list' ) ) {

	function powernodewt_footer_layout_list() {
		
		$layouts = powernodewt_get_post_type_posts( array( 'post_type' => 'layout', 'meta_key' => '_powernode_layout_page_layout', 'meta_value'   => 'footer', 'orderby' => 'ID', 'order' => 'asc', 'not_selected' => false, 'numberposts' => '-1' ) );
		$layouts['hidden'] = esc_html__( 'Hidden', 'powernode' );
		
		return apply_filters( 'powernode_footer_layout_list', $layouts);
	}
}

/**
 * Footer Layout
 */
if ( ! function_exists( 'powernodewt_footer_layout' ) ) {

	function powernodewt_footer_layout() {
		
		$pm_layout = powernodewt_get_post_meta( 'footer_layout' );
		if ( powernodewt_is_not_def_empty( $pm_layout ) ) {
			$layout = $pm_layout;
		} else {
			$layout = get_theme_mod( 'powernode_footer_layout' );	
		}
		
		$layout = ($layout) ? $layout : '';

		return apply_filters( 'powernode_footer_layout', $layout );
	}
}

 
/**
 * Footer template
 */
if ( ! function_exists( 'powernodewt_footer_template' ) ) {

	function powernodewt_footer_template() {
		
		$layout = powernodewt_footer_layout();
		if ( $layout == 'hidden' ) return;
		
		$args = $args['atts'] = array();
		$args['layout'] = $layout;
		$args['atts']['class'] = array( 'footer', 'footer-wrap' );
		$args['atts']['class'][] = 'footer-layout-' . $layout;
		
		powernodewt_get_template( 'template-parts/footer/layout' , $args );
		
	}
	add_action( 'powernode_footer', 'powernodewt_footer_template' );
}

/*-----------------------------------------------
 * Main Page
 *----------------------------------------------*/

/**
 * Content attributes
 */
if ( ! function_exists( 'powernodewt_main_page_atts' ) ) {

	function powernodewt_main_page_atts() {

		$atts = array();

		$atts['id'] = 'main';
		$atts['class'] = powernodewt_get_main_page_classes();

		$atts = apply_filters( 'powernode_main_page_atts', $atts );
		
		return powernodewt_stringify_atts( $atts );
		
	}
}

if ( ! function_exists( 'powernodewt_get_main_page_classes' ) ) {

	function powernodewt_get_main_page_classes( $class = '' ) {

		// array of class names.
		$classes = array();

		// default class from widget area.
		$classes[] = 'site-main';

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}
		
		$el_classes = powernodewt_get_post_meta( 'page_el_classes' );
		if( !empty( $el_classes ) ) {
			$classes = array_merge( $classes, array( $el_classes  ) );
		}
		
		$classes = apply_filters( 'powernode_main_page_classes', $classes, $class );
		
		return array_unique( $classes );
	}
}

/*-----------------------------------------------
 * Primary Content
 *----------------------------------------------*/

/**
 * Content attributes
 */
if ( ! function_exists( 'powernodewt_primary_col_atts' ) ) {

	function powernodewt_primary_col_atts() {

		$atts = array();

		$atts['id'] = 'primary';
		$atts['class'] = powernodewt_stringify_classes( powernodewt_get_primary_col_class() );

		$atts = apply_filters( 'powernode_primary_col_atts', $atts );
		
		return powernodewt_stringify_atts( $atts );
		
	}
}

/**
 * Retrieve the classes for the primary column element as an array.
 */
if ( ! function_exists( 'powernodewt_get_primary_col_class' ) ) {

	function powernodewt_get_primary_col_class( $class = '' ) {

		// array of class names.
		$classes = array();

		// default class from widget area.
		$classes[] = 'content-area';

		$cont_classes = powernodewt_primary_columns();
		if ( !empty ( $cont_classes ) ) {
			$classes = array_merge( $classes, $cont_classes );
		} 

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}

		$classes = apply_filters( 'powernode_primary_col_class', $classes, $class );

		$classes = array_map( 'sanitize_html_class', $classes );

		return array_unique( $classes );
	}
}


/*-----------------------------------------------
 * Secondary Sidebar
 *----------------------------------------------*/

/**
 * Get the sidebar
 */
if ( ! function_exists( 'powernodewt_display_sidebar' ) ) {

	function powernodewt_display_sidebar() {

		// Return if full width or full screen
		if ( in_array( powernodewt_get_layout(), array( 'full-screen', 'full-width' ) ) ) {
			return;
		}
		
		get_sidebar();
	}
}

/**
 * Sidebar attributes
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'powernodewt_sidebar_atts' ) ) {

	function powernodewt_sidebar_atts() {

		$atts = array();

		$atts['itemtype'] = "https://schema.org/WPSideBar";
		$atts['itemscope'] = "itemscope";
		$atts['id'] = "secondary";
		$atts['class'] = powernodewt_stringify_classes( powernodewt_get_secondary_col_class() );

		$atts = apply_filters( 'powernode_secondary_atts', $atts );
		
		return powernodewt_stringify_atts( $atts );
		
	}
}

/**
 * Returns the sidebar
 */
if ( ! function_exists( 'powernodewt_sidebar_action' ) ) {

	function powernodewt_sidebar_action() {
		
		$action = 'powernode_after_primary';

		add_action( $action, 'powernodewt_display_sidebar' );
		
	}

	add_action( 'wp', 'powernodewt_sidebar_action', 20 );
}

/**
 * Sidebar
 */
if ( ! function_exists( 'powernodewt_get_sidebar_name' ) ) {
	
	function powernodewt_get_sidebar_name() {
		
		$sidebar = get_theme_mod( 'powernode_blog_loop_post_sidebar', 'blog-sidebar' );
		
		$pm_sidebar = powernodewt_get_post_meta( 'sidebar' );
		if ( powernodewt_is_not_def_empty( $pm_sidebar ) ) {
			$sidebar = $pm_sidebar;
		} else if ( powernodewt_is_portfolio_archive() ) {
			$sidebar = get_theme_mod( 'powernode_portfolio_loop_post_sidebar', 'portfolio-sidebar' );
		} else if ( is_singular( 'portfolio' ) ) {
			$sidebar = get_theme_mod( 'powernode_portfolio_single_post_sidebar', 'single-portfolio-sidebar' );
		} else if ( powernodewt_is_segment_archive() ) {
			$sidebar = get_theme_mod( 'powernode_segment_loop_post_sidebar', 'segment-sidebar' );
		} else if ( is_singular( 'segment' ) ) {
			$sidebar = get_theme_mod( 'powernode_segment_single_post_sidebar', 'single-segment-sidebar' );
		} else if ( is_singular( 'post' ) ) {
			$sidebar = get_theme_mod( 'powernode_blog_single_post_sidebar', 'single-post-sidebar' );
		}
		$sidebar = apply_filters( 'powernode_get_sidebar', $sidebar );
		if ( ! is_active_sidebar( $sidebar ) ) {
			$sidebar = 'sidebar-1';
			$sidebar = ( is_active_sidebar( $sidebar ) ) ? $sidebar : false;
		}
		
		return $sidebar;
	}
}

/**
 * Retrieve the classes for the secondary element as an array.
 */
if ( ! function_exists( 'powernodewt_get_secondary_col_class' ) ) {

	function powernodewt_get_secondary_col_class( $class = '' ) {

		$classes = array();

		$classes[] = 'widget-area';
		$classes[] = 'secondary';
		
		//is catalog woo
		if ( ( function_exists( 'powernodewt_is_catalog' ) && powernodewt_is_catalog() ) || ( function_exists( 'powernodewt_is_woo_single_prod' ) && powernodewt_is_woo_single_prod() )  ) {
			$classes[] = 'mobile-filter';
		}

		$sidebar_classes = powernodewt_sidebar_columns();
		if ( !empty ( $sidebar_classes ) ) {
			$classes = array_merge( $classes, $sidebar_classes );
		} 

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}

		$classes = apply_filters( 'powernode_secondary_class', $classes, $class );

		$classes = array_map( 'sanitize_html_class', $classes );

		return array_unique( $classes );
	}
}
/*-----------------------------------------------
 * Social
 *----------------------------------------------*/

/**
 * Social Links
 */
if ( ! function_exists( 'powernodewt_social_links_data' ) ) {

	function powernodewt_social_links_data() {
		
		return apply_filters( 'powernode_social_links', array(
			'facebook' => array(
				'label' => esc_html__( 'Facebook', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-facebook',
			),
			'twitter' => array(
				'label' => esc_html__( 'Twitter', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-twitter',
			),
			'instagram'  => array(
				'label' => esc_html__( 'Instagram', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-instagram',
			),
			'pinterest'  => array(
				'label' => esc_html__( 'Pinterest', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-pinterest',
			),
			'google_plus'  => array(
				'label' => esc_html__( 'Google Plus', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-google-plus',
			),
			'linkedin' => array(
				'label' => esc_html__( 'LinkedIn', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-linkedin',
			),
			'tumblr'  => array(
				'label' => esc_html__( 'Tumblr', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-tumblr',
			),
			'whatsapp'  => array(
				'label' => esc_html__( 'WhatsApp', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-whatsapp',
			),
			'github'  => array(
				'label' => esc_html__( 'Github', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-github',
			),
			'youtube' => array(
				'label' => esc_html__( 'Youtube', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-youtube',
			),
			'vimeo' => array(
				'label' => esc_html__( 'Vimeo', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-vimeo-square',
			),
			'rss'  => array(
				'label' => esc_html__( 'RSS', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-rss',
			),
			'email' => array(
				'label' => esc_html__( 'Email', 'powernode' ),
				'description' => esc_html__( 'Enter your custom links. Leave blank to hide icon.', 'powernode' ),
				'icon_class' => 'flaticon-envelope',
			),
		) );
	}
}

/**
 * Social Links Settings
 */
if ( ! function_exists( 'powernodewt_social_links_settings' ) ) {

	function powernodewt_social_links_settings() {

		return apply_filters( 'powernode_social_links_settings', get_theme_mod( 'powernode_social_links_settings' ) );
	}
}

/**
 * Social Links Display Type
 */
if ( ! function_exists( 'powernodewt_social_type' ) ) {

	function powernodewt_social_type() {

		return apply_filters( 'powernode_social_type', 'links' );
	}
}

/**
 * Social Links Display Type
 */
if ( ! function_exists( 'powernodewt_social_links_display_type' ) ) {

	function powernodewt_social_links_display_type() {

		return apply_filters( 'powernode_social_links_display_type', get_theme_mod( 'powernode_social_links_display_type', 'default' ) );
	}
}

/**
 * Social Links Icon Style
 */
if ( ! function_exists( 'powernodewt_social_links_icon_style' ) ) {

	function powernodewt_social_links_icon_style() {

		return apply_filters( 'powernode_social_links_icon_style', get_theme_mod( 'powernode_social_links_icon_style', 'default' ) );
	}
}

/**
 * Social Links Icon Shape
 */
if ( ! function_exists( 'powernodewt_social_links_icon_shape' ) ) {

	function powernodewt_social_links_icon_shape() {

		return apply_filters( 'powernode_social_links_icon_shape', get_theme_mod( 'powernode_social_links_icon_shape', 'default' ) );
	}
}

/**
 * Social Links Icon Size
 */
if ( ! function_exists( 'powernodewt_social_links_icon_size' ) ) {

	function powernodewt_social_links_icon_size() {

		return apply_filters( 'powernode_social_links_icon_size', get_theme_mod( 'powernode_social_links_icon_size', 'default' ) );
	}
}

/**
 * Social Share Links
 */
if ( ! function_exists( 'powernodewt_social_share_links_data' ) ) {

	function powernodewt_social_share_links_data( $display_type = 'settings'  ) {
		
		$social_share_links = array(
			'facebook' => array(
				'label' 		=> esc_html__( 'Facebook', 'powernode' ),
				'url' 			=> 'https://www.facebook.com/sharer/sharer.php?u={url}',
				'icon_class'	=> 'flaticon-facebook',
			),
			'twitter' => array(
				'label' => esc_html__( 'Twitter', 'powernode' ),
				'url' 			=> 'https://twitter.com/share?text={title}&amp;url={url}',
				'icon_class' => 'flaticon-twitter',
			),
			'instagram'  => array(
				'label' => esc_html__( 'Instagram', 'powernode' ),
				'url' 			=> 'https://twitter.com/share?url={title}&amp;{url}',
				'icon_class' => 'flaticon-instagram',
			),
			'pinterest'  => array(
				'label' => esc_html__( 'Pinterest', 'powernode' ),
				'url' 			=> 'https://www.pinterest.com/pin/create/button/?url={url}&amp;media={thumb_url}&amp;description={description}',
				'icon_class' => 'flaticon-pinterest',
			),
			'linkedin' => array(
				'label' => esc_html__( 'LinkedIn', 'powernode' ),
				'url' 			=> 'https://www.linkedin.com/shareArticle?mini=true&amp;url={url}&amp;title={title}',
				'icon_class' => 'flaticon-linkedin',
			),
			'whatsapp'  => array(
				'label' => esc_html__( 'WhatsApp', 'powernode' ),
				'url'  => 'https://wa.me/?text={title}',
				'icon_class' => 'flaticon-whatsapp',
			),
			'tumblr'  => array(
				'label' => esc_html__( 'Tumblr', 'powernode' ),
				'url'  => 'https://tumblr.com/widgets/share/tool?canonicalUrl={url}&amp;name={title}',
				'icon_class' => 'flaticon-tumblr',
			),
			'email'  => array(
				'label' => esc_html__( 'E-Mail', 'powernode' ),
				'url'  => 'mailto:?subject={title}&amp;body={url}',
				'icon_class' => 'flaticon-envelope',
			),
			'telegram'  => array(
				'label' => esc_html__( 'Telegram', 'powernode' ),
				'url'  => 'https://telegram.me/share/url?url={url}',
				'icon_class' => 'flaticon-telegram',
			),
			'stumbleupon'  => array(
				'label' => esc_html__( 'StumbleUpon', 'powernode' ),
				'url'  => 'http://www.stumbleupon.com/submit?url={url}&amp;title={title}',
				'icon_class' => 'flaticon-stumbleupon',
			),
			'reddit'  => array(
				'label' => esc_html__( 'Reddit', 'powernode' ),
				'url'  => 'https://reddit.com/submit?url={url}&amp;title={title}',
				'icon_class' => 'flaticon-reddit',
			),
		);
		
		return apply_filters( 'powernode_social_share_links', $social_share_links );
	}
}

/**
 * Social links share settings
 */
if ( ! function_exists( 'powernodewt_social_share_links_settings' ) ) {

	function powernodewt_social_share_links_settings() {

		return apply_filters( 'powernode_social_share_links_settings', get_theme_mod( 'powernode_social_share_links_settings' ) );
	}
}

/**
 * Social Share Links Display Type
 */
if ( ! function_exists( 'powernodewt_social_share_links_display_type' ) ) {

	function powernodewt_social_share_links_display_type() {

		return apply_filters( 'powernode_social_share_links_display_type', get_theme_mod( 'powernode_social_share_links_display_type', 'default' ) );
	}
}

/**
 * Social Share Links Icon Style
 */
if ( ! function_exists( 'powernodewt_social_share_links_icon_style' ) ) {

	function powernodewt_social_share_links_icon_style() {

		return apply_filters( 'powernode_social_share_links_icon_style', get_theme_mod( 'powernode_social_share_links_icon_style', 'default' ) );
	}
}

/**
 * Social Share Links Icon Shape
 */
if ( ! function_exists( 'powernodewt_social_share_links_icon_shape' ) ) {

	function powernodewt_social_share_links_icon_shape() {

		return apply_filters( 'powernode_social_share_links_icon_shape', get_theme_mod( 'powernode_social_share_links_icon_shape', 'default' ) );
	}
}

/**
 * Social Share Links Icon Size
 */
if ( ! function_exists( 'powernodewt_social_share_links_icon_size' ) ) {

	function powernodewt_social_share_links_icon_size() {

		return apply_filters( 'powernode_social_share_links_icon_size', get_theme_mod( 'powernode_social_share_links_icon_size', 'default' ) );
	}
}
 
 
/*-----------------------------------------------
 * Blog/Post
 *----------------------------------------------*/
 
function powernodewt_get_post_thumbnail( $size = 'thumbnail', $css_class = '', $attributes = false ) {
	
	global $post;
	return powernodewt_get_image_html( array( 'attach_id' => get_post_thumbnail_id(), 'size' => $size, 'css_class' => $css_class, 'attributes' => $attributes  ) );}

/**
 * Blog Loop Wrapper Classes
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_wrapper_classes' ) ) {

	function powernodewt_blog_loop_post_wrapper_classes( $class = '' ) {
		
		$classes = array();
		$classes[] = 'blog-posts';
		
		$view_type = powernodewt_blog_loop_view_type();
		$display_type = powernodewt_get_loop_prop( 'powernode_blog_loop_display_type' );
		$classes[] = 'view-'.$view_type;
		$classes[] = 'blog-'.$view_type;
		$classes[] = 'blog-style-'.powernodewt_get_loop_prop( 'powernode_blog_loop_post_style' );
		
	
		
		if ( in_array( $view_type, array( 'slider', 'micro-slider' ) )  ) {
			
			$classes[] = 'items-cen-cont';
			$classes[] = 'pnwt-owl-slider';
			$classes[] = 'owl-carousel';
			
			if( !in_array( $display_type, array('widget') ) ) {
				$classes[] = 'nav-on-hover';
			}
			
			$classes = array_merge( $classes, powernodewt_get_nav_classes( array( 'slider_nav' => powernodewt_get_loop_prop( 'powernode_blog_loop_slider_nav' ), 'slider_nav_position' => powernodewt_get_loop_prop( 'powernode_blog_loop_slider_nav_position' ), 'slider_nav_style' => powernodewt_get_loop_prop( 'powernode_blog_loop_slider_nav_style' ) ) ) );
			

		} else {
			
			if ( $view_type == 'grid' ) {
				$blog_grid_columns = powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_lg', 2 );
				$classes[] = 'row';
				$classes[] = 'blog-grid-'.$blog_grid_columns.'cols';
			}
			
			if ( powernodewt_is_blog_archive() && in_array( powernodewt_blog_loop_post_pagination_style(), array( 'infinite-scroll', 'load-more' ) ) ) {
				$classes[] = 'infinite-scroll-wrap';
			}
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}

		$classes = apply_filters( 'powernode_blog_loop_post_wrapper_classes', $classes, $class );
		
		return array_unique( $classes );
	}
}

/**
 * Blog Loop Wrapper Attributes
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_wrapper_atts' ) ) {

	function powernodewt_blog_loop_post_wrapper_atts() {

		$atts = array();
		
		$post_style = powernodewt_get_loop_prop( 'powernode_blog_loop_post_style', true );
		
		$atts['id'] = 'blog-1';
		if( $post_style == 'fancy' ) {
			$atts['id'] = 'blog-2';
		} else if( $post_style == 'modern' ) {
			$atts['id'] = 'blog-3';
		}
		
		$atts['class'] = powernodewt_stringify_classes( powernodewt_blog_loop_post_wrapper_classes() );
		
		$p_atts = array(
			'view_type'			=> powernodewt_blog_loop_view_type(),
			'slider_nav'		=> powernodewt_get_loop_prop( 'powernode_blog_loop_slider_nav', true ),
			'slider_loop'		=> powernodewt_get_loop_prop( 'powernode_blog_loop_slider_loop', false ),
			'slider_autoplay' 	=> powernodewt_get_loop_prop( 'powernode_blog_loop_slider_autoplay', false ),
			'slider_dots' 		=> powernodewt_get_loop_prop( 'powernode_blog_loop_slider_dots', false ),
			'items_col_lg' 		=> powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_lg' ),
			'items_col_md' 		=> powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_md' ),
			'items_col_sm' 		=> powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_sm' ),
			'items_col_xs' 		=> powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_xs' ),
			'items_col_xxs' 	=> powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_xxs', 1 ),
		);

		$atts = array_merge( $atts, powernodewt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'powernode_blog_loop_post_wrapper_atts', $atts );
		
		return powernodewt_stringify_atts( $atts );
		
	}
}

/**
 * Blog Loop Post Classes
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_classes' ) ) {

	function powernodewt_blog_loop_post_classes( $class = '' ) {
		
		$classes = array();		
		$display_type = powernodewt_get_loop_prop( 'powernode_blog_loop_display_type' );
		$view_type = powernodewt_blog_loop_view_type();
		
		if ( in_array( $view_type, array( 'slider', 'micro-slider' ) )  ) {
			$classes[] = 'slider-item';
		} else {
			$nums_rows = powernodewt_get_loop_prop('nums_rows');
			$classes[] = $display_type . '-item-entry';
			if ( $view_type == 'grid' ) {
				$classes[] = powernodewt_cols_class( 'lg', powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_lg' ) );
				$classes[] = powernodewt_cols_class( 'md', powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_md' ) );
				$classes[] = powernodewt_cols_class( 'sm', powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_sm' ) );
				$classes[] = powernodewt_cols_class( 'xs', powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_xs' ) );
				$classes[] = powernodewt_cols_class( 'xxs', powernodewt_get_loop_prop( 'powernode_blog_loop_items_col_xxs' ) );
			}
		}
		
		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}
			$classes = array_merge( $classes, $class );

		} else {
			$class = array();
		}
		
		
		$classes = array_merge( $classes, get_post_class() );

		$classes = apply_filters( 'powernode_blog_loop_post_wrapper_classes', $classes, $class );

		$classes = array_map( 'sanitize_html_class', $classes );

		return array_unique( $classes );
	}
}

/**
 * Blog Loop Post Attributes
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_atts' ) ) {

	function powernodewt_blog_loop_post_atts() {

		$atts = array();

		$atts['class'] = powernodewt_blog_loop_post_classes();
		
		$p_atts = array(
			'id'			=> 'post-'.get_the_ID(),
		);

		$atts = array_merge( $atts, powernodewt_loop_atts( $p_atts ) );

		$atts = apply_filters( 'powernode_blog_loop_post_atts', $atts );
		
		return powernodewt_stringify_atts( $atts );
	}
}
 
/**
 * Blog Loop View Type
 */
if ( ! function_exists( 'powernodewt_blog_loop_view_type' ) ) {

	function powernodewt_blog_loop_view_type() {
		
		$view_type = powernodewt_get_loop_prop( 'powernode_blog_loop_view_type' );
		if ( empty( $view_type ) ) {
			$view_type = get_theme_mod( 'powernode_blog_loop_view_type', 'list' );
		}
		
		return apply_filters( 'powernode_blog_loop_view_type', $view_type );
	}
}

/**
 * Returns header background
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_page_title_background' ) ) {

	function powernodewt_blog_loop_post_page_title_background() {

		return apply_filters( 'powernode_blog_loop_post_page_title_background', get_theme_mod( 'powernode_blog_loop_post_page_title_background', 'hidden' ) );
	}
}
 
/**
 * Returns sections loop post positioning
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_sections_positioning' ) ) {

	function powernodewt_blog_loop_post_sections_positioning() {
		
		$sections = powernodewt_get_loop_prop( 'powernode_blog_loop_post_sections_positioning' );
		
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'powernode_blog_loop_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Returns sections single post positioning
 */
if ( ! function_exists( 'powernodewt_blog_single_post_sections_positioning' ) ) {

	function powernodewt_blog_single_post_sections_positioning() {

		$sections = array( 'categories', 'title', 'meta', 'thumbnail', 'content', 'tags', 'author-info', 'related-posts', 'comments' );
		
		$sections = get_theme_mod( 'powernode_blog_single_post_sections_positioning', $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'powernode_blog_single_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Loop Post : Blog Style
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_style' ) ) {
	
	function powernodewt_blog_loop_post_style() {
		
		$style = get_theme_mod( 'powernode_blog_loop_post_style', 'default' );
		if ( in_array( powernodewt_get_loop_prop( 'powernode_blog_loop_view_type' ), array( 'full', 'list', 'modern' ) ) ) {
			$style = 'default';
		}
		return $style;
	}
}

/**
 * Returns Content Limit
 */
if ( ! function_exists( 'powernodewt_content_limit' ) ) {
	
	function powernodewt_content_limit( $content, $length, $more = '' ) {
		
		$content = wp_trim_words( $content, $length );
		$content = preg_replace('`\[[^\]]*\]`','',$content);
		$content = stripslashes( wp_filter_nohtml_kses( $content ) );

		if ( $more ) {
			$output = sprintf(
				'<p>%s <a href="%s" class="more-link" title="%s">%s</a></p>',
				$content,
				get_permalink(),
				sprintf( esc_html__( 'Continue reading &quot;%s&quot;', 'powernode' ), the_title_attribute( 'echo=0' ) ),
				esc_html( $more )
			);
		} else {
			$output = sprintf( '%s', $content );
		}
		
		return $output;
	}
}
 
/**
 * Returns blog meta
 */
if ( ! function_exists( 'powernodewt_blog_post_meta' ) ) {

	function powernodewt_blog_post_meta() {

		$display_type = powernodewt_get_loop_prop( 'powernode_blog_loop_display_type' );
		$sections = array( 'author', 'date', 'comments' );
		$option_name = 'powernode_blog_loop_post_meta';
		
		if ( is_singular( 'post' ) && !in_array( $display_type, array( 'related_posts' ) ) ) {
			$option_name = 'powernode_blog_single_post_meta';
		}
		
		$sections = powernodewt_get_loop_prop( $option_name, $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}

		$sections = apply_filters( $option_name, $sections );

		return $sections;

	}
}

/**
 * Returns reading time
*/
if ( ! function_exists( 'powernodewt_reading_time' ) ) {

	function powernodewt_reading_time() {

		global $post;

		$content      = get_post_field( 'post_content', $post->ID );
		$word_count   = str_word_count( strip_tags( $content ) );
		$reading_time = ceil( $word_count / 200 );

		$rwp_reading_time = $reading_time . " " . esc_html__( 'min read', 'powernode' );
		return apply_filters( 'powernodewt_post_reading_time', $rwp_reading_time );
	}}

/**
 * Returns the pagination style
 */
if ( ! function_exists( 'powernodewt_blog_loop_post_pagination_style' ) ) {

	function powernodewt_blog_loop_post_pagination_style() {

		return apply_filters( 'powernode_blog_loop_post_pagination_style', get_theme_mod( 'powernode_blog_loop_post_pagination_style', 'default' ) );
	}
}

/**
 * Single Post Returns header background
 */
if ( ! function_exists( 'powernodewt_blog_single_post_page_title_background' ) ) {

	function powernodewt_blog_single_post_page_title_background() {

		return apply_filters( 'powernode_blog_single_post_page_title_background', get_theme_mod( 'powernode_blog_single_post_page_title_background', 'hidden' ) );
	}
}

/**
 * Single post social share links
 */
if ( ! function_exists( 'ctm_powernode_blog_single_post_social_share_links' ) ) {
	
	function ctm_powernode_blog_single_post_social_share_links() {
		
		return apply_filters( 'powernode_blog_single_post_social_share_links', get_theme_mod( 'powernode_blog_single_post_social_share_links') );
	}
}

/**
 * Single post social share links settings
 */
if ( ! function_exists( 'ctm_powernode_blog_single_post_social_share_links_settings' ) ) {
	
	function ctm_powernode_blog_single_post_social_share_links_settings() {
		
		return apply_filters( 'powernode_blog_single_post_social_share_links_settings', get_theme_mod( 'powernode_blog_single_post_social_share_links_settings') );
	}
}

if ( ! function_exists( 'powernodewt_blog_loop_latest_articles_atts' ) ) {

	function powernodewt_blog_loop_latest_articles_atts( $args = array() ) {
		
		$atts = array(); 
		$status = get_theme_mod( 'powernode_blog_loop_latest_articles_section', true );
		if( $status ) {
			
			$default_args = array(
				'posts_per_page' => apply_filters( 'powernode_blog_loop_latest_articles_limit', absint( get_theme_mod( 'powernode_blog_loop_latest_articles_limit', 2 ) ) ),
				'orderby'        => 'id',
				'order'        	 => 'desc',
				'no_found_rows'  => true,
				'post__not_in'  => ( !empty( $args['exclude_posts'] ) ) ? $args['exclude_posts'] : '',
			);
							
			$args = wp_parse_args( $args, $default_args );
			$args = apply_filters( 'powernode_blog_loop_post_latest_posts_query_args', $args );
			
			$atts['display_type'] 			= 'latest-posts';
			$atts['query_args'] 			= $args;
			$atts['view_type'] 				= 'list';
			$atts['blog_loop_post_tags'] 	= true;
			$atts['el_classes'] 			= 'latest-posts post-column-reverse';
			
			if( $title = get_theme_mod( 'powernode_blog_loop_latest_articles_section_title', 'Latest Articles' ) ) {
				$atts['sec_title'] = '<h5 class="sec-title h5-xs border-bottom w-100 pb-3 mb-4">' . $title . '</h5>';
			}
		}
		return $atts;
	}
}

/**
 * Blog loop post show latest articles
 */
if ( !function_exists( 'powernodewt_latest_articles' ) ) {

	function powernodewt_latest_articles( $args = array() ) {
		
		$atts = powernodewt_blog_loop_latest_articles_atts( $args );
		if( !empty( $atts['query_args'] ) ) {
			$posts = get_posts( $atts['query_args'] );
			if( function_exists('powernodewt_blog') && !empty( $atts ) && count( $posts ) > 0 && ( !empty( $args['display_type'] ) && $args['display_type'] == 'loop' ) && $args['items_count'] == 1 ) {
				
				echo powernodewt_blog( $atts );
				
				// Set main loop item count
				if( isset( $args['items_count'] ) ) $GLOBALS['items_count'] = $args['items_count'];
				if( !empty( $args['display_type'] ) ) $GLOBALS['display_type'] = $args['display_type'];
			}
		}
	}
	add_action( 'powernode_outer_before_loop_post_start', 'powernodewt_latest_articles', 10 );
}

/**
 * Blog loop post show latest article
 */
if ( function_exists('powernodewt_blog') && !function_exists( 'powernodewt_loop_post_subatts' ) ) {

	function powernodewt_loop_post_subatts( $sub_atts, $args = array() ) {
		
		$atts = powernodewt_blog_loop_latest_articles_atts( $args );
		if( !empty( $atts['query_args'] ) ) {
			$posts = get_posts( $atts['query_args'] );
			if( !empty( $atts ) && count( $posts ) > 0 && ( !empty( $args['display_type'] ) && $args['display_type'] == 'loop' ) && $args['items_count'] == 0 ) {
				
				if( in_array( 'b-bottom', $sub_atts['class'] ) ) {
					unset( $sub_atts['class'][array_search( 'b-bottom', $sub_atts['class'] )] ); 
				}
			}
		}
		return $sub_atts;
	}
	add_filter( 'powernode_loop_post_subatts', 'powernodewt_loop_post_subatts', 10, 2 );
}

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
if ( ! function_exists( 'powernodewt_do_shortcode' ) ) {
	
	function powernodewt_do_shortcode( $tag, array $atts = array(), $content = null ) {
		global $shortcode_tags;

		if ( ! isset( $shortcode_tags[ $tag ] ) ) {
			return false;
		}

		$content = call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
		
		// Replace {{Y}} or {Y} with the current year
		$content = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $content );
		
		return $content;
	}
}

/**
 * Check is catalog
 */
if ( ! function_exists( 'powernodewt_is_catalog' ) ) {
	function powernodewt_is_catalog() {
		return false;
	}
}

/*-----------------------------------------------
 * Portfolio
 *----------------------------------------------*/
 
if( ! function_exists( 'powernodewt_is_portfolio_archive' ) ) {
	
	function powernodewt_is_portfolio_archive() {
		return ( is_post_type_archive('portfolio') || is_tax('portfolio-cat') || is_tax('portfolio-skills') );
	}
}

/*-----------------------------------------------
 * Portfolio
 *----------------------------------------------*/
 
 if( ! function_exists( 'powernodewt_is_segment_archive' ) ) {
	
	function powernodewt_is_segment_archive() {
		return ( is_post_type_archive('segment') || is_tax('segment-cat') || is_tax('segment-skills') );
	}
}

/**
 * Returns header background
 */
if ( ! function_exists( 'powernodewt_portfolio_loop_post_page_title_background' ) ) {

	function powernodewt_portfolio_loop_post_page_title_background() {

		return apply_filters( 'powernode_portfolio_loop_post_page_title_background', get_theme_mod( 'powernode_portfolio_loop_post_page_title_background', 'hidden' ) );

	}
}
/**
 * Returns header background
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_page_title_background' ) ) {

	function powernodewt_segment_loop_post_page_title_background() {

		return apply_filters( 'powernode_segment_loop_post_page_title_background', get_theme_mod( 'powernode_segment_loop_post_page_title_background', 'hidden' ) );

	}
}

/**
 * Single Portfolio Post Returns header background
 */
if ( ! function_exists( 'powernodewt_portfolio_single_post_page_title_background' ) ) {

	function powernodewt_portfolio_single_post_page_title_background() {
		return apply_filters( 'powernode_portfolio_single_post_page_title_background', get_theme_mod( 'powernode_portfolio_single_post_page_title_background', 'hidden' ) );
	}
}

/**
 * Single Portfolio Post Returns header background
 */
if ( ! function_exists( 'powernodewt_segment_single_post_page_title_background' ) ) {

	function powernodewt_segment_single_post_page_title_background() {
		return apply_filters( 'powernode_segment_single_post_page_title_background', get_theme_mod( 'powernode_segment_single_post_page_title_background', 'hidden' ) );
	}
}

/**
 * Returns sections single portfolio positioning
 */
if ( ! function_exists( 'powernodewt_portfolio_single_post_sections_positioning' ) ) {

	function powernodewt_portfolio_single_post_sections_positioning() {

		$sections = array( 'categories', 'title', 'content', 'tags', 'social-links', 'author-info', 'next-prev', 'related-portfolio' );
		
		if( !$show_categories = powernodewt_get_post_meta( 'portfolio_show_categories' ) ) if (($key = array_search('categories', $sections)) !== false) unset($sections[$key]);
		if( !$show_title = powernodewt_get_post_meta( 'portfolio_show_title' ) ) if (($key = array_search('title', $sections)) !== false) unset($sections[$key]);
		if( !$show_social = powernodewt_get_post_meta( 'portfolio_show_share' ) ) if (($key = array_search('social-links', $sections)) !== false) unset($sections[$key]);
		
		$sections = get_theme_mod( 'powernode_portfolio_single_post_sections_positioning', $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'powernode_portfolio_single_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Returns sections single segment positioning
 */
if ( ! function_exists( 'powernodewt_segment_single_post_sections_positioning' ) ) {

	function powernodewt_segment_single_post_sections_positioning() {

		$sections = array( 'categories', 'title', 'content', 'tags', 'social-links', 'author-info', 'next-prev', 'related-segment' );
		
		if( !$show_categories = powernodewt_get_post_meta( 'segment_show_categories' ) ) if (($key = array_search('categories', $sections)) !== false) unset($sections[$key]);
		if( !$show_title = powernodewt_get_post_meta( 'segment_show_title' ) ) if (($key = array_search('title', $sections)) !== false) unset($sections[$key]);
		if( !$show_social = powernodewt_get_post_meta( 'segment_show_share' ) ) if (($key = array_search('social-links', $sections)) !== false) unset($sections[$key]);
		
		$sections = get_theme_mod( 'powernode_segment_single_post_sections_positioning', $sections );

		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'powernode_segment_single_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Returns sections loop post positioning
 */
if ( ! function_exists( 'powernodewt_portfolio_loop_post_sections_positioning' ) ) {

	function powernodewt_portfolio_loop_post_sections_positioning() {
		
		$sections = powernodewt_get_loop_prop( 'powernode_portfolio_loop_post_sections_positioning' );
		
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'powernode_portfolio_loop_post_sections_positioning', $sections );

		return $sections;
	}
}

/**
 * Returns sections loop post positioning
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_sections_positioning' ) ) {

	function powernodewt_segment_loop_post_sections_positioning() {
		
		$sections = powernodewt_get_loop_prop( 'powernode_segment_loop_post_sections_positioning' );
		
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'powernode_segment_loop_post_sections_positioning', $sections );

		return $sections;
	}
}
/**
 * Returns sections loop post positioning
 */
if ( ! function_exists( 'powernodewt_segment_loop_post_sections_positioning' ) ) {

	function powernodewt_segment_loop_post_sections_positioning() {
		
		$sections = powernodewt_get_loop_prop( 'powernode_segment_loop_post_sections_positioning' );
		
		if ( $sections && ! is_array( $sections ) ) {
			$sections = explode( ',', $sections );
		}
		$sections = apply_filters( 'powernode_segment_loop_post_sections_positioning', $sections );

		return $sections;
	}
}