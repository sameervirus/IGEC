(function ($) {
	"use strict";
	jQuery(document).ready(function() {
		jQuery('body').on('change', ".edit-menu-item-menu-type", function( e ){
			var $this = jQuery(this);
			pnwt_megamenu_items_handler( $this, $this.val() );
		});
		
		jQuery('body').on('change', ".edit-menu-item-megamenu-layout", function(){
			var $this = jQuery(this)
			powernodewt_edit_megamenu_layout( $this, $this.val() );
		});
	});
	
	function pnwt_megamenu_items_handler( $this, $type = '' ) {
		var mgFeilds = $this.parents('.powernode-menu-fields');
		mgFeilds.find('.megamenu-fields').addClass('hidden');
		if( $type ) {
			mgFeilds.find('.megamenu-fields.'+ $type).removeClass('hidden');
		}
		powernodewt_edit_megamenu_layout( $this, mgFeilds.find('.edit-menu-item-megamenu-layout option:selected').val() );
	}
	
	function powernodewt_edit_megamenu_layout ( $this, layout = 'full-width' ) {
		var megamenu_flds_block = $this.parents('.powernode-menu-fields').find('.megamenu-layout-block');
		megamenu_flds_block.addClass('hidden');
		if ( layout == 'custom-size' ) {
			megamenu_flds_block.removeClass('hidden');
		} else {
			megamenu_flds_block.addClass('hidden');
		}
		
	}
})(jQuery); 
