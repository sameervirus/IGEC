<?php
/**
 * Header Mobile
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
<div class="wsmobileheader header-mobile clearfix">
	<div class="smllogo site-branding">
		<?php do_action( 'powernode_mob_header_logo_display' ); ?>
		<?php do_action( 'powernode_mob_header_navigation' ); ?>
	</div>
	<a id="wsnavtoggle" class="wsanimated-arrow" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span></span></a>
</div>