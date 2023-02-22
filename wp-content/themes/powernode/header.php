<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url( bloginfo( 'pingback_url' ) ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php do_action( 'powernode_before_site' ); ?>
	<div id="main-wrap" class="main-wrap">
	<?php do_action( 'powernode_before_main_wrap' ); ?>
	<?php do_action( 'powernode_header' ); ?>
	<?php do_action( 'powernode_before_outer_main' ); ?>
		<div <?php echo powernodewt_main_page_atts(); ?>>
		<?php do_action( 'powernode_before_main' );  ?>
