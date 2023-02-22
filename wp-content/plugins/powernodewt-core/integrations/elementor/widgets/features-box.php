<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use PowerNodeElementor\IconSelector_Control;

/*
 *  Elementor widget for Features Box
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class FeaturesBox extends Widget_Base {
	
	public function get_name() {
		return 'powernode-features-box';
	}
	
	public function get_title() {
		return __( 'Features Box', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-icon-box';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_features',
			[
				'label' => esc_html__( 'Features Box', 'powernodewt-core' ),
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
				'default' => 'flat-icon',
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
				'placeholder' => esc_html__( 'Enter your title', 'powernodewt-core' ),
				'label_block' => true,
				'separator' => 'before',
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
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'powernodewt-core' ),
				'placeholder' => esc_html__( 'Enter your content', 'powernodewt-core' ),
				'rows' => 10,
				'separator' => 'none',
				'show_label' => false,
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
			'icon_position',
			[
				'label' => esc_html__( 'Icon Position', 'powernodewt-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'powernodewt-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'powernodewt-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'powernodewt-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
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
				'type' => Controls_Manager::SELECT,
				'default' => 'icon-65',
				'options' => array_flip( powernodewt_icon_size_array() ),
				'condition' => [
					'icon_type' => array('text', 'flat-icon')
				],
			]
		);
		
		$this->add_control(
			'icon_size_custom',
			[
				'label' => __( 'Icon Size Custom', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '65px', 'powernodewt-core' ),
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
				'condition' => [
					'icon_size' => array('icon-custom')
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
				'default' => '#818a91',
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
		
		$this->add_responsive_control(
			'icon_ver_alignment',
			[
				'label' => __( 'Vertical Icon Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'start',
				'options' => array_flip( powernodewt_vertical_alignment_array() ),
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
				'default' => '1',
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
				'label' => __( 'Content Wrap Extra Classes', 'powernodewt-core' ),
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
		echo powernodewt_features_box( $settings, $settings['content'] );
		
	}
}