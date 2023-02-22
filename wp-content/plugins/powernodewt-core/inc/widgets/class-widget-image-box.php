<?php
/**
 * Widget Image Box
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WPH_Widget' ) ) {
	return;
}

class PowerNode_Widget_Image_Box extends WPH_Widget {

	public function __construct() {
	
		$target_param_list = array(
			esc_html__( 'Same window', 'powernodewt-core' ) => '_self',
			esc_html__( 'New window', 'powernodewt-core' ) => '_blank',
		);
		
		// Widget Backend information
		$args = array(
			'label' => __( '[POWERNODE] Image Box', 'powernodewt-core' ),
			'description' => __( 'Add Image Box', 'powernodewt-core' ),
			'slug' => 'powernode_widget_image_box',
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
				'type' 			=> 'attach_image',
				'heading' 		=> esc_html__( 'Image', 'powernodewt-core' ),
				'param_name' 	=> 'image',
				'value' 		=> '',
				'description' 	=> esc_html__( 'Select image from media library.', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Image Size', 'powernodewt-core' ),
				'param_name' 	=> 'thumbnail_size',
				'value' 		=> 'full',
				'description' 	=> esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'textfield',
				'heading' 		=> esc_html__( 'Title', 'powernodewt-core' ),
				'param_name' 	=> 'inner_title',
				'description' 	=> esc_html__( 'Enter Title.', 'powernodewt-core' ),
				'admin_label' 	=> true,
			),
			array(
				'type' 			=> 'textarea_html',
				'holder'	 	=> 'p',
				'heading' 		=> esc_html__( 'Content', 'powernodewt-core' ),
				'param_name' 	=> 'content',
				'value' 		=> '',				
			),
			array(
				'type' 			=> 'href',
				'heading' 		=> esc_html__( 'Link', 'powernodewt-core' ),
				'param_name' 	=> 'link',
				'description' 	=> esc_html__( 'Enter URL if you want this image to have a link (Note: parameters like "mailto:" are also accepted).', 'powernodewt-core' ),
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Link Target', 'powernodewt-core' ),
				'param_name' 	=> 'link_target',
				'value' 		=> $target_param_list,
			),
			array(
				'type' 			=> 'dropdown',
				'heading' 		=> esc_html__( 'Image Position', 'powernodewt-core' ),
				'param_name' 	=> 'image_position',
				'value' 		=>  array(
										esc_html__( 'Left', 'powernodewt-core' ) => 'left',
										esc_html__( 'Top', 'powernodewt-core' ) => 'top',
										esc_html__( 'Right', 'powernodewt-core' ) => 'right',
									),
				'std' 			=> 'top',
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
		
		echo powernodewt_image_box( $instance, ( ( !empty( $instance['content'] ) ) ? $instance['content'] : '' ) );

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
			echo "<script type='text/javascript'>
					jQuery(document).ready(function() {
						if ( typeof powernodeMediaInit !== 'undefined' ) {
							powernodeMediaInit('.". $id ." .powernode-image-upload', '.". $id ." .powernode-image-upload-btn', '.". $id ." .powernode-image-src');
						}
						if ( typeof powernodeWidgetInit !== 'undefined' ) {
							powernodeWidgetInit('.". $id ."');
						}
					} );
				</script>";
		echo '</div>';
	}
}
