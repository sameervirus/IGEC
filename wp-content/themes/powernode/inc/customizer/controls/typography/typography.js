wp.customize.controlConstructor['powernodewt-typography'] = wp.customize.powernodewtBaseControl.extend( {} );

( function($) {
	
	$( document ).ready(function () {

		$( '.powernodewt-typography-select' ).select2();

	} );

} )( jQuery );