<div <?php echo powernodewt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( $display_type != 'widget'  ) { ?>
		<div class="sec-heading"><?php echo $sec_heading ; ?></div>
	<?php } ?>
	<div class="sec-content">
		<?php
		woocommerce_product_loop_start();

		while ( $query->have_posts() ) : $query->the_post();

			wc_get_template_part( 'content', 'product' );

		endwhile;
		
		wp_reset_postdata();
		powernodewt_reset_loop();
		woocommerce_product_loop_end();
		?>
	</div>
</div>