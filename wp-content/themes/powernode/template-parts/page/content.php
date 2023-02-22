<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="entry-content">
	<?php
	the_content();

	wp_link_pages(
		array(
			'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'powernode' ) . '">',
			'after'    => '</nav>',
			/* translators: %: Page number. */
			'pagelink' => esc_html__( 'Page %', 'powernode' ),
		)
	);
	?>
</div>
	