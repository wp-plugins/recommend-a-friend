jQuery(document).ready(function() {
	jQuery( '#hidden_tab' ).hide();
	
	//Set the hidden field and textarea value with the visible texarea value
	jQuery('#hidden_content_field, #message_box').val( jQuery('#private_message').val() ) ;
	
	////Set the hidden field and textarea value with the visible texarea value on key up
	jQuery('#private_message').keyup(function() {
 		 jQuery('#hidden_content_field, #message_box').val( jQuery('#private_message').val() ) ;
	});
	
	jQuery( '#toggle_all' ) . click( toggleAll );
	function toggleAll() {
		var checkboxes = jQuery( "#oi_form input[type=checkbox]");
		var globalcheckbox = this.checked; 
		
		if ( globalcheckbox ) {
			checkboxes.each( function( index ){
				if ( index > 0 ) 
					this.checked = true; 
			} );
		}
		else {
			checkboxes.each( function( index ){
				if ( index > 0 )
					this.checked = false; 
			} );
		}
	}
});