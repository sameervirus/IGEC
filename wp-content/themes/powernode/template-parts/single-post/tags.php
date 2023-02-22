<?php
/**
 * Display Single Post Tags
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tags_list = get_the_tag_list(' ');
if ( empty( $tags_list ) ) return;
?>
<div class="entry-tags"><span class="tags-label d-none"><?php esc_html_e( 'Tags: ', 'powernode' ); ?></span><span class="tags-list post-tags-list"><?php echo wp_kses_post( get_the_tag_list('<span>', '', '</span>') ); ?></span></div>
	