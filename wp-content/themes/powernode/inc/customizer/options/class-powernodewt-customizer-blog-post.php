<?php
/**
 * Blog/Post Customizer Options
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { die(); }

if ( ! class_exists( 'PowerNodeWT_Blog_Post_Customizer' ) ) :

	class PowerNodeWT_Blog_Post_Customizer {

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
			 * Blog/Post Panel
			 */
			$wp_customize->add_panel( new PowerNodeWT_Customizer_Module_Panels( $wp_customize, 'powernode_blog_post_panel',  array(
				'title' 			=> __( 'Blog / Post', 'powernode' ),
				'priority' 			=> '-2500',
				'panel' 			=> 'powernode_options_panel',
			) ) );
			
			/**
			 * Blog/Archives Section
			 */
			$wp_customize->add_section( 'powernode_blog_loop_post_section' , array(
				'title' 			=> __( 'Blog / Archives', 'powernode' ),
				'priority' 			=> 110,
				'panel' 			=> 'powernode_blog_post_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Radio_Image_Control( $wp_customize, 'powernode_blog_loop_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'powernode' ),
				'choices' 				=> array(
											'full-width'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sidebar
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_sidebar', array(
				'default'        	    => 'blog-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_loop_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'powernode' ),
				'description'	   		=> __( 'Choose sidebar for display on the Blog/Archives page.', 'powernode' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_powernode_get_registered_sidebars(),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Blog View
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_view_type', array(
				'default'           	=> 'list',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_loop_view_type', array(
				'label'	   				=> __( 'Blog View', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_view_type',
				'priority' 				=> 10,
				'choices' 				=> array(
											'full' 			=> __( 'Full', 'powernode' ),
											'grid' 			=> __( 'Grid', 'powernode' ),
											'list' 			=> __( 'List', 'powernode' ),
											'modern' 		=> __( 'Modern', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Post Style
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_loop_post_style', array(
				'label'	   				=> __( 'Post Style', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_style',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'powernode' ),
											'fancy' 			=> __( 'Fancy', 'powernode' ),
											'box' 				=> __( 'Box', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_view_type_is_grid',
			) ) );
			
			/**
			 * Loop Post : Columns Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_columns_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_blog_loop_columns_heading', array(
				'label'	   				=> __( 'Blog Columns', 'powernode' ),
				'description'	   		=> __( 'Show numbers of items below list of screen size. Blog columns settings apply only grid and slider.', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_columns_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : LG Columns
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_items_col_lg', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_loop_items_col_lg', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_items_col_lg',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
											'4' 				=> __( '4 - Item(s)', 'powernode' ),
											'5' 				=> __( '5 - Item(s)', 'powernode' ),
											'6' 				=> __( '6 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : MD Columns
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_items_col_md', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_loop_items_col_md', array(
				'label'	   				=> __( 'Large devices (desktops, 992px and up)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_items_col_md',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
											'4' 				=> __( '4 - Item(s)', 'powernode' ),
											'5' 				=> __( '5 - Item(s)', 'powernode' ),
											'6' 				=> __( '6 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : SM Columns
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_items_col_sm', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_loop_items_col_sm', array(
				'label'	   				=> __( 'Small devices (landscape phones, less than 768px)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_items_col_sm',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
											'4' 				=> __( '4 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_view_type_is_grid',
			) ) );

			/**
			 * Loop Post : XS Columns
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_items_col_xs', array(
				'default'           	=> '1',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_loop_items_col_xs', array(
				'label'	   				=> __( 'Extra small devices (portrait phones, less than 576px)', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_items_col_xs',
				'priority' 				=> 10,
				'choices' 				=> array(
											'1' 				=> __( '1 - Item', 'powernode' ),
											'2' 				=> __( '2 - Item(s)', 'powernode' ),
											'3' 				=> __( '3 - Item(s)', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_view_type_is_grid',
			) ) );
						
			/**
			 * Loop Post : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_title_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_blog_loop_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Section
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_loop_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_title_alignment', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_loop_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_title_alignment',
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
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_loop_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_title',
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
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_title_custom', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'Blog',
			) );

			$wp_customize->add_control( 'powernode_blog_loop_post_page_title_custom', array(
				'label' 			=> esc_html__( 'Page Title Custom Text', 'powernode' ),
				'section' 			=> 'powernode_blog_loop_post_section',
				'settings' 			=> 'powernode_blog_loop_post_page_title_custom',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_powernode_blog_loop_post_page_title',
			) );
			
			/**
			 * Loop Post : Page Title Background Image
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_loop_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_title_background',
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
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_title_bg_image', array(
				'default'				=>  POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_blog_loop_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'powernode' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_post_page_title_background',
			) ) );
			
			/**
			 * Loop Post : Breadcrumb
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_loop_post_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_page_content_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_blog_loop_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_sections_positioning', array(
				'default'        	    => apply_filters( 'powernode_blog_loop_post_sections_positioning_default', array( 'thumbnail', 'tags', 'title', 'content', 'meta', 'read-more' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_blog_loop_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_blog_loop_post_meta_choices',
												array(
													'thumbnail'     => esc_html__( 'Thumbnail', 'powernode' ),
													'tags'			=> esc_html__( 'Tags', 'powernode' ),
													'title'    		=> esc_html__( 'Title', 'powernode' ),
													'meta'    		=> esc_html__( 'Meta', 'powernode' ),
													'content'    	=> esc_html__( 'Content', 'powernode' ),
													'categories'    => esc_html__( 'Categories', 'powernode' ),
													'social-links'  => esc_html__( 'Social Links', 'powernode' ),
													'read-more'  => esc_html__( 'Read More', 'powernode' ),
												)
											),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Blog Meta
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_meta', array(
				'default'        	    => apply_filters( 'powernode_blog_loop_post_meta_default', array( 'author', 'categories', 'tags', 'comments', 'date' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_blog_loop_post_meta', array(
				'label'	   				=> __( 'Meta', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_blog_loop_post_meta_choices',
												array(
													'author'        => esc_html__( 'Author', 'powernode' ),
													'categories'    => esc_html__( 'Categories', 'powernode' ),
													'tags'    		=> esc_html__( 'Tags', 'powernode' ),
													'comments'      => esc_html__( 'Comments', 'powernode' ),
													'date'          => esc_html__( 'Date', 'powernode' ),
													'reading-time'  => esc_html__( 'Reading Time', 'powernode' ),
												)
											),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_meta',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Post Content
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_content', array(
				'default'           	=> 'excerpt',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_loop_post_content', array(
				'label'	   				=> __( 'Post Content', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'powernode' ),
											'full' 				=> __( 'Full', 'powernode' ),
										),
			) ) );
			
			/**
			 * Loop Post : Excerpt Length
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_excerpt_length', array(
				'default'          		=>  12,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_blog_loop_post_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'powernode' ),
				'description'	   		=> __( 'Show Blog/Archives Post Content Summery.', 'powernode' ),
				'section' 				=> 'powernode_blog_loop_post_section',
				'settings'  			=> 'powernode_blog_loop_post_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Loop Post : Social Share Links
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_social_share_links', array(
				'default'        	    => apply_filters( 'powernode_blog_loop_post_social_share_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = powernodewt_social_share_links_data();
			$blog_loop_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$blog_loop_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_blog_loop_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_blog_loop_post_social_share_links_choices',
												$blog_loop_post_social_share_links
											),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_post_social_share',
			) ) );
			
			/**
			 * Loop Post : Show Facy Date
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_fancy_date', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_loop_post_fancy_date', array(
				'label'	   				=> __( 'Show Facy Date', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_fancy_date',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Show Read Time With Tags
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_readtime_with_tag', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_loop_post_readtime_with_tag', array(
				'label'	   				=> __( 'Show Read Time With Tags', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_readtime_with_tag',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Read More
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_read_more', array(
				'default'           	=> 'button',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_loop_post_read_more', array(
				'label'	   				=> __( 'Read More', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link' 				=> __( 'Link (Default)', 'powernode' ),
					'button' 			=> __( 'Button', 'powernode' ),
					'0' 				=> __( 'Hide', 'powernode' ),
				),
			) ) );
			
			/**
			 * Loop Post : Pagination Style
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_pagination_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_loop_post_pagination_style', array(
				'label'	   				=> __( 'Pagination Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_post_pagination_style',
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
			$wp_customize->add_setting( 'powernode_blog_loop_post_pagination_last_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'End of content',
			) );

			$wp_customize->add_control( 'powernode_blog_loop_post_pagination_last_text', array(
				'label' 			=> esc_html__( 'Pagination Last Text', 'powernode' ),
				'section' 			=> 'powernode_blog_loop_post_section',
				'settings' 			=> 'powernode_blog_loop_post_pagination_last_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_post_pagination_style_not_default',
			) );
			
			/**
			 * Loop Post : Load More Button Text
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_post_load_more_button_text', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'default' 			=> 'More Posts',
			) );

			$wp_customize->add_control( 'powernode_blog_loop_post_load_more_button_text', array(
				'label' 			=> esc_html__( 'Load More Button Text', 'powernode' ),
				'section' 			=> 'powernode_blog_loop_post_section',
				'settings' 			=> 'powernode_blog_loop_post_load_more_button_text',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_post_pagination_style_not_default',
			) );
			
			/**
			 * Loop Post : Show Latest Articles Section
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_latest_articles_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_loop_latest_articles_section', array(
				'label'	   				=> __( 'Show Latest Articles', 'powernode' ),
				'section'  				=> 'powernode_blog_loop_post_section',
				'settings' 				=> 'powernode_blog_loop_latest_articles_section',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Latest Articles Section Title
			 */
			$wp_customize->add_setting( 'powernode_blog_loop_latest_articles_section_title', array(
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Latest Articles',
			) );

			$wp_customize->add_control( 'powernode_blog_loop_latest_articles_section_title', array(
				'label' 			=> esc_html__( 'Latest Articles Title', 'powernode' ),
				'section' 			=> 'powernode_blog_loop_post_section',
				'settings' 			=> 'powernode_blog_loop_latest_articles_section_title',
				'priority' 			=> 10,
				'active_callback' 	=> 'ctm_powernodewt_blog_loop_latest_articles_section',
			) );
			
			/**
			 * Loop Post : Show Numbers Latest Article Limit
			 */
			
			$wp_customize->add_setting( 'powernode_blog_loop_latest_articles_limit', array(
				'default'          		=>  6,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_blog_loop_latest_articles_limit', array(
				'label'   				=> __( 'Show Numbers of Latest Articles', 'powernode' ),
				'section' 				=> 'powernode_blog_single_post_section',
				'settings'  			=> 'powernode_blog_loop_latest_articles_limit',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 10,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernodewt_blog_loop_latest_articles_section',
			) ) );
			
			/**
			 * Single Post Section -----------------------------------------------------------------------------------------------
			 */
			$wp_customize->add_section( 'powernode_blog_single_post_section' , array(
				'title' 			=> __( 'Single Post', 'powernode' ),
				'priority' 			=> 110,
				'panel' 			=> 'powernode_blog_post_panel',
			) );
			
			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_layout', array(
				'default'        	    => 'right-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Radio_Image_Control( $wp_customize, 'powernode_blog_single_post_page_layout', array(
				'label'	   				=> __( 'Page Layout', 'powernode' ),
				'choices' 				=> array(
											'full-width'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/full-width.png',
											'left-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/left-sidebar.png',
											'right-sidebar'  => POWERNODEWT_INC_DIR_URI . '/customizer/assets/images/right-sidebar.png',
											),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_layout',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Sidebar
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_sidebar', array(
				'default'        	    => 'single-post-sidebar',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_single_post_sidebar', array(
				'label'	   				=> __( 'Sidebar', 'powernode' ),
				'description'	   		=> __( 'Choose sidebar for display on singlular page.', 'powernode' ),
				'type' 					=> 'select',
				'choices' 				=>  ctm_powernode_get_registered_sidebars(),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_sidebar',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Page Title Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_title_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_blog_single_post_page_title_heading', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_title_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Page Title Section
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_title_section', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_single_post_page_title_section', array(
				'label'	   				=> __( 'Show Page Title Section', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_title_section',
				'priority' 				=> 10,
			) ) );
			
			
			/**
			 * Single Post : Page Title Alignment
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_title_alignment', array(
				'default'           	=> 'centered',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_single_post_page_title_alignment', array(
				'label'	   				=> __( 'Page Title Alignment', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_title_alignment',
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
			$wp_customize->add_setting( 'powernode_blog_single_post_page_title', array(
				'default'           	=> 'post_title',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_single_post_page_title', array(
				'label'	   				=> __( 'Page Title', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_title',
				'priority' 				=> 10,
				'choices' 				=> array(
											'hidden' 			=> __( 'Hidden', 'powernode' ),
											'custom' 			=> __( 'Custom Text', 'powernode' ),
											'post_title' 		=> __( 'Post Title', 'powernode' ),
										),
			) ) );
		
			
			/**
			 * Single Post : Page Header Custom Title
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_title_custom', array(
				'type' 				=> 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' 			=> 'Blog',
			) );

			$wp_customize->add_control( 'powernode_blog_single_post_page_title_custom', array(
				'label' 			=> esc_html__( 'Page Title Custom Text', 'powernode' ),
				'section' 			=> 'powernode_blog_single_post_section',
				'settings' 			=> 'powernode_blog_single_post_page_title_custom',
				'priority' 			=> 10,
				'active_callback' 		=> 'ctm_powernode_blog_single_post_page_title',
			) );
			
			/**
			 * Single Post : Page Title Background Image
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_title_background', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_single_post_page_title_background', array(
				'label'	   				=> __( 'Page Title Background', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_title_background',
				'priority' 				=> 10,
				'choices' 				=> array(
											'default' 			=> __( 'Default', 'powernode' ),
											'featured_image' 	=> __( 'Featured Image', 'powernode' ),
											'custom' 			=> __( 'Custom', 'powernode' ),
											'hidden' 			=> __( 'Hidden', 'powernode' ),
										),
			) ) );
			
			/**
			 * Single Post : Background Image
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_title_bg_image', array(
				'default'				=>  POWERNODEWT_IMAGES_DIR_URI . '/breadcrumb_banner.jpg',
				'sanitize_callback'		=> 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'powernode_blog_single_post_page_title_bg_image', array(
				'label'	   				=> __( 'Backgournd Image', 'powernode' ),
				'description'	   		=> __( 'Select the image to be used for page title background', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_title_bg_image',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_blog_single_post_page_title_background',
			) ) );
			
			/**
			 * Single Post : Breadcrumb
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_header_breadcrumb', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_single_post_page_header_breadcrumb', array(
				'label'	   				=> __( 'Show Breadcrumb', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_header_breadcrumb',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Page Content Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_page_content_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_blog_single_post_page_content_heading', array(
				'label'	   				=> __( 'Content', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_page_content_heading',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Loop Post : Sections Positioning
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_sections_positioning', array(
				'default'        	    => apply_filters( 'powernode_blog_single_post_sections_positioning', array( 'categories', 'thumbnail', 'title', 'meta', 'content', 'tags', 'social-links', 'author-info', 'next-prev', 'related-posts', 'comments' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_blog_single_post_sections_positioning', array(
				'label'	   				=> __( 'Sections Positioning', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_blog_single_post_meta_choices',
												array(
													'categories'    => esc_html__( 'Categories', 'powernode' ),
													'thumbnail'     => esc_html__( 'Thumbnail', 'powernode' ),
													'title'    		=> esc_html__( 'Title', 'powernode' ),
													'meta'    		=> esc_html__( 'Meta', 'powernode' ),
													'content'    	=> esc_html__( 'Content', 'powernode' ),
													'tags'			=> esc_html__( 'Tags', 'powernode' ),
													'social-links'  => esc_html__( 'Social Links', 'powernode' ),
													'author-info'  	=> esc_html__( 'Author Info', 'powernode' ),
													'next-prev' 	=> esc_html__( 'Next/Prev', 'powernode' ),
													'related-posts'	=> esc_html__( 'Related Posts', 'powernode' ),
													'comments' 		=> esc_html__( 'Comments', 'powernode' ),
												)
											),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_sections_positioning',
				'priority' 				=> 10,
			) ) );
		
			/**
			 * Single Post : Blog Meta
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_meta', array(
				'default'        	    => apply_filters( 'powernode_blog_single_post_meta_default', array( 'author', 'categories', 'tags', 'comments', 'date' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_blog_single_post_meta', array(
				'label'	   				=> __( 'Meta', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_blog_single_post_meta_choices',
												array(
													'author'        => esc_html__( 'Author', 'powernode' ),
													'categories'    => esc_html__( 'Categories', 'powernode' ),
													'tags'    => esc_html__( 'Tags', 'powernode' ),
													'comments'      => esc_html__( 'Comments', 'powernode' ),
													'date'          => esc_html__( 'Date', 'powernode' ),
													'reading-time'  => esc_html__( 'Reading Time', 'powernode' ),
												)
											),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_meta',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Social Share Links
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_social_share_links', array(
				'default'        	    => apply_filters( 'powernode_blog_single_post_social_share_links_default', array( 'facebook', 'twitter', 'instagram', 'pinterest', 'linkedin', 'whatsapp' ) ),
				'sanitize_callback' 	=> 'powernodewt_sanitize_multi_choices',
			) );
			
			$social_share_links_data = powernodewt_social_share_links_data();
			
			$single_post_social_share_links = array();
			foreach ( $social_share_links_data as $soc_name => $soc_det ) {
				$single_post_social_share_links[$soc_name] = esc_html( $soc_det['label'] );
			}
			$wp_customize->add_control( new PowerNodeWT_Customizer_Sortable_Control( $wp_customize, 'powernode_blog_single_post_social_share_links', array(
				'label'	   				=> __( 'Social Share Links', 'powernode' ),
				'choices' 				=>  apply_filters(
												'powernode_blog_single_post_social_share_links_choices',
												$single_post_social_share_links
											),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_social_share_links',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_blog_single_post_social_share',
			) ) );
			
			/**
			 * Single Post : Related Posts Heading ================================
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_posts_heading', array(
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Heading_Control( $wp_customize, 'powernode_blog_single_post_related_posts_heading', array(
				'label'	   				=> __( 'Related Posts', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_related_posts_heading',
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_blog_single_post_related_posts',
			) ) );
			
			/**
			 * Single Post : Related Posts
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'powernodewt_sanitize_checkbox',
			) );
			
			$wp_customize->add_control( new PowerNodeWT_Customizer_Checkbox_Toggle_Control( $wp_customize, 'powernode_blog_single_post_related', array(
				'label'	   				=> __( 'Show Related Posts', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_related',
				'priority' 				=> 10,
			) ) );
			
			/**
			 * Single Post : Posts Styles
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_single_post_related_style', array(
				'label'	   				=> __( 'Post Style', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_related_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 		=> __( 'Default', 'powernode' ),
					'fancy' 		=> __( 'Fancy', 'powernode' ),
					'box' 			=> __( 'Box', 'powernode' ),
				),
			) ) );
			
			/**
			 * Single Post : Post Content
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_content', array(
				'default'           	=> '',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_single_post_related_content', array(
				'label'	   				=> __( 'Post Content', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_related_content',
				'priority' 				=> 10,
				'choices' 				=> array(
											'excerpt' 			=> __( 'Excerpt', 'powernode' ),
											'full' 				=> __( 'Full', 'powernode' ),
											'' 					=> __( 'Hidden', 'powernode' ),
										),
			) ) );
			
			/**
			 * Single Post : Excerpt Length
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_excerpt_length', array(
				'default'          		=>  20,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
				'transport' 			=> 'postMessage',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_blog_single_post_related_excerpt_length', array(
				'label'   				=> __( 'Excerpt Length', 'powernode' ),
				'description'	   		=> __( 'Show Post Content Summery.', 'powernode' ),
				'section' 				=> 'powernode_blog_single_post_section',
				'settings'  			=> 'powernode_blog_single_post_related_excerpt_length',
				'choices' 				=> array(
											'min'  => 0,
											'max'  => 500,
											'step' => 1,
										),
			) ) );
			
			/**
			 * Single Post : Read More
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_read_more', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'powernodewt_sanitize_choices',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'powernode_blog_single_post_related_read_more', array(
				'label'	   				=> __( 'Read More', 'powernode' ),
				'type' 					=> 'select',
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_related_read_more',
				'priority' 				=> 10,
				'choices' 				=> array(
					'link' 				=> __( 'Link (Default)', 'powernode' ),
					'button' 			=> __( 'Button', 'powernode' ),
					'icon' 				=> __( 'Icon', 'powernode' ),
					'0' 				=> __( 'Hide', 'powernode' ),
				),
			) ) );
			
			/**
			 * Single Post : Show Numbers Related Posts
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_posts_number', array(
				'default'          		=>  6,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_blog_single_post_related_posts_number', array(
				'label'   				=> __( 'Show Numbers of Related Posts', 'powernode' ),
				'section' 				=> 'powernode_blog_single_post_section',
				'settings'  			=> 'powernode_blog_single_post_related_posts_number',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 20,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_blog_single_post_related_posts',
			) ) );
			
			/**
			 * Single Post : Show Related Posts Columns
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_posts_columns', array(
				'default'          		=>  2,
				'sanitize_callback' 	=> 'powernodewt_sanitize_number_range',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Slider_Control( $wp_customize, 'powernode_blog_single_post_related_posts_columns', array(
				'label'   				=> __( 'Show Related Posts Columns', 'powernode' ),
				'section' 				=> 'powernode_blog_single_post_section',
				'settings'  			=> 'powernode_blog_single_post_related_posts_columns',
				'choices' 				=> array(
											'min'  => 1,
											'max'  => 12,
											'step' => 1,
										),
				'priority' 				=> 10,
				'active_callback' 		=> 'ctm_powernode_blog_single_post_related_posts',
			) ) );
			
			/**
			 * Single Post : Related Posts Taxonomy
			 */
			$wp_customize->add_setting( 'powernode_blog_single_post_related_posts_taxonomy', array(
				'default'           	=> 'category',
				'sanitize_callback' 	=> 'powernodewt_sanitize_select',
			) );

			$wp_customize->add_control( new PowerNodeWT_Customizer_Buttonset_Control( $wp_customize, 'powernode_blog_single_post_related_posts_taxonomy', array(
				'label'	   				=> __( 'Related Posts Taxonomy', 'powernode' ),
				'section'  				=> 'powernode_blog_single_post_section',
				'settings' 				=> 'powernode_blog_single_post_related_posts_taxonomy',
				'priority' 				=> 10,
				'choices' 				=> array(
											'category' 			=> __( 'Category', 'powernode' ),
											'post_tag' 			=> __( 'Tags', 'powernode' ),
										),
				'active_callback' 		=> 'ctm_powernode_blog_single_post_related_posts',
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
			$ctegories = get_categories( array('post_type' => 'post', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			$posts_id = get_posts( array('post_type' => 'post', 'numberposts' => 1, 'post_status' => 'publish', 'fields' => 'ids' ) );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					<?php if ( !empty( $ctegories[0] ) ) { ?>
					wp.customize.section( 'powernode_blog_loop_post_section', function( section ) {
						section.expanded.bind( function( isExpanded ) {
							if ( isExpanded ) {
								wp.customize.previewer.previewUrl.set( "<?php echo esc_js( get_category_link( $ctegories[0] ) ); ?>" );
							}
						} );
					} );
					<?php } ?>
					<?php if ( !empty( $posts_id[0] ) ) { ?>
					wp.customize.section( 'powernode_blog_single_post_section', function( section ) {
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

return new PowerNodeWT_Blog_Post_Customizer();