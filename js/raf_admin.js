jQuery(document).ready(function() {
	
	jQuery('.colorp').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			jQuery(el).val(hex);
			jQuery(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			jQuery(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		jQuery(this).ColorPickerSetColor(this.value);
	});
	
	/*
	TODO
	
	jQuery('.display_default').click(function() {
		jQuery(this).parent().find( '.img_input' ).hide('fast');
		jQuery(this).parent().find( '.txt_input' ).hide('fast');
		 
	});
	
	jQuery('.display_img').click(function() {
		jQuery(this).parent().find( '.img_input' ).show('fast');
		jQuery(this).parent().find( '.txt_input' ).hide('fast');
		 
	});
	
	jQuery('.display_text').click(function() {
		jQuery(this).parent().find( '.img_input' ).hide('fast');
		jQuery(this).parent().find( '.txt_input' ).show('fast');
		 
	});
	*/
	
});	