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
$categories_list = get_the_term_list(get_the_ID(), 'portfolio-cat', '', ', ', '');
if ( $categories_list ) {?>	
<div class="post-categories">	
	<p class="cat-links p-sm"><?php echo wp_kses_post( $categories_list );?></p>
</div>				
<?php
}
?>	
