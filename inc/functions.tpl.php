<?php
/**
 * Generate a Recommend a Friend link. Can be customized with an image url or a text
 * 
 * @param string $permalink
 * @param string $image_url
 * @param string $text_link
 * @return string the link 
 * @author Benjamin Niess
 */
function recommend_a_friend_link( $permalink ='', $image_url = '', $text_link = '' ){
	if ( empty( $permalink ) ) {
		$permalink = get_permalink();
		$permalink = ( !empty( $permalink ) ? $permalink : home_url() );
	}
	if ( !empty( $text_link ) ){
		$link_content = $text_link;
	}
	elseif ( !empty( $image_url ) ) {
		$link_content = '<img src="' . $image_url . '" alt=" ' . __('Recommend a friend', 'raf') . '" />';
	}
	else {
		$link_content = '<img src="' . RAF_URL . 'images/addtoany-bg-btn.jpg" alt="Recommend a friend" />';

	}
	ob_start();
	 ?>
	<div class="raf_share_buttons"><a href="<?php echo RAF_URL; ?>inc/raf_form.php?current_url=<?php echo $permalink; ?>" title="<?php _e('Recommend a friend', 'raf'); ?>" class="iframe raf_link"><?php echo $link_content; ?></a></div>
	
	<?php 
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
	
}
?>