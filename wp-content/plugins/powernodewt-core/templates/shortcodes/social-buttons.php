<div <?php echo powernodewt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( $display_type != 'widget' && !empty( $title ) ) { ?>
		<div class="sec-heading">
			<h2 class="sec-title"><?php echo $title ; ?></h2>
		</div>
	<?php } ?>
	<?php echo powernodewt_js_remove_wpautop( $sec_content ); ?>
</div>