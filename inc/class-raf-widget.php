<?php
/**
 * Recommend To A Friend widget class
 *
 */
class RAF_Widget extends WP_Widget {

	function RAF_Widget() {
		$widget_ops = array( 'classname' => 'raf_widget raf_link', 'description' => __( 'Add a recommend to a friend widget' , 'raf') );
		$this->WP_Widget('recommend_a_friend', 'Recommend to a Friend', $widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? 'Recommend to a friend'	 : $instance['title'], $instance, $this->id_base);
		$display_type = empty( $instance['display_type'] ) ? 1 : $instance['display_type'];
		$link_text = empty( $instance['link_text'] ) ? __( 'Share this page' , 'raf') : $instance['link_text'];
		$image_url = empty( $instance['image_url'] ) ? '' : $instance['image_url'];
		echo $before_widget;
		
		$tpl = RAF_Client::get_template( 'widget' );
		if ( empty( $tpl ) ) {
			return false;
		}
		
		include( $tpl );
		
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
		
		$tpl = RAF_Client::get_template( 'admin/widget-form' );
		if ( empty( $tpl ) ) {
			return false;
		}
		
		include( $tpl );
		
		return true;
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("RAF_Widget");') );