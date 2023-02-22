<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

$sidebar = powernodewt_get_sidebar_name();

// Retunr if full width or full screen
if ( !is_active_sidebar( $sidebar ) &&  in_array( powernodewt_get_layout(), array( 'full-width' ) ) ) {
	return;
}
?>
<aside <?php echo powernodewt_sidebar_atts(); ?>>
	<div class="sidebar-inner">
	<?php
	if ( $sidebar ) {
		dynamic_sidebar( $sidebar );
	} ?>
	</div>
</aside>