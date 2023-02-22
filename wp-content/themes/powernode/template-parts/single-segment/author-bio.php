<?php
/**
 * Displays author info
 *
 * @package PowerNodeWT
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="author-bio">
	<div class="author-avatar">
		<?php				
		$author_bio_avatar_size = apply_filters( 'powernode_author_bio_avatar_size', 80 );
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div>
	<div class="author-description">
		<h4 class="author-title">
			<span class="author-heading">
				<?php
				printf(
					/* translators: %s: post author */
					__( 'Published by %s', 'powernode' ),
					esc_html( get_the_author() )
				);
				?>
			</span>
		</h4>
		<p class="author-desc">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php _e( 'View more posts', 'powernode' ); ?>
			</a>
		</p>
	</div>
</div>
