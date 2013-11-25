<?php 
function RAF_Install(){
	
	//enable default features on plugin activation
	$raf_options = get_option ( 'raf_options' );
	if ( !empty( $raf_options ) ) {
		return false;
	}
	
	update_option( 'raf_options', array( 'manual' => 1, 'social' => 1, 'openinviter' => 1 ) );
}