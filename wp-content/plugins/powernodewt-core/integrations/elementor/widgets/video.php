<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size; 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Video extends Widget_Base {
	
	public function get_name() {
		return 'powernode-video';
	}
	
	public function get_title() {
		return __( 'Video', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-video';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__( 'Video', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Url', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'placeholder' => esc_html__( 'Enter your URL', 'elementor' ) . ' (YouTube)',
				'default' => '',
				'label_block' => true,
				'frontend_available' => true,
			]
		);
		
		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'     => array(
                    'active'  => true
                ),
			]
		);
		
		$this->add_control(
			'image_alt_text',
			[
				'label' => esc_html__( 'Image Alternative Text', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'label_block' => true,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
			]
		);
		
		$this->add_control(
			'image_rounded_cornors',
			[
				'label' => esc_html__( 'Rounded Cornors', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' 				=> esc_html__( 'Default', 'powernodewt-core' ),
					'rounded-0' 	=> esc_html__( 'No', 'powernodewt-core' ),
					'rounded' 		=> esc_html__( 'Rounded', 'powernodewt-core' ),
					'rounded-sm'	=> esc_html__( 'Rounded Small', 'powernodewt-core' ),
					'rounded-lg' 	=> esc_html__( 'Rounded Large', 'powernodewt-core' ),
				],
				'default' => '',
			]
		);
		
		$this->add_responsive_control(
			'image_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( '//your-link.com', 'powernodewt-core' ),
				'default' => [
					'url' => '',
				],
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'animation',
			[
				'label' => __( 'Animation', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => array_flip(powernodewt_animations_array()),
			]
		);
		$this->add_control(
			'animation_delay',
			[
				'label' => __( 'Animation delay', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '0', 'powernodewt-core' ),
				'placeholder' => '',
				'description' => __( 'Add animation delay like 800ms,0.4s.', 'powernodewt-core' ),
				'condition' => [
					'animation!' => '',
				],
			]
		);
		
		$this->add_control(
			'el_classes',
			[
				'label' => __( 'Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'wrap_el_classes',
			[
				'label' => __( 'Wrap Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo powernodewt_image( $settings );
		
	}
}