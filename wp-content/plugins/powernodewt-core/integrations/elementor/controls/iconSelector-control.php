<?php
namespace PowerNodeElementor;
use Elementor\Controls_Manager;
use Elementor\Base_Data_Control;

/**
 * Elementor Icon Selector Control
 * @package  powernodewt
 * @since    1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IconSelector_Control extends Base_Data_Control {
	
	const IconSelector = 'icon_selector';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::IconSelector;
	}
	
	public function includes() {
		require_once( POWERNODEWT_CORE_INC_DIR.'/icons_list.php' );
	}
	
	/**
	 * Enqueue control scripts and styles.
	 */
	public function enqueue() {

		$url = POWERNODE_ELEXTS_URL.'assets/';
		
		wp_enqueue_style('icon-selector', $url.'/css/icon-selector.css', array(), '');
		wp_enqueue_script( 'pnwt-elementor-selector', $url . 'js/selector.js', array('jquery'), POWERNODEWT_CORE_VERSION , true );
	}

	/**
	 * Retrieve icons control default settings.
	 *
	 * Get the default settings of the icons control. Used to return the default
	 * settings while initializing the icons control.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'value'   => '',
			'label_block' => true,
			'toggle' => true,
			'options' => [],
		];
	}

	/**
	 * Render icons control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		
		$control_uid = $this->get_control_uid('{{ value }}');
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<div style="pading-bottom:5px;"><input type="text" class="pnwt_param_icons_search" placeholder="Search..." /></div>
			<div class="elementor-control-icon-selector-wrapper">

				<# _.each( data.options, function( options, value ) { #>
				<input id="<?php echo $control_uid; ?>" type="radio" name="elementor-image-selector-{{ data.name }}-{{ data._cid }}" value="{{ value }}" data-setting="{{ data.name }}">
				<label class="elementor-icon-selector-label tooltip2-target" for="<?php echo $control_uid; ?>" data-tooltip2="{{ options }}" title="{{ options }}">
					<i class="{{ value }}"></i>
					<span class="elementor-screen-only">{{{ options }}}</span>
				</label>
				<# } ); #>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}