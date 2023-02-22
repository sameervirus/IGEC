<?php
/**
 * Updater
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class PowerNodeWT_Updater {
	
	static $instance = null;
	public $api_url;
	public $item_name;
	public $item_id;
	public $envato_option;
	public $powernodewt_token;

	private function __construct() {
		$this->api_url = 'https://wttechdesign.com/envato/';
		$this->item_id = '39354794';
		$this->item_name = 'PowerNode - Multipurpose WordPress Theme';
		$this->envato_option = 'envato_purchase_code_'.$this->item_id;
		$this->powernodewt_token = 'powernodewt_token';
		
		add_action( 'wp_ajax_activation_theme', array( $this, 'powernodewt_check_activation_state' ) );
		add_action( 'wp_ajax_nopriv_activation_theme', array( $this, 'powernodewt_check_activation_state' ) );
		
		/* Admin Notice */
		add_action( 'admin_notices', array( $this, 'check_theme_license_activate' ), 90);
	}
	
	public function getVerifyUrl(){
		$url = $this->api_url . 'verify.php';
		$url .= '?domain='. $this->powernodewt_domain();
		return $url;
    }
	
	public function getDeactivateUrl(){
        $url = $this->api_url . 'deactivate.php';
		$url .= '?domain='. $this->powernodewt_domain();
		return $url;
    }
	
	public function powernodewt_check_activation_state() {
		$data = array();
		if ( empty( $_POST['purchase_code'] ) ) {
			$data = array( 'result' => 0 , 'message' => __( 'Purchase code field required', 'powernode' ) );
        }
		
		if ( !empty( $_POST['purchase_code'] ) && !empty( $_POST['activation_actions'] ) ) {
			$purchase_code = sanitize_text_field( $_POST['purchase_code'] );
			$actions = sanitize_text_field( $_POST['activation_actions'] );
			if ( $actions == 'deactivate_theme' ) {
				$purchase_code = $this->get_purchase_code();
			}
			$url = ( $actions == 'activate_theme' ) ? $this->getVerifyUrl() : $this->getDeactivateUrl();
			$url .= '&purchase_code='. $purchase_code;
			$url .= '&item_id='. $this->item_id;
			$response = wp_remote_get( $url );
			if ( is_wp_error( $response ) ) {
				$data = array( 'result' => 0 , 'message' => 'The server is unable to connect with the external websites.' );
			} else {
				if ( !empty( $response['body'] ) ) {
					$data = json_decode( $response['body'], true);
					if ( $actions == 'activate_theme' ) {
						if ( $data['result'] == 1 ) {
							if ( !empty( $data['data']['token'] ) ) {
								$this->powernodewt_activate_theme( $data['data']['purchase_code'], $data['data']['token'] );
							}
						}
					} else {
						if ( $data['result'] == 1 ) {
							if ( !empty( $data['data']['token'] ) ) {
								$this->powernodewt_deactivate_theme( $data['data']['purchase_code'] );
							}
						}
					}
					
					$data['message'] = $this->powernodewt_get_html_messages( $data['result'], $data['message'] );
					if ( $data['result'] == 1 ) {
						$data['is_reload'] = true;	
					}
				}
			}
		}

		echo json_encode( $data );
		die();
	}
	
	public function powernodewt_get_html_messages( $status, $message ) {
		$html = '';
		if ( $status == 0 ) {
			$html = '<div class="notice notice-error is-dismissible"><p>'.$message.'</p></div>';
		} else if ( $status == 1 ) {
			$html = '<div class="notice notice-success is-dismissible"> <p>'.$message.'</p></div>';
		} else if ( $status == 2 ) {
			$html = '<div class="notice notice-warning is-dismissible"> <p>'.$message.'</p></div>';
		} else if ( $status == 3 ) {
			$html = '<div class="notice notice-info is-dismissible"> <p>'.$message.'</p></div>';
		}
		return $html;
	}
	
	public function powernodewt_domain() {
        $domain = get_option('siteurl'); 
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www', '', $domain); 
        return urlencode($domain);
    }
	
	public function powernodewt_activate_theme( $purchase_code, $token ) {
		update_option( $this->envato_option, $purchase_code );
		update_option( $this->powernodewt_token, $token );
		update_option( 'powernodewt_license_verified', true );
	}
	
	public function powernodewt_deactivate_theme( $purchase_code ) {
		delete_option( $this->envato_option );
		delete_option( $this->powernodewt_token );
		delete_option( 'powernodewt_license_verified' );
	}
	
	public function init_actions() {
		if ( current_user_can( 'manage_options' ) ) {
			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
			}
			add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
			add_action( 'wp_ajax_envato_setup_plugins', array( $this, 'ajax_plugins' ) );
		}
	}
	
	public static function cleanFilePath( $path ) {
		$path = str_replace( '', '', str_replace( array( '\\', '\\\\', '//' ), '/', $path ) );
		if ( $path[ strlen( $path ) - 1 ] === '/' ) {
			$path = rtrim( $path, '/' );
		}

		return $path;
	}
	
	public function is_verified() {
		$code = get_option( $this->envato_option );
       	return ( get_option( 'powernodewt_license_verified' ) && $code ) ? true : false;
	}
	
	public function get_purchase_code() {
		$code = get_option( $this->envato_option );
       	return ( $code ) ? $code : false;
	}
	public function get_purchase_code_asterisk() {
		$code = get_option( $this->envato_option );
       	if ( $code ) {
			$code = substr( $code, 0, 15 );
			$code = $code . '**-****-************';
		}
		return $code;
	}
	
	public function check_theme_license_activate(){
            
		if( powernodewt_is_license_verified() ){
			return;
		}
		$theme_details		= wp_get_theme();
		$activate_page_link	= admin_url( 'admin.php?page=powernode-dashboard' );

		?>
		<div class="notice notice-error is-dismissible">
			<p>
				<?php 
					echo sprintf( esc_html__( ' %1$s Theme is not activated! Please activate your theme and enjoy all features of the %2$s theme', 'powernode'), 'PowerNode','PowerNode' );
					?>
			</p>
			<p>
				<strong style="color:red"><?php esc_html_e( 'Please activate the theme!', 'powernode' ); ?></strong> -
				<a href="<?php echo esc_url(( $activate_page_link )); ?>">
					<?php esc_html_e( 'Activate Now','powernode' ); ?> 
				</a> 
			</p>
		</div>
	<?php
	}
	
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}
add_action( 'after_setup_theme', 'PowerNodeWT_Updater', 10 );
if ( ! function_exists( 'PowerNodeWT_Updater' ) ) :
	function PowerNodeWT_Updater() {
		return PowerNodeWT_Updater::get_instance();
	}
endif;