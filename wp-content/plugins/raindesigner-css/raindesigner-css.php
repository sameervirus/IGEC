<?php
/*
 * Plugin Name: Raindesigner CSS
 * Description: This plugin for add modified style to the theme
 * Author: Samir Nabil <raindesigner.com>
 * Version: 1.0.0
 */
// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function add_theme_css() {
    wp_enqueue_style( 'raindesigner', plugin_dir_url( __FILE__ ). 'raindesigner.css?a=' . time() );
}
add_action('wp_enqueue_scripts', 'add_theme_css');