<?php
/**
 * Import / Export View
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php if( !powernodewt_is_license_verified() ) { ?>
<div class="pnwt-error mb-0"><?php esc_html_e( 'Activate your theme in order to be able to import/export settings.', 'powernode' ); ?></div>
<?php } else { ?>
<div class="pnwt-dashboard">
	<div class="pnwt-row">
		<div class="pnwt-col-12">
			<div class="pnwt-info mb-0"><?php esc_html_e( 'Export Customizer settings of the current theme and import on a Child Theme or use to create your own default styling for the next website.', 'powernode' ); ?></div>
		</div>
	</div>
	<div class="pnwt-row">
		<div class="pnwt-col-12">
			<div class="pnwt-panel activation-panel">
				<div class="pnwt-panel-header">
					<div class="title"><?php esc_html_e( 'Export', 'powernode' ); ?></div>
				</div>
				<div class="pnwt-panel-content">
					<div class="pnwt-messages"></div>
					<form name="activation-form" class="activation-form" action="" method="post">
						<p class="about-description"><?php esc_html_e( 'Click the button below to export the customization settings for this theme.', 'powernode' ); ?></p>
						<input type="button" class="button" name="wt-cie-export-button" value="<?php esc_attr_e( 'Export', 'powernode' ); ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="pnwt-row">
		<div class="pnwt-col-12">
			
			<div class="pnwt-panel activation-panel">
				<div class="pnwt-panel-header">
					<div class="title"><?php esc_html_e( 'Import', 'powernode' ); ?></div>
				</div>
				<div class="pnwt-panel-content">
					
						<?php 
						global $cie_error, $cie_success;
						if ( $cie_error ) {
							echo '<script> alert("' . $cie_error . '"); </script>';
						}
						if( !empty( $cie_success ) ) {
							echo '<div class="pnwt-success">' . wp_kses_post( $cie_success ) . '</div>';
						}
						?>
					<form name="wt-cie-import-from" class="cie-form" method="POST" enctype="multipart/form-data">
						<p class="about-description"><?php esc_html_e( 'Choose a valid .dat file, previously generated using the Export Customizer Styling option.', 'powernode' ); ?></p>
						<p><input type="file" name="wt-cie-import-file" class="wt-cie-import-file"></p>
						<?php wp_nonce_field( 'wt-cie-importing', 'wt-cie-import' ); ?>
						<div class="cie-uploading pnwt-loader">Uploading...</div>
						<input type="button" class="button" name="wt-cie-import-button" value="<?php esc_attr_e( 'Import', 'powernode' ); ?>">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>