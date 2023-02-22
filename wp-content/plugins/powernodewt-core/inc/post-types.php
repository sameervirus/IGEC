<?php
require_once( 'post-types/portfolio.php' );
require_once( 'post-types/layouts.php' );
require_once( 'post-types/segment.php' );

/**
 *	Get content type labels
 */
function powernodewt_posttype_labels( $singular_name, $name, $title = FALSE ) {
	if( !$title )
		$title = $name;
	
	return array(
		'name' 					=> $title,
		'singular_name' 		=> $singular_name,
		'add_new' 				=> __('Add New','powernodewt-core'),
		'add_new_item' 			=> sprintf( __('Add New %s','powernodewt-core'), $singular_name ),
		'edit_item' 			=> sprintf( __('Edit %s','powernodewt-core'), $singular_name ),
		'new_item' 				=> sprintf( __('New %s','powernodewt-core'), $singular_name ),
		'view_item' 			=> sprintf( __('View %s','powernodewt-core'), $singular_name ),
		'search_items' 			=> sprintf( __('Search %s','powernodewt-core'), $name ),
		'not_found' 			=> sprintf( __('No %s found','powernodewt-core'), $name ),
		'not_found_in_trash' 	=> sprintf( __('No %s found in Trash','powernodewt-core'), $name ),
		'parent_item_colon' 	=> '',
		'menu_name'            	=> $name,
		'featured_image' 		=> sprintf( __('%s Image','powernodewt-core'), $singular_name ),
		'set_featured_image' 	=> sprintf( __('Set %s Image','powernodewt-core'), $singular_name ),
		'remove_featured_image' => sprintf( __('Remove %s image','powernodewt-core'), $singular_name ),
		'use_featured_image'	=> sprintf( __('Use as %s image','powernodewt-core'), $singular_name ),
	);
}

/**
 *	Get texonomy labels
 */
function powernodewt_texonomy_labels( $singular_name, $name ) {
	
	return array(
        'name'              => $name,
        'singular_name'     => $singular_name,
        'search_items'      => sprintf( __('Search %s','powernodewt-core'), $name ),
        'all_items'         => sprintf( __('All %s','powernodewt-core'), $name ),
        'view_item'         => sprintf( __('View %s','powernodewt-core'), $singular_name ),
        'parent_item'       => sprintf( __('Parent %s','powernodewt-core'), $singular_name ),
        'parent_item_colon' => sprintf( __('Parent %s','powernodewt-core'), $singular_name ),
        'edit_item'         => sprintf( __('Edit %s','powernodewt-core'), $singular_name ),
        'update_item'       => sprintf( __('Update %s','powernodewt-core'), $singular_name ),
        'add_new_item'      => sprintf( __('Add New %s','powernodewt-core'), $singular_name ),
        'new_item_name'     => sprintf( __('New %s Name','powernodewt-core'), $singular_name ),
        'not_found'         => sprintf( __('No %s Found','powernodewt-core'), $singular_name ),
        'back_to_items'     => sprintf( __('Back to %s','powernodewt-core'), $singular_name ),
        'menu_name'         => sprintf( __('%s','powernodewt-core'), $singular_name ),
    );
}