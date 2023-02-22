<?php
/**
 * Customizer Control: Checkbox Toggle
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
 * Checkbox toggle control (modified checkbox)
 *
 * @since 1.0
 */
class PowerNodeWT_Customizer_Checkbox_Toggle_Control extends PowerNodeWT_Customizer_Base_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'powernodewt-checkbox-toggle';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_style( 'powernodewt-control-checkbox-toggle-style', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'checkbox-toggle/checkbox-toggle.css', array(), POWERNODEWT_VERSION );
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
		<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		<div id="input_{{ data.id }}" class="powernodewt-chk-toggle checkbox-toggle checkbox-toggle-field">
			<label class="chktoggle-switch">
				<input {{{ data.inputAttrs }}} class="checkbox-toggle-input" type="checkbox" value="{{ key }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( key === data.value ) { #> checked="checked" <# } #>>
				<span class="slider round"></span>
			</label>
			<label class="checkbox-toggle-label checkbox-toggle-label-<# if ( key === data.value ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}{{ key }}">{{{ data.label }}}</label>
			</input>
		</div>
		<?php
	}
}
