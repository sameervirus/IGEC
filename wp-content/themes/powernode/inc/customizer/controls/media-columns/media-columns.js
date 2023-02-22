
wp.customize.controlConstructor['powernodewt-media-columns'] = wp.customize.powernodewtBaseControl.extend( {

	initPowerNodeWTControl: function( control ) {
	
		var value,
		control      = control || this;

		jQuery( '.devices-wrapper .device-cont input[type="range"]' ).each(function( i ) {
			var $this = jQuery( this ),
			$cur_wrap = $this.parents('.mediacols-wrap');
			$cur_wrap.find('input[type="range"]').attr( 'value', $this.val() );
			$cur_wrap.find('input[type="text"]').attr( 'value',$this.val() );
			control.settings[$cur_wrap.data('keyid')].set( $this.val() );
		  });

		control.container.on( 'mousemove change', 'input[type="range"]', function() {
			var $this = jQuery( this ),
			$cur_wrap = $this.parents('.mediacols-wrap');
			$cur_wrap.find('input[type="text"]').attr( 'value', $this.val() );
			control.settings[$cur_wrap.data('keyid')].set( $this.val() );
		} );

		control.container.on( 'input paste change', 'input[type="text"]', function() {
			var $this = jQuery( this ),
			$cur_wrap = $this.parents('.mediacols-wrap');
			$cur_wrap.find('input[type="range"]').attr( 'value', $this.val() );
			control.settings[$cur_wrap.data('keyid')].set( $this.val() );
		} );
		
		control.container.find( '.slider-reset' ).on( 'click', function() {
			var $this = jQuery( this ),
			$cur_wrap = $this.parents('.mediacols-wrap'),
			rangeInput = $cur_wrap.find('input[type="range"]'),
			reset_val = rangeInput.data('reset_value');
			rangeInput.attr( 'value', reset_val );
			$cur_wrap.find('input[type="text"]').attr( 'value', reset_val );
			control.settings[$cur_wrap.data('keyid')].set( reset_val );
		} );
	}
} );