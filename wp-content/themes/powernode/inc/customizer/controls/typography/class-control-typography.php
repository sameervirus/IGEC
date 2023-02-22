<?php
/**
 * Customizer Control: Typography
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
 * Typography control.
 *
 * @since 1.0
 */
class PowerNodeWT_Customizer_Typography_Control extends PowerNodeWT_Customizer_Base_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'powernodewt-typography';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();
		wp_enqueue_script( 'powernodewt-select2-script', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'typography/select2.min.js',  array( 'jquery'), '4.0.8', true );
		wp_enqueue_script( 'powernodewt-control-typography', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'typography/typography.js',  array( 'jquery', 'powernodewt-select2-script', 'powernodewt-base-control' ), POWERNODEWT_VERSION, true );
		wp_enqueue_style( 'powernodewt-control-select2-style', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'typography/select2.min.css', array(), '4.0.8' );
		wp_enqueue_style( 'powernodewt-control-typography-style', POWERNODEWT_CUSTOMIZER_CONTROL_DIR_URI.'typography/typography.css', array(), POWERNODEWT_VERSION );
	}
	
	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content() {
		$this_val = $this->value(); ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<select class="powernodewt-typography-select" <?php $this->link(); ?>>
				<option value="" 
				<?php
				if ( ! $this_val ) {
					echo 'selected="selected"';}
?>
><?php esc_html_e( 'Default', 'powernode' ); ?></option>
				<?php
				// Get Standard font options
				$std_fonts = powernodewt_standard_fonts();
				if ( ! empty( $std_fonts ) ) {
				?>
					<optgroup label="<?php esc_attr_e( 'Standard Fonts', 'powernode' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $std_fonts as $font ) {
						?>
							<option value="<?php echo esc_html( $font ); ?>" <?php selected( $font, $this_val ); ?>><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php
				}

				// Google font options
				$google_fonts = powernodewt_google_fonts_array();
				if ( ! empty( $google_fonts ) ) {
				?>
					<optgroup label="<?php esc_attr_e( 'Google Fonts', 'powernode' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $google_fonts as $font ) {
						?>
							<option value="<?php echo esc_html( $font ); ?>" <?php selected( $font, $this_val ); ?>><?php echo esc_html( $font ); ?></option>
						<?php } ?>
					</optgroup>
				<?php } ?>
			</select>

		</label>

		<?php
	}
}
