<?php
/**
 * Customizer Helpers
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( !function_exists( 'powernodewt_customizer_options_val' ) ) {
	
	function powernodewt_opt_chk_def_val( $val = '', $def_val = '' ) {
		
		if ( $val != '' && $val == $def_val ) {
			return true;
		}
		return false;
	}
}

function ctm_powernode_general_preloader() {
	return get_theme_mod( 'powernode_general_preloader', true );
}

function ctm_powernode_general_preloader_type_is_predefine() {
	$type = get_theme_mod( 'powernode_general_preloader_type', 'predefine' );
	if ( ctm_powernode_general_preloader() && $type == 'predefine' ) {
		return true;
	}
	return false;
}

function ctm_powernode_general_preloader_type_is_custom() {
	$type = get_theme_mod( 'powernode_general_preloader_type', 'predefine' );
	if ( ctm_powernode_general_preloader() && $type == 'custom' ) {
		return true;
	}
	return false;
}
 
function ctm_powernode_is_topbar_enable() {
	$status = get_theme_mod( 'powernode_topbar', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernode_display_topbar_social() {
	return ( ctm_powernode_is_topbar_enable() && get_theme_mod( 'powernode_topbar_social' ) ) ? true : false;
}

function ctm_powernode_page_title_background_enabled() {
	$status = get_theme_mod( 'powernode_page_title_background', 'default' );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernode_is_container_width_active() {
	$page_layout = get_theme_mod( 'powernode_main_layout_style', true );
	if ($page_layout == 'predefine') {
		return true;
	}
	return false;
}

function ctm_powernode_is_boxed_layout_active() {
	$page_layout = get_theme_mod( 'powernode_main_layout_style', true );
	if ($page_layout == 'boxed') {
		return true;
	}
	return false;
}

function ctm_powernode_is_product_image_swap_style() {
	$style = get_theme_mod( 'powernode_woo_loop_product_image_style', true );
	if ($style == 'image-swap') {
		return true;
	}
	return false;
}

function ctm_powernode_is_product_image_slider_style() {
	$style = get_theme_mod( 'powernode_woo_loop_product_image_style', true );
	if ($style == 'image-slider') {
		return true;
	}
	return false;
}

function powernodewt_woo_general_badges_enable() {
	$style = get_theme_mod( 'powernode_woo_loop_product_badges_status', true );
	if ($style == true) {
		return true;
	}
	return false;
}

function ctm_powernode_woo_general_badges_sale_enable() {
	$style = get_theme_mod( 'powernode_woo_loop_product_badges_sale', true );
	if ($style == true && (powernodewt_woo_general_badges_enable() == true) ) {
		return true;
	}
	return false;
}

function ctm_powernode_woo_general_badges_new_enable() {
	$style = get_theme_mod( 'powernode_woo_loop_product_badges_new', true );
	if ($style == true) {
		return true;
	}
	return false;
}

function ctm_powernode_is_product_content_ratings_enable() {
	$value = get_theme_mod( 'powernode_woo_loop_prod_ratings', true );
	if ($value == true) {
		return true;
	}
	return false;
}

function ctm_powernode_is_product_content_description_enable() {
	$value = get_theme_mod( 'powernode_woo_loop_prod_description', true );
	if ($value == true) {
		return true;
	}
	return false;
}

function ctm_powernode_is_product_content_action_buttons_enable() {
	$style = get_theme_mod( 'powernode_woo_loop_prod_actions_buttons', true );
	if ($style == true) {
		return true;
	}
	return false;
}

function ctm_powernode_woo_general_badges_featured_enable() {
	$style = get_theme_mod( 'powernode_woo_loop_product_badges_featured', true );
	if ($style == true && (powernodewt_woo_general_badges_enable() == true) ) {
		return true;
	}
	return false;
}

function ctm_powernode_woo_general_badges_outofstock_enable() {
	$style = get_theme_mod( 'powernode_woo_loop_product_badges_outofstock', true );
	if ($style == true && (powernodewt_woo_general_badges_enable() == true) ) {
		return true;
	}
	return false;
}

function ctm_powernode_woo_loop_gridlist_enable() {
	$status = get_theme_mod( 'powernode_woo_loop_gridlist', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernode_woo_loop_show_perpage_dropdown_enable() {
	$status = get_theme_mod( 'powernode_is_woo_loop_show_perpage_dropdown', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernode_is_woo_single_prod_availability_enable() {
	$status = get_theme_mod( 'powernode_woo_single_prod_availability_enable', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernode_is_woo_single_prod_upsells_related_prods_slider_enable() {
	$status = get_theme_mod( 'powernode_woo_single_prod_upsell_related_prods_slider_enable', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernode_woo_single_prod_sale_label_after_price() {
	$status = get_theme_mod( 'powernode_woo_single_prod_sale_label', 'after-price' );
	if ($status == 'after-price') {
		return true;
	}
	return false;
}


function ctm_powernode_is_woo_cart_prod_slider_slider_enable() {
	$status = get_theme_mod( 'powernode_woo_cart_prod_slider_slider_enable', true );
	if ( $status == true ) {
		return true;
	}
	return false;
}

function ctm_powernode_get_registered_sidebars() {
	global $wp_registered_sidebars;
	$sidebars = array();
	if ( !empty( $wp_registered_sidebars ) ) {
		foreach( $wp_registered_sidebars as $sk => $sv ) {
			$sidebars[$sv['id']] = $sv['name'];
		}
	}
	return $sidebars;
}

function ctm_powernode_blog_loop_post_page_title() {
	$page_title = get_theme_mod( 'powernode_blog_loop_post_page_title', 'custom' );
	if ( $page_title == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_powernodewt_blog_loop_post_page_title_background() {
	$type = get_theme_mod( 'powernode_blog_loop_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_powernodewt_blog_loop_view_type_is_grid() {
	$style = get_theme_mod( 'powernode_blog_loop_view_type', 'default' );
	if ( $style == 'grid' ) {
		return true;
	}
	return false;
}

function ctm_powernodewt_blog_loop_post_social_share() {
	$sections = get_theme_mod( 'powernode_blog_loop_post_sections_positioning');
	if ( in_array( 'social_links', $sections ) ) {
		return true;
	}
	return false;
}

function ctm_powernodewt_blog_loop_post_pagination_style_not_default() {
	$style = get_theme_mod( 'powernode_blog_loop_post_pagination_style', 'default' );
	if ($style != 'default') {
		return true;
	}
	return false;
}

function ctm_powernodewt_blog_loop_latest_articles_section() {
	$status = get_theme_mod( 'powernode_blog_loop_latest_articles_section', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernodewt_blog_loop_mostread_articles_section() {
	$status = get_theme_mod( 'powernode_blog_loop_mostread_articles_section', true );
	if ($status == true) {
		return true;
	}
	return false;
}

function ctm_powernode_blog_single_post_page_title() {
	$page_title = get_theme_mod( 'powernode_blog_single_post_page_title', 'custom' );
	if ($page_title == 'custom') {
		return true;
	}
	return false;
}

function ctm_powernode_blog_single_post_page_title_background() {
	$type = get_theme_mod( 'powernode_blog_single_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_powernode_blog_single_post_social_share() {
	$enabled = get_theme_mod( 'powernode_blog_single_post_social_share', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_powernode_blog_single_post_related_posts() {
	$enabled = get_theme_mod( 'powernode_blog_single_post_related_posts', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_powernode_social_links_enabled() {
	$enabled = get_theme_mod( 'powernode_social_links', true );
	if ( $enabled == true) {
		return true;
	}
	return false;
}

function ctm_powernode_social_share_links_enabled() {
	$enabled = get_theme_mod( 'powernode_social_share_links', true );
	if ( $enabled == true) {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_loop_post_page_title() {
	$page_title = get_theme_mod( 'powernode_portfolio_loop_post_page_title', 'custom' );
	if ($page_title == 'custom') {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_loop_post_page_title_background() {
	$type = get_theme_mod( 'powernode_portfolio_loop_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_loop_view_type_is_grid() {
	$style = get_theme_mod( 'powernode_portfolio_loop_view_type', 'default' );
	if ($style == 'grid') {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_loop_post_social_share() {
	$sections = get_theme_mod( 'powernode_portfolio_loop_post_sections_positioning');
	if ( in_array( 'social_links', $sections ) ) {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_loop_post_pagination_style_not_default() {
	$style = get_theme_mod( 'powernode_portfolio_loop_post_pagination_style', 'default' );
	if ($style != 'default') {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_single_post_page_title() {
	$page_title = get_theme_mod( 'powernode_portfolio_single_post_page_title', 'custom' );
	if ($page_title == 'custom') {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_single_post_page_title_background() {
	$type = get_theme_mod( 'powernode_portfolio_single_post_page_title_background', 'custom' );
	if ( $type == 'custom' ) {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_single_post_social_share() {
	$enabled = get_theme_mod( 'powernode_portfolio_single_post_social_share', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}

function ctm_powernode_portfolio_single_post_related_posts() {
	$enabled = get_theme_mod( 'powernode_portfolio_single_post_related_posts', true);
	if ($enabled == true) {
		return true;
	}
	return false;
}