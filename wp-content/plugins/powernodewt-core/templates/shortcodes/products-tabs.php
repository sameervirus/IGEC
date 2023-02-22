<div <?php echo powernodewt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( $display_type != 'widget'  ) { ?>
		<div class="sec-heading"><?php echo $sec_heading ; ?></div>
	<?php } ?>
	<div class="tab-content"><?php echo powernodewt_js_remove_wpautop( $sec_content ); ?></div>
</div>