<?php
/**
 * Before Content Wrapper
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<?php do_action( 'powernode_before_content_wrap' ); ?>
	<div id="content-wrap" class="container content-wrap">
		<?php do_action( 'powernode_before_primary' ); ?>
		<div class="row">
			<div <?php echo powernodewt_primary_col_atts(); ?>>
				<?php do_action( 'powernode_before_content' ); ?>
				<div id="content" class="site-content">
					<?php do_action( 'powernode_before_content_inner' ); ?>