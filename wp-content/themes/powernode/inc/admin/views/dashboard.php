<?php
/**
 * Admin Dashboard
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$is_verified = powernodewt_is_license_verified();
?>
<?php if( !$is_verified ) { ?>
<div class="pnwt-error mb-0"><?php esc_html_e( 'Activate your theme in order to be able to download and update addons.', 'powernode' ); ?></div>
<?php } ?>
<div class="pnwt-dashboard">
	<div class="pnwt-row">
		<div class="pnwt-col-12">
			<div class="pnwt-panel activation-panel">
				<div class="pnwt-panel-header">
					<div class="title"><?php esc_html_e( 'Purchase Code', 'powernode' ); ?></div>
					<span class="activation-status"><?php echo wp_kses_post( ( $is_verified ) ? '<span class="act-status active">' . __( 'Activated', 'powernode' ) . '</span>' : '<span class="act-status not-active">' . __( 'No Activated', 'powernode' ) . '</span>' ); ?></span>
				</div>
				<div class="pnwt-panel-content">
					<div class="pnwt-messages"></div>
				<?php if ( $is_verified ) { ?>
					<form name="activation-form" class="activation-form" action="" method="post">
						<p class="about-description"><?php esc_html_e( 'Your product is registered now.', 'powernode' ); ?></p>
						<p>
							<input type="text" class="regular-text txt-purchase-code" name="purchase_code" placeholder="<?php esc_attr_e( 'Enter Purchased Code', 'powernode' ); ?>" required="" value="<?php echo PowerNodeWT_Updater()->get_purchase_code_asterisk(); ?>" disabled>
							<input type="hidden" name="activation_actions" value="deactivate_theme">
							<input type="submit" class="button button-primary button-large pnwt-large-button" value="<?php esc_attr_e( 'Deactive Theme', 'powernode' ); ?>">
						</p>
					</form>
				<?php } else { ?>
					<form name="activation-form" class="activation-form" action="" method="post">
						<p class="about-description"><?php esc_html_e( 'Please enter your Purchase Code to complete registration.', 'powernode' ); ?></p>
						<p>
							<input type="text" class="regular-text txt-purchase-code" name="purchase_code" placeholder="<?php esc_attr_e( 'Enter Purchased Code', 'powernode' ); ?>" required="">
							<input type="hidden" name="activation_actions" value="activate_theme">
							<input type="submit" class="button button-primary button-large pnwt-large-button" value="<?php esc_attr_e( 'Active Theme', 'powernode' ); ?>">
							<p><?php echo wp_sprintf( __( 'You can find your purchase code', 'powernode' ) . '<a href="%s" target="_blank"> here </a>','https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code' ); ?></p>
						</p>
					</form>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	//System Status
	require_once POWERNODEWT_ADMIN . '/views/system-status.php';
	?>
</div>