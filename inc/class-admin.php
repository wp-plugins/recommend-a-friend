<?php
class RAF_Admin {
	/**
	 * Constructor
	 *
	 * @return void
	 * @author Benjamin Niess
	 */
	function RAF_Admin() {
		// ADD the admin options page
		add_action( 'admin_menu', array(__CLASS__, 'RAF_plugin_menu' ) );
		
		add_action( 'admin_init', array( __CLASS__, 'init_styles_scripts' ) );
	}
	
	/**
	 * Register scripts
	 */
	public static function init_styles_scripts() {
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'raf_admin', RAF_URL . 'js/raf_admin.js', array( 'jquery', 'wp-color-picker' ) );
		wp_enqueue_style( 'wp-color-picker' );
	}
	
	public static function RAF_plugin_menu() {
		add_options_page( __('Options for Recommend to a friend plugin', 'raf'), __('Recommend to a friend', 'raf'), 'manage_options', 'raf-options', array(__CLASS__, 'display_RAF_options' ) );
	}
	 
	/**
	 * Call the admin option template
	 * 
	 * @echo the form 
	 * @author Benjamin Niess
	 */
	public static function display_RAF_options() {
	
		if ( isset($_POST['save']) ) {
			check_admin_referer( 'raf-update-options' );
			$new_options = array();
			
			// Update existing
			foreach( (array) $_POST['raf'] as $key => $value ) {
				$new_options[$key] = stripslashes($value);
			}
			
			update_option( 'raf_options', $new_options );
		}
		
		if (isset($_POST['save']) ) {
			echo '<div class="message updated"><p>'.__('Options updated!', 'raf').'</p></div>';
		}
		
		$fields = get_option('raf_options');
		if ( $fields == false ) {
			$fields = array();
		}
		
		$tpl = RAF_Client::get_template( 'admin/options-page' );
		if ( empty( $tpl ) ) {
			return false;
		}
		
		include( $tpl );
		return true;
	}
}	