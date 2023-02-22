<?php
/**
 * Customizer Control: Base
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
 * A base for controls.
 *
 * @since 1.0
 */
class PowerNodeWT_Customizer_Base_Control extends \WP_Customize_Control {
	
	/**
	 * Used to automatically generate all CSS output.
	 */
	public $output = [];

	/**
	 * Data type
	 */
	public $option_type = 'theme_mod';

	/**
	 * Option name (if using options).
	 */
	public $option_name = false;

	/**
	 * The powernodewt_config we're using for this control
	 */
	public $powernodewt_config = 'global';

	/**
	 * Whitelisting the "preset" argument.
	 */
	public $preset = [];

	/**
	 * Whitelisting the "css_vars" argument.
	 */
	public $css_vars = '';

	/**
	 * Parent setting.
	 */
	public $parent_setting;

	/**
	 * Wrapper attributes.
	 */
	public $wrapper_atts = [];

	/**
	 * Extra script dependencies.
	 */
	public function powernodewt_script_dependencies() {
		return [];
	}

	/**
	 * Enqueue control related scripts/styles.
	 */
	public function enqueue() {
	
		wp_enqueue_script( 'powernodewt-base-control', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'base/base.js', array( 'jquery', 'customize-controls' ), POWERNODEWT_VERSION, true );
		wp_enqueue_style( 'powernodewt-control-base-style', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'base/base.css', array(), POWERNODEWT_VERSION );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 */
	public function to_json() {

		// Get the basics from the parent class.
		parent::to_json();

		// Default value.
		if ( isset($this->setting->default) ) {
			$this->json['default'] = $this->setting->default;
		}
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		// Output.
		$this->json['output'] = $this->output;

		$this->json['value'] = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link'] = $this->get_link();
		$this->json['id'] = $this->id;

		// Translation strings.
		$this->json['l10n'] = $this->l10n();

		// The ajaxurl in case we need it.
		//$this->json['ajaxurl'] = admin_url( 'admin-ajax.php' );

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
			if ( $attr == 'class' ) {
				$this->json['inputClassAttr'] = esc_attr( $value );
			}
			
		}

		// The powernodewt-config.
		$this->json['powernodewtConfig'] = $this->powernodewt_config;

		// The option-type.
		$this->json['powernodewtOptionType'] = $this->option_type;

		// The option-name.
		$this->json['powernodewtOptionName'] = $this->option_name;

		// The preset.
		$this->json['preset'] = $this->preset;

		// The CSS-Variables.
		$this->json['css-var'] = $this->css_vars;

		// Parent setting.
		$this->json['parent_setting'] = $this->parent_setting;

		// Wrapper Attributes.
		$this->json['wrapper_atts'] = $this->wrapper_atts;
	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function render_content() {}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @access protected
	 * @since 1.0
	 * @see WP_Customize_Control::print_template()
	 * @return void
	 */
	protected function content_template() {}

	/**
	 * Returns an array of translation strings.
	 */
	protected function l10n() {
		return array();
	}
}
