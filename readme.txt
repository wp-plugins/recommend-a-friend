=== Recommend to a friend ===
Contributors: Cocola, benjaminniess, momo360modena, Rahe
Donate link: http://beapi.fr/donate
Tags: share, facebook, openinviter, gmail, hotmail, email, recommend, widget
Requires at least: 3.1
Tested up to: 4.0
Stable tag: 2.0.3

== Description ==

Plugin that add a share to friends jQuery Lightbox to your pages or posts. Users will be able to share your content using 3 ways :

1. Writing email addresses manually
2. Using Facebook and Twitter sharing feature
3. Using Open Inviter to get back contacts from your email providers.


== Installation ==

1. Upload and activate the plugin
2. Go to the Recommend a friend option page

- Complete your Open Inviter login if you want to use the feature (http://openinviter.com/)
- Choose the feature you want to enable
- You can autoadd the button after your posts content by checking the box
 
3. Add the Recommend a Friend widget or use the php function  
`<?php echo recommend_a_friend_link( $permalink, $image_url, $text_link ); ?>`

- $premalink is the URL you want to be shared
- $image_url (facultative) the image url used instead of the default one
- $text_link(facultative) the text you want to display instead the image (you need to choose between display an image or a text)


== Screenshots ==

1. Front office view
2. Backoffice view

== Changelog ==

* 2.0.3
	* Add german translation thanks to Sebastian Maar
	* Add portuguese (BR) translation thanks to Alexandre Ruoso
	* Allow to load a custom CSS stylesheet in theme thanks to Emmanuel Hesry 
	* Use the official wp color picker thanks to me :)
* 2.0.2
	* Add nofollow tag to the form
* 2.0.1 
	* Encode URL to the RAF link
* 2.0
	* Code refactoring
	* Fix bug with homepage link
* 1.0.6
	* Secutiry update thanks to http://secu.boiteaweb.fr/
	* Change plugin name Recommend a friend > Recommend to a friend
	
* 1.0.4
	* Cleanup CSS
	* Add new widget image	
	
* 1.0.3
	* Remove font-face
	* Use wp_redirect after sending mail
	
* 1.0.1 
	* Change readme file
	
* 1.0
	* First release