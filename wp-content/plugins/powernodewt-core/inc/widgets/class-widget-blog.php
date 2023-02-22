<?php
/**
 * Widget Blog
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class PowerNode_Widget_Blog extends WPH_Widget {

	public function __construct() {
				
		$args = array(
			'label' => __( '[POWERNODE] Blog', 'powernodewt-core' ),
			'description' => __( 'Display a list of your blog on your site', 'powernodewt-core' ),
			'slug' => 'powernode_widget_blog',
			'options' => array( 'cache' => false )
		);
		
		$args['fields'] = array(
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title', 'powernodewt-core' ),
				'param_name' 	=> 'title',
				'description' 	=> esc_html__( 'Enter Widget Title.', 'powernodewt-core' ),
				'admin_label' 	=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Style', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_style',
				'value' 		=>  array(
										esc_html__( 'Default', 'powernodewt-core' ) => 'default',
										esc_html__( 'Fancy', 'powernodewt-core' ) => 'fancy',
										esc_html__( 'Box', 'powernodewt-core' ) => 'box',
									),
				'std' 			=> 'default',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Category', 'powernodewt-core' ),
				'param_name' 	=> 'categories',
				'value' 		=>  array_flip( powernodewt_categories( 'category' ) ),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'View', 'powernodewt-core' ),
				'param_name' 	=> 'view_type',
				'value' 		=>  array(
										esc_html__( 'Grid (Default)', 'powernodewt-core' ) => 'grid',
										esc_html__( 'Slider', 'powernodewt-core' ) => 'slider',
										esc_html__( 'list', 'powernodewt-core' ) => 'list',
									),
				'std' 			=> 'grid',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Posts Count', 'powernodewt-core' ),
				'param_name' 	=> 'limit',
				'value' 		=> '3',
				'description' 	=> esc_html__( 'Numbers of items show per page.', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Order by', 'powernodewt-core' ),
				'param_name' 	=> 'orderby',
				'value' 		=>  array(
										esc_html__( 'Date', 'powernodewt-core' ) => 'date',
										esc_html__( 'Title', 'powernodewt-core' ) => 'title',
										esc_html__( 'Random', 'powernodewt-core' ) => 'random',
										esc_html__( 'Number of comments', 'powernodewt-core' ) => 'comment_count',
										esc_html__( 'Last modified', 'powernodewt-core' ) => 'modified',
									),
				'std' 			=> 'date',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Sort Order', 'powernodewt-core' ),
				'param_name' 	=> 'order',
				'value' 		=>  array(
										esc_html__( 'ASC', 'powernodewt-core' ) => 'ASC',
										esc_html__( 'DESC', 'powernodewt-core' ) => 'DESC',
									),
				'std' 			=> 'DESC',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Image', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_image',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Image', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_thumbnail',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Title', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_title',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Meta', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_meta',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Tags', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_tags',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Post Content', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_content',
				'value' 		=>  array(
										esc_html__( 'Excerpt', 'powernodewt-core' ) => 'excerpt',
										esc_html__( 'Full', 'powernodewt-core' ) => 'full',
										esc_html__( 'Hide', 'powernodewt-core' ) => false,										
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Excerpt Length', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_excerpt_length',
				'value' 		=> '20',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Read More', 'powernodewt-core' ),
				'param_name' 	=> 'blog_loop_post_read_more',
				'value' 		=>  array(
										esc_html__( 'Link (Default)', 'powernodewt-core' ) => 'link',
										esc_html__( 'Button', 'powernodewt-core' ) => 'button',
										esc_html__( 'Icon', 'powernodewt-core' ) => 'icon',
										esc_html__( 'Hide', 'powernodewt-core' ) => false,
									),
				'std' 			=> 'link',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Rows', 'powernodewt-core' ),
				'param_name' 	=> 'nums_rows',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'powernodewt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Navigation', 'powernodewt-core' ),
				'param_name' 	=> 'slider_nav',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Navigation Style', 'powernodewt-core' ),
				'param_name' 	=> 'slider_nav_style',
				'value' 		=>  array(
										esc_html__( 'Circle (default)', 'powernodewt-core' ) => 'cir',
										esc_html__( 'Rectangle', 'powernodewt-core' ) => 'rec',
									),
				'std' 			=> 'cir',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Navigation Position', 'powernodewt-core' ),
				'param_name' 	=> 'slider_nav_position',
				'value' 		=>  array(
										esc_html__( 'Slider Middle (Default)', 'powernodewt-core' ) => 'slider-middle',
										esc_html__( 'Title Right', 'powernodewt-core' ) => 'title-right',
									),
				'std' 			=> 'title-right',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Loop', 'powernodewt-core' ),
				'param_name' 	=> 'slider_loop',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Slider Dots', 'powernodewt-core' ),
				'param_name' 	=> 'slider_dots',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Auto Play', 'powernodewt-core' ),
				'param_name' 	=> 'slider_autoplay',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Large devices', 'powernodewt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Large devices (desktops, 992px and up)', 'powernodewt-core' ),
				'param_name' 	=> 'items_col_lg',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'powernodewt-core' ),
											'5' => esc_html__( '5 - Item(s)', 'powernodewt-core' ),
											'6' => esc_html__( '6 - Item(s)', 'powernodewt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Medium devices', 'powernodewt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Medium devices (tablets, less than 992px)', 'powernodewt-core' ),
				'param_name' 	=> 'items_col_md',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'powernodewt-core' ),
											'5' => esc_html__( '5 - Item(s)', 'powernodewt-core' ),
											'6' => esc_html__( '6 - Item(s)', 'powernodewt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Small devices', 'powernodewt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Small devices (landscape phones, 576px and up).', 'powernodewt-core' ),
				'param_name' 	=> 'items_col_sm',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
											'4' => esc_html__( '4 - Item(s)', 'powernodewt-core' ),
										)
									),
				'std' 			=> '1',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Extra small devices', 'powernodewt-core' ),
				'description' 	=> esc_html__( 'Show numbers of items Extra small devices (portrait phones, less than 576px).', 'powernodewt-core' ),
				'param_name' 	=> 'items_col_xs',
				'value' 		=>  array_flip(
										array(
											'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
											'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
											'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
										)
									),
				'std' 			=> '1',
			),
		);
		
		$this->create_widget( $args );

	}

	/**
	 * Output widget.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	public function widget( $args, $instance ) {
		
		$instance['display_type'] = 'widget';
		
		extract($args);
			
		echo wp_kses_post( $before_widget );
		
		if(!empty($instance['title'])) { echo wp_kses_post( $before_title ) . $instance['title'] . wp_kses_post( $after_title ); };
		
		echo powernodewt_blog( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

		echo wp_kses_post( $after_widget );

	}
	
	/**
	 * Output widget.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	function form( $instance ) {
		$id = powernodewt_uniqid('powernode-widget-');
		echo '<div class="' . $id . '">';
			parent::form( $instance );
		echo '</div>';
	}
}
