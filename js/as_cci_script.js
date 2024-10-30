function as_cci_show_cookieinfobox( html, opt ) {
	var is_confirmed = getCookie('cci_confirmed');
	var option = eval('(' + opt +')');
	
	if( is_confirmed==null ) {
		jQuery('body').prepend(html);	
		var contener = jQuery('#cci-infobox_contener');
		var infobox = jQuery('#cci-infobox');
		var textinfo = jQuery('#cci-textinfo');
		
		var c_args = {
			'width': option.cci_boxwidth,
			'position': 'relative',
			'top': 0
		};
		
		if( option.cci_halign == 'center' ) {
			var info_args = {
				'width': option.cci_boxwidth,
				'background-color': option.cci_boxbackground_color,
				'position': 'absolute',
				'left': '50%',
				'margin-left': -1*option.cci_boxwidth/2,
				'top': option.cci_valign == 'top' ? 0 : '100%'
			};
		} else {
			if( option.cci_halign == 'right' ) {
				var info_args = {
					'width': option.cci_boxwidth,
					'background-color': option.cci_boxbackground_color,
					'position': 'absolute',
					'right': 0,
					'top': option.cci_valign == 'top' ? 0 : '100%'
				};
			} else {
				var info_args = {
					'width': option.cci_boxwidth,
					'background-color': option.cci_boxbackground_color,
					'position': 'absolute',
					'left': 0,
					'top': option.cci_valign == 'top' ? 0 : '100%'
				};
			}
		}
		var text_args = {
			'color': option.cci_info_font_color,
			'font-size': option.cci_info_font_size + option.cci_info_font_size_type,
			'font-family': option.cci_info_font_family
		};

		contener.css( c_args );
		infobox.css( info_args );
		textinfo.css( text_args );
	}
}	
function as_cci_close_cookieinfobox( opt ) {
	jQuery("#cci-infobox").slideUp();
	setCookie('cci_confirmed', 1, opt); //cci_confirmedtime in days
}
/*
 * Below from http://www.w3schools.com/js/js_cookies.asp
 */
function getCookie(c_name) {
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1) {
		c_start = c_value.indexOf(c_name + "=");
	}
	if (c_start == -1) {
		c_value = null;
	} else {
		c_start = c_value.indexOf("=", c_start) + 1;
		var c_end = c_value.indexOf(";", c_start);
		if (c_end == -1) {
			c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
	}
	return c_value;
}

function setCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}