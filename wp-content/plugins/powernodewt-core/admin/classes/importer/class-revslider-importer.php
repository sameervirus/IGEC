<?php
/**
 * Class for the RevSlider importer.
 */
class PowerNodeWT_RevSlider_Importer {

	public function import_revslider( $revslider_path ) {
		
		if (  !empty( $revslider_path ) && class_exists( 'UniteFunctionsRev' ) && class_exists( 'ZipArchive' ) ) {
			
			$rev_sliders = array();
			foreach( glob( $revslider_path.'/*.zip') as $file ){
				$filename = basename( $file );
				$rev_sliders[] = $revslider_path . '/' . $filename;
			}
			
			if(!function_exists( 'WP_Filesystem' )){
				require_once( ABSPATH . 'wp-admin/includes/file.php' );	
			}
			
			$slider = new RevSlider();	
			foreach( $rev_sliders as $rev_slider ) { // finally import rev slider data files
				ob_start();
					$result = $slider->importSliderFromPost( true, false, $rev_slider );
				ob_clean();
				ob_end_clean();
			}
			
		} else {
			return esc_html__( 'RevSlider class does not exits.', 'powernodewt-core' );
		}
    }
}