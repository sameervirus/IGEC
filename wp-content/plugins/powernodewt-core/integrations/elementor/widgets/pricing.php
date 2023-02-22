<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use PowerNodeElementor\IconSelector_Control;

/*
 *  Elementor widget for Team Member
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Pricing extends Widget_Base {
	
	public function get_name() {
		return 'powernode-pricing';
	}
	
	public function get_title() {
		return __( 'Pricing', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-price-table';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__( 'General', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'pricing_box_style',
			[
				'label' => __( 'Pricing Box Style', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'pricing-5-table' => 'Style - 1',
					'pricing-1-table' => 'Style - 2',
				],
				'default' => 'pricing-5-table',
			]
		);
		
		$this->add_control(
			'icon_type',
			[
				'label' => __( 'Icon Type', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'none' => 'None',
					'icon' => 'Icon',
					'flat-icon' => 'Flat icon',
					'text' => 'Text',
					'image' => 'Image',
				],
				'default' => 'none',
			]
		);
		
		require POWERNODEWT_CORE_INC_DIR.'/icons_list.php';
		$this->add_control(
			'flat_icon',
			[
				'label' => __( 'Flat Icon', 'powernodewt-core' ),
				'type' => \PowerNodeElementor\IconSelector_Control::IconSelector,
				'options' => array_flip( getFlatIconsList() ),
				'default' => 'flaticon-calculator',
				'skin' => 'inline',
				'condition' => [
					'icon_type' => 'flat-icon',
				],
			]
		); 
		
		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'powernodewt-core' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'icon_type' => array( 'icon' ),
				),
			]
		);
		
		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic'     => array(
                    'active'  => true
                ),
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'icon_type' => 'image',
				],
			]
		);
		
		$this->add_control(
			'icon_text',
			[
				'label' => __( 'Icon Text', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'icon_type' => 'text',
				],
			]
		);
		
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Enter the title', 'powernodewt-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'content',
			[
				'label' => 'Content',
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Enter the description', 'powernodewt-core' ),
				'rows' => 10,
				'separator' => 'after',
				'label_block' => true,
			]
		);
		
		// Content List -------------------------------
		
		$repeater = new \Elementor\Repeater();
		
		require POWERNODEWT_CORE_INC_DIR.'/icons_list.php';
		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'powernodewt-core' ),
				'type' => \PowerNodeElementor\IconSelector_Control::IconSelector,
				'options' => array_flip( getFlatIconsList() ),
				'default' => 'flaticon-facebook',
				'skin' => 'inline',
			]
		);
		
		$repeater->add_control(
			'icon_alt', [
				'label' => __( 'Icon alternative text', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'content_items',
			[
				'label' => __( 'Content List', 'powernodewt-core' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);
		
		$this->add_control(
			'price_amount',
			[
				'label' => 'Price',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Ex: 199', 'powernodewt-core' ),
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'price_currency',
			[
				'label' => 'Currency',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Ex: $', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'price_period',
			[
				'label' => 'Period',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Ex: Per Month', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'price_prefix',
			[
				'label' => 'Prefix',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Ex: 99', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'price_validity',
			[
				'label' => 'Validity',
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Ex: /mo', 'powernodewt-core' ),
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'powernodewt' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Get Started', 'powernodewt' ),
				
			]
		);
		
		$this->add_control(
			'button_link',
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
				'default' => '',
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

		$this->end_controls_section();
		
		// Content Wrap Section -------------------------------
		
		$this->start_controls_section(
			'section_style_pricing_box_wrap',
			[
				'label' => esc_html__( 'Price Box', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'add_pricing_box_shadow',
			[
				'label' => esc_html__( 'Add Box Shadow', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'pricing_box_bg_color',
			[
				'label' => __( 'Icon Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'white',
				'options' => array_flip(powernodewt_bg_color_array()),
			]
		);
		
		$this->end_controls_section();
		
		// Icon Style -------------------------------
		
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'icon_type',
							'operator' => '!=',
							'value' => '',
						],
					],
				],
			]
		);
		
		$this->add_control(
			'icon_view',
			[
				'label' => esc_html__( 'Icon View', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'powernodewt-core' ),
					'stacked' => esc_html__( 'Stacked', 'powernodewt-core' ),
					'framed' => esc_html__( 'Framed', 'powernodewt-core' ),
					'bg' => esc_html__( 'Background', 'powernodewt-core' ),
				],
				'default' => 'default',
				'condition' => [
					'icon_type!' => 'none',
				],
			]
		);
		
		$this->add_control(
			'icon_shape',
			[
				'label' => esc_html__( 'Icon Shape', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => esc_html__( 'Circle', 'powernodewt-core' ),
					'square' => esc_html__( 'Square', 'powernodewt-core' ),
				],
				'default' => 'circle',
				'condition' => [
					'icon_type!' => 'none',
					'icon_view!' => 'default',
					'icon[value]!' => '',
				],
			]
		);
		
		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '93px',
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'icon_type' => array('text', 'flat-icon')
				],
			]
		);
		
		$this->add_control(
			'icon_bg_image',
			[
				'label' => __( 'Icon Background Image', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => POWERNODEWT_IMAGES_DIR_URI.'/ico-bkg.png',
				],
				'dynamic'     => array(
                    'active'  => true
                ),
				'condition' => [
					'icon_view' => 'bg',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'label' => __( 'Icon Background Image Size', 'powernodewt-core' ),
				'name' => 'icon_bg_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'icon_view' => 'bg',
				],
			]
		);
		
		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'icon_color_custom',
			[
				'label' => __( 'Icon Custom Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_color' => 'custom',
				],
			]
		);
		
		$this->add_control(
			'icon_bg_color',
			[
				'label' => __( 'Icon Background Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(powernodewt_bg_color_array()),
			]
		);
		
		$this->add_control(
			'icon_bg_color_custom',
			[
				'label' => __( 'Icon Background Color Custom', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_bg_color' => 'custom',
				],
			]
		);
		
		$this->add_responsive_control(
			'icon_alignment',
			[
				'label' => __( 'Icon Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_horizontal_alignment_array() ),
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
		
		// Image Style -------------------------------
		
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'icon_type' => 'image'
				],
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
				'default' => 'rounded',
			]
		);
		
		$this->add_control(
			'image_below_padding',
			[
				'label' => __( 'Image Below Padding', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'image_wrap_el_classes',
			[
				'label' => __( 'Image Wrap Extra Classes', 'powernodewt-core' ),
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
				'default' => '',
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
				'default' => 'md',
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
				'label' => __( 'Content Wrap Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Content List Style --------------------------------------
		
		$this->start_controls_section(
			'section_style_content_list',
			[
				'label' => esc_html__( 'Content List', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'cotnent_list_size',
			[
				'label' => __( 'HTML Tag', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'span',
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
			'cotnent_list_font_size',
			[
				'label' => __( 'Font Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'cotnent_list_custom_font_size',
			[
				'label' => __( 'Custom Font Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1em', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'cotnent_list_font_size' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'cotnent_list_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_weight_array() ),
			]
		);
		
		$this->add_control(
			'cotnent_list_font_style',
			[
				'label' => __( 'Font Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'cotnent_list_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_transform_array() ),
			]
		);
		
		$this->add_control(
			'cotnent_list_color',
			[
				'label' => __( 'Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grey',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'cotnent_list_color_custom',
			[
				'label' => __( 'Custom Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#757575',
				'condition' => [
					'cotnent_list_color' => 'custom',
				],
			]
		);
		
		$this->add_control(
			'cotnent_list_line_height',
			[
				'label' => __( 'Line Height', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'cotnent_list_letter_spacing',
			[
				'label' => __( 'Letter Spacing', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'cotnent_list_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'cotnent_list_el_classes',
			[
				'label' => __( 'Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->add_control(
			'cotnent_list_wrap_el_classes',
			[
				'label' => __( 'Wrap Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Price Style --------------------------------------
		
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'price_size',
			[
				'label' => __( 'HTML Tag', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'span',
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
			'price_font_size',
			[
				'label' => __( 'Font Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'price_custom_font_size',
			[
				'label' => __( 'Custom Font Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1em', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'price_font_size' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'price_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_weight_array() ),
			]
		);
		
		$this->add_control(
			'price_font_style',
			[
				'label' => __( 'Font Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'price_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'uppercase',
				'options' => array_flip( powernodewt_text_transform_array() ),
			]
		);
		
		$this->add_control(
			'price_color',
			[
				'label' => __( 'Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'price_color_custom',
			[
				'label' => __( 'Custom Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'price_color' => 'custom',
				],
			]
		);
		
		$this->add_control(
			'price_line_height',
			[
				'label' => __( 'Line Height', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'price_letter_spacing',
			[
				'label' => __( 'Letter Spacing', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'price_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'price_el_classes',
			[
				'label' => __( 'Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
			
		$this->end_controls_section();
		
		// Period Style --------------------------------------
		
		$this->start_controls_section(
			'section_style_period',
			[
				'label' => esc_html__( 'Period', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'period_size',
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
			'period_font_size',
			[
				'label' => __( 'Font Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'period_custom_font_size',
			[
				'label' => __( 'Custom Font Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1em', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'period_font_size' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'period_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'bold',
				'options' => array_flip( powernodewt_font_weight_array() ),
			]
		);
		
		$this->add_control(
			'period_font_style',
			[
				'label' => __( 'Font Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'period_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'uppercase',
				'options' => array_flip( powernodewt_text_transform_array() ),
			]
		);
		
		$this->add_control(
			'period_color',
			[
				'label' => __( 'Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'period_color_custom',
			[
				'label' => __( 'Custom Color', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'period_color' => 'custom',
				],
			]
		);
		
		$this->add_control(
			'period_line_height',
			[
				'label' => __( 'Line Height', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'period_letter_spacing',
			[
				'label' => __( 'Letter Spacing', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'period_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'period_el_classes',
			[
				'label' => __( 'Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		// Button Style --------------------------------------
		
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'button_style',
			[
				'label' => __('Style', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'flat' => esc_html__( 'Flat', 'powernodewt' ),
					'line' => esc_html__( 'Line', 'powernodewt' ),
					'outline' => esc_html__( 'Outline', 'powernodewt' ),
					'underline' => esc_html__( 'Underline', 'powernodewt' ),
					'link' => esc_html__( 'Link', 'powernodewt' ),
				],
				'default' => 'flat',
				'frontend_available' => true,
			]
		);
		
		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'button_custom_font_size',
			[
				'label' => __( 'Custom Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '1em', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'button_size' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'button_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_font_weight_array() ),
			]
		);
		
		$this->add_control(
			'button_font_style',
			[
				'label' => __( 'Font Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'button_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip( powernodewt_text_transform_array() ),
			]
		);
				
		$this->add_control(
			'button_line_height',
			[
				'label' => __( 'Line Height', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add letter spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'button_letter_spacing',
			[
				'label' => __( 'Letter Spacing', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add spacing in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'button_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'button_corners_style',
			[
				'label' => __('Corners Style', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => [
					'default'   => __('Default', 'powernodewt'),
					'rounded'  => __('Rounded', 'powernodewt'),
					'round' => __('Round', 'powernodewt'),
				],
			]
		);
		
		$this->add_control(
			'button_color',
			[
				'label' => __('Button Color', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'   => __('Default', 'powernodewt'),
					'theme'   => __('Theme', 'powernodewt'),
					'tra-theme'   => __('Transparent Theme', 'powernodewt'),
					'grey'   => __('Grey', 'powernodewt'),
					'tra-grey'   => __('Transparent Grey', 'powernodewt'),
					'white'   => __('White', 'powernodewt'),
					'tra-white'   => __('Transparent White', 'powernodewt'),
					'black'   => __('Black', 'powernodewt'),
					'tra-black'   => __('Transparent Black', 'powernodewt'),
					'azure'   => __('Azure', 'powernodewt'),
					'tra-azure'   => __('Transparent Azure', 'powernodewt'),
					'brown'   => __('Brown', 'powernodewt'),
					'tra-brown'   => __('Transparent Brown', 'powernodewt'),
					'gold'   => __('Gold', 'powernodewt'),
					'tra-gold'   => __('Transparent Gold', 'powernodewt'),
					'navy'   => __('Navy', 'powernodewt'),
					'tra-navy'   => __('Transparent Navy', 'powernodewt'),
					'purple'   => __('Purple', 'powernodewt'),
					'tra-purple'   => __('Transparent Purple', 'powernodewt'),
					'rose'   => __('Rose', 'powernodewt'),
					'tra-rose'   => __('Transparent Rose', 'powernodewt'),
					'salmon'   => __('Salmon', 'powernodewt'),
					'tra-salmon'   => __('Transparent Salmon', 'powernodewt'),
					'silk'   => __('Silk', 'powernodewt'),
					'tra-silk'   => __('Transparent Silk', 'powernodewt'),
					'skyblue'   => __('SkyBlue', 'powernodewt'),
					'tra-skyblue'   => __('Transparent SkyBlue', 'powernodewt'),
					'steel'   => __('Steel', 'powernodewt'),
					'tra-steel'   => __('Transparent Steel', 'powernodewt'),
					'steelblue'   => __('SteelBlue', 'powernodewt'),
					'tra-steelblue'   => __('Transparent SteelBlue', 'powernodewt'),
					'yellow'   => __('Yellow', 'powernodewt'),
					'tra-yellow'   => __('Transparent Yellow', 'powernodewt'),
					'custom' => __('Custom', 'powernodewt'),
				],
			]
		);
		
		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'button_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'button_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'button_border_color',
			[
				'label' => esc_html__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'button_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'heading_button_hover',
			[
				'label' => esc_html__( 'Button Hover', 'powernodewt-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'button_hover_color',
			[
				'label' => __('Button Hover Color', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'   => __('Default', 'powernodewt'),
					'theme'   => __('Theme', 'powernodewt'),
					'tra-theme'   => __('Transparent Theme', 'powernodewt'),
					'grey'   => __('Grey', 'powernodewt'),
					'tra-grey'   => __('Transparent Grey', 'powernodewt'),
					'white'   => __('White', 'powernodewt'),
					'tra-white'   => __('Transparent White', 'powernodewt'),
					'black'   => __('Black', 'powernodewt'),
					'tra-black'   => __('Transparent Black', 'powernodewt'),
					'custom' => __('Custom', 'powernodewt'),
				],
			]
		);
		
		$this->add_control(
			'button_bg_hcolor',
			[
				'label' => esc_html__( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'button_hover_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'button_text_hcolor',
			[
				'label' => esc_html__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'button_hover_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'button_border_hcolor',
			[
				'label' => esc_html__( 'Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'button_hover_color' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'button_el_classes',
			[
				'label' => __( 'Extra Classes', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
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
		echo powernodewt_pricing( $settings, $settings['content'] );
		
	}
}