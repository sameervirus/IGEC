<?php
/**
 * Displays the post entry highlight
 *
 * @package PowerNodeWT
 * @since 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sections	= powernodewt_portfolio_post_meta();
$post_style	= powernodewt_get_loop_prop( 'powernode_portfolio_loop_post_style' );

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}
?>
<div class="entry-portfolio-meta mb-10 post-author">
	
	<?php do_action( 'powernodewt_before_portfolio_post_archives_meta' ); ?>
	
	<?php foreach ( $sections as $section ) :

		switch ( $section ) {
			case 'author': ?>	
				<span class="author">
					<span class="post-author">
					<?php echo sprintf( 'By %s', ucfirst( get_the_author() ) ); ?>
					</span>
				</span> <?php					
				break;
			case 'categories':
				$categories_list = get_the_term_list(get_the_ID(), 'portfolio-cat', '', ', ', '');
				if ( $categories_list ) {?>					
					<span class="meta-cats"><?php echo wp_kses_post($categories_list);?> </span><?php
				}
				break;
			case 'tags':
				$tags_list = get_the_tag_list( '', ', ' );
				if ( $tags_list ) {?>					
					<span class="meta-tags"><?php echo wp_kses_post($tags_list);?> </span><?php
				}
				break;
			case 'comments':				
				if( ! post_password_required() && ( comments_open() || get_comments_number() ) ){?>
					<span class="meta-comments">
						<?php 
						$comment_tag = '%s<span class="post-meta-label"> %s</span>';			
						comments_popup_link( 
							sprintf( $comment_tag, '0', esc_html__( 'Comments', 'powernode' ) ),
							sprintf( $comment_tag, '1', esc_html__( 'Comment', 'powernode' ) ),
							sprintf( $comment_tag, '%', esc_html__( 'Comments', 'powernode' ) )
						);?>			
					</span><?php 
				}
				break;
			case 'date':				
				if( $post_style == 'fancy' ) {
					echo '<h5 class="h5-md txt-upcase grey-color">' . get_the_date('M d, Y') . '</h5>';
				} else {
					echo '<span class="meta-date"><a href="'. esc_url( get_permalink() ) . '">' . get_the_date() .'</a></span>';
				}				
				break;
			case 'reading-time':
				echo '<span class="meta-reading-time">' . esc_attr( powernodewt_reading_time() ) . '</span>';
				break;
			case 'edit':
				edit_post_link( sprintf(esc_html__( 'Edit ', 'powernode' ) ), '<span class="meta-edit-link">', '</span>');
				break;
			
			default:				
		}
	endforeach; ?>		
	
	<?php do_action( 'powernodewt_after_portfolio_post_archives_meta' ); ?>	
	
</div>