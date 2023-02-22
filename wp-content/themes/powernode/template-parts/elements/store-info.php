<?php
/**
 * Store Info
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

$storeinfo_html = '';
if(!empty($store_info)){
	$storeinfo_html .= '<div class="store-info">';
	$storeinfo_html .= '<ul class="menu">';
	foreach ( $store_info as $key => $val ) {
		if(isset($store_info_vals[$key]) && $store_info_vals[$key] != ''){
			$storeinfo_html .= '<li class="si-'.$key.' mr-1"><i class="'.esc_attr($val['icon_class']).' mr-1"></i><span>'.($store_info_vals[$key]).'</span></li>';
		}
	}
	$storeinfo_html .= '</ul>';
	$storeinfo_html .= '</div>';
}
echo apply_filters( 'powernode_storeinfo', $storeinfo_html );