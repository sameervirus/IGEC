<?php
/**
 * Portfolio Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Portfolio_Customizer' ) ) :

	class PowerNodeWT_Portfolio_Customizer {

		public function __construct() {
		
			add_action( 'customize_register', array( $this, 'options_register' ) );
			add_action( 'powernode_head_css', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_controls_print_scripts', array( $this, 'add_customizer_scripts' ), 30 );

		}

		/**
		 * Customizer options
		 */
		public function options_register( $wp_customize ) {
			
			/**
			 * Portfolio Panel
			 */
			$wp_customize->add_panel( new PowerNodeWT_Customizer_Module_Panels( $wp_customize, 'powernode_portfolio_panel',  array(
				'title' 			=> __( 'Portfolio', 'powernode' ),
				'priority' 			=> '-2500',
				'panel' 			=> 'powernode_options_panel',
			) ) );
			
			/**
			 * Portfolio/Archives Section
			 */
			$wp_customize->add_section( 'powernode_portfolio_loop_post_section' , array(
				'title' 			=> __( 'Portfolio / Archives', 'powernode' ),
				'priority' 			=> 110,
				'panel' 			=> 'powernode_portfolio_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Radio_Image_Control( $wp_customize, 'powernode_portfolio_loop_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'powernode' ),
				'choices' 				=> array(
											'full-width'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sidebar
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_sidebar', array(
				'default'        	    => 'portfolio-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_loop_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'powernode' ),
				'description'	   		=> __( 'Choose sidebar for display on the Portfolio/Archives page.', 'powernode' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_powernode_get_registered_sidebars(),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Portfolio View
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_view_type', array(
				'default'           	=> 'grid',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_loop_view_type', array(
				'label'	   				=> __( 'Portfolio View', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_view_type',
				'priority' 				=> 10,
				'choices' 				=> array(
											'gallery-filter' 	=> __( 'Gallery Filter', 'powernode' ),
											'grid' 				=> __( 'Grid', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Post Style
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_style', array(
				'default'           	=> 'grid',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_loop_post_style', array(
				'label'	   				=> __( 'Post Style', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'powernode' ),
											'box' 				=> __( 'Box', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Columns Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_columns_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_portfolio_loop_columns_heading', array(
				'label'	   				=> __( 'Portfolio Columns', 'powernode' ),
				'description'	   		=> __( 'Show numbers of items below list of screen size. Portfolio columns settings apply only grid and slider.', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_columns_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : LG Columns
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_items_col_lg', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_loop_items_col_lg', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_items_col_lg',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
											'4' 				=> __( '4 - Item(s)', 'powernode' ),
											'5' 				=> __( '5 - Item(s)', 'powernode' ),
											'6' 				=> __( '6 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : MD Columns
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_items_col_md', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_loop_items_col_md', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_items_col_md',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
											'4' 				=> __( '4 - Item(s)', 'powernode' ),
											'5' 				=> __( '5 - Item(s)', 'powernode' ),
											'6' 				=> __( '6 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : SM Columns
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_items_col_sm', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_loop_items_col_sm', array(
				'label'	   				=> __( 'Small devices (landscape phones, less than 768px)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_items_col_sm',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
											'4' 				=> __( '4 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : XS Columns
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_items_col_xs', array(
				'default'           	=> '1',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_loop_items_col_xs', array(
				'label'	   				=> __( 'Extra small devices (portrait phones, less than 576px)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_items_col_xs',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_view_type_is_grid',
			) ) );
			
			/**
			 * Loop Post : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_title_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_portfolio_loop_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Section
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_portfolio_loop_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_title_alignment', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_loop_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_title_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
											'left' 			=> __( 'Left', 'powernode' ),
											'centered' 		=> __( 'Center', 'powernode' ),
											'right' 		=> __( 'Right', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Page Title
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_loop_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'powernode' ),
											'custom' 			=> __( 'Custom Text', 'powernode' ),
											'post_title' 		=> __( 'Post Title', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Page Custom Title
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_title_custom', array(
				'type' 					=> 'theme_mod',
				'sanitize_callback' 	=> 'sanitize_text_field',
				'default' 				=> 'Portfolio',
			) );

			$wp_customize->add_control( 'powernode_portfolio_loop_post_page_title_custom', array(
				'label' 				=> esc_html__( 'Page Title Custom Text', 'powernode' ),
				'section' 				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_title_custom',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_post_page_title',
			) );
			
			/**
			 * Loop Post : Page Title Background Image
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_loop_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'powernode' ),
											'custom' 			=> __( 'Custom', 'powernode' ),
											'hidden' 			=> __( 'Hidden', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Background Image
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_title_bg_image', array(
				'default'				=>  POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_portfolio_loop_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'powernode' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_post_page_title_background',
			) ) );
			
			/**
			 * Loop Post : Breadcrumb
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_portfolio_loop_post_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_page_content_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_portfolio_loop_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_sections_positioning', array(
				'default'        	    => apply_filters( 'powernode_portfolio_loop_post_sections_positioning_default', array( 'thumbnail', 'categories', 'title', 'content', 'social_links', 'meta', 'read-more' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_portfolio_loop_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'powernode' ),
				'description' 			=>  esc_html__( 'Section positioning working only default post style view.', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_portfolio_loop_post_meta_choices',
												array(
													'thumbnail'     => esc_html__( 'Thumbnail', 'powernode' ),
													'categories'    => esc_html__( 'Categories', 'powernode' ),
													'title'    		=> esc_html__( 'Title', 'powernode' ),
													'content'    	=> esc_html__( 'Content', 'powernode' ),
													'social-links'  => esc_html__( 'Social Links', 'powernode' ),
													'meta'    		=> esc_html__( 'Meta', 'powernode' ),
													'read-more'  	=> esc_html__( 'Read More', 'powernode' ),
												)
											),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Post Content
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_content', array(
				'default'           	=> 'excerpt',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_loop_post_content', array(
				'label'	   				=> __( 'Post Content', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'powernode' ),
											'full' 				=> __( 'Full', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Excerpt Length
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_excerpt_length', array(
				'default'          		=>  40,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_portfolio_loop_post_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'powernode' ),
				'description'	   		=> __( 'Show Portfolio/Archives Post Content Summery.', 'powernode' ),
				'section' 				=> 'powernode_portfolio_loop_post_section',
				'settings'  			=> 'powernode_portfolio_loop_post_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Loop Post : Social Share Links
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_social_share_links', array(
				'default'        	    => apply_filters( 'powernode_portfolio_loop_post_social_share_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = powernodewt_social_share_links_data();
			$portfolio_loop_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$portfolio_loop_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_portfolio_loop_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_portfolio_loop_post_social_share_links_choices',
												$portfolio_loop_post_social_share_links
											),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_post_social_share',
			) ) );
			
			/**
			 * Loop Post : Show Facy Date
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_fancy_date', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_portfolio_loop_post_fancy_date', array(
				'label'	   				=> __( 'Show Facy Date', 'powernode' ),
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_fancy_date',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Read More
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_read_more', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_loop_post_read_more', array(
				'label'	   				=> __( 'Read More', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link' 				=> __( 'Link (Default)', 'powernode' ),
					'icon' 				=> __( 'Icon', 'powernode' ),
					'button' 			=> __( 'Button', 'powernode' ),
					'0' 				=> __( 'Hide', 'powernode' ),
				),
			) ) );
			
			/**
			 * Loop Post : Portfolio Per Page
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_per_page', array(
				'default'          		=>  6,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_portfolio_loop_post_per_page', array(
				'label'   				=> __( 'Portfolio Per Page', 'powernode' ),
				'section' 				=> 'powernode_portfolio_loop_post_section',
				'settings'  			=> 'powernode_portfolio_loop_post_per_page',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 50,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Loop Post : Pagination Style
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_pagination_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_loop_post_pagination_style', array(
				'label'	   				=> __( 'Pagination Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_loop_post_section',
				'settings' 				=> 'powernode_portfolio_loop_post_pagination_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 			=> __( 'Default', 'powernode' ),
					'infinite-scroll' 	=> __( 'Infinite Scroll', 'powernode' ),
					'load-more' 		=> __( 'Load More', 'powernode' ),
				),
			) ) );
			
			/**
			 * Loop Post : Pagination Last Text
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_pagination_last_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'End of content',
			) );

			$wp_customize->add_control( 'powernode_portfolio_loop_post_pagination_last_text', array(
				'label' 			=> esc_html__( 'Pagination Last Text', 'powernode' ),
				'section' 			=> 'powernode_portfolio_loop_post_section',
				'settings' 			=> 'powernode_portfolio_loop_post_pagination_last_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_post_pagination_style_not_default',
			) );
			
			/**
			 * Loop Post : Load More Button Text
			 */
			$wp_customize->add_setting( 'powernode_portfolio_loop_post_load_more_button_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'More Posts',
			) );

			$wp_customize->add_control( 'powernode_portfolio_loop_post_load_more_button_text', array(
				'label' 			=> esc_html__( 'Load More Button Text', 'powernode' ),
				'section' 			=> 'powernode_portfolio_loop_post_section',
				'settings' 			=> 'powernode_portfolio_loop_post_load_more_button_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_loop_post_pagination_style_not_default',
			) );
			
			
			/**
			 * Single Portfolio Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_portfolio_single_post_section' , array(
				'title' 			=> __( 'Single Portfolio', 'powernode' ),
				'priority' 			=> 110,
				'panel' 			=> 'powernode_portfolio_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Radio_Image_Control( $wp_customize, 'powernode_portfolio_single_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'powernode' ),
				'choices' 				=> array(
											'full-width'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Sidebar
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_sidebar', array(
				'default'        	    => 'single-post-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_single_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'powernode' ),
				'description'	   		=> __( 'Choose sidebar for display on singlular page.', 'powernode' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_powernode_get_registered_sidebars(),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_title_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_portfolio_single_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Page Title Section
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_portfolio_single_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_title_alignment', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_single_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_title_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
											'left' 			=> __( 'Left', 'powernode' ),
											'centered' 		=> __( 'Center', 'powernode' ),
											'right' 		=> __( 'Right', 'powernode' ),
										),
			) ) );
			
			/**
			 * Single Post : Page Title
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_single_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'powernode' ),
											'custom' 			=> __( 'Custom Text', 'powernode' ),
											'post_title' 		=> __( 'Post Title', 'powernode' ),
										),
			) ) );
			
			/**
			 * Single Portfolio : Page Header Custom Title
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_title_custom', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Portfolio',
			) );

			$wp_customize->add_control( 'powernode_portfolio_single_post_page_title_custom', array(
				'label' 			=> esc_html__( 'Page Title Custom Text', 'powernode' ),
				'section' 			=> 'powernode_portfolio_single_post_section',
				'settings' 			=> 'powernode_portfolio_single_post_page_title_custom',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_page_title',
			) );
			
			/**
			 * Single Portfolio : Page Title Background Image
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_single_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'powernode' ),
											'featured_image' 	=> __( 'Featured Image', 'powernode' ),
											'custom'		 	=> __( 'Custom', 'powernode' ),
											'hidden' 			=> __( 'Hidden', 'powernode' ),
										),
			) ) );
			
			/**
			 * Single Portfolio : Background Image
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_title_bg_image', array(
				'default'				=>  POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_portfolio_single_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'powernode' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_page_title_background',
			) ) );
			
			/**
			 * Single Portfolio : Breadcrumb
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_portfolio_single_post_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_page_content_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_portfolio_single_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_sections_positioning', array(
				'default'        	    => apply_filters( 'powernode_portfolio_single_post_sections_positioning', array( 'categories', 'title', 'content', 'skills', 'social-links', 'next-prev', 'related-portfolio' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_portfolio_single_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_portfolio_single_post_meta_choices',
												array(
													'categories'    => esc_html__( 'Categories', 'powernode' ),
													'thumbnail'     => esc_html__( 'Thumbnail', 'powernode' ),
													'title'    		=> esc_html__( 'Title', 'powernode' ),
													'content'    	=> esc_html__( 'Content', 'powernode' ),
													'skills'  		=> esc_html__( 'Skills', 'powernode' ),
													'social-links'  => esc_html__( 'Social Links', 'powernode' ),
													'next-prev' 	=> esc_html__( 'Next/Prev', 'powernode' ),
													'related-portfolio'	=> esc_html__( 'Related Portfolios', 'powernode' ),
												)
											),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Social Share Links
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_social_share_links', array(
				'default'        	    => apply_filters( 'powernode_portfolio_single_post_social_share_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = powernodewt_social_share_links_data();
			
			$single_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$single_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_portfolio_single_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_portfolio_single_post_social_share_links_choices',
												$single_post_social_share_links
											),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_social_share',
			) ) );
			
			/**
			 * Single Portfolio : Related Portfolios Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_posts_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_portfolio_single_post_related_posts_heading', array(
				'label'	   				=> __( 'Related Portfolios', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_related_posts_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Show/Hide Related Portfolio
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_posts', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_portfolio_single_post_related_posts', array(
				'label'	   				=> __( 'Show Related Portfolio', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_related_posts',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Portfolio : Posts Styles
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_style', array(
				'default'           	=> 'box',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_single_post_related_style', array(
				'label'	   				=> __( 'Post Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_related_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 		=> __( 'Default', 'powernode' ),
					'box' 			=> __( 'Box', 'powernode' ),
				),
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Post Content
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_content', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_portfolio_single_post_related_content', array(
				'label'	   				=> __( 'Post Content', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_related_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'powernode' ),
											'full' 				=> __( 'Full', 'powernode' ),
											'' 					=> __( 'Hidden', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Excerpt Length
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_excerpt_length', array(
				'default'          		=>  20,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_portfolio_single_post_related_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'powernode' ),
				'description'	   		=> __( 'Show Post Content Summery.', 'powernode' ),
				'section' 				=> 'powernode_portfolio_single_post_section',
				'settings'  			=> 'powernode_portfolio_single_post_related_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Read More
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_read_more', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_portfolio_single_post_related_read_more', array(
				'label'	   				=> __( 'Read More', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_post_related_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link' 				=> __( 'Link (Default)', 'powernode' ),
					'button' 			=> __( 'Button', 'powernode' ),
					'icon' 				=> __( 'Icon', 'powernode' ),
					'0' 				=> __( 'Hide', 'powernode' ),
				),
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Remove Items Padding
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_related_remove_items_padding', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_portfolio_single_related_remove_items_padding', array(
				'label'	   				=> __( 'Remove Items Padding', 'powernode' ),
				'section'  				=> 'powernode_portfolio_single_post_section',
				'settings' 				=> 'powernode_portfolio_single_related_remove_items_padding',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Show Numbers Related Portfolios
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_posts_number', array(
				'default'          		=>  6,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_portfolio_single_post_related_posts_number', array(
				'label'   				=> __( 'Show Numbers of Related Portfolios', 'powernode' ),
				'section' 				=> 'powernode_portfolio_single_post_section',
				'settings'  			=> 'powernode_portfolio_single_post_related_posts_number',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 20,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
			/**
			 * Single Portfolio : Show Related Portfolios Columns
			 */
			$wp_customize->add_setting( 'powernode_portfolio_single_post_related_posts_columns', array(
				'default'          		=>  2,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_portfolio_single_post_related_posts_columns', array(
				'label'   				=> __( 'Show Related Portfolios Columns', 'powernode' ),
				'section' 				=> 'powernode_portfolio_single_post_section',
				'settings'  			=> 'powernode_portfolio_single_post_related_posts_columns',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 12,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_portfolio_single_post_related_posts',
			) ) );
			
		}

		/**
		 * Get CSS
		 */
		public static function add_customizer_css( $output ) {
			
			return $output;
		}
		
		/**
		 * Scripts
		 */
		public function add_customizer_scripts() {
			$categories = get_categories( array( 'taxonomy' => 'portfolio-cat', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			$posts_id = get_posts( array('post_type' => 'portfolio', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( $categories[0] ) ) { ?>
					wp.customize.section( 'powernode_portfolio_loop_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_permalink('/portfolio') ); ?>" );
							}
						} );
					} );
					<?php } ?>
					<?php if ( !empty( $posts_id[0] ) ) { ?>
					wp.customize.section( 'powernode_portfolio_single_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_permalink( $posts_id[0] ) ); ?>" );
							}
						} );
					<?php } ?>
					} );
				} );
			</script>
			<?php
		}
	}

endif;

return new PowerNodeWT_Portfolio_Customizer();