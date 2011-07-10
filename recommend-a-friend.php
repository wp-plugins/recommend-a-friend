<?php
/*
Plugin Name: Recommend a friend
Description: Plugin that add a share to friends jQuery Lightbox 
Version: 1.0.5
Author: benjaminniess
Author URI: http://www.benjamin-niess.fr
Text Domain: raf
Domain Path: /lang/


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA


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