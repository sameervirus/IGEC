<?php
/**
 * Page Header
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! powernodewt_display_page_title() ) {
	return;
}

$classes = array( 'page-header', 'page-title-wrap', 'hero-txt' );

// Get header style
$style = powernodewt_page_title_style();
if ( $style ) {
	$classes[] = $style.'-page-header';
}
if ( powernodewt_page_title_background() ) {
	$classes[] = 'bgimg-page-header';
}

$page_title = powernodewt_page_title();
?>
<?php do_action( 'powernode_outer_before_page_header' ); ?>
<div class="<?php echo implode( ' ', $classes ); ?>" >
	<?php do_action( 'powernode_before_page_header' ); ?>
	<div class="container">
		<div class="row">
			<div class="col">
				<?php if ( function_exists( 'powernodewt_breadcrumb_trail' ) ) {
					powernodewt_breadcrumb_trail();
				} ?>
				<?php if ( !empty( $page_title ) && $page_title != 'hidden' ) { ?>
				<h2 class="page-header-title h2-xs"><?php echo wp_kses_post( powernodewt_page_title() ); ?></h2>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php do_action( 'powernode_after_page_header' ); ?>
</div>
<?php do_action( 'powernode_outer_after_page_header' ); ?>