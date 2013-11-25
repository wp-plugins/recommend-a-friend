<h3 class="widget-title">
	<?php if ( $title ) echo $title; ?>
</h3>
<?php 
//custom image view
if ( $display_type == 2 ) {
	echo recommend_a_friend_link( '', $image_url );
}
//text view
elseif ( $display_type == 3 ) {
	echo "<p>" . recommend_a_friend_link( '', '', $link_text ) . "</p>";
}
//default view
else {
	echo recommend_a_friend_link( '', RAF_URL . 'images/share-widget-bg.png' );
}