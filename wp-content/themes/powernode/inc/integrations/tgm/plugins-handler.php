<?php
require_once POWERNODEWT_INC_DIR .'integrations/tgm/class-tgm-plugin-activation.php';

class PowerNodeWT_Plugins_Handler {
	
	protected static $instance = null;

	/**
	 * Retrieves class instance
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance 	= new self;
		}

		return self::$instance;
	}

	/**
	 * Construct
	 */
	public function __construct() {
		add_action( 'tgmpa_register', array( $this, 'powernodewt_register_required_plugins' ) );
		add_action( 'vc_before_init', array( $this, 'powernodewt_vc_set_as_theme' ) );
		add_action( 'wp_ajax_install_plugins', array( $this, 'install_plugins') );
		add_action( 'wp_ajax_plugin_process', array( $this, 'plugin_process') );
		add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
	}
	
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variables passed to the `tgmpa()` function should be:
	 * - an array of plugin arrays;
	 * - optionally a configuration array.
	 * If you are not changing anything in the configuration array, you can remove the array and remove the
	 * variable from the function call: `tgmpa( $plugins );`.
	 * In that case, the TGMPA default settings will be used.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
	 */
	function powernodewt_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			
			array(
				'name'               => 'PowerNodeWT Core',
				'slug'               => 'powernodewt-core',
				'source'             => $this->get_tgm_powernodewt_plugins_path('powernodewt-core.zip'),
				'required'           => true,
			),
			array(
				'name'               => 'Slider Revolution',
				'slug'               => 'revslider',
				'source'             => $this->get_tgm_powernodewt_plugins_path('revslider.zip'),
				'required'           => true,
			),
			array(
				'name'               => 'Elementor Page Builder',
				'slug'               => 'elementor',
				'required'           => true,
			),
			array(
				'name'               => 'One Click Demo Import',
				'slug'               => 'one-click-demo-import',
				'required'           => true,
			),
			array(
				'name'               => 'MC4WP: Mailchimp for WordPress',
				'slug'               => 'mailchimp-for-wp',
				'required'           => true,
			),
			array(
				'name'               => 'Contact Form 7',
				'slug'               => 'contact-form-7',
				'required'           => true,
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'powernode',             // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'powernode-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
	
	/**
	 * Get path
	 */
	function get_tgm_powernodewt_plugins_path( $plugin_name ) {
		if ( !empty( $plugin_name ) ) {
			return 'https://wpdemo.wttechdesign.com/plugins/'.$plugin_name;
		}
	}
	
	// Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the  Settings-> Visual Composer page
	public function powernodewt_vc_set_as_theme() {
		vc_set_as_theme();
	}
	
	/**
	 * Check capability for handling plugins
	 */
	public function tgmpa_load( $status ) {
		return is_admin() || current_user_can( 'install_themes' );
	}
	
	/**
     * get required plugins
     */
    public function _get_plugins() {
		
        $instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
        $plugins  = array(
            'all'      => array(), // Meaning: all plugins which still have open actions.
            'install'  => array(),
            'update'   => array(),
            'activate' => array(),
        );

        foreach ( $instance->plugins as $slug => $plugin ) {
			$plugins['all'][ $slug ] = $plugin;
            if ( ( !empty( $instance->plugins[ $slug ]['is_callable'] ) ) && false === $instance->does_plugin_have_update( $slug ) ) {
                continue;
            } else {
                if ( ! $instance->is_plugin_installed( $slug ) ) {
                    $plugins['install'][ $slug ] = $plugin;
                } else {
                    if ( false !== $instance->does_plugin_have_update( $slug ) ) {
                        $plugins['update'][ $slug ] = $plugin;
                    }

                    if ( $instance->can_plugin_activate( $slug ) ) {
                        $plugins['activate'][ $slug ] = $plugin;
                    }
                }
            }
        }

        return $plugins;
    }
	
	/*
	 * Plugin Process
	 */
	public function _plugin_process ( $slug ) {
		
		$button_classes = array( 'button', 'pnwt-process-button' );
		$keys = $messages = array();
		$actions = array(
			'install'   => '',
			'update'    => '',
			'activate'  => ''
		);
		
		$plugins = $this->_get_plugins();
		$required = ( $plugins['all'][ $slug ]['required'] ) ? esc_html__( 'Required' , 'powernode' ) : 'Recommended';
		if ( isset( $plugins['install'][ $slug ] ) ) {
			
			$messages = $this->_plugin_process_message( 'install', 'init', sprintf( esc_html__( 'Installation %s' , 'powernode' ), $required ), $slug );
			$button_classes[] = 'pnwt-plugin-action install-now';
			$actions['install'] = 'install';
			$button_text 	= esc_html__( 'Install', 'powernode' );
			
		} else if ( isset( $plugins['update'][ $slug ] ) ) {
			
			$messages = $this->_plugin_process_message( 'update', 'init', sprintf( esc_html__( 'Update %s' , 'powernode' ), $required ), $slug );
			$actions['update'] = 'update';
			$button_classes[] = 'pnwt-plugin-action update';
			$button_text 	= esc_html__( 'Update', 'powernode' );
			
		} else if ( isset( $plugins['activate'][ $slug ] ) ) {
			
			$messages = $this->_plugin_process_message( 'activate', 'init', sprintf( esc_html__( 'Activation %s' , 'powernode' ), $required ), $slug );
			$actions['activate'] = 'activate';
			$button_classes[] = 'pnwt-plugin-action activate-now button-primary';
			$button_text 	= esc_html__( 'Activate', 'powernode' );
			
		} else {
			
			$messages = $this->_plugin_process_message( 'activated', 'success', esc_html__( 'Success' , 'powernode' ), $slug );
			$button_classes[] = 'activated disabled';
			
			$button_text 	= esc_html__( 'Activated', 'powernode' );
			
		}
		
		$plugin_process = array();
		$plugin_process['process_message'] = $messages;
		$plugin_process['process_button'] = '<button type="button" class="'. powernodewt_stringify_classes( $button_classes ) . '"
									name="' .esc_attr( $slug ). '" 
									id="' .esc_attr( $slug ). '"
									data-install="' .esc_attr( admin_url( $this->tgmpa_url ) ). '"
									data-actions="' .esc_attr( json_encode( $actions ) ) .'"
									data-slug="' .esc_attr( $slug ) . '" 
									data-wpnonce="' .wp_create_nonce( 'bulk-plugins' ). '">
									' .$button_text. '
								</button>';
		return $plugin_process;
	}
	
	/**
     * Process Message
     */
	public function _plugin_process_message ( $action, $status, $message, $slug ) {
		
		$messages = array();
		switch( $status ) {
			case 'init' :
				$message_status = 'error';
				 break;
			case 'processing' :
				$message_status = 'notice';
				 break;
			case 'success' :
				$message_status = 'success';
				 break;
			default:
				$message_status = 'error';
				break;

		}
		
		return array( 'key' => $action, 'message' => '<span class="pnwt-msg pnwt-'.$message_status.'">' . $message . '</span>' );
		
	}
	
	/**
     * Install Plugins
     */
    public function install_plugins() {
        if ( ! check_ajax_referer( 'pnwt_admin_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
            wp_send_json_error(
                array(
                    'error'   => 1,
                    'message' => esc_html__(
                        'No Slug Found',
                        'powernode'
                    ),
                )
            );
        }
        $json = array();
        // send back some json we use to hit up TGM
		$plugins = $this->_get_plugins();
		$received_slug = sanitize_text_field( $_POST['slug'] );
		
        foreach ( $plugins['activate'] as $slug => $plugin ) {
            if ( $received_slug == $slug ) {
                $json = array(
                    'url'           => admin_url( $this->tgmpa_url ),
                    'plugin'        => $slug,
                    'tgmpa-page'    => $this->tgmpa_menu_slug,
                    'plugin_status' => 'all',
                    '_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
                    'action'        => 'tgmpa-bulk-activate',
                    'action2'       => - 1,
					'message'       => $this->_plugin_process_message( 'activate', 'processing', esc_html__( 'Activating ', 'powernode' ) . $plugin['name'], $slug  ),
                );
                break;
            }
        }
        foreach ( $plugins['update'] as $slug => $plugin ) {
            if ( $received_slug == $slug ) {
                $json = array(
                    'url'           => admin_url( $this->tgmpa_url ),
                    'plugin'        => $slug,
                    'tgmpa-page'    => $this->tgmpa_menu_slug,
                    'plugin_status' => 'all',
                    '_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
                    'action'        => 'tgmpa-bulk-update',
                    'action2'       => - 1,
                    'message'       => $this->_plugin_process_message( 'update', 'processing', esc_html__( 'Updating ', 'powernode' ) . $plugin['name'], $slug  ),					
                );
                break;
            }
        }
        foreach ( $plugins['install'] as $slug => $plugin ) {
            if ( $received_slug == $slug ) {
                $json = array(
                    'url'           => admin_url( $this->tgmpa_url ),
                    'plugin'        => $slug,
                    'tgmpa-page'    => $this->tgmpa_menu_slug,
                    'plugin_status' => 'all',
                    '_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
                    'action'        => 'tgmpa-bulk-install',
                    'action2'       => - 1,
                    'message'       => $this->_plugin_process_message( 'install', 'processing', esc_html__( 'Installing ', 'powernode' ) . $plugin['name'], $slug  ),
                );
                break;
            }
        }

        if ( $json ) {
            $json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
            wp_send_json( $json );
        } else {
            if ( $received_slug == 'woocommerce' ) {
                if ( get_transient( '_wc_activation_redirect' ) ) {
                    delete_transient( '_wc_activation_redirect' );
                }
            }
            if ( $received_slug == 'elementor' ) {
                if ( get_transient( 'elementor_activation_redirect' ) ) {
                    delete_transient( 'elementor_activation_redirect' );
                }
            }
            wp_send_json(
                array(
                    'done'    => 1,
                    'message' => esc_html__(
                        'Success',
                        'powernode'
                    ),
                )
            );
        }
        exit;
    }
	
	/**
     * Ajax Plugin Process
     */
    public function plugin_process() {
		if ( ! check_ajax_referer( 'pnwt_admin_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
            wp_send_json_error(
                array(
                    'error'   => 1,
                    'message' => esc_html__(
                        'No Slug Found',
                        'powernode'
                    ),
                )
            );
        }
		
		if ( !empty( $_POST['slug'] ) ) {
			$plugin_process = $this->_plugin_process(  $_POST['slug'] );
			
			wp_send_json(
                array(
                    'done'    => 1,
                    'process_button' => $plugin_process['process_button'],
                    'process_message' => $plugin_process['process_message']['message'],
                )
            );
			
		}
		
	}
}
PowerNodeWT_Plugins_Handler::get_instance();