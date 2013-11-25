<?php
class RAF_Client {

	/**
	 * Constructor
	 *
	 * @return void
	 * @author Benjamin Niess
	 */
	function RAF_Client() {
		if ( is_admin() ) {
			return false;
		}
		
		add_action( 'init', array( __CLASS__, 'init_styles_scripts' ) );
		add_filter( 'the_content', array( __CLASS__, 'auto_add_button' ) );
		add_shortcode( 'raf_link', array( __CLASS__, 'shortcode_recommend_a_friend_link' ) );
	}
	
	/**
	 * Enqueue all scripts and styles
	 * 
	 * @author Benjamin Niess
	 */
	public static function init_styles_scripts() {
		//Register scripts
		wp_enqueue_script( 'jquery');
		wp_enqueue_script( 'fancy_box', RAF_URL . 'js/fancybox/jquery.fancybox-1.3.4.pack.js', array( 'jquery' ), '1.3' );
		wp_enqueue_script( 'raf_script', RAF_URL . 'js/raf_script.js', array( 'jquery', 'fancy_box' ), '1.0' );
		
		//Register styes
		wp_enqueue_style( 'fancy_box_css', RAF_URL . 'js/fancybox/jquery.fancybox-1.3.4.css', '', '1.3.4' );
		wp_enqueue_style( 'raf-style', RAF_URL . 'css/style.css', '', '1.0' );
	}
	
	/**
	 * Add RAF button after the_content if the option is enabled.
	 * 
	 * @param string $the_content
	 * @return string the link 
	 * @author Benjamin Niess
	 */
	public static function auto_add_button( $the_content ){
		$raf_options = get_option ( 'raf_options' );
		
		if ( !isset( $raf_options['auto_add'] ) || $raf_options['auto_add'] != 1 ) {
			return $the_content;
		}
		
		return $the_content . recommend_a_friend_link();
	}
	
	/**
	 * The function for the RAF shortcode.
	 * 
	 * @param array $atts
	 * @author Benjamin Niess
	 */
	public static function shortcode_recommend_a_friend_link( $atts = array() ) {
		extract( shortcode_atts( array(
			'permalink' => '',
			'image' => '',
			'text' => ''
		), $atts ) );
		
		return recommend_a_friend_link( $permalink, $image, $text );
	}

	/**
	 * Get template file depending on theme
	 * 
	 * @param (string) $tpl : the template name
	 * @return (string) the file path | false
	 * 
	 * @author Benjamin Niess
	 */
	public static function get_template( $tpl = '' ) {
		if ( empty( $tpl ) ) {
			return false;
		}
		
		if ( is_file( STYLESHEETPATH . '/views/raf/' . $tpl . '.tpl.php' ) ) {// Use custom template from child theme
			return ( STYLESHEETPATH . '/views/raf/' . $tpl . '.tpl.php' );
		} elseif ( is_file( TEMPLATEPATH . '/raf/' . $tpl . '.tpl.php' ) ) {// Use custom template from parent theme
			return (TEMPLATEPATH . '/views/raf/' . $tpl . '.tpl.php' );
		} elseif ( is_file( RAF_DIR . 'views/' . $tpl . '.tpl.php' ) ) {// Use builtin template
			return ( RAF_DIR . 'views/' . $tpl . '.tpl.php' );
		}
		
		return false;
	}	
}