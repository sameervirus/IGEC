<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

/*
 *  Elementor widget for ImageCarousel
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class ReviewsCarousel extends Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'pnwt-reviews-carousel-handle', POWERNODE_ELEXTS_URL . 'assets/js/reviews-carousel.js', [ 'elementor-frontend' ], POWERNODEWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'powernode-reviews-carousel';
	}
	
	public function get_title() {
		return __( 'Reviews Carousel', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-slider-push';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_reviews_carousel',
			[
				'label' => esc_html__( 'Reviews Carousel', 'powernodewt-core' ),
			]
		);
		
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your content', 'powernodewt-core' ),
				'rows' => 6,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'name',
			[
				'label' => esc_html__( 'Name', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your name', 'powernodewt-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your title', 'powernodewt-core' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image', [
				'label' => __( 'Image', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				/* 'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				] */
			]
		);
		$repeater->add_control(
			'alt', [
				'label' => __( 'Image alternative text', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'rating',
			[
				'label' => __( 'Rating', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'1' 				=> '1',
					'2' 				=> '2',
					'3' 				=> '3',
					'4' 				=> '4',
					'5' 				=> '5',
					'' 					=> 'None',
				],
			]
		);
		$repeater->add_control(
			'link', [
				'label' => __( 'Link', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'powernodewt-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);
		
		$this->add_control(
			'reviews_style',
			[
				'label' => esc_html__( 'Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'review-2' => esc_html__( 'Style - 1 ( Default )', 'powernodewt-core' ),
					'review-3' => esc_html__( 'Style - 2', 'powernodewt-core' ),
				],
				'default' => 'review-3',
			]
		);
		
		$this->add_control(
			'reviews_bg',
			[
				'label' => esc_html__( 'Background', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'powernodewt-core' ),
					'bg-lightgrey' => esc_html__( 'Light Grey', 'powernodewt-core' ),
					'bg-dark' => esc_html__( 'Dark', 'powernodewt-core' ),
				],
				'default' => '',
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
		
		// Name Style -------------------------------
		
		$this->start_controls_section(
			'section_style_name',
			[
				'label' => esc_html__( 'Name', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'name_size',
			[
				'label' => __( 'HTML Tag', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h5',
				'options' => [
					'h1' 				=> 'h1',
					'h2' 				=> 'h2',
					'h3' 				=> 'h3',
					'h4' 				=> 'h4',
					'h5' 				=> 'h5',
					'h6' 				=> 'h6',
					'div' 				=> 'div',
					'span' 				=> 'span',
					'p' 				=> 'p',
				],
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'name_font_size',
			[
				'label' => __( 'Font Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'name_custom_font_size',
			[
				'label' => __( 'Custom Font Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1em', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'name_font_size' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'name_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_weight_array() ),
			]
		);
		
		$this->add_control(
			'name_font_style',
			[
				'label' => __( 'Font Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'name_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_transform_array() ),
			]
		);
		
		$this->add_control(
			'name_color',
			[
				'label' => __( 'Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'name_color_custom',
			[
				'label' => __( 'Custom Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#222',
				'condition' => [
					'name_color' => 'custom',
				],
			]
		);
		
		$this->add_control(
			'name_line_height',
			[
				'label' => __( 'Line Height', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'name_letter_spacing',
			[
				'label' => __( 'Letter Spacing', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'name_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'name_el_classes',
			[
				'label' => __( 'Title Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Title Style -------------------------------
		
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'title_size',
			[
				'label' => __( 'HTML Tag', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h5',
				'options' => [
					'h1' 				=> 'h1',
					'h2' 				=> 'h2',
					'h3' 				=> 'h3',
					'h4' 				=> 'h4',
					'h5' 				=> 'h5',
					'h6' 				=> 'h6',
					'div' 				=> 'div',
					'span' 				=> 'span',
					'p' 				=> 'p',
				],
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'title_font_size',
			[
				'label' => __( 'Font Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'title_custom_font_size',
			[
				'label' => __( 'Custom Font Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1em', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'title_font_size' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'title_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_weight_array() ),
			]
		);
		
		$this->add_control(
			'title_font_style',
			[
				'label' => __( 'Font Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'title_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_transform_array() ),
			]
		);
		
		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'title_color_custom',
			[
				'label' => __( 'Custom Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#222',
				'condition' => [
					'title_color' => 'custom',
				],
			]
		);
		
		$this->add_control(
			'title_line_height',
			[
				'label' => __( 'Line Height', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'title_letter_spacing',
			[
				'label' => __( 'Letter Spacing', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_responsive_control(
			'title_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'title_el_classes',
			[
				'label' => __( 'Title Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Content Style -------------------------------
		
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'content_size',
			[
				'label' => __( 'HTML Tag', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'p',
				'options' => [
					'h1' 				=> 'h1',
					'h2' 				=> 'h2',
					'h3' 				=> 'h3',
					'h4' 				=> 'h4',
					'h5' 				=> 'h5',
					'h6' 				=> 'h6',
					'div' 				=> 'div',
					'span' 				=> 'span',
					'p' 				=> 'p',
				],
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'content_font_size',
			[
				'label' => __( 'Font Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'content_custom_font_size',
			[
				'label' => __( 'Custom Font Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1em', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'content_font_size' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'content_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_weight_array() ),
			]
		);
		
		$this->add_control(
			'content_font_style',
			[
				'label' => __( 'Font Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'content_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_transform_array() ),
			]
		);
		
		$this->add_control(
			'content_color',
			[
				'label' => __( 'Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grey',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'content_color_custom',
			[
				'label' => __( 'Custom Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#757575',
				'condition' => [
					'content_color' => 'custom',
				],
			]
		);
		
		$this->add_control(
			'content_line_height',
			[
				'label' => __( 'Line Height', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'content_letter_spacing',
			[
				'label' => __( 'Letter Spacing', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_responsive_control(
			'content_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'content_el_classes',
			[
				'label' => __( 'Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'content_wrap_el_classes',
			[
				'label' => __( 'Content Wrap Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Section Style -------------------------------
		
		$this->start_controls_section(
			'section_style_section',
			[
				'label' => esc_html__( 'Section', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_section_bg' => '1',
				],
			]
		);
		
		$this->add_control(
			'section_bg_color',
			[
				'label' => __( 'Section Gradien Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#005cda',
			]
		);
		
		$this->add_control(
			'section_bg_color2',
			[
				'label' => __( 'Section Gradien Second Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#006cff',
			]
		);
		
		$this->end_controls_section();
		
		// Responsive Style -------------------------------
		
		$this->start_controls_section(
			'section_style_responsive',
			[
				'label' => esc_html__( 'Responsive', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'items_col_lg',
			[
				'label' => esc_html__( 'Large devices', 'powernodewt-core' ),
				'description' => __( 'Show numbers of items Large devices (desktops, 992px and up)', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
					'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
					'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
					'4' => esc_html__( '4 - Item(s)', 'powernodewt-core' ),
					'5' => esc_html__( '5 - Item(s)', 'powernodewt-core' ),
					'6' => esc_html__( '6 - Item(s)', 'powernodewt-core' ),
					'7' => esc_html__( '7 - Item(s)', 'powernodewt-core' ),
					'8' => esc_html__( '8 - Item(s)', 'powernodewt-core' ),
					'9' => esc_html__( '9 - Item(s)', 'powernodewt-core' ),
					'10' => esc_html__( '10 - Item(s)', 'powernodewt-core' ),
				],
				'default' => '3',
			]
		);
		
		$this->add_control(
			'items_col_md',
			[
				'label' => esc_html__( 'Medium devices', 'powernodewt-core' ),
				'description' => esc_html__( 'Show numbers of items Medium devices (tablets, less than 992px)', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
					'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
					'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
					'4' => esc_html__( '4 - Item(s)', 'powernodewt-core' ),
					'5' => esc_html__( '5 - Item(s)', 'powernodewt-core' ),
					'6' => esc_html__( '6 - Item(s)', 'powernodewt-core' ),
					'7' => esc_html__( '7 - Item(s)', 'powernodewt-core' ),
					'8' => esc_html__( '8 - Item(s)', 'powernodewt-core' ),
				],
				'default' => '3',
			]
		);
		
		$this->add_control(
			'items_col_sm',
			[
				'label' => esc_html__( 'Small devices', 'powernodewt-core' ),
				'description' => esc_html__( 'Show numbers of items Small devices (landscape phones, 576px and up).', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
					'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
					'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
					'4' => esc_html__( '4 - Item(s)', 'powernodewt-core' ),
					'5' => esc_html__( '5 - Item(s)', 'powernodewt-core' ),
					'6' => esc_html__( '6 - Item(s)', 'powernodewt-core' ),
				],
				'default' => '2',
			]
		);
		
		$this->add_control(
			'items_col_xs',
			[
				'label' => esc_html__( 'Extra small devices', 'powernodewt-core' ),
				'description' => esc_html__( 'Show numbers of items Extra small devices (portrait phones, less than 576px).', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1 - Item', 'powernodewt-core' ),
					'2' => esc_html__( '2 - Item(s)', 'powernodewt-core' ),
					'3' => esc_html__( '3 - Item(s)', 'powernodewt-core' ),
				],
				'default' => '1',
			]
		);
		
		$this->end_controls_section();
		
		// Carousel Style -------------------------------
		
		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'carousel_per_page',
			[
				'label' => esc_html__( 'Slides per page', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'powernodewt-core' ),
					'2' => esc_html__( '2', 'powernodewt-core' ),
					'3' => esc_html__( '3', 'powernodewt-core' ),
					'4' => esc_html__( '4', 'powernodewt-core' ),
					'5' => esc_html__( '5', 'powernodewt-core' ),
					'6' => esc_html__( '6', 'powernodewt-core' ),
					'7' => esc_html__( '7', 'powernodewt-core' ),
					'8' => esc_html__( '8', 'powernodewt-core' ),
					'9' => esc_html__( '9', 'powernodewt-core' ),
					'10' => esc_html__( '10', 'powernodewt-core' ),
				],
				'default' => '5',
			]
		);
		
		$this->add_control(
			'carousel_navigation',
			[
				'label' => esc_html__( 'Navigation buttons', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'carousel_infinite',
			[
				'label' => esc_html__( 'Infinite Scroll', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'carousel_dots',
			[
				'label' => esc_html__( 'Dots', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'carousel_autoplay',
			[
				'label' => esc_html__( 'Auto Play', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'carousel_autoplay_speed',
			[
				'label' => __( 'Autoplay time', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '3500',
				'placeholder' => '',
				'condition' => [
					'carousel_autoplay' => '1',
				],
			]
		);
		
		$this->end_controls_section();
		
		// Advanced Style --------------------------------------
		
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
				'label' => __( 'Wrap ID', 'powernodewt-core' ),
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
		echo powernodewt_reviews_carousel( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'pnwt-global', 'pnwt-reviews-carousel-handle' ];
		return [];
	}
}
