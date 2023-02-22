<?php
/**
 * Page Header v1
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */

$atts = array();
$atts['id'] = 'header';
$atts['class'] = apply_filters( 'powernode_header_classes', array( 'header' ) );
$atts = apply_filters( 'powernode_header_atts', $atts );
?>
<header <?php echo powernodewt_stringify_atts( $atts ); ?>>
	<div class="header-wrapper">
		<?php do_action( 'powernode_topbar' ); ?>
		<?php powernodewt_get_template( 'template-parts/elements/header-mobile'); ?>
		<div class="header-mid-area wsmainfull header-wrap menu clearfix">
			<span class="logo-background"> </span>
			<div class="wsmainwp menu-container clearfix">
				<?php do_action( 'powernode_header_logo' ); ?>
				<div class="pnwt-nav wsmenu clearfix">
					<?php do_action( 'powernode_header_primary_navigation' ); ?>
				</div>
			</div>
		</div>
		<?php if( get_theme_mod( 'powernode_show_header_search', true ) ) { ?>
		<div class="container">
			<div class="header-pop-area">
				<div id="search-dropdown" class="searchfrm-dropdown search-content mpwi-dropdown">
					<?php get_search_form();?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</header>