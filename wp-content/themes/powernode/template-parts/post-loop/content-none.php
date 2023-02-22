<?php
/**
 * Post Loop Content None
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

?>
<div class="no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'powernode' ); ?></h1>
	</header>
	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
		
			<p><?php echo wp_kses( sprintf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'powernode' ), esc_url( admin_url( 'post-new.php' ) ) ), pressmart_allowed_html('a') ); ?></p>

		<?php else : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'powernode' ); ?></p>
			<?php
				get_search_form();

		endif; ?>
	</div>
</div>
