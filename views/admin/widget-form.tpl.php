<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title' , 'raf'); ?></label></p>

<p><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

<p><label><?php _e( 'Display type' , 'raf'); ?></label></p>

<p>
<input type="radio" id="display_type_1" name="<?php echo $this->get_field_name('display_type'); ?>" value="1" class="display_default" <?php checked( $display_type, 1 ); ?> /> <label for="display_type_1"><?php _e( 'Default' , 'raf'); ?></label><br />
<input type="radio" id="display_type_2" name="<?php echo $this->get_field_name('display_type'); ?>" value="2" class="display_img" <?php checked( $display_type, 2 ); ?> /> <label for="display_type_2"><?php _e( 'Custom image' , 'raf'); ?></label><br />
<input type="radio" id="display_type_3" name="<?php echo $this->get_field_name('display_type'); ?>" value="3" class="display_text" <?php checked( $display_type, 3 ); ?> /> <label for="display_type_3"><?php _e( 'Custom text' , 'raf'); ?></label><br />
</p>

<p class="img_input">
	<input type="text" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo $image_url; ?>" /> <label><?php _e( 'Image URL' , 'raf'); ?></label>
</p>

<p class="txt_input">
	<input type="text" name="<?php echo $this->get_field_name('link_text'); ?>" value="<?php echo $link_text; ?>" /> <label><?php _e( 'Link text' , 'raf'); ?></label>
</p>
