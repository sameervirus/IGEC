<?php
/**
*	Register layout content type
*/
function powernodewt_layout_post_type() {
	
	$singular_name = get_option('layout-singular-name', 'Layout');
	$name = get_option('layout-name', 'Layouts');
	$slug = get_option('layout-slug', 'layout');
	$category_name = sprintf( __('%s Groups','powernodewt-core'), $singular_name );
	$categories_name = sprintf( __('%s Groups','powernodewt-core'), $singular_name );
	$category_slug = get_option('powernode-layout-groups', 'layout-group');
	
	$args = array(
		'labels' 				=> powernodewt_posttype_labels( $singular_name, $name ),
		'menu_icon'				=> 'dashicons-editor-kitchensink',
		'public' 				=> true,
		'has_archive' 			=> true,
		'with_front'            => true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export' 			=> true,
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'show_in_menu' 			=> true,
		'show_in_rest' 			=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'powernodewt_core_layout_slug', $slug ) ),
		'supports' 				=> array( 'title', 'editor', 'author', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'elementor' ),
	);
	
	register_post_type( 'layout', $args );
	
	register_taxonomy( 'layout-group', 'layout', array(
		'hierarchical' 			=> true,
		'labels' 				=> powernodewt_texonomy_labels( $category_name, $categories_name ),
		'exclude_from_search' 	=> true,
		'public' 				=> true,
		'show_ui' 				=> true,
		'rewrite' 				=> array( 'slug' => apply_filters( 'powernodewt_core_layout_group_slug', $category_slug ) ),
		'menu_icon' 			=> 'dashicons-editor-kitchensink',
		'supports' 				=> array('title', 'editor'),
		'query_var' 			=> true,
		'show_in_nav_menus' 	=> false,
		'show_admin_column'     => true,
		'show_tagcloud'         => true,
		'show_in_rest'			=> true,
	) );
}	
add_action( 'init', 'powernodewt_layout_post_type' );

if ( ! function_exists( 'powernodewt_layout_meta_boxes' ) ) {
	
	function powernodewt_layout_meta_boxes() {
				
		$meta_boxes = array();
		
		$layouts = array( 'default' => esc_html__( 'Default', 'powernode' ), 'hidden' => esc_html__( 'Hidden', 'powernode' ) ) + powernodewt_get_post_type_posts( array( 'post_type' => 'layout' ) );
		
		// Post format's meta box
		$meta_boxes[] = array(
			'id'      		=> POWERNODEWT_PREFIX.'pnwt_layout_options',
			'title'    		=> esc_html__( 'PowerNode Options', 'powernode' ),
			'tabs'      	=> array(
								'general'			=> 'General',
							),
			'tab_style' => 'left',
			'tab_wrapper' 	=> true,
			'pages'			=> array( 'layout'),
			'context'  		=> 'normal',
			'priority' 		=> 'high',
			'autosave' 		=> true,
			'fields'   		=> array(
				array(
					'type' 			=> 'heading',
					'tab'			=> 'general',
					'name' 			=> 'General Settings',
				),
				array(
					'name'    		=> esc_html__( 'Type', 'powernode' ),
					'id'      		=> POWERNODEWT_PREFIX.'layout_page_layout',
					'type'    		=> 'select_advanced',
					'std'			=> 'default',
					'options' 		=> array(
										'custom' 		=> esc_html__( 'Custom', 'powernode' ),
										'submenu' 	=> esc_html__( 'Submenu', 'powernode' ),
										'footer' 	=> esc_html__( 'Footer', 'powernode' ),
									),
					'tab'			=> 'general',
				),
			),
		);

		return apply_filters( 'powernode_layout_meta_boxes', $meta_boxes );
	}
	
	add_filter( 'rwmb_meta_boxes', function ( $meta_boxes ) {
		$powernodewt_layout_meta_boxes = powernodewt_layout_meta_boxes();
		if ( !empty( $powernodewt_layout_meta_boxes ) ) {
			$meta_boxes = array_merge( $meta_boxes, $powernodewt_layout_meta_boxes );
		}
		return $meta_boxes;
	} );
	
	add_filter( 'powernode_metaboxes_post_types_scripts', function ( $post_types ) {
		$powernodewt_layout_meta_boxes = powernodewt_layout_meta_boxes();
		if ( !empty( $powernodewt_layout_meta_boxes ) ) {
			$post_types[] = 'layout';
		}
		return $post_types;
	} );	
}