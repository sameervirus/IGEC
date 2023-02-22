<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

/*
 *  Elementor widget for Features Box
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Posts extends Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);
   	}
	
	public function get_name() {
		return 'powernode-posts';
	}
	
	public function get_title() {
		return __( 'Posts', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-posts-grid';
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
			'posts_type',
			[
				'label' => esc_html__( 'Post Type', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'post' => esc_html__( 'Post', 'powernodewt-core' ),
					'portfolio' => esc_html__( 'Portfolio', 'powernodewt-core' ),
					'segment' => esc_html__( 'Segment', 'powernodewt-core' ),
				],
				'default' => 'post',
			]
		);
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Category', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => powernodewt_categories( 'category' ),
			]
		);
		
		$this->add_control(
			'limit',
			[
				'label' => __( 'Posts Count', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 6,
				'placeholder' => '',
				'description' => __( 'Numbers of items show per page.', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array_flip( array(
                    __('Date','powernodewt-core') => 'date',
                    __('Title','powernodewt-core') => 'title',
                    __('Random','powernodewt-core') => 'rand',
                    __('Number of comments','powernodewt-core') => 'comment_count',
                    __('Last modified','powernodewt-core') => 'modified',
                ) ),
			]
		);
		
		$this->add_control(
			'order',
			[
				'label' => __( 'Sort Order', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array_flip( array(
                    __('DESC','powernodewt-core') => 'DESC',
                    __('ASC','powernodewt-core') => 'ASC',
                ) ),
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
		
		// Posts Settings -------------------------------
		
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => esc_html__( 'Posts Setttings', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'posts_thumbnail',
			[
				'label' => esc_html__( 'Show Post Image', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'medium',
				'separator' => 'none',
				'condition' => [
					'posts_thumbnail' => '1',
				],
			]
		);
		
		$this->add_control(
			'posts_title',
			[
				'label' => esc_html__( 'Show Post Title', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'posts_title_length',
			[
				'label' => __( 'Title Length', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => '',
				'condition' => [
					'posts_title' => '1',
				],
			]
		);
		
		$this->add_control(
			'posts_date',
			[
				'label' => esc_html__( 'Show Post date', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'posts_categories',
			[
				'label' => esc_html__( 'Show Post Categories', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '0',
			]
		);
		
		$this->add_control(
			'posts_content',
			[
				'label' => esc_html__( 'Post Content', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'excerpt'	=> esc_html__( 'Excerpt', 'powernodewt-core' ),
					'full' 		=> esc_html__( 'Full', 'powernodewt-core' ),
					'0' 		=> esc_html__( 'Hide', 'powernodewt-core' ),
				],
				'default' => 'excerpt',
			]
		);
		
		$this->add_control(
			'posts_excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 20,
				'placeholder' => '',
				'condition' => [
					'posts_content' => 'excerpt',
				],
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
		
		$this->add_control(
			'remove_list_border',
			[
				'label' => esc_html__( 'Removed List Border', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'default' => '0',
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
				'default' => 'div',
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
				'default' => 'sm',
				'options' => array_flip( powernodewt_font_size_array() ),
				'separator' => 'top',
			]
		);
		
		$this->add_control(
			'title_font_weight',
			[
				'label' => __( 'Font Weight', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '400',
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
				'default' => 'grey',
				'options' => array_flip(powernodewt_color_array()),
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
		
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo powernodewt_posts( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'pnwt-global', 'pnwt-posts-handle' ];
		return [];
	}
}