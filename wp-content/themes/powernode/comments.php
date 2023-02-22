<?php
/**
 * The template file for displaying the comments and comment form for the
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
if ( post_password_required() ) {
	return;
}

if ( $comments ) {
	?>
	<div class="comments" id="comments">
		<?php
		$comments_number = absint( get_comments_number() );
		?>
		<div class="comments-header section-inner small max-percentage">
			<h4 class="comment-reply-title h2-sm">
			<?php
			if ( ! have_comments() ) {
				_e( 'Leave a comment', 'powernode' );
			} elseif ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'powernode' ), esc_html( get_the_title() ) );
			} else {
				echo sprintf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s reply on &ldquo;%2$s&rdquo;',
						'%1$s replies on &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'powernode'
					),
					number_format_i18n( $comments_number ),
					esc_html( get_the_title() )
				);
			}
			?>
			</h4>
		</div>
		<div class="comments-list">
			<ol class="media-list"><?php wp_list_comments( array( 'avatar_size' => 75, 'callback' => 'powernodewt_comments', 'style' => 'ol', 'short_ping'  => true ) ); ?></ol>
			<?php
			$comment_pagination = paginate_comments_links(
				array(
					'echo'      => false,
					'end_size'  => 0,
					'mid_size'  => 0,
					'next_text' => __( 'Newer Comments', 'powernode' ) . ' <span aria-hidden="true">&rarr;</span>',
					'prev_text' => '<span aria-hidden="true">&larr;</span> ' . __( 'Older Comments', 'powernode' ),
				)
			);

			if ( $comment_pagination ) {
				$pagination_classes = '';

				// If we're only showing the "Next" link, add a class indicating so.
				if ( false === strpos( $comment_pagination, 'prev page-numbers' ) ) {
					$pagination_classes = ' only-next';
				}
				?>

				<nav class="comments-pagination pagination<?php echo esc_attr( $pagination_classes ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>" aria-label="<?php esc_attr_e( 'Comments', 'powernode' ); ?>">
					<?php echo wp_kses_post( $comment_pagination ); ?>
				</nav>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}

if ( comments_open() || pings_open() ) {
	comment_form(
		array(
			'class_form'         => 'section-inner thin max-percentage',
			'title_reply_before' => '<h4 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h4>',
		)
	);

} elseif ( is_single() ) {

	if ( $comments ) {
		echo '<hr class="styled-separator is-style-wide" aria-hidden="true" />';
	}
	?>
	<div class="comment-respond" id="respond">
		<p class="comments-closed"><?php _e( 'Comments are closed.', 'powernode' ); ?></p>
	</div>
	<?php
}
