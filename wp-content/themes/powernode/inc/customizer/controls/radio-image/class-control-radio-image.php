<?php
/**
 * Customizer Control: Radio Image
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
 * Radio Image control (modified radio).
 *
 * @since 1.0
 */
class PowerNodeWT_Customizer_Radio_Image_Control extends PowerNodeWT_Customizer_Base_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'powernodewt-radio-image';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_script( 'powernodewt-control-radio-image', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'radio-image/radio-image.js',  array( 'jquery', 'customize-base', 'powernodewt-base-control' ), POWERNODEWT_VERSION, true );
		wp_enqueue_style( 'powernodewt-control-radio-image-style', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'radio-image/radio-image.css', array(), POWERNODEWT_VERSION );
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
		<span class="customizer-text">
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</span>
		<div id="input_{{ data.id }}" class="image">
			<# for ( key in data.choices ) { #>
				<# dataAlt = ( _.isObject( data.choices[ key ] ) && ! _.isUndefined( data.choices[ key ].alt ) ) ? data.choices[ key ].alt : '' #>
				<input {{{ data.inputAttrs }}} class="image-select" type="radio" value="{{ key }}" title="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #> data-alt="{{ dataAlt }}">
					<label for="{{ data.id }}{{ key }}" {{{ data.labelStyle }}} class="{{{ data.id + key }}}">
						<# if ( _.isObject( data.choices[ key ] ) ) { #>
							<img src="{{ data.choices[ key ].src }}" alt="{{ data.choices[ key ].alt }}">
							<span class="image-label"><span class="inner">{{ data.choices[ key ].alt }}</span></span>
						<# } else { #>
							<img src="{{ data.choices[ key ] }}">
						<# } #>
						<span class="image-clickable"></span>
						<span class="radio-label">{{ key }}</span>
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}
