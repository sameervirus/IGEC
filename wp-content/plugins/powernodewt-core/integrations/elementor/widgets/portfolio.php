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

class Portfolio extends Widget_Base {
	
	public function __construct($data = [], $args = null) {
      parent::__construct($data, $args);

      wp_register_script( 'pnwt-portfolio-handle', POWERNODE_ELEXTS_URL . 'assets/js/portfolio.js', [ 'elementor-frontend' ], POWERNODEWT_CORE_VERSION, true );
   	}
	
	public function get_name() {
		return 'powernode-portfolio';
	}
	
	public function get_title() {
		return __( 'Portfolio', 'powernodewt-core' );
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
			'view_type',
			[
				'label' => esc_html__( 'Portfolio View', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'slider' => esc_html__( 'Slider (Default)', 'powernodewt-core' ),
					'grid' => esc_html__( 'Grid', 'powernodewt-core' ),
					'gallery-filter' => esc_html__( 'Gallery Filter', 'powernodewt-core' ),
				],
				'default' => 'slider',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_style',
			[
				'label' => esc_html__( 'Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'powernodewt-core' ),
					'box' => esc_html__( 'Box', 'powernodewt-core' ),
				],
				'default' => 'box',
			]
		);
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Category', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => powernodewt_categories( 'portfolio-cat', 'id' ),
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
		
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => esc_html__( 'Portfolio Setttings', 'powernodewt-core' ),
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_thumbnail',
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
				'name' => 'portfolio_loop_post_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default' => 'large',
				'separator' => 'none',
				'condition' => [
					'portfolio_loop_post_thumbnail' => '1',
				],
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_fancy_date',
			[
				'label' => esc_html__( 'Show Fancy Date', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '0',
				'condition' => [
					'portfolio_loop_post_thumbnail' => '1',
				],
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_title',
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
			'portfolio_loop_post_categories',
			[
				'label' => esc_html__( 'Show Category', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_content',
			[
				'label' => esc_html__( 'Post Content', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'excerpt'	=> esc_html__( 'Excerpt', 'powernodewt-core' ),
					'0' 		=> esc_html__( 'Hide', 'powernodewt-core' ),
				],
				'default' => 'excerpt',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 20,
				'placeholder' => '',
				'condition' => [
					'portfolio_loop_post_content' => 'excerpt',
				],
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_read_more',
			[
				'label' => esc_html__( 'Read More', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'link'	 => esc_html__( 'Link (Default)', 'powernodewt-core' ),
					'button' => esc_html__( 'Button', 'powernodewt-core' ),
					'icon' => esc_html__( 'Icon', 'powernodewt-core' ),
					'0' 	 => esc_html__( 'Hide', 'powernodewt-core' ),
				],
				'default' => 'link',
			]
		);
		
		$this->add_control(
			'portfolio_loop_post_remove_items_padding',
			[
				'label' => esc_html__( 'Remove items padding', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'default' => '0',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_slider',
			[
				'label' => esc_html__( 'Slider Settings', 'powernodewt-core' ),
				'condition' => [
					'view_type' => 'slider',
				],
			]
		);
		
		$this->add_control(
			'nums_rows',
			[
				'label' => esc_html__( 'Rows', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( '1', 'powernodewt-core' ),
					'2' => esc_html__( '2', 'powernodewt-core' ),
					'3' => esc_html__( '3', 'powernodewt-core' ),
					'4' => esc_html__( '4', 'powernodewt-core' ),
				],
				'default' => '1',
			]
		);
		
		$this->add_control(
			'slider_nav',
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
			'slider_nav_style',
			[
				'label' => esc_html__( 'Navigation Style', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'cir' => esc_html__( 'Circle (default)', 'powernodewt-core' ),
					'rec' => esc_html__( 'Rectangle', 'powernodewt-core' ),
				],
				'default' => 'cir',
				'condition' => [
					'slider_nav' => '1',
				],
			]
		);
		
		$this->add_control(
			'slider_nav_position',
			[
				'label' => esc_html__( 'Navigation Position', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'slider-middle' => esc_html__( 'Slider Middle (Default)', 'powernodewt-core' ),
					'title-right' => esc_html__( 'Title Right', 'powernodewt-core' ),
				],
				'default' => 'slider-middle',
				'condition' => [
					'slider_nav' => '1',
				],
			]
		);
		
		$this->add_control(
			'slider_loop',
			[
				'label' => esc_html__( 'Loop', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '1',
			]
		);
		
		$this->add_control(
			'slider_dots',
			[
				'label' => esc_html__( 'Dots', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '',
			]
		);
		
		$this->add_control(
			'slider_autoplay',
			[
				'label' => esc_html__( 'Auto Play', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'powernodewt-core' ),
				'label_off' => __( 'No', 'powernodewt-core' ),
				'return_value' => '1',
				'default' => '',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_content_responsive',
			[
				'label' => esc_html__( 'Responsive', 'powernodewt-core' ),
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
				],
				'default' => '4',
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
		
	}
	
	protected function render() {
		
		$settings = $this->get_settings();
		echo powernodewt_portfolio( $settings );
		
	}
	
	public function get_script_depends() {
		if( is_user_logged_in() ) return [ 'pnwt-global', 'pnwt-portfolio-handle' ];
		return [];
	}
}