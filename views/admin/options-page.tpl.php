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
				<td><input type="text" class="colorp" name="raf[bg_color]" value="<?php echo isset(  $fields['bg_color'] ) ? esc_attr( $fields['bg_color'] ) : ''; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Titles color', 'raf'); ?></th>
				<td><input type="text" class="colorp" name="raf[titles_color]" value="<?php echo isset(  $fields['titles_color'] ) ? esc_attr( $fields['titles_color'] ) : ''; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Buttons background color', 'raf'); ?></th>
				<td><input type="text" class="colorp" name="raf[button_bg_color]" value="<?php echo isset(  $fields['button_bg_color'] ) ? esc_attr( $fields['button_bg_color'] ) : ''; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Buttons background color hover', 'raf'); ?></th>
				<td><input type="text" class="colorp" name="raf[button_bg_color_hover]" value="<?php echo isset(  $fields['button_bg_color_hover'] ) ? esc_attr( $fields['button_bg_color_hover'] ) : ''; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Buttons text color', 'raf'); ?></th>
				<td><input type="text" class="colorp" name="raf[button_text_color]" value="<?php echo isset(  $fields['button_text_color'] ) ? esc_attr( $fields['button_text_color'] ) : ''; ?>" /></td>
			</tr>
			
		</table>
		
		<p class="submit">
			<?php wp_nonce_field( 'raf-update-options' ); ?>
			<input type="submit" name="save" class="button-primary" value="<?php _e('Save Changes', 'raf') ?>" />
		</p>
	</form>
</div>