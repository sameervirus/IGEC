
/* global dimensionspowernodeL10n */
wp.customize.controlConstructor['powernode-dimensions'] = wp.customize.powernodewtBaseControl.extend( {

	initPowerNodeWTControl: function( control ) {
		var value;
		control = control || this;

		control.container.on( 'change keyup paste', '.dimension-desktop_top', function() {
			control.settings['desktop_top'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-desktop_right', function() {
			control.settings['desktop_right'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-desktop_bottom', function() {
			control.settings['desktop_bottom'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-desktop_left', function() {
			control.settings['desktop_left'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-tablet_top', function() {
			control.settings['tablet_top'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-tablet_right', function() {
			control.settings['tablet_right'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-tablet_bottom', function() {
			control.settings['tablet_bottom'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-tablet_left', function() {
			control.settings['tablet_left'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-mobile_top', function() {
			control.settings['mobile_top'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-mobile_right', function() {
			control.settings['mobile_right'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-mobile_bottom', function() {
			control.settings['mobile_bottom'].set( jQuery( this ).val() );
		} );

		control.container.on( 'change keyup paste', '.dimension-mobile_left', function() {
			control.settings['mobile_left'].set( jQuery( this ).val() );
		} );

		// Notifications.
		//control.powernodewtNotifications();
	},

	/**
	 * Handles notifications.
	 *
	 * @returns {void}
	 */
	powernodewtNotifications: function() {

		var control        = this,
			acceptUnitless = ( 'undefined' !== typeof control.params.choices && 'undefined' !== typeof control.params.choices.accept_unitless && true === control.params.choices.accept_unitless );

		wp.customize( control.id, function( setting ) {
			setting.bind( function( value ) {
				var code = 'long_title';

				if ( false === control.validateCssValue( value ) && ( ! acceptUnitless || isNaN( value ) ) ) {
					setting.notifications.add( code, new wp.customize.Notification( code, {
						type: 'warning',
						message: dimensionspowernodeL10n['invalid-value']
					} ) );
				} else {
					setting.notifications.remove( code );
				}
			} );
		} );
	},

	validateCssValue: function( value ) {

		var validUnits = [ 'fr', 'rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax' ],
			numericValue,
			unit;

		// Whitelist values.
		if ( ! value || '' === value || 0 === value || '0' === value || 'auto' === value || 'inherit' === value || 'initial' === value ) {
			return true;
		}

		// Skip checking if calc().
		if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
			return true;
		}

		// Get the numeric value.
		numericValue = parseFloat( value );

		// Get the unit
		unit = value.replace( numericValue, '' );

		// Allow unitless.
		if ( ! unit ) {
			return true;
		}

		// Check the validity of the numeric value and units.
		return ( ! isNaN( numericValue ) && -1 !== validUnits.indexOf( unit ) );
	}
} );

jQuery( document ).ready( function($) {

	// Connected button
	$('body').on('click', '.powernodewt-connected' , function() {

		var $this = $( this );

		// Remove connected class
		$(this).parents( '.device-cont' ).find( 'input' ).removeClass( 'connected' ).attr( 'data-element', '' );

		// Remove class
		$(this).parents( '.link-dimensions' ).removeClass( 'disconnected' );
	});

	// Connected button
	$('body').on('click', '.powernodewt-disconnected' , function() {
		
		var $this 		= $( this ),
			$element 	= $(this).data( 'element' );

		// Remove connected class
		$(this).parents( '.device-cont' ).find( 'input' ).addClass( 'connected' ).attr( 'data-element', $element );

		// Remove class
		$(this).parents( '.link-dimensions' ).addClass( 'disconnected' );
	});
	
	// Values connected inputs
	$( '.dimension-wrap' ).on( 'input', '.connected', function() {

		var $data 	= $( this ).attr( 'data-element' ),
			$val 	= $( this ).val();

		$( '.connected[ data-element="' + $data + '" ]' ).each( function( key, value ) {
			$( this ).val( $val ).change();
		} );

	} );

} );