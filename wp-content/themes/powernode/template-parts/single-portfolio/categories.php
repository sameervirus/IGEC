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

$categories_list = get_the_term_list(get_the_ID(), 'portfolio-cat', '', ' / ', '');
if ( $categories_list ) {
$args = array();
$args['class'][] = 'post-categories px-2 project-title';
$args['class'][] = ( powernodewt_get_post_meta( 'portfolio_single_layout' ) == 'compact' ) ? 'col-xl-10 offset-xl-1' : '';
?>	
<div <?php echo powernodewt_stringify_atts( $args ); ?>>	
	<p class="cat-links p-sm theme-color txt-500 mb-3"><?php echo wp_kses_post($categories_list);?></p>
</div>				
<?php
}
?>