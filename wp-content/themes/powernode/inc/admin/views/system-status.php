<?php
/**
 * PowerNodeWT Dashboard
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$system_info = PowerNodeWT_Admin()->get_system_data();
$wp_theme = wp_get_theme();
?>
<div id="pnwt-system" class="pnwt-system">
	<div class="pnwt-row">
		<div class="pnwt-col-12">
			<div class="pnwt-panel theme-info-panel">
				<div class="pnwt-panel-header">
					<div class="title"><?php esc_html_e( 'Theme Information', 'powernode' ); ?></div>
				</div>
				<div class="pnwt-panel-content">
					<div class="pnwt-messages"></div>
					<div class="pnwt-panel-in-content">
						<table class="widefat pnwt-table system-status pnwt-messages">
							<tr>
								<th><?php esc_html_e( 'Theme Name', 'powernode' ); ?></th>
								<td><?php echo esc_html( $wp_theme->name ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'Current Version', 'powernode' ); ?></th>
								<td><?php echo esc_html( $wp_theme->version ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'Installation Path', 'powernode' ); ?></th>
								<td><code><?php echo esc_html( $wp_theme->theme_root ); ?></code></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'PowerNode Server Status', 'powernode' ); ?></th>
								<td>
									<?php if(PowerNodeWT_Admin()->powernodewt_server_status()) {?> <span class="dashicons dashicons-yes"></span> <?php } else { ?><span class="dashicons dashicons-no"></span><p class="pnwt-error"><?php echo __( 'The server is unable to connect with the external websites.', 'powernode' ); ?></p>
<?php }?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="pnwt-row">
		<div class="pnwt-col-12">
			<div class="pnwt-panel system-req-panel">
				<div class="pnwt-panel-header">
					<div class="title"><?php esc_html_e( 'System Requirement', 'powernode' ); ?></div>
				</div>
				<div class="pnwt-panel-content">
					<div class="pnwt-messages"></div>
					<div class="pnwt-panel-in-content">
						<table class="widefat pnwt-table system-status pnwt-messages">
							<tr>
								<th><?php esc_html_e( 'Server', 'powernode' ); ?></th>
								<td><?php echo esc_html( $system_info['server'] ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'PHP Version', 'powernode' ); ?></th>
								<td><?php echo esc_html( $system_info['phpversion'] ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'Uploads folder writable', 'powernode' ); ?></th>
								<td>
									<?php if ( $system_info['uploads'] ) : ?>
									<span class="dashicons dashicons-yes"></span>
								<?php else : ?>
									<span class="dashicons dashicons-no"></span>
									<p class="pnwt-error"><?php esc_html_e( 'Uploads folder must be writable. Please set write permission to your wp-content/uploads folder.', 'powernode' ); ?></p>
								<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'ZipArchive', 'powernode' ); ?></th>
								<td>
									<?php if ( $system_info['zip'] ) : ?>
									<span class="dashicons dashicons-yes"></span>
								<?php else : ?>
									<span class="dashicons dashicons-no"></span>
									<p class="pnwt-error"><?php esc_html_e( 'ZipArchive is required for pre-built websites and plugins installation. Please contact your hosting provider.', 'powernode' ); ?></p>
								<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'PHP Memory Limit', 'powernode' ); ?></th>
								<td>
									<?php if ( $system_info['memory_limit'] >= 260000000 ) : ?>
									<span class="dashicons dashicons-yes"></span>
									<span class="desc"><?php echo esc_html( size_format( $system_info['memory_limit'] ) ); ?></span>
								<?php else : ?>
									<?php if ( $system_info['memory_limit'] < 130000000 ) : ?>
										<span class="dashicons dashicons-no"></span>
										<span class="desc"><?php echo size_format( $system_info['memory_limit'] ); ?></span>
										<p class="pnwt-error"><?php echo __( 'Minimum <strong>128 MB</strong> is required. Least <strong>256 MB</strong> is recommended.', 'powernode' ); ?><br>
									<?php else : ?>
										<span class="dashicons dashicons-info"></span>
										<span class="desc"><?php echo esc_html( size_format( $system_info['memory_limit'] ) ); ?></span>
										<p class="pnwt-notice"><?php echo __( 'Current memory limit is OK, however <strong>256 MB</strong> is recommended.', 'powernode' ); ?><br>
									<?php endif; ?>
									<?php echo wp_kses(sprintf( __( 'Please define memory limit in <strong>wp-config.php</strong> file. To learn how, see: <a href="%1$s" target="_blank">Increasing max execution to PHP</a>', 'powernode' ), 'https://wordpress.org/support/article/common-wordpress-errors/#php-errors' ), array( 'strong' => array(), 'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) );	?></p>
								<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'PHP Time Limit', 'powernode' ); ?></th>
								<td>
									<?php if ( ( $system_info['time_limit'] >= 600 ) || ( $system_info['time_limit'] == 0 ) ) : ?>
									<span class="dashicons dashicons-yes"></span>
									<span class="desc"><?php esc_html( $system_info['time_limit'] ); ?></span>
								<?php else : ?>
									<?php if ( $system_info['time_limit'] < 300 ) : ?>
										<span class="dashicons dashicons-no"></span>
										<span class="desc"><?php esc_html( $system_info['time_limit'] ); ?></span>
										<p class="pnwt-error"><?php echo __( 'Minimum <strong>300</strong> is required. Least <strong>600</strong> is recommended.', 'powernode' ); ?><br>
									<?php else : ?>
										<span class="dashicons dashicons-info"></span>
										<span class="desc"><?php esc_html( $system_info['time_limit'] ); ?></span>
										<p class="pnwt-notice"><?php echo __( 'Current memory limit is OK, however <strong>600</strong> is recommended.', 'powernode' ); ?><br>
									<?php endif; ?>
									<?php echo wp_kses(sprintf( __( 'To learn how, see: <a href="%1$s" target="_blank">Increasing memory allocated to PHP.</a>', 'powernode' ), 'https://wordpress.org/support/article/editing-wp-config-php/#increasing-memory-allocated-to-php' ), array( 'strong' => array(), 'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) );	?></p>
								<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'PHP Max Input Vars', 'powernode' ); ?></th>
								<td>
									<?php if ( $system_info['max_input_vars'] >= 2000 ) : ?>
									<span class="dashicons dashicons-yes"></span>
									<span class="desc"><?php echo esc_html( $system_info['max_input_vars'] ); ?></span>
								<?php else : ?>
									<span class="dashicons dashicons-info"></span>
									<span class="desc"><?php echo esc_html( $system_info['max_input_vars'] ); ?></span>
									<p class="pnwt-notice"><?php echo __( 'Minimum <strong>2000</strong> is required.', 'powernode' ); ?></p>
								<?php endif; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>