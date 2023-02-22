<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package PowerNode
 * @since PowerNode 1.0
 */

get_header();
?>
<div class="content-wrap bg-lightgrey">
	<section class="error-404 wide-50 pt-0 bg-fixed division">
		<div class="container">	
			<div class="row">
				<div class="col-lg-8 offset-lg-2">
					<div class="hero-30-txt text-center">
						<div class="hero-30-img text-center">
							<h1 class="entry-title"><?php echo esc_html__('404', 'powernode'); ?></h1>
						</div>
						<?php if( $heading = get_theme_mod( 'powernode_pages_404page_heading_text', esc_html__('Page Not Found', 'powernode') ) ) { ?>
						<h2 class="h2-lg"><?php echo esc_html( $heading ); ?></h2>
						<?php } ?>
						<?php if( $content = get_theme_mod( 'powernode_pages_404page_content', esc_html__('The page you are looking for might have been moved , renamed or might never existed.', 'powernode') ) ) { ?>
						<h5 class="h5-lg"><?php echo esc_html( $content ); ?></h5>
						<?php } ?>
						<div class="mb-40"><?php get_search_form(); ?></div>
						<!-- Button -->
						<?php if( $button = get_theme_mod( 'powernode_pages_404page_button_text', esc_html__('Back to Home', 'powernode') ) ) { ?>
						<a href="<?php echo esc_url( get_home_url() ); ?>" class="btn btn-md btn-tra-theme theme-hover"><?php echo wp_kses_post( $button ); ?></a>
						<?php } ?>
					</div>
				</div>
			</div>	  
		</div>	
	</section>
</div>
<?php
get_footer();