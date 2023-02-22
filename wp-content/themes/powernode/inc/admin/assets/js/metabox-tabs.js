( function ( window, document, $ ) {
	'use strict';

	function switchTab() {
		$( '.mb-tab-nav' ).on( 'click', 'a', e => {
			e.preventDefault();
			showTab( e.target );
		} );
	}

	function showTab( el ) {
		var tab = el.closest( 'li' ).dataset.panel,
			$wrapper = $( el ).closest( '.mb-tabs' ),
			$tabs = $wrapper.find( '.mb-tab-nav > li' ),
			$panels = $wrapper.find( '.mb-tab-panel' );

		$tabs.removeClass( 'mb-tab-active' ).filter( '[data-panel="' + tab + '"]' ).addClass( 'mb-tab-active' );
		$panels.hide().filter( '.mb-tab-panel-' + tab ).show();

		// Refresh maps, make sure they're fully loaded, when it's in hidden div (tab).
		$( window ).trigger( 'rwmb_map_refresh' );
	}

	// Set active tab based on visible pane to better works with Meta Box Conditional Logic.
	function tweakForConditionalLogic() {
		if ( $( '.mb-tab-active' ).is( 'visible' ) ) {
			return;
		}

		// Find the active pane.
		var activePane = $( '.mb-tab-panel[style*="block"]' ).index();
		if ( activePane >= 0 ) {
			$( '.mb-tab-nav li' ).removeClass( 'mb-tab-active' ).eq( activePane ).addClass( 'mb-tab-active' );
		}
	}

	function showValidateErrorFields() {
		var inputSelectors = 'input[class*="rwmb-error"], textarea[class*="rwmb-error"], select[class*="rwmb-error"], button[class*="rwmb-error"]';
		$( document ).on( 'after_validate', 'form', e => {
			var $input = $( e.target ).find( inputSelectors );
			showTab( $input, $input.closest( '.mb-tab-panel' ).data( 'panel' ) );
		} );
	}

	$( function() {
		switchTab();
		tweakForConditionalLogic();
		showValidateErrorFields();

		$( '.mb-tab-active a' ).trigger( 'click' );

		// Remove wrapper. Use Meta Box's seamless style.
		$( '.mb-tabs-no-wrapper' ).closest( '.postbox' ).removeClass( 'rwmb-default' ).addClass( 'rwmb-seamless' );
	} );
} )( window, document, jQuery );
