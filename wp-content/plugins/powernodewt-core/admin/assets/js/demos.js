var pnwtdemos = pnwtdemos || {};
(function ($) {
	pnwtdemos.initialization = {
		importData: {},
		init: function () {
			var that = this;
			$('.demo-items .demo-item').click( function (e) {
				e.preventDefault();
				var cur_wrap = $(this),
					demo_name = cur_wrap.data('demo-id');
					cur_wrap.addClass('pnwt-loader');
					that.getDemoData( cur_wrap, demo_name );
			});
			
			$( document ).on( 'click' 						, '.install-now', this.installNow );
			$( document ).on( 'click' 						, '.activate-now', this.activatePlugins );
			$( document ).on( 'wp-plugin-install-success'	, this.installSuccess );
			$( document ).on( 'wp-plugin-installing' 		, this.pluginInstalling );
			$( document ).on( 'wp-plugin-install-error'		, this.installError );
			
		},
		getDemoData : function ( cur_wrap, demo_name ) {
			var that = this;
			$.ajax({
				url: pnWTDemos.ajaxUrl,
				data: {
					'action' : 'powernodewt_get_import_data',
					'demo_name'	: demo_name,
					'data_nonce' : pnWTDemos.pnwt_import_data_nonce,
				},
				method: 'post',
				complete: function ( data ) {
					cur_wrap.removeClass('pnwt-loader');
					that.importData = $.parseJSON( data.responseText );
				},
				error: function () {
					alert('Something went wrong, please try again latter.');
				}
			});
			$.ajax({
				url: pnWTDemos.ajaxUrl,
				data: {
					'action' : 'powernodewt_get_demo_data',
					'demo_name'	: demo_name,
					'data_nonce' : pnWTDemos.pnwt_demo_data_nonce,
				},
				method: 'post',
				complete: function ( data ) {
					cur_wrap.removeClass('pnwt-loader');
					that.popup( data );
				},
				error: function () {
					alert('Something went wrong, please try again latter.');
				}
			});
			
		},
		popup : function ( data ) {
			var that = this;
			if ( data.responseText ) {
				var popup_content = $( '#pnwt-demo-popup-content' );
				popup_content.html( data.responseText );
				$.magnificPopup.open({
					items: {
						src: '.pnwt-demo-popup-wrap',
					},
					enableEscapeKey: !0,
					callbacks: {
						beforeOpen: function() {
							this.st.mainClass = "pnwt-demo-popup"
						},
						close: function() {
							popup_content.html('');
						}
					}
				});
			  
				$('body').on( 'click', '.pnwt-plugins-next', function(e){
					  e.preventDefault();
					  $('#pnwt-demo-plugins').hide();
					  $('#pnwt-demo-import').show();
				});
			  
				$('.import-item-checkbox').change(function(){
					if ( $('.import-item-checkbox:checked').length > 0 ) {
					   $('.pnwt-import').prop( "disabled", false );
					} else {
						$('.pnwt-import').prop( "disabled", true );
					}
				});
				
				$('#pnwt-demo-import-form').submit( function( e ) {
					e.preventDefault();
					
					var $this = $( this ),
						demo = $this.find( '[name="pnwt_import_demo"]' ).val(),
						nonce = $this.find( '[name="pnwt_import_demo_data_nonce"]' ).val(),
						contentToImport = [];
						
					$this.find( 'input[type="checkbox"]' ).each( function() {
						if ( $( this ).is( ':checked' ) === true ) {
							contentToImport.push( $( this ).attr( 'name' ) );
						}
					} );
					
					$('#pnwt-demo-import').hide();
					$('#pnwt-demo-import-process').show();
					
					that.importContent( {
						demo: demo,
						nonce: nonce,
						contentToImport: contentToImport,
						isContents: $( '#pnwt_import_contents' ).is( ':checked' )
					} );
				});
			}
		},
		importContent: function( importData ) {
			var that = this,
			currentContent,
			importingLimit,
			timerStart = Date.now(),
			ajaxData = {
				pnwt_import_demo: importData.demo,
				pnwt_import_demo_data_nonce: importData.nonce
			};
			
			// When all the selected content has been imported
			if ( importData.contentToImport.length === 0 ) {
				
				// Show the imported screen after 1 second
				setTimeout( function() {
					$( '#pnwt-demo-import-success' ).show();
				}, 1000 );

				// Notify the server that the importing process is complete
				$.ajax( {
					url: pnWTDemos.ajaxUrl,
					type: 'post',
					data: {
						action: 'pnwt_after_import',
						pnwt_import_demo: importData.demo,
						pnwt_import_demo_data_nonce: importData.nonce,
						pnwt_import_is_contents: importData.isContents
					},
					complete: function( data ) {}
				} );

				this.allowPopupClosing = true;
				$( '.mfp-close' ).fadeIn();

				return;
			}
			
			for ( var key in this.importData ) {

				var contentIndex = $.inArray( this.importData[ key ][ 'id' ], importData.contentToImport );
				if ( contentIndex !== -1 ) {
					currentContent = key;
					importData.contentToImport.splice( contentIndex, 1 );
					ajaxData.action = this.importData[ key ]['action'];
					break;
				}
			}
			
			$( '.pnwt-import-status' ).append( '<p class="pnwt-importing">' + this.importData[ currentContent ]['loader'] + '</p>' );
			
			var ajaxRequest = $.ajax( {
				url: pnWTDemos.ajaxUrl,
				data: ajaxData,
				method: 'post',
				complete: function( data ) {

					var continueProcess = true;
					if ( data.status === 500 || data.status === 502 || data.status === 503 ) {
						$( '.pnwt-importing' )
							.addClass( 'pnwt-importing-failed' )
							.removeClass( 'pnwt-importing' )
							.text( pnWTDemos.content_importing_error + ' '+ data.status );
					} else if ( data.responseText.indexOf( 'successful import' ) !== -1 ) {
						$( '.pnwt-importing' ).addClass( 'pnwt-imported' ).removeClass( 'pnwt-importing' );
					} else {
						var errors = $.parseJSON( data.responseText ),
							errorMessage = '';

						// Iterate through the list of errors
						for ( var error in errors ) {
							errorMessage += errors[ error ];

							// If there was an error with the importing of the XML file, stop the process
							if ( error === 'pnwt_import_error' ) {
								continueProcess = false;
							}
						}

						// Display the error message
						$( '.pnwt-importing' )
							.addClass( 'pnwt-importing-failed' )
							.removeClass( 'pnwt-importing' )
							.text( errorMessage );

						that.allowPopupClosing = true;
						$( '.mfp-close' ).fadeIn();
					}

					if ( continueProcess === true ) {
						that.importContent( importData );
					}

				}
			} );
			
			// Set a time limit of 15 minutes for the importing process.
			importingLimit = setTimeout( function() {

				// Abort the AJAX request
				ajaxRequest.abort();

				// Allow the popup to be closed
				that.allowPopupClosing = true;
				$( '.mfp-close' ).fadeIn();

				$( '.pnwt-importing' )
					.addClass( 'pnwt-importing-failed' )
					.removeClass( 'pnwt-importing' )
					.text( pnWTDemos.content_importing_error );
			}, 15 * 60 * 1000 );

		},
		installNow: function( e ) {
			e.preventDefault();

			// Vars
			var $button 	= $( e.target ),
				$document   = $( document );

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( e );

				$document.on( 'credential-modal-cancel', function() {
					var $message = $( '.install-now.updating-message' );

					$message
						.removeClass( 'updating-message' )
						.text( wp.updates.l10n.installNow );

					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' );
				} );
			}

			wp.updates.installPlugin( {
				slug: $button.data( 'slug' )
			} );
		},
		activatePlugins: function( e ) {
			e.preventDefault();

			// Vars
			var $button = $( e.target ),
				$init 	= $button.data( 'init' ),
				$slug 	= $button.data( 'slug' );

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return;
			}

			$button.addClass( 'updating-message button-primary' ).html( pnWTDemos.button_activating );

			$.ajax( {
				url: pnWTDemos.ajaxUrl,
				type: 'POST',
				data: {
					action : 'pnwt_ajax_required_plugins_activate',
					init   : $init,
				},
			} ).done( function( result ) {

				if ( result.success ) {

					$button.removeClass( 'button-primary install-now activate-now updating-message' )
						.attr( 'disabled', 'disabled' )
						.addClass( 'disabled' )
						.text( pnWTDemos.button_active );

				}

			} );
		},
		installSuccess: function( e, response ) {
			e.preventDefault();

			var $message = $( '.pnwt-plugin-' + response.slug ).find( '.button' );

			// Transform the 'Install' button into an 'Activate' button.
			var $init = $message.data('init');

			$message.removeClass( 'install-now installed button-disabled updated-message' )
				.addClass( 'updating-message' )
				.html( pnWTDemos.button_activating );

			// WordPress adds "Activate" button after waiting for 1000ms. So we will run our activation after that.
			setTimeout( function() {

				$.ajax( {
					url: pnWTDemos.ajaxUrl,
					type: 'POST',
					data: {
						action : 'pnwt_ajax_required_plugins_activate',
						init   : $init,
					},
				} ).done( function( result ) {

					if ( result.success ) {

						$message.removeClass( 'button-primary install-now activate-now updating-message' )
							.attr( 'disabled', 'disabled' )
							.addClass( 'disabled' )
							.text( pnWTDemos.button_active );

					} else {
						$message.removeClass( 'updating-message' );
					}

				} );

			}, 1200 );
		},
		pluginInstalling: function( e, args ) {
			e.preventDefault();

			var $card = $( '.pnwt-plugin-' + args.slug ),
				$button = $card.find( '.button' );

			$button.addClass( 'updating-message' );
		},
		installError: function( e, response ) {
			e.preventDefault();

			var $card = $( '.pnwt-plugin-' + response.slug );

			$card.removeClass( 'button-primary' ).addClass( 'disabled' ).html( wp.updates.l10n.installFailedShort );
		}
		
	};
	pnwtdemos.documentReady = {
		init: function () {
			pnwtdemos.initialization.init();
		}
	};
	pnwtdemos.documentLoad = {
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
		$document.on('ready', pnwtdemos.documentReady.init);
		$window.on('load', pnwtdemos.documentLoad.init);
		//$window.on('resize', pnwtdemos.documentResize.init);
			
})(jQuery);