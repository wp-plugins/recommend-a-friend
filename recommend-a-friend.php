<?php
/*
Plugin Name: Recommend a friend
Description: Plugin that add a share to friends jQuery Lightbox 
Version: 1.1
Author: BeAPI
Author URI: http://www.beapi.fr

Copyright 2011 - BeAPI Team (technique@beapi.fr)

*/

// Register the plugin path
define( 'RAF_URL', plugins_url('/', __FILE__) );
define( 'RAF_DIR', dirname(__FILE__) );

require( RAF_DIR . '/inc/functions.tpl.php');
require( RAF_DIR . '/inc/functions.plugin.php');
require( RAF_DIR . '/inc/class.client.php');

//admin
require( RAF_DIR . '/inc/class.admin.php' );

// Add required classes
require_once( RAF_DIR . '/inc/class.raf-widget.php' );

// Activate Recommend a friend
register_activation_hook  ( __FILE__, 'RAF_Install' );

// Init SimpleCustomFields
function RAF_Init() {
	global $raf, $raf_options;

	// Load up the localization file if we're using WordPress in a different language
	// Place it in this plugin's "lang" folder and name it "raf-[value in wp-config].mo"
	load_plugin_textdomain( 'raf', false, basename(rtrim(dirname(__FILE__), '/')) . '/lang' );
	
	$raf_options = get_option ( 'raf_options' );
	
	// Admin
	if ( is_admin() ) {
		
		$raf['admin'] = new RAF_Admin();
	}else {
		// Load client
		$raf['client'] = new RAF_Client();
	}
}
add_action( 'plugins_loaded', 'RAF_Init' );
?>