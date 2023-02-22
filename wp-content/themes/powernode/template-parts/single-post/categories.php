<?php
/**
 * Displays the post entry categories
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$categories = get_the_category(get_the_ID());
if( !empty( $categories ) ) {
	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
	?>
	<div class="post-categories cat-links post-title-tag">
	<?php foreach( $categories as $k => $category ) { ?>
		<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="btn btn-tra-theme btn-xs theme-hover" rel="<?php echo esc_attr($rel);?>"><?php echo esc_html( $category->name ); ?></a>
	<?php } ?>
	</div>
<?php } ?>