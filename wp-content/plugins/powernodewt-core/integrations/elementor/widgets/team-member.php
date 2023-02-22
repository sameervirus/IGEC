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

class TeamMember extends Widget_Base {
	
	public function get_name() {
		return 'powernode-team-member';
	}
	
	public function get_title() {
		return __( 'Team Member', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-user-circle-o';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'team_style',
			[
				'label' => esc_html__( 'Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'team-1' => esc_html__( 'Style-1', 'powernodewt-core' ),
					'team-2' => esc_html__( 'Style-2', 'powernodewt-core' ),
				],
				'default' => 'team-1',
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
			'name',
			[
				'label' => esc_html__( 'Name', 'powernodewt-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Enter the name', 'powernodewt-core' ),
				'label_block' => true,
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
				'label' => 'Description',
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'placeholder' => esc_html__( 'Enter the description', 'powernodewt-core' ),
				'rows' => 10,
				'separator' => 'none',
				'label_block' => true,
			]
		);
		
		// Icons
		
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
		
		$this->start_controls_section(
			'section_style_content_wrap',
			[
				'label' => esc_html__( 'Content Wrap', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'content_wrap_bg_color',
			[
				'label' => __( 'Background Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'darkblue',
				'options' => array_flip(powernodewt_bg_color_array()),
			]
		);
		
		$this->add_control(
			'content_wrap_bg_color_custom',
			[
				'label' => __( 'Background Color Custom', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'content_wrap_bg_color' => 'custom',
				],
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
		
		$this->add_responsive_control(
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
				'label' => __( 'Name Extra Classes', 'powernodewt-core' ),
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
				'default' => 'stacked',
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
		echo powernodewt_team_member( $settings, $settings['content'] );
		
	}
}