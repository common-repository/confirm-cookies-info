jQuery( document ).ready( function(){
//	jQuery( "tr[class]" ).fadeOut(10);
	jQuery( "h3.title" ).click( function(){
		var cl = jQuery( this ).attr( "id" );
		if( jQuery( "."+cl ).hasClass( "aktywne" ) ) {
			jQuery( "."+cl ).fadeOut( 500 );
			jQuery( "."+cl ).removeClass( "aktywne" );
		} else {
			jQuery( "."+cl ).fadeIn( 700 );
			jQuery( "."+cl ).addClass( "aktywne" );
		}	
	});
	
	jQuery( "input[type='checkbox']" ).click(function(){
		var chid = jQuery( this ).attr( "id" );
		var checked = jQuery( this ).is( ":checked" );
		switch( chid ){
		case'cci_display':{
			if( checked ){
				jQuery( this ).siblings( "span" ).text( cci_object.string_on );
			} else {
				jQuery( this ).siblings( "span" ).text( cci_object.string_off );
			}			
			break;
		}
		}
	});
});