<?php
/**
 * Topbar Social
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

$social_html = '';
if(!empty($social_icons)){
	$social_html .= '<div class="social-icons">';
	$social_html .= '<ul class="menu">';
	foreach ( $social_icons as $key => $val ) {
		if(isset($social_icons_vals[$key]) && $social_icons_vals[$key] != ''){
			if($key == 'email'){
				$href = 'mailto:'.$social_icons_vals[$key];
			} else {
				$href = $social_icons_vals[$key];
			}
			$social_html .= '<li class="soc-'.$key.'"><a href="'.$href.'" title = "'.esc_attr($val['label']).'" target="_blank"><i class="'.esc_attr($val['icon_class']).'"></i></a></li>';
		}
	}
	$social_html .= '</ul>';
	$social_html .= '</div>';
}
echo apply_filters( 'powernode_social_icons', $social_html );