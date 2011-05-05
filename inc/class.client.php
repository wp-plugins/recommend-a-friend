<?php
class RAF_Client {

	/**
	 * Constructor
	 *
	 * @return void
	 * @author Benjamin Niess
	 */
	function RAF_Client() {
	
		global $raf_options;
		
		if ( !is_admin() ) {
		
			//Register scripts
			wp_enqueue_script( 'jquery');
			wp_enqueue_script( 'fancy_box', RAF_URL . 'js/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.3' );
			wp_enqueue_script( 'raf_script', RAF_URL . 'js/raf_script.js', array( 'jquery', 'fancy_box' ), '1.0' );
			
			//Register styes
			wp_enqueue_style( 'fancy_box_css', RAF_URL . 'js/fancybox/jquery.fancybox-1.3.4.css', '', '1.3.4' );
			wp_enqueue_style( 'raf-style', RAF_URL . 'css/style.css', '', '1.0' );
			
			if ( isset( $raf_options['auto_add'] ) && $raf_options['auto_add'] == 1 )
				add_filter( 'the_content', array( &$this, 'autoAddButton' ) );
			
			add_shortcode( 'raf_link', array( &$this, 'shortcode_recommend_a_friend_link' ) );
		}
	}
	
	/**
	 * Add RAF button after the_content if the option is enabled.
	 * 
	 * @param string $the_content
	 * @return string the link 
	 * @author Benjamin Niess
	 */
	function autoAddButton( $the_content ){
		
		return $the_content . recommend_a_friend_link();
	}
	
	/**
	 * The function for the RAF shortcode.
	 * 
	 * @param array $atts
	 * @author Benjamin Niess
	 */
	function shortcode_recommend_a_friend_link( $atts ) {
		extract( shortcode_atts( array(
			'permalink' => '',
			'image' => '',
			'text' => ''
		), $atts ) );

		return recommend_a_friend_link( $permalink, $image, $text );
	}
	
}
?>