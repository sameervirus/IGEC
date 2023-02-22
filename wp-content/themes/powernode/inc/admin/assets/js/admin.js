var wtadmin = wtadmin || {}, powernodeMediaInit;
(function ($) {
	"use strict";
	wtadmin.initialization = {
		init: function () {
			this.colorPicker('.powernode-color-picker');
			this.activationForm();
			this.pluginManager();
			$body.on('click', 'input[name=wt-cie-export-button]', function(){
				wtadmin.initialization.exportCustomizer();
			});
			$body.on('click', 'input[name=wt-cie-import-button]', function(){
				wtadmin.initialization.importCustomizer();
			});
		},
		colorPicker : function (selector) {
			jQuery(selector).each(function () {
				jQuery(this).wpColorPicker();
			})
		},
		mediaInit: function( selector, button_selector, image_selector ) {
			var clicked_button = false;
			jQuery(selector).each(function (i, input) {
				var button = jQuery(input).next(button_selector);
				button.click(function (event) {
					event.preventDefault();
					var selected_img;
					clicked_button = jQuery(this);
		 
					// check for media manager instance
					if (wp.media.frames.gk_frame) {
						wp.media.frames.gk_frame.open();
						return;
					}
					// configuration of the media manager new instance
					wp.media.frames.gk_frame = wp.media({
						title: 'Select image',
						multiple: false,
						library: {
							type: 'image'
						},
						button: {
							text: 'Use selected image'
						}
					});
		 
					// Function used for the image selection and media manager closing
					var gk_media_set_image = function() {
						var selection = wp.media.frames.gk_frame.state().get('selection');
		 
						// no selection
						if (!selection) {
							return;
						}
		 
						// iterate through selected elements
						selection.each(function(attachment) {
							var url = attachment.attributes.url;
							clicked_button.prev(selector).val(attachment.attributes.id);
							jQuery(image_selector).attr('src', url).show();
						});
					};
		 
					// closing event for media manger
					wp.media.frames.gk_frame.on('close', gk_media_set_image);
					// image selection event
					wp.media.frames.gk_frame.on('select', gk_media_set_image);
					// showing media manager
					wp.media.frames.gk_frame.open();
				});
		   });
		},
		activationForm : function () {
			$body.on('submit', 'form.activation-form', function (e) {
				e.preventDefault();
				var $this = $(this),
					panelWrap = $this.parents('.pnwt-panel');
				panelWrap.addClass('pnwt-loader');
				$.ajax({
					dataType: 'json',
					url: paWT.ajxUrl,
					data: {
						'action' : 'activation_theme',
						'purchase_code'	: $this.find('input[name=purchase_code]').val(),
						'activation_actions' : $this.find('input[name=activation_actions]').val(),
					},
					method: 'POST',
					success: function ( response ) {
						if( response ) {
							panelWrap.find('.pnwt-messages').html( response.message );
							panelWrap.removeClass('pnwt-loader');
							if ( response.is_reload ) {
								location.reload();
							}
						}
					},
					error: function () {
						alert('Something went wrong, please try again latter.');
					}
				});
			});
		},
		pluginManager: function() {
			
			var current_item = '';
			var $current_node;
			var current_item_hash = '';
			
			$body.on('click', '.pnwt-plugin-action', function (e) {
				e.preventDefault();
				var $this = $(this);
				current_item = $this.data('slug');
				$current_node = $this.parents('.plugin-item');
				process_current();
				$this.addClass('updating-message').removeClass('pnwt-plugin-action');
				$this.parents( '.plugin-item' ).find('.spinner').css('visibility', 'visible');
			});
			
			function ajax_callback(response){
				if(typeof response == 'object' && typeof response.message != 'undefined') {
					$current_node.find('span').html( response.message.message );
					$('.pnwt-install-core-plugins').html(response.message.message);
					if(typeof response.url != 'undefined'){
						// we have an ajax url action to perform.
						if(response.hash == current_item_hash){
							$current_node.find('span').html('<span class="pnwt-msg pnwt-error">'+ wp.updates.l10n.installFailedShort +'</span>');
						}else {
							current_item_hash = response.hash;
							jQuery.post(response.url, response, function(response2) {
								jQuery.post( paWT.ajxUrl, {
									action: 'plugin_process',
									wpnonce: paWT.wpnonce,
									slug: current_item
								}, function( res_process ) {
									$current_node.find('.spinner').css('visibility','hidden');
									$current_node.find('span').html( res_process.process_message );
									$current_node.find('.pnwt-process-button').replaceWith( res_process.process_button );
								} ).fail(ajax_callback);
							}).fail(ajax_callback);
						}
					}
				} else {
					$current_node.find('span').html('<span class="pnwt-msg pnwt-success">Succcess</span>');
				}
			}
			
			function process_current() {
				if(current_item){
					// query our ajax handler to get the ajax to send to TGM
					// if we don't get a reply we can assume everything worked and continue onto the next one.
					$.post( paWT.ajxUrl, {
						action: 'install_plugins',
						wpnonce: paWT.wpnonce,
						slug: current_item
					}, ajax_callback).fail(ajax_callback);
				}
			}
		},
		exportCustomizer : function () {
			window.location.href = paWT.customizerURL + '?wt-cie-export=' + paWT.exportNonce;
		},
		importCustomizer : function () {
			var file		= $( 'input[name=wt-cie-import-file]' ),
				message		= $( '.cie-uploading' );
			
			if ( '' == file.val() ) {
				alert( paWT.emptyImport );
			}
			else {
				$window.off( 'beforeunload' );
				message.show();
				$( '[name="wt-cie-import-from"]' ).submit();
			}
		}
	};
	wtadmin.documentReady = {
		init: function () {
			wtadmin.initialization.init();
		}
	};
	wtadmin.documentLoad = {
		init: function () {
			w = window.innerWidth || $window.width();
		}
	};
	
	var $body = $('body'),
		$window = $(window),
		$document = $(document),
		w = window.innerWidth || $window.width(),
		maxXXS = 0,
		maxXS = 576,
		maxSM = 768,
		maxMD = 992,
		maxLG = 1200,
		maxXL = 1770,
		mobileMenuBreikpoint = 992,
		isMobile = w < mobileMenuBreikpoint;
		$document.on('ready', wtadmin.documentReady.init);
		$window.on('load', wtadmin.documentLoad.init);		

})(jQuery); 
powernodeMediaInit = wtadmin.initialization.mediaInit;