<?php
/**
 * Display Post Next/Prev Links
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( get_post_type() != 'portfolio' ) {
	return;
}

$next_post = get_next_post();
$prev_post = get_previous_post();

do_action( 'powernode_before_portfolio_single_post_next_prev' );
if ( !empty( $prev_post ) || !empty( $next_post ) ) {
?>
<div class="other-posts">
	<div id="op-row" class="row d-flex align-items-center">
		<div class="col-md-5">
		<?php if ( !empty( $prev_post ) ) { ?>
			<div class="prev-post mb-30 pr-45">								
				<h6 class="h6-sm"><?php esc_html_e( 'Previous Post', 'powernode' ) ?></h6>
				<a href="<?php echo esc_url( get_permalink($prev_post->ID) ); ?>" rel="next"><?php echo get_the_title($prev_post->ID); ?></a>
			</div>
		<?php } ?>
		</div>
		<div class="col-md-2 text-center">
			<div class="all-posts ico-35 mb-30">
				<a href="<?php echo esc_url( get_post_type_archive_link( get_post_type() ) ); ?>"><span class="flaticon-four-black-squares"></span></a>
			</div>
		</div>
		<div class="col-md-5 text-right">
		<?php if ( !empty( $next_post ) ) { ?>
			<div class="next-post mb-30 pl-45">		
				<h6 class="h6-sm"><?php esc_html_e( 'Next Post', 'powernode' ) ?></h6>
				<a href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>" rel="next"><?php echo get_the_title($next_post->ID); ?></a>
			</div>
		<?php } ?>
		</div>
	</div>
</div>
<?php
}

do_action( 'powernode_after_portfolio_single_post_next_prev' );