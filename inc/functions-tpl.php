<?php
/**
 * Generate a Recommend to a Friend link. Can be customized with an image url or a text
 * 
 * @param string $permalink
 * @param string $image_url
 * @param string $text_link
 * @return string the link 
 * @author Benjamin Niess
 */
function recommend_a_friend_link( $permalink ='', $image_url = '', $text_link = '' ){
	if ( empty( $permalink ) ) {
		$permalink = is_front_page() ? home_url() : get_permalink();
	}
	if ( !empty( $text_link ) ) {
		$link_content = $text_link;
	}
	elseif ( !empty( $image_url ) ) {
		$link_content = '<img src="' . $image_url . '" alt="' . __('Recommend to a friend', 'raf') . '" />';
	}
	else {
		$link_content = '<img src="' . RAF_URL . 'images/addtoany-bg-btn.jpg" alt="Recommend to a friend" />';
	}
	
	$tpl = RAF_Client::get_template( 'raf-link' );
	if ( empty( $tpl ) ) {
		return false;
	}
	
	ob_start();
	
	include( $tpl );
	
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
}