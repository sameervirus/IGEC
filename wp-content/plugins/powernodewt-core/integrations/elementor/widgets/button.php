<?php
namespace PowerNodeElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use PowerNodeElementor\IconSelector_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Button extends Widget_Base {
	
	public function get_name() {
		return 'powernode-button';
	}
	
	public function get_title() {
		return __( 'Button', 'powernodewt-core' );
	}
	
	public function get_icon() {
		return 'eicon-button';
	}
	
	public function get_categories() {
		return ['powernode-elements'];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'content_settings',
			[
				'label' => __( 'Button', 'powernodewt' ),
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
		
		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'powernodewt' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Let\'s Started', 'powernodewt' )
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
			'animations',
			[
				'label' => __( 'Animation', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip(powernodewt_animations_array()),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'animations_delay',
			[
				'label' => __( 'Animation delay', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '0', 'powernodewt-core' ),
				'placeholder' => '',
				'description' => __( 'Add animation delay like 800ms,0.4s.', 'powernodewt-core' ),
				'condition' => [
					'animations!' => '',
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
		
		$this->add_responsive_control(
			'button_ver_alignment',
			[
				'label' => __( 'Vertical Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array_flip( powernodewt_vertical_alignment_array() ),
			]
		);
		
		$this->add_responsive_control(
			'button_alignment',
			[
				'label' => __( 'Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'heading_button_normal',
			[
				'label' => esc_html__( 'Button Normal', 'powernodewt-core' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
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
				'default' => '',
				'options' => array_flip( powernodewt_font_style_array() ),
			]
		);
		
		$this->add_control(
			'button_text_transform',
			[
				'label' => __( 'Text Transform', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
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
			'button_text_alignment',
			[
				'label' => __( 'Text Alignment', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => array_flip( powernodewt_text_alignment_array() ),
			]
		);
		
		$this->add_control(
			'button_rounded_cornors',
			[
				'label' => __('Border Style', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'default' => 'rounded',
				'options' => [
					'default'   => __('Default', 'powernodewt'),
					'rounded'  => __('Rounded', 'powernodewt'),
					'round' => __('Round', 'powernodewt'),
					'custom' => __('Custom', 'powernodewt'),
				],
			]
		);
		
		$this->add_responsive_control(
			'button_custom_radius',
			[
				'label' => __('Border Radius', 'powernodewt'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'rem', 'em'],
				'separator' => 'after',
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .pnwt-button-container .pnwt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'button_rounded_cornors' => 'custom'
				],
			]
		);
		
		$this->add_control(
			'button_color',
			[
				'label' => __('Button Color', 'powernodewt'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array( ''   => __('Default', 'powernodewt') ) + powernodewt_button_color_array() + array( 'custom'   => __('Custom', 'powernodewt') ),
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
				'options' => array( ''   => __('Default', 'powernodewt') ) + powernodewt_button_hover_color_array() + array( 'custom'   => __('Custom', 'powernodewt') ),
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
		
		$this->end_controls_section();
		
		// Icon Style -------------------------------
		
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon', 'powernodewt-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'powernodewt-core' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'description' => __( 'You can add size in (px,em,rem,%)', 'powernodewt-core' ),
				'placeholder' => '',
			]
		);
		
		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(powernodewt_color_array()),
			]
		);
		
		$this->add_control(
			'icon_color_custom',
			[
				'label' => __( 'Custom Color', 'powernodewt-core' ),
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
				'label' => __( 'Background Color', 'powernodewt-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array_flip(powernodewt_bg_color_array()),
			]
		);
		
		$this->add_control(
			'icon_bg_color_custom',
			[
				'label' => __( 'Background Color Custom', 'powernodewt-core' ),
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
		echo powernodewt_button( $settings );
		
		/* $settings = $this->get_settings();
		$target = $settings['button_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['button_link']['nofollow'] ? ' rel="nofollow"' : '';
		?>
		<a href="<?php echo esc_url($settings['button_link']['url']); ?>" class="btn btn-md theme-hover" <?php echo $target; echo $nofollow ?>>
		    <?php if( $settings['icon'] ) { ?>
		    <i class="<?php echo esc_attr($settings['icon']); ?>"></i>
		    <?php } ?>
		    <?php echo esc_attr($settings['button_text']); ?>
		</a>
		<?php */
	}
}
?>