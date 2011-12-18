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
		add_action( 'admin_menu', array( &$this, 'RAF_plugin_menu' ) );
		
		//Register scripts
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'CP_colorpicker', RAF_URL . 'js/colorpicker/js/colorpicker.js', 'jquery' );
		wp_enqueue_script( 'CP_eye', RAF_URL . 'js/colorpicker/js/eye.js', 'CP_colorpicker' );
		wp_enqueue_script( 'CP_utils', RAF_URL . 'js/colorpicker/js/utils.js', 'CP_colorpicker' );
		wp_enqueue_script( 'CP_layout', RAF_URL . 'js/colorpicker/js/layout.js', 'CP_colorpicker' );
		wp_enqueue_script( 'raf_admin', RAF_URL . 'js/raf_admin.js', 'CP_colorpicker' );
		
		wp_enqueue_style( 'colorpicker', RAF_URL . 'js/colorpicker/css/colorpicker.css');
	}
	
	function RAF_plugin_menu() {
		add_options_page( __('Options for Recommend to a friend plugin', 'raf'), __('Recommend to a friend', 'raf'), 'manage_options', 'raf-options', array( &$this, 'display_RAF_options' ) );
	}
	 
	/**
	 * Call the admin option template
	 * 
	 * @echo the form 
	 * @author Benjamin Niess
	 */
	function display_RAF_options() {
	
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
		?>
		<div class="wrap" id="raf_options">
			<h2><?php _e('Recommend to a friend', 'raf'); ?></h2>
			
			<form method="post" action="">
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Open inviter login', 'raf'); ?><br /><a href="http://openinviter.com/" target="_blank"><?php _e('Get an Open Inviter Login', 'raf'); ?></a></th>
						<td><input type="text" name="raf[oi_login]" value="<?php echo isset( $fields['oi_login'] ) ? esc_attr( $fields['oi_login'] ) : '' ; ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Open inviter private key', 'raf'); ?></th>
						<td><input type="text" name="raf[oi_private_key]" value="<?php echo isset( $fields['oi_private_key'] ) ? esc_attr( $fields['oi_private_key'] ) : ''; ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Email shipper ( ex: contact@mysite.com)', 'raf'); ?></th>
						<td><input type="text" name="raf[email_shipper]" value="<?php echo isset(  $fields['email_shipper'] ) && is_email( $fields['email_shipper'] ) ? esc_attr( $fields['email_shipper'] ) : ''; ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Enabled features', 'raf'); ?></th>
						<td>
							<input type="checkbox" name="raf[manual]" value="1" <?php checked( isset( $fields['manual'] ) ? (int) $fields['manual'] : '' , 1 ); ?> /> <?php _e('Insert emails mannualy', 'raf'); ?><br />
							<input type="checkbox" name="raf[social]" value="1" <?php checked( isset( $fields['social'] ) ? (int) $fields['social'] : '' , 1 ); ?> /> <?php _e('Share on social networks', 'raf'); ?><br />
							<input type="checkbox" name="raf[openinviter]" value="1" <?php checked( isset( $fields['openinviter'] ) ? (int) $fields['openinviter'] : '' , 1 ); ?> /> <?php _e('Use email providers', 'raf'); ?><br />
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Auto add RAF button after the_content', 'raf'); ?></th>
						<td><input type="checkbox" name="raf[auto_add]" value="1" <?php checked( isset( $fields['auto_add'] ) ? (int) $fields['auto_add'] : '' , 1 ); ?> /> <?php _e('Check to auto add RAF after the_content', 'raf'); ?></td>
					</tr> 
					<tr valign="top">
						<th scope="row"><?php _e('Background color', 'raf'); ?></th>
						<td>#<input type="text" class="colorp" name="raf[bg_color]" value="<?php echo isset(  $fields['bg_color'] ) ? esc_attr( $fields['bg_color'] ) : ''; ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Titles color', 'raf'); ?></th>
						<td>#<input type="text" class="colorp" name="raf[titles_color]" value="<?php echo isset(  $fields['titles_color'] ) ? esc_attr( $fields['titles_color'] ) : ''; ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Buttons background color', 'raf'); ?></th>
						<td>#<input type="text" class="colorp" name="raf[button_bg_color]" value="<?php echo isset(  $fields['button_bg_color'] ) ? esc_attr( $fields['button_bg_color'] ) : ''; ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Buttons background color hover', 'raf'); ?></th>
						<td>#<input type="text" class="colorp" name="raf[button_bg_color_hover]" value="<?php echo isset(  $fields['button_bg_color_hover'] ) ? esc_attr( $fields['button_bg_color_hover'] ) : ''; ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Buttons text color', 'raf'); ?></th>
						<td>#<input type="text" class="colorp" name="raf[button_text_color]" value="<?php echo isset(  $fields['button_text_color'] ) ? esc_attr( $fields['button_text_color'] ) : ''; ?>" /></td>
					</tr>
					
				</table>
				
				<p class="submit">
					<?php wp_nonce_field( 'raf-update-options' ); ?>
					<input type="submit" name="save" class="button-primary" value="<?php _e('Save Changes', 'raf') ?>" />
				</p>
			</form>
		</div>
		<?php
	}
	
}	
?>