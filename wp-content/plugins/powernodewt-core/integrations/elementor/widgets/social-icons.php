<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use PowerNodeElementor\IconSelector_Control;

/*
 *  Elementor widget for ImageCarousel
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SocialIcons extends Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

     // wp_register_script( 'pnwt-image-carousel-handle', POWERNODE_ELEXTS_URL . 'assets/js/image-carousel.js', [ 'elementor-frontend' ], POWERNODEWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'powernode-social-icons';
	}
	
	public function get_title() {
		return __( 'Social Icons', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-social-icons';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_social_icons',
			[
				'label' => esc_html__( 'Icons', 'powernodewt-core' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'facebook',
				'options' => array_flip(powernodewt_social_icons_array()),
			]
		);
		
		require POWERNODEWT_CORE_INC_DIR.'/icons_list.php';
		$repeater->add_control(
			'icon_custom',
			[
				'label' => __( 'Icon', 'powernodewt-core' ),
				'type' => \PowerNodeElementor\IconSelector_Control::IconSelector,
				'options' => array_flip( getFlatIconsList() ),
				'default' => 'flaticon-facebook',
				'skin' => 'inline',
				'condition' => [
					'icon' => 'custom',
				],
			]
		);
		$repeater->add_control(
			'icon_alt_custom', [
				'label' => __( 'Image alternative text', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
				'condition' => [
					'icon' => 'custom',
				],
			]
		);
		
		$repeater->add_control(
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
			'icon_items',
			[
				'label' => __( 'Icons', 'powernodewt-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);
	
		$this->add_control(
			'animation',
			[
				'label' => __( 'Animation', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip(powernodewt_animations_array()),
				'separator' => 'before',
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

		$this->end_controls_section();
		
		// General Style -------------------------------
		
		$this->start_controls_section(
			'section_style_general',
			[
				'label' => esc_html__( 'General', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'main_wrap_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_horizontal_alignment_array() ),
			]
		);
		
		$this->end_controls_section();
		
		// Icons Style -------------------------------
		
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icons', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'icon_view',
			[
				'label' => esc_html__( 'View', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'powernodewt-core' ),
					'stacked' => esc_html__( 'Stacked', 'powernodewt-core' ),
					'framed' => esc_html__( 'Framed', 'powernodewt-core' ),
				],
				'default' => 'default',
			]
		);
		
		$this->add_control(
			'icon_shape',
			[
				'label' => esc_html__( 'Shape', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'powernodewt-core' ),
					'square' => esc_html__( 'Square', 'powernodewt-core' ),
				],
				'default' => 'circle',
				'condition' => [
					'icon_view!' => 'default',
				],
			]
		);
		
		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '22px',
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'icon_color',
			[
				'label' => __('Icon Color', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'default' => 'colored',
				'options' => array( ''   => __('Default', 'powernodewt'), 'colored'   => __('Colored', 'powernodewt') ) + powernodewt_button_color_array() + array( 'custom'   => __('Custom', 'powernodewt') ),
			]
		);
		
		$this->add_control(
			'icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'icon_text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'icon_border_color',
			[
				'label' => esc_html__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'heading_icon_hover',
			[
				'label' => esc_html__( 'Button Hover', 'powernodewt-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'icon_hover_color',
			[
				'label' => __('Button Hover Color', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'default' => 'colored',
				'options' => array( ''   => __('Default', 'powernodewt'), 'colored'   => __('Colored', 'powernodewt') ) + powernodewt_button_hover_color_array() + array( 'custom'   => __('Custom', 'powernodewt') ),
			]
		);
		
		$this->add_control(
			'icon_bg_hcolor',
			[
				'label' => esc_html__( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_hover_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'icon_text_hcolor',
			[
				'label' => esc_html__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_hover_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'icon_border_hcolor',
			[
				'label' => esc_html__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_hover_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'icon_el_classes',
			[
				'label' => __( 'Icon Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'icon_wrap_el_classes',
			[
				'label' => __( 'Icon Wrap Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Advanced Style -------------------------------
		
		$this->start_controls_section(
			'section_style_advanced',
			[
				'label' => esc_html__( 'Advanced', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'wrap_id',
			[
				'label' => __( 'Section ID', 'powernodewt-core' ),
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
		echo powernodewt_social_icons( $settings );
		
	}
}
