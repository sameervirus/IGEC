<?php
/**
 * Customizer Control: Buttonset
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
 * Radio Buttonset control (modified radio)
 *
 * @since 1.0
 */
class PowerNodeWT_Customizer_Buttonset_Control extends PowerNodeWT_Customizer_Base_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'powernodewt-buttonset';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_script( 'powernodewt-control-buttonset', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'buttonset/buttonset.js',  array( 'jquery', 'customize-base', 'powernodewt-base-control' ), POWERNODEWT_VERSION, true );
		wp_enqueue_style( 'powernodewt-control-buttonset-style', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'buttonset/buttonset.css', array(), POWERNODEWT_VERSION );
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
		<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		<div id="input_{{ data.id }}" class="buttonset switch-field">
			<# for ( key in data.choices ) { #>
				<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="{{ key }}" name="_customize-radio-{{{ data.id }}}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( key === data.value ) { #> checked="checked" <# } #>>
					<label class="switch-label switch-label-<# if ( key === data.value ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}{{ key }}">{{{ data.choices[ key ] }}}</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}
