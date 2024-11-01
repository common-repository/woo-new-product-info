( function( $ ) {
	$( document ).ready( function() {

		var settings = motpr355_woo_new_product_info_settings;

		var init = function() {
			init_activation();
			init_duration();
			init_text();
			init_background_color();
			init_color();
			init_font_weight();
			init_text_transform();
			init_list_position();
			init_product_position();
			init_preview();
		};

		var init_activation = function() {
			init_value( 'activation' );
			if ( settings[ 'activation' ] === 'deactived' ) {
				$( '#motpr355_woo_new_product_info #motpr355_woo_new_product_info_activate_arrow' ).show();
			}
		};

		var init_duration = function() {
			init_value( 'duration' );
		};

		var init_text = function() {
			init_value( 'text' );
		}

		var init_background_color = function() {
			init_value( 'background_color' );
		};

		var init_color = function() {
			init_value( 'color' );
		};

		var init_font_weight = function() {
			init_value( 'font_weight' );
		};

		var init_text_transform = function() {
			init_value( 'text_transform' );
		};

		var init_list_position = function() {
			init_value( 'list_position' );
		};

		var init_product_position = function() {
			init_value( 'product_position' );
		};

		var init_preview = function() {
			set_preview(
				settings.text,
				settings.background_color,
				settings.color,
				settings.font_weight,
				settings.text_transform
			);
		};

		var get_text = function() {
			return get_value( 'text' );
		};

		var get_background_color = function() {
			return get_value( 'background_color' );
		};

		var get_color = function() {
			return get_value( 'color' );
		};

		var get_font_weight = function() {
			return get_value( 'font_weight' );
		};

		var get_text_transform = function() {
			return get_value( 'text_transform' );
		};

		var refresh_preview = function() {
			set_preview(
				get_text(),
				get_background_color(),
				get_color(),
				get_font_weight(),
				get_text_transform()
			);
		};

		var get_value = function( id ) {
			var text_values = [ 'background_color', 'color' ];
			var radio_values = [ 'text', 'font_weight', 'text_transform' ];
			var element = '#motpr355_woo_new_product_info input[name="' + id + '"]';
			if ( radio_values.indexOf( id ) !== -1 ) {
				element += ':checked';
				return $( element ).val();
			} else if ( text_values.indexOf( id ) !== -1 ) {
				return $( element ).val();
			}
		};

		var init_value = function( id ) {
			var text_values = [ 'background_color', 'color', 'duration' ];
			var radio_values = [ 'activation', 'text', 'font_weight', 'text_transform', 'list_position', 'product_position' ];
			var element = '#motpr355_woo_new_product_info [name="' + id + '"]';
			if ( radio_values.indexOf( id ) !== -1 ) {
				element += '[value="' + settings[ id ] + '"]';
				$( element ).prop( 'checked', true );
			} else if ( text_values.indexOf( id ) !== -1 ) {
				$( element ).val( settings[ id ] );
			}
		};

		var set_preview = function( text, background_color, color, font_weight, text_transform ) {
			var new1 = '#motpr355_woo_new_product_info #motpr355_woo_new_product_info_classic_new1';
			var new2 = '#motpr355_woo_new_product_info #motpr355_woo_new_product_info_classic_new2';
			var show = '';
			var hide = '';
			if (text === 'New') {
				show = new1;
				hide = new2;
			} else {
				show = new2;
				hide = new1;
			}
			$( show ).show();
			$( hide ).hide();
			if ( check_color_format( background_color ) && check_color_format( color ) ) {
				var element = '#motpr355_woo_new_product_info .motpr355_woo_new_product_info_classic';
				$( element ).css( {
					backgroundColor: background_color,
					color: color,
					fontWeight: font_weight,
					textTransform: text_transform
				} );
			}
		};

		var check_color_format = function( color ) {
			if ( ( color.length !== 4 && color.length !== 7 ) || color.substring( 0, 1 ) !== '#' ) {
				return false;
			}
			var check1 = ( parseInt( color.substring( 1 ), 16 ).toString( 16 ) ).padStart( color.length - 1, '0' );
			var check2 = color.substring( 1 );
			return check1 === check2;
		};

		init();

		$( '#motpr355_woo_new_product_info .input_color' ).wpColorPicker( {
			change: function () {
				setTimeout( function() {
					refresh_preview();
				} );
			}
		} );

		$( document ).on( 'click', '#motpr355_woo_new_product_info #motpr355_woo_new_product_info_submit', function() {
			$( '#motpr355_woo_new_product_info form' ).submit();
		} );

		$( document ).on( 'change', '#motpr355_woo_new_product_info input', function() {
			refresh_preview();
		} );

	} );
} ) ( jQuery );