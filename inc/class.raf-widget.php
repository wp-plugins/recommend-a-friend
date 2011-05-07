<?php
/**
 * Recommend A Friend widget class
 *
 */
class RAF_Widget extends WP_Widget {

	function RAF_Widget() {
		$widget_ops = array( 'classname' => 'raf_widget raf_link', 'description' => __( 'Add a recommend a friend widget' , 'raf') );
		$this->WP_Widget('recommend_a_friend', 'Recommend A Friend', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? 'Recommend a friend'	 : $instance['title'], $instance, $this->id_base);
		$display_type = empty( $instance['display_type'] ) ? 1 : $instance['display_type'];
		$link_text = empty( $instance['link_text'] ) ? __( 'Share this page' , 'raf') : $instance['link_text'];
		$image_url = empty( $instance['image_url'] ) ? '' : $instance['image_url'];
		echo $before_widget;?>
		<h3 class="widget-title">
			<?php if ( $title ) echo $title; ?>
		</h3>
		<?php 
		//custom image view
		if ( $display_type == 2 ){
			echo recommend_a_friend_link( '', $image_url );
		}
		//text view
		elseif ( $display_type == 3 ){
			echo "<p>" . recommend_a_friend_link( '', '', $link_text ) . "</p>";
		}
		//default view
		else {
			echo recommend_a_friend_link( '', RAF_URL . 'images/share-widget-bg.png' );
		}
			
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['display_type'] = strip_tags( $new_instance['display_type'] );
		$instance['image_url'] = strip_tags( $new_instance['image_url'] );
		$instance['link_text'] = strip_tags( $new_instance['link_text'] );

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'display_type' => 1, 'link_text' => '', 'image_url' => '' ) );
		$title = esc_attr( $instance['title'] ); 
		$display_type = ( isset( $instance['display_type'] ) && !empty( $instance['display_type'] ) ) ? esc_attr( $instance['display_type'] ) : 1 ;
		$image_url = ( isset( $instance['image_url'] ) && !empty( $instance['image_url'] ) ) ? esc_attr( $instance['image_url'] ) : '' ;
		$link_text = ( isset( $instance['link_text'] ) && !empty( $instance['link_text'] ) ) ? esc_attr( $instance['link_text'] ) : '' ;
		?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title' , 'raf'); ?></label>
		
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		
		<label><?php _e( 'Display type' , 'raf'); ?></label><br />
		<input type="radio" name="<?php echo $this->get_field_name('display_type'); ?>" value="1" class="display_default" <?php checked( $display_type, 1 ); ?> /> <label><?php _e( 'Default' , 'raf'); ?></label><br />
		<input type="radio" name="<?php echo $this->get_field_name('display_type'); ?>" value="2" class="display_img" <?php checked( $display_type, 2 ); ?> /> <label><?php _e( 'Custom image' , 'raf'); ?></label><br />
		<input type="radio" name="<?php echo $this->get_field_name('display_type'); ?>" value="3" class="display_text" <?php checked( $display_type, 3 ); ?> /> <label><?php _e( 'Custom text' , 'raf'); ?></label><br />
		</p>
		
		<p class="img_input">
			<input type="text" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo $image_url; ?>" /> <label><?php _e( 'Image URL' , 'raf'); ?></label>
		</p>
		
		<p class="txt_input">
			<input type="text" name="<?php echo $this->get_field_name('link_text'); ?>" value="<?php echo $link_text; ?>" /> <label><?php _e( 'Link text' , 'raf'); ?></label>
		</p>

<?php
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("RAF_Widget");') );
?>