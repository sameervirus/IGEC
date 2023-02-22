<?php
/**
 * PowerNodeWT Dashboard
 *
 * @package powernodewt
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap pnwt-admin-wrap">
	<div class="pnwt-admin-main">
		<div class="pnwt-container">
			<div class="pnwt-row">
				<div class="pnwt-col-12">
					<div class="pnwt-about-wrap about-wrap">
						<h1><?php esc_html_e( 'Welcome to PowerNode!', 'powernode' ); ?></h1>
						<div class="about-text">Thank you for purchasing our premium PowerNode theme. Here you are able
							to start creating your awesome web store by importing our dummy content and theme options.
						</div>
						<div class="pnwt-logo"><span>&nbsp;</span></div>
						<div class="pnwt-version"><?php esc_html_e( 'Version', 'powernode' ); ?><?php echo esc_html( POWERNODEWT_VERSION ); ?></div>
						<p class="actions">
							<?php echo sprintf( '<a href="%s" target="_blank" class="btn-docs button">' . esc_html__( 'Documentation', 'powernode' ) . '</a>', 'https://docs.wttechdesign.com/powernode/' ); ?>
							<a href="<?php echo esc_url('https://themeforest.net/item/powernode-multipurpose-wordpress-theme/39354794/support'); ?>" class="btn-support button button-primary" target="_blank"><?php echo esc_html__( 'Support forum', 'powernode' ); ?></a>
						</p>
					</div>
					<?php 
					 $dashboard_tabs_menu = array(
						'0' => array (
							'title' => __( 'Dashboard', 'powernode' ),
							'page'  => 'powernode-dashboard',
							'link'  => add_query_arg( array( 'page' => 'powernode-dashboard' ) ),
							'class' => 'pnwt-dashboard ',
						),
						'10' => array (
							'title' => __( 'Import / Export', 'powernode' ),
							'page'  => 'powernode-customizer-import-export',
							'link'  => add_query_arg( array( 'page' => 'powernode-customizer-import-export' ) ),
							'class' => 'pnwt-customizer-import-export ',
						),
					);

					$dashboard_tabs_menu = apply_filters( 'powernode_dashboard_tabs_menu', $dashboard_tabs_menu );
					?>
					<div class="pnwt-menu-section">
						<ul class="pnwt-tab-wrap">
							<?php 
								foreach( $dashboard_tabs_menu as $tab_key => $menu ) {
								$menu['class'] .= ( !empty( $_GET['page'] ) && $_GET['page'] == $menu['page'] ) ? ' active' : '';
								?>
									<li class="tab-item <?php echo esc_attr( $menu['class'] ); ?>">
										<a href="<?php echo esc_url( ( !empty( $menu['link'] ) ? $menu['link'] : add_query_arg( array( 'page' => $menu['page'] ) ) ) ); ?>"><?php echo esc_html( $menu['title'] );?></a>
									</li>
								<?php
								}
							?>
						</ul>
					</div>
					<div class="pnwt-wrap-content">
						<div class="pnwt-page-content">