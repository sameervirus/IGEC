( function( $ ) {
	
	var body 	= 	$( 'body' );
	wp.customize('powernode_body_typography[font-family]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var idfirst = ( contVal.trim().toLowerCase().replace( " ", "-" ), "customizer-typography-body-font-family" );
				var fontSize = contVal.replace( " ", "%20" );
				fontSize = fontSize.replace( ",", "%2C" );
				fontSize = powernodewt.googleFontsUrl + "/css?family=" + contVal + ":" + powernodewt.googleFontsWeight;
				if ( $( "#" + idfirst ).length ) {
					$( "#" + idfirst ).attr( "href", fontSize );
				} else {
					$('head').append( '<link id="' + idfirst + '" rel="stylesheet" type="text/css" href="' + fontSize + '">' );
				}
				
				var custStyle = 'body{font-family: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_body_typography-font-family', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_body_typography[font-weight]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{font-weight: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_body_typography-font-weight', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_body_typography[font-style]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{font-style: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_body_typography-font-style', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_body_typography[text-transform]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{text-transform: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_body_typography-text-transform', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_body_typography[font-size]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{font-size: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_body_typography-font-size', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_body_typography[line-height]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'body{line-height: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_body_typography-line-height', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_body_typography[color]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'html, body{color: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_body_typography-color', custStyle);
			}
		} );
	} ),wp.customize('powernode_headings_typography[font-family]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var idfirst = ( contVal.trim().toLowerCase().replace( " ", "-" ), "customizer-typography-headings-font-family" );
				var fontSize = contVal.replace( " ", "%20" );
				fontSize = fontSize.replace( ",", "%2C" );
				fontSize = powernodewt.googleFontsUrl + "/css?family=" + contVal + ":" + powernodewt.googleFontsWeight;
				if ( $( "#" + idfirst ).length ) {
					$( "#" + idfirst ).attr( "href", fontSize );
				} else {
					$('head').append( '<link id="' + idfirst + '" rel="stylesheet" type="text/css" href="' + fontSize + '">' );
				}
				
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.powernodewt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-family: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_headings_typography-font-family', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_headings_typography[font-weight]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.powernodewt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-weight: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_headings_typography-font-weight', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_headings_typography[font-style]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.powernodewt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-style: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_headings_typography-font-style', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_headings_typography[text-transform]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.powernodewt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{text-transform: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_headings_typography-text-transform', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_headings_typography[font-size]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.powernodewt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{font-size: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_headings_typography-font-size', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_headings_typography[line-height]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.powernodewt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{line-height: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_headings_typography-line-height', custStyle);
			}
		} );
	} ), wp.customize( 'powernode_headings_typography[color]', function( control ) {
		control.bind( function( contVal ) {
			if ( contVal ) {
				var custStyle = 'h1,h2,h3,h4,h5,h6,.theme-heading,.widget-title,.powernodewt-widget-recent-posts-title,.comment-reply-title,.entry-title,.sidebar-box .widget-title{color: ' + contVal + ';}';
				powernodewt_add_customize_css('powernode_headings_typography-color', custStyle);
			}
		} );
	} )
   
} )( jQuery );
