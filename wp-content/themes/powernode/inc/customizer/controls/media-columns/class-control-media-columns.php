<?php
/**
 * Customizer Control: Media Columns
 *
 * @package   PowerNodeWT
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Media Columns control.
 *
 * @since 1.0
 */
class PowerNodeWT_Customizer_Media_Columns_Control extends PowerNodeWT_Customizer_Base_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'powernodewt-media-columns';

	/**
	 * The unit type.
	 *
	 * @access public
	 * @var array
	 */
	public $unit_choices = array( 'col' => 'col' );

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_script( 'powernodewt-control-media-columns', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'media-columns/media-columns.js',  array( 'jquery', 'customize-base', 'powernodewt-base-control' ), POWERNODEWT_VERSION, true );
		wp_enqueue_style( 'powernodewt-control-media-columns-style', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'media-columns/media-columns.css', array(), POWERNODEWT_VERSION );
	}
	
	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		$this->json['unit_choices']   = $this->unit_choices;

		$this->json['desktop'] = array();
	    $this->json['tablet']  = array();
	    $this->json['mobile']  = array();

	    foreach ( $this->settings as $setting_key => $setting ) {

	    	list( $_key ) = explode( '_', $setting_key );
	        $this->json[ $_key ][ $setting_key ] = array(
	            'id'        => $setting->id,
	            'link'      => $this->get_link( $setting_key ),
	            'value'     => $this->value( $setting_key ),
	            'default'   => $setting->default,
	        );
		}
		
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}
				<ul class="devices-list">
					<li class="desktop">
						<button type="button" class="preview-desktop active" aria-pressed="true" data-device="desktop"><i class="dashicons dashicons-desktop"></i></button>
					</li>
					<li class="tablet">
						<button type="button" class="preview-tablet active" aria-pressed="true" data-device="tablet"><i class="dashicons dashicons-tablet"></i></button>
					</li>
					<li class="mobile">
						<button type="button" class="preview-mobile active" aria-pressed="true" data-device="mobile"><i class="dashicons dashicons-smartphone"></i></button>
					</li>
				</ul>
			</span>
		<# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		<div class="devices-wrapper">
			<div class="desktop device-cont active">
				<# _.each( data.desktop, function( args, key ) { #>
				<div class="mediacols-wrap {{ key }}" data-keyid="{{ key }}">
					<input {{{ data.inputAttrs }}} type="range" class="mediacols-range-{{ key }}" {{{ args.link }}} min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" value="{{{ args.value }}}" data-reset_value="{{ args.default }}" />
					<span class="value">
						<input {{{ data.inputAttrs }}} class="mediacols-input-{{ key }}" type="text"/>
						<span class="suffix">{{ data.choices['suffix'] }}</span>
					</span>
					<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_html_e( 'Reset', 'powernode' ); ?></span></span>
				</div>
				<# } ); #>
			</div>
			<div class="tablet device-cont">
				<# _.each( data.tablet, function( args, key ) { #>
				<div class="mediacols-wrap {{ key }}" data-keyid="{{ key }}">
					<input {{{ data.inputAttrs }}} type="range" class="mediacols-range-{{ key }}" {{{ args.link }}} min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" value="{{{ args.value }}}" data-reset_value="{{ args.default }}" />
					<span class="value">
						<input {{{ data.inputAttrs }}} class="mediacols-input-{{ key }}" type="text"/>
						<span class="suffix">{{ data.choices['suffix'] }}</span>
					</span>
					<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_html_e( 'Reset', 'powernode' ); ?></span></span>
				</div>
				<# } ); #>
			</div>
			<div class="mobile device-cont">
				<# _.each( data.mobile, function( args, key ) { #>
				<div class="mediacols-wrap {{ key }}" data-keyid="{{ key }}">
					<input {{{ data.inputAttrs }}} type="range" class="mediacols-{{ key }}" {{{ args.link }}} min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" step="{{ data.choices['step'] }}" value="{{{ args.value }}}" data-reset_value="{{ args.default }}" />
					<span class="value">
						<input {{{ data.inputAttrs }}} class="mediacols-input-{{ key }}" type="text"/>
						<span class="suffix">{{ data.choices['suffix'] }}</span>
					</span>
					<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_html_e( 'Reset', 'powernode' ); ?></span></span>
				</div>
				<# } ); #>
			</div>
		</div>
		<?php
	}
}
