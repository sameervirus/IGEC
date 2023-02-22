<?php
/**
 * Single Post Header
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<header class="entry-header">
<?php	
	do_action( 'powernode_before_post_header' );

	do_action( 'powernode_post_header' );

	do_action( 'powernode_after_post_header' );
?>
</header>