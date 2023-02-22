<div <?php echo powernodewt_stringify_atts( $args['wrap_atts'] ); ?>>
	<div class="mbnr-wrap">
		<?php echo $image; ?>
		<?php if ( !empty( $content ) ) { ?>
		<div class="mbnr-content"><div class="mbnr-cont-wrap"><?php echo powernodewt_js_remove_wpautop( implode( ' ', $content ) , true ); ?></div></div>
		<?php } ?>
	</div>
</div>