<?php
/**
 * Import / Export
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class PowerNodeWT_Import_Export {
	
	/**
	 * An array of core options that shouldn't be imported.
	 */
	static private $core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);
	
	public function __construct() {
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		if ( isset( $_REQUEST['wt-cie-import'] ) && isset( $_FILES['wt-cie-import-file'] ) ) {
			self::_import();
		}
	}
	
	public function admin_menu() {
		
		if ( !current_user_can( 'administrator' ) ) {
			return;
		}
		
		add_submenu_page( 'powernode-customizer-import-export', 'PowerNode Cutomizer Import / Export', 'Customizer Import / Export', 'manage_options', 'powernode-customizer-import-export', array( $this, 'customizer_import_export_page' ), 5  );
		
	}
	
	public function customizer_import_export_page() {
		require_once POWERNODEWT_ADMIN . '/views/header.php';
		require_once POWERNODEWT_ADMIN . '/views/customizer-import-export.php';
		require_once POWERNODEWT_ADMIN . '/views/footer.php';
	}
	
	/**
	 * Check to see if we need to do an export or import.
	 * This should be called by the customize_register action.
	 *
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static public function customize_register( $wp_customize )
	{
		if ( current_user_can( 'edit_theme_options' ) ) {
			if ( isset( $_REQUEST['wt-cie-export'] ) ) {
				self::_export( $wp_customize );
			}
		}
	}
	
	static private function _export( $wp_customize )
	{
		if ( ! wp_verify_nonce( $_REQUEST['wt-cie-export'], 'wt-cie-exporting' ) ) {
			return;
		}

		$theme		= get_stylesheet();
		$template	= get_template();
		$charset	= get_option( 'blog_charset' );
		$mods		= get_theme_mods();
		$data		= array(
						  'template'  => $template,
						  'mods'	  => $mods ? $mods : array(),
						  'options'	  => array()
					  );

		// Get options from the Customizer API.
		$settings = $wp_customize->settings();

		foreach ( $settings as $key => $setting ) {

			if ( 'option' == $setting->type ) {

				// Don't save widget data.
				if ( 'widget_' === substr( strtolower( $key ), 0, 7 ) ) {
					continue;
				}

				// Don't save sidebar data.
				if ( 'sidebars_' === substr( strtolower( $key ), 0, 9 ) ) {
					continue;
				}

				// Don't save core options.
				if ( in_array( $key, self::$core_options ) ) {
					continue;
				}

				$data['options'][ $key ] = $setting->value();
			}
		}

		// Plugin developers can specify additional option keys to export.
		$option_keys = apply_filters( 'wt_cie_export_option_keys', array() );

		foreach ( $option_keys as $option_key ) {
			$data['options'][ $option_key ] = get_option( $option_key );
		}

		if( function_exists( 'wp_get_custom_css_post' ) ) {
			$data['wp_css'] = wp_get_custom_css();
		}

		// Set the download headers.
		header( 'Content-disposition: attachment; filename=' . $theme . '-export.dat' );
		header( 'Content-Type: application/octet-stream; charset=' . $charset );

		// Serialize the export data.
		echo serialize( $data );

		// Start the download.
		die();
	}
	
	/**
	 * Imports uploaded mods and calls WordPress core customize_save actions so
	 * themes that hook into them can act before mods are saved to the database.
	 *
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function _import()
	{
		// Make sure we have a valid nonce.
		if ( ! wp_verify_nonce( $_REQUEST['wt-cie-import'], 'wt-cie-importing' ) ) {
			return;
		}

		// Make sure WordPress upload support is loaded.
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		// Setup global vars.
		global $wp_customize;
		global $cie_error, $cie_success;

		// Setup internal vars.
		$cie_error	 = false;
		$cie_success = false;
		$template	 = get_template();
		$overrides   = array( 'test_form' => false, 'test_type' => false, 'mimes' => array('dat' => 'text/plain') );
		$file        = wp_handle_upload( $_FILES['wt-cie-import-file'], $overrides );

		// Make sure we have an uploaded file.
		if ( isset( $file['error'] ) ) {
			$cie_error = $file['error'];
			return;
		}
		if ( ! file_exists( $file['file'] ) ) {
			$cie_error = __( 'Error importing settings! Please try again.', 'powernode' );
			return;
		}

		global $wp_filesystem;
		// Get the upload data.
		WP_Filesystem();
		$raw  = $wp_filesystem->get_contents( $file['file'] );
		$data = @unserialize( $raw );

		// Remove the uploaded file.
		unlink( $file['file'] );

		// Data checks.
		if ( 'array' != gettype( $data ) ) {
			$cie_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'powernode' );
			return;
		}
		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			$cie_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'powernode' );
			return;
		}
		if ( $data['template'] != $template ) {
			$cie_error = __( 'Error importing settings! The settings you uploaded are not for the current theme.', 'powernode' );
			return;
		}

		// If wp_css is set then import it.
		if( function_exists( 'wp_update_custom_css_post' ) && isset( $data['wp_css'] ) && '' !== $data['wp_css'] ) {
			wp_update_custom_css_post( $data['wp_css'] );
		}
		
		// Import the file
		if ( ! empty( $data['mods'] ) ) {

			// Loop through mods and add them
			foreach ( $data['mods'] as $mod => $value ) {
				set_theme_mod( $mod, $value );
			}

			// Success message
			$cie_success  = esc_attr__( 'Settings imported successfully.', 'powernode' );
		}
		else {
			$cie_error = esc_attr__( 'No import data found.', 'powernode' );
		}
	}
}

new PowerNodeWT_Import_Export();