<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for ImageCarousel
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Gallery extends Widget_Base {
	
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_register_script( 'pnwt-gallery-handle', POWERNODE_ELEXTS_URL . 'assets/js/gallery.js', [ 'elementor-frontend' ], POWERNODEWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'powernode-gallery';
	}
	
	public function get_title() {
		return __( 'Gallery', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-gallery-justified';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_Gallery',
			[
				'label' => esc_html__( 'Gallery', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'gallery_style',
			[
				'label' => esc_html__( 'Gallery Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'grid' => esc_html__( 'Grid ( Default )', 'powernodewt-core' ),
					'masonry' => esc_html__( 'Masonry', 'powernodewt-core' ),
				],
				'default' => 'grid',
			]
		);
		
		$this->add_control(
			'image_box_style',
			[
				'label' => esc_html__( 'Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'powernodewt-core' ),
					'style-1' => esc_html__( 'Style - 1', 'powernodewt-core' ),
					'style-2' => esc_html__( 'Style - 2', 'powernodewt-core' ),
				],
				'default' => 'default',
			]
		);
		
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'image', [
				'label' => __( 'Image', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				]
			]
		);
		
		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
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
			'use_link',
			[
				'label' => esc_html__( 'Use link as', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'None', 'powernodewt-core' ),
					'link' => esc_html__( 'Link', 'powernodewt-core' ),
					'lightbox' => esc_html__( 'Lightbox', 'powernodewt-core' ),
				],
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
			'grid_padding',
			[
				'label' => esc_html__( 'Grid Padding', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'With Padding( Default )', 'powernodewt-core' ),
					'gutter-0' => esc_html__( 'Without Padding', 'powernodewt-core' ),
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
		
		// Image Style -------------------------------
		
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'image_rounded_cornors',
			[
				'label' => esc_html__( 'Rounded Cornors', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'rounded-0' => esc_html__( 'No', 'powernodewt-core' ),
					'rounded' => esc_html__( 'Rounded', 'powernodewt-core' ),
					'rounded-sm' => esc_html__( 'Rounded Small', 'powernodewt-core' ),
					'rounded-lg' => esc_html__( 'Rounded Large', 'powernodewt-core' ),
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
			'hover_overlay',
			[
				'label' => esc_html__( 'Hover Overlay Effect', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
	
		$this->add_control(
			'image_el_classes',
			[
				'label' => __( 'Extra Classes', 'powernodewt-core' ),
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
				'default' => 'default',
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
		
		// Responsive Style --------------------------------------
				
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
		echo powernodewt_gallery( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'pnwt-global', 'pnwt-gallery-handle' ];
		return [];
	}
}
