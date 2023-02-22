<?php
/**
 * Customizer Sanitizes
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 * @since  1.0.0
 */
function powernodewt_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 * @since  1.0.0
 */
function powernodewt_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Number sanitization callback
 *
 * @since 1.0.0
 */
function powernodewt_sanitize_number( $val ) {
	return is_numeric( $val ) ? $val : 0;
}


function powernodewt_sanitize_color( $color ) {
    if ( empty( $color ) || is_array( $color ) )
        return '';

    // If string does not start with 'rgba', then treat as hex
    // sanitize the hex color and finally convert hex to rgba
    if ( false === strpos( $color, 'rgba' ) ) {
        return sanitize_hex_color( $color );
    }

    // By now we know the string is formatted as an rgba color so we need to further sanitize it.
    $color = str_replace( ' ', '', $color );
    sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
    return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
}

/**
 * Sanitize Image
 */
function powernodewt_sanitize_image( $file, $setting ) {
  
	//allowed file types
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'ico'          => 'image/x-icon'
	);
	  
	//check file type from file name
	$file_ext = wp_check_filetype( $file, $mimes );
	  
	//if file has a valid mime type return it, otherwise return default
	return ( $file_ext['ext'] ? $file : $setting->default );
}

/**
 * PowerNodeWT Sanitize Hex Color
 *
 * @param string $color The color as a hex.
 */
function powernodewt_sanitize_hex_color( $color ) {
	_deprecated_function( 'powernodewt_sanitize_hex_color', '2.0', 'sanitize_hex_color' );

	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}

/**
 * Number Range sanitization callback example.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 * 
 * Sanitization callback for 'number' or 'tel' type text inputs. This callback sanitizes
 * `$number` as an absolute integer within a defined min-max range.
 * 
 * @see absint() https://developer.wordpress.org/reference/functions/absint/
 *
 * @param int                  $number  Number to check within the numeric range defined by the setting.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int|string The number, if it is zero or greater and falls within the defined range; otherwise,
 *                    the setting default.
 */
function powernodewt_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}
	
/**
 * Select sanitization callback
 */
function powernodewt_sanitize_select( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function powernodewt_validate_image( $validity, $value ) {

  // Get the url of the image
  $image = wp_get_attachment_image_src( $value )[0];

  /*
  * Array of valid image file types.
  *
  * The array includes image mime types that are included in wp_get_mime_types()
  */
  $mimes = array(
      'jpg|jpeg|jpe' => 'image/jpeg',
      'gif'          => 'image/gif',
      'png'          => 'image/png',
      'bmp'          => 'image/bmp',
      'tif|tiff'     => 'image/tiff',
      'ico'          => 'image/x-icon'
  );
  // Return an array with file extension and mime_type.
  $file = wp_check_filetype( $image, $mimes );
  
  if( !$value ) {
    // If no image has been chosen, instruct user to choose an image
    $validity->add( 'required', __( 'Please choose an image', 'powernode' ) );
  } elseif ( !$file['ext'] ) {
    // If a valid image file extension is not found, instruct user to choose appropriate image
    $validity->add( 'not_valid', __( 'Please choose a valid image type', 'powernode' ) );
  }
  return $validity;
}

/**
 * Select choices sanitization callback
 */
function powernodewt_sanitize_multi_choices( $input, $setting ) {
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	$input_keys = $input;

	foreach ( $input_keys as $key => $value ) {
		if ( ! array_key_exists( $value, $choices ) ) {
			unset( $input[ $key ] );
		}
	}

	// If the input is a valid key, return it;
	// otherwise, return the default.
	return ( is_array( $input ) ? $input : $setting->default );
}