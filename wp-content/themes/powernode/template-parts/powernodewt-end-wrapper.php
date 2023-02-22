<?php
/**
 * After Content Wrapper
 *
 * @package PowerNodeWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>
					<?php do_action( 'powernode_after_content_inner' ); ?>
				</div>
				<?php do_action( 'powernode_after_content' ); ?>
			</div>
			<?php do_action( 'powernode_after_primary' ); ?>
		</div>
	</div>
<?php do_action( 'powernode_after_content_wrap' ); ?>