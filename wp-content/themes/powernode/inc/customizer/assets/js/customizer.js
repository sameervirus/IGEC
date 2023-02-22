jQuery( document ).ready(function($) {
	"use strict";
	
	$('body').on('click', '.devices-list li button', function(){
		var $this = $(this),
		data_device = $this.data('device');
		$this.parents('ul').find('button').removeClass('active');
		$this.addClass('active');
		$('.devices-wrapper .device-cont').removeClass('active');
		$('.devices-wrapper .device-cont' + '.' + data_device).addClass('active');
		$('.devices-wrapper .devices button.preview-' + data_device).trigger('click');
		if ( data_device == 'desktop' ) {
			$this.parents('.customize-control').toggleClass('devices-open');
		}
	})
});
