<?php
/**
 * Widget Functions
 *
 * Widget related functions and widget registration.
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */


if ( !defined( 'ABSPATH' ) ) exit;

define( 'POWERNODEWT_CORE_WIDGETS_DIR', POWERNODEWT_CORE_INC_DIR . 'widgets' );

require_once POWERNODEWT_CORE_WIDGETS_DIR . '/wph-widget-class.php';
require_once POWERNODEWT_CORE_WIDGETS_DIR . '/class-widget-image-box.php';
require_once POWERNODEWT_CORE_WIDGETS_DIR . '/class-widget-blog.php';
require_once POWERNODEWT_CORE_WIDGETS_DIR . '/class-widget-posts.php';

/**
 * Register Widgets.
 */
function powernodewt_register_widgets() {
	
	register_widget( 'PowerNode_Widget_Image_Box' );
	register_widget( 'PowerNode_Widget_Blog' );
	register_widget( 'PowerNode_Widget_Posts' );
}
add_action( 'widgets_init', 'powernodewt_register_widgets' );
