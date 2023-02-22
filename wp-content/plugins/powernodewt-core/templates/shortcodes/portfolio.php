<div <?php echo powernodewt_stringify_atts( $args['wrap_atts'] ); ?>>
	<?php if ( !empty( $sec_heading ) && $display_type != 'widget'  ) { ?>
		<div class="sec-heading"><?php echo $sec_heading ; ?></div>
	<?php } ?>
	<?php
	do_action( 'powernode_before_portfolio_loop_post' );

	if( !empty( $query ) ) {
		while ( $query->have_posts() ) : $query->the_post();

			get_template_part( 'template-parts/portfolio-loop/layout', get_post_format() );

		endwhile;
		
		wp_reset_postdata();
	}
	
	do_action( 'powernode_after_portfolio_loop_post' );
	?>
</div>