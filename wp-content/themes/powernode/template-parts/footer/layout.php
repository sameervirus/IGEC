<?php
/**
 * Footer Layout
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
if( empty( $args['layout'] ) ) return;
?>
<footer <?php echo powernodewt_stringify_atts( $args['atts'] ); ?>>

	<?php do_action( 'powernode_before_footer' ); ?>
	
	<?php echo powernodewt_do_shortcode( 'powernode_layout', array( 'id' => $args['layout'] ) )?>
	
	<?php do_action( 'powernode_after_footer' ); ?>
</footer>