<?php
/**
 * Widget Posts
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class PowerNode_Widget_Posts extends WPH_Widget {
	
	public function __construct() {
		
		$args = array(
			'label' => __( '[POWERNODE] Posts', 'powernodewt-core' ),
			'description' => __( 'Display a list of your posts on your site', 'powernodewt-core' ),
			'slug' => 'powernode_widget_posts',
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
				'heading' 		=> esc_html__( 'Post Type', 'powernodewt-core' ),
				'param_name' 	=> 'posts_type',
				'value' 		=>  array(
										esc_html__( 'Post', 'powernodewt-core' ) => 'post',
										esc_html__( 'Portfolio', 'powernodewt-core' ) => 'portfolio',
										esc_html__( 'Segment', 'powernodewt-core' ) => 'segment',
									),
				'std' 			=> 'post',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Category', 'powernodewt-core' ),
				'param_name' 	=> 'categories',
				'value' 		=> array_flip ( powernodewt_categories( 'category' ) ),
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
				'param_name' 	=> 'posts_thumbnail',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Title', 'powernodewt-core' ),
				'param_name' 	=> 'posts_title',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post date', 'powernodewt-core' ),
				'param_name' 	=> 'posts_date',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> true,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Show Post Categories', 'powernodewt-core' ),
				'param_name' 	=> 'posts_categories',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Post Content', 'powernodewt-core' ),
				'param_name' 	=> 'Post Content',
				'value' 		=>  array(
										esc_html__( 'Excerpt', 'powernodewt-core' ) => 'excerpt',
										esc_html__( 'Full', 'powernodewt-core' ) => 'full',
										esc_html__( 'Hide', 'powernodewt-core' ) => false,										
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Excerpt Length', 'powernodewt-core' ),
				'param_name' 	=> 'posts_excerpt_length',
				'value' 		=> '20',
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'General', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Removed List Border', 'powernodewt-core' ),
				'param_name' 	=> 'remove_list_border',
				'value' 		=>  array(
										esc_html__( 'Yes', 'powernodewt-core' ) => true,
										esc_html__( 'No', 'powernodewt-core' ) => false,
									),
				'std' 			=> false,
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'Image', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Image Size', 'powernodewt-core' ),
				'param_name' 	=> 'thumbnail_size',
				'value' 		=> 'full',
				'description' 	=> esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Rounded Cornors', 'powernodewt-core' ),
				'param_name' 	=> 'image_rounded_cornors',
				'value' 		=>  array(
										'rounded-0' => esc_html__( 'No', 'powernodewt-core' ),
										'rounded' => esc_html__( 'Rounded', 'powernodewt-core' ),
										'rounded-sm' => esc_html__( 'Rounded Small', 'powernodewt-core' ),
										'rounded-lg' => esc_html__( 'Rounded Large', 'powernodewt-core' ),
									),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'Title', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'HTML Tag', 'powernodewt-core' ),
				'param_name' 	=> 'title_size',
				'value' 		=>  array(
										'h1' 				=> 'h1',
										'h2' 				=> 'h2',
										'h3' 				=> 'h3',
										'h4' 				=> 'h4',
										'h5' 				=> 'h5',
										'h6' 				=> 'h6',
										'div' 				=> 'div',
										'span' 				=> 'span',
										'p' 				=> 'p',
									),
				'std' 			=> 'div',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Size', 'powernodewt-core' ),
				'param_name' 	=> 'title_font_size',
				'value' 		=> powernodewt_font_size_array(),
				'std' 			=> 'sm',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Weight', 'powernodewt-core' ),
				'param_name' 	=> 'title_font_weight',
				'value' 		=> powernodewt_font_weight_array(),
				'std' 			=> '400',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Style', 'powernodewt-core' ),
				'param_name' 	=> 'title_font_style',
				'value' 		=> powernodewt_font_style_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Text Transform', 'powernodewt-core' ),
				'param_name' 	=> 'title_text_transform',
				'value' 		=> powernodewt_text_transform_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Color', 'powernodewt-core' ),
				'param_name' 	=> 'title_color',
				'value' 		=> powernodewt_color_array(),
				'std' 			=> 'grey',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Alignment', 'powernodewt-core' ),
				'param_name' 	=> 'title_alignment',
				'value' 		=> powernodewt_text_alignment_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title Length', 'powernodewt-core' ),
				'param_name' 	=> 'posts_title_length',
				'value' 		=> '5',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title Extra Classes', 'powernodewt-core' ),
				'param_name' 	=> 'title_el_classes',
				'value' 		=> '',
			),
			array(
				'type' 			=> 'heading',
				'heading' 		=> esc_html__( 'Content', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'HTML Tag', 'powernodewt-core' ),
				'param_name' 	=> 'content_size',
				'value' 		=>  array(
										'h1' 				=> 'h1',
										'h2' 				=> 'h2',
										'h3' 				=> 'h3',
										'h4' 				=> 'h4',
										'h5' 				=> 'h5',
										'h6' 				=> 'h6',
										'div' 				=> 'div',
										'span' 				=> 'span',
										'p' 				=> 'p',
									),
				'std' 			=> 'p',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Size', 'powernodewt-core' ),
				'param_name' 	=> 'content_font_size',
				'value' 		=> powernodewt_font_size_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Weight', 'powernodewt-core' ),
				'param_name' 	=> 'content_font_weight',
				'value' 		=> powernodewt_font_weight_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Font Style', 'powernodewt-core' ),
				'param_name' 	=> 'content_font_style',
				'value' 		=> powernodewt_font_style_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Text Transform', 'powernodewt-core' ),
				'param_name' 	=> 'content_text_transform',
				'value' 		=> powernodewt_text_transform_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Color', 'powernodewt-core' ),
				'param_name' 	=> 'content_color',
				'value' 		=> powernodewt_color_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Alignment', 'powernodewt-core' ),
				'param_name' 	=> 'content_alignment',
				'value' 		=> powernodewt_text_alignment_array(),
				'std' 			=> '',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Content Extra Classes', 'powernodewt-core' ),
				'param_name' 	=> 'content_el_classes',
				'value' 		=> '',
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Content Wrap Extra Classes', 'powernodewt-core' ),
				'param_name' 	=> 'content_wrap_el_classes',
				'value' 		=> '',
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
		
		echo powernodewt_posts( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

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
