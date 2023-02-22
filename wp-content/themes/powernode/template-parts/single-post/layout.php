<?php
/**
 * Post Single Layout
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$blog_view_type = 'single';

$sections = powernodewt_blog_single_post_sections_positioning();

// Return if sections are empty.
if ( empty( $sections ) ) {
	return;
}
$classes[] = 'item-entry';
$classes[] = 'single-post';
$classes[] = 'single-post-wrapper';
$classes[] = 'single-post-txt';
?>

<?php do_action( 'powernodewt_before_single_post_content' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div id="single-post" class="entry-post">
	<?php do_action( 'powernodewt_before_single_post_inner_content' ); ?>
	<?php
		foreach ( $sections as $section ) :
			if ( $section == 'tags' && in_array( 'social-links', $sections ) ) {
				$tags_key = array_search( 'tags', $sections );
				if ( !empty( $tags_key ) && $sections[$tags_key+1] == 'social-links' ) {
					echo wp_kses_post( '<div class="post-share-links d-flex align-items-center">' );
				}
			}
			
			get_template_part( 'template-parts/single-post/'. $section  );
			
			if ( $section == 'social-links' && in_array( 'tags', $sections ) ) {
				$social_links_key = array_search( 'social-links', $sections );
				if ( !empty( $social_links_key ) && $sections[$social_links_key-1] == 'tags' ) {
					echo wp_kses_post( '</div>' );
				}
			}
		endforeach; 
	?>		
	<?php do_action( 'powernodewt_after_single_post_inner_content' ); ?>
	</div>
</article>
<?php do_action( 'powernodewt_after_single_post_content' ); ?>