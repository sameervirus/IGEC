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
?>	
<div class="post-categories">	
	<p class="cat-links theme-color txt-400"><?php echo get_the_category_list( ', ' );?> </p>
</div>