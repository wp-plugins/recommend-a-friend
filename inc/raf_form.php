<?php
//load WordPress environment 
require_once( dirname(__FILE__) . '../../../../../wp-load.php' );


//init $error_message
$error_message = array();

global $oi_login, $oi_private_key, $email_shipper, $manual_feature, $social_feature, $open_inviter_feature;

$raf_options = get_option ( 'raf_options' );

$oi_login = ( !empty( $raf_options['oi_login'] ) ) ? $raf_options['oi_login'] : '';
$oi_private_key = ( !empty( $raf_options['oi_private_key'] ) ) ? $raf_options['oi_private_key'] : '';

//enabled features
$manual_feature = ( isset( $raf_options['manual'] ) && $raf_options['manual'] == 1 ) ? true : false;
$social_feature = ( isset( $raf_options['social'] ) && $raf_options['social'] == 1 ) ? true : false;
$open_inviter_feature = ( isset( $raf_options['openinviter'] ) && $raf_options['openinviter'] == 1 ) ? true : false;


//Get the emailshipper from admin option
$email_shipper = ( !empty( $raf_options['email_shipper'] ) ) ? $raf_options['email_shipper'] : 'contact@yoursite.com';

$bg_color = ( !empty( $raf_options['bg_color'] ) ) ? $raf_options['bg_color'] : 'ffffff';
$bg_color_hover = ( !empty( $raf_options['button_bg_color_hover'] ) ) ? $raf_options['button_bg_color_hover'] : '85acca';
$button_color = ( !empty( $raf_options['button_bg_color'] ) ) ? $raf_options['button_bg_color'] : '6194bb';
$border_color = ( !empty( $raf_options['border_color'] ) ) ? $raf_options['border_color'] : 'ECECE6';
$legend_color = ( !empty( $raf_options['titles_color'] ) ) ? $raf_options['titles_color'] : '6194BB';
$button_text_color = ( !empty( $raf_options['button_text_color'] ) ) ? $raf_options['button_text_color'] : 'FFFFFF';


//Set $openinviter_settings (login, key and mail content) 
$openinviter_settings = array(
	'username'=> $oi_login, 
	'private_key'=> $oi_private_key, 
	'cookie_path'=>"/tmp", 
	'message_body'=> __( 'You are invited on ', 'raf' ) . ' http://' . $_SERVER['HTTP_HOST'], 
	'message_subject'=> __( ' would like to invite you on ', 'raf' ) . ' http://' . $_SERVER['HTTP_HOST'], 
	'transport'=>"curl", 
	'local_debug'=>"on_error", 
	'remote_debug'=>"", 
	'hosted'=>"", 
	'proxies'=>array(),
	'stats'=>"", 
	'plugins_cache_time'=>"1800", 
	'plugins_cache_file'=>"oi_plugins.php", 
	'update_files'=>"1", 
	'stats_user'=>"", 
	'stats_password'=>"" );

require_once( RAF_DIR  .'/openinviter/openinviter.php'); 

//get the current url (in $_GET)
$current_url = ( isset( $_GET['current_url'] ) && !empty( $_GET['current_url'] ) ) ? $_GET['current_url'] : '';

//check if the success message is set
$success_message = ( isset( $_GET['success_message'] ) && !empty( $_GET['success_message'] ) ) ? true : false;

if ( isset( $_POST['raf_manual_invit'] ) && !empty( $_POST['raf_manual_invit'] ) && $_POST['raf_manual_invit'] == '1' ) {
	$email_addresses = str_replace( ";", ",", trim( $_POST['raf_email_addresses'] ) ) ;
	
	//delete escape char
	$clean_email_addresses = str_replace( ' ', '', $email_addresses );
	
	//Explode email field in an array
	$email_addresses = explode( ",", $clean_email_addresses );
	
	$secure_content = stripslashes( esc_textarea( $_POST['private_message'] ) );
	$secure_name_from = stripslashes( $_POST['raf_name_from'] );
	
	//Set the $error_message value if one of the emails is not correct
	foreach ( $email_addresses as $email ) {
		if ( !is_email( $email ) ) {
			$error_message['email'] = __( 'You need to enter valid email addresses', 'raf' );
		}
	}
	
	
	//Set $email_default_value to display it into the form
	$email_default_value = ( !isset( $error_message['mail'] ) || !empty( $error_message['mail'] ) ) ? $clean_email_addresses : '';
	
	//check if user is logged in - Use name & first name or name field depending on the logged in statut
	if ( is_user_logged_in() ) {
		$name_from = $current_user->user_login;
	}
	else {
		if ( !empty( $secure_name_from ) ){
			$name_from = $secure_name_from;
		}
		else {
			$error_message['name_from'] = __( 'You need to specify your name', 'raf' ) ;
			$name_from = '';
		}
	}
	//If everything is correct send an mail for each email address
	if ( isset( $error_message ) && count( $error_message ) == 0 ) {
		$headers = 'From: "' . $name_from . '" <' . $email_shipper . '>'. "\n";
		$headers .= 'MIME-version: 1.0'. "\n";
		$headers .= 'Content-type: text/html; charset= utf-8'. "\n";
		
		$body_message = $openinviter_settings['message_body'];
		$body_message .= '<br /><br />';
		$body_message .= __( 'Attached message: ', 'raf' ) . "<br /><br />";
		$body_message .= $secure_content;
		$body_message = nl2br( $body_message );
		
		foreach ( $email_addresses as $dest_email ) {
			
			
			if ( !function_exists( 'raf_mail' ) ){
				function raf_mail(  $email, $subject, $body_message, $headers, $sender  ){
					wp_mail( $email, $sender['name'] . $subject, $body_message, $headers );
				
				}
			
			}
			raf_mail( $email, $openinviter_settings['message_subject'], $body_message, $headers, array( 'mail' => $email_shipper, 'name' => $name_from, 'id' => $current_user->data->ID ) );
			
		} 
		wp_redirect( RAF_URL . '/inc/raf_form.php?success_message=true' );
		exit;
	}
}


//Set the $textarea value to display it into the form. It checks the hidden_content_field that is in the openinviter form
if ( isset( $_POST['hidden_content_field'] ) && !empty( $_POST['hidden_content_field'] )) {
	$textarea_value = stripslashes ( $_POST['hidden_content_field'] );
}
elseif ( isset( $_POST['private_message'] ) && !empty( $_POST['private_message'] )) { 
	$textarea_value = stripslashes ( $_POST['private_message'] );
}
else {
	$textarea_value = __( "Hello,\nI'd like to recommend you the following page...\n", 'raf' ) . $current_url;
}

//OpenInviter fuctions for messages
function ers( $ers ) {
	if ( !empty( $ers ) ) {
		$contents = "<table cellspacing='0' cellpadding='0' style='border:1px solid red;' align='center'><tr><td valign='middle' style='padding:3px' valign='middle'><img src='" . RAF_URL . "openinviter/images/ers.gif'></td><td valign='middle' style='color:red;padding:5px;'>";
		foreach ( $ers as $key => $error )
			$contents .= "{$error}<br >";
		$contents .= "</td></tr></table><br >";
		return $contents;
	}
}
	
function oks( $oks ) {
	if ( !empty( $oks ) ) {
		$contents = '<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			</head>
		<body>';
		
		$contents .= "<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center'><tr><td valign='middle' valign='middle'><img src='" . RAF_URL . "openinviter/images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
		foreach ( $oks as $key=>$msg )
			$contents .= "{$msg}<br >";
		$contents .= "</td></tr></table><br >";
		$contents .= '</body></html>'; 
		return $contents;
	}
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		<meta name="robots" content="nofollow" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script src="<?php echo RAF_URL; ?>js/raf_form.js"></script>
		<link rel='stylesheet' href='<?php echo RAF_URL; ?>css/style.css' type='text/css' media='all' />
		<style type="text/css" media="all">

			#raf_global {
				border-color: #<?php echo $border_color; ?>;
				background: #<?php echo $bg_color; ?>;
			}
			#raf_global legend, #raf_global h1 {
				color:#<?php echo $legend_color; ?>;
			}
			#raf_global submit-btn, #raf_global .thButton, .submit-btn, .thButton {
				color: #<?php echo $button_text_color; ?>;
			}
			#raf_global .submit-btn, #raf_global .thButton {
				background-color: #<?php echo $button_color; ?>;
			}
			#raf_global .submit-btn:hover, #raf_global .thButton:hover {
				background-color: #<?php echo $bg_color_hover; ?>;
			}
		</style>
	</head>
	
	<body>
		<div id="raf_global">
			<h1><?php _e( 'Recommend this page to a friend !' , 'raf'); ?></h1>
			<?php if ( isset( $error_message ) && count( $error_message ) > 0 ) 
				echo ers( $error_message ); 
				elseif ( $success_message ) 
					echo oks( array( __( 'Your message has been sent', 'raf' ) ) ); ?>
				
			<form action="" method="post">
				<fieldset>
					<legend><?php _e( 'Customize your message' , 'raf'); ?></legend>
					<textarea name="private_message" cols="69" rows="6" id="private_message"><?php echo esc_textarea( $textarea_value ) ; ?></textarea>
				</fieldset>
				
				<?php if ( $manual_feature == true ) : ?>
					<fieldset>
						<legend><?php _e( 'Please insert here the email addresses separate by commas' , 'raf'); ?></legend>
						<input class="field" type="text" name="raf_email_addresses" size="70" value="<?php echo ( isset( $email_default_value ) && !empty( $email_default_value ) ) ? $email_default_value : "" ;?>" />
						
							<?php if ( is_user_logged_in() ) : ?>
								<input type="hidden" name="raf_name_from" size="70" value="<?php echo ( isset( $name_from ) && !empty( $name_from ) ) ? $name_from : "" ; ?>" />
							<?php else : ?>
								<label><?php _e( 'Your name' , 'raf'); ?></label>
								<input class="field" type="text" name="raf_name_from" size="70" value="<?php echo ( isset( $name_from ) && !empty( $name_from ) ) ? $name_from : "" ; ?>" />
							<?php endif; ?>
							
						<input type="hidden" name="raf_manual_invit" size="100" value="1" />
						<input name="" class="submit-btn" type="submit" value="<?php _e( 'Send' , 'raf'); ?>" />
					</fieldset>
				<?php endif; ?>
				
				<?php if ( $social_feature == true ) : ?>
				<fieldset>
					<legend><?php _e( 'You can recommend using: ' , 'raf'); ?></legend>
					<ul>
						<li>
							<a id="raf-facebook" href="http://www.facebook.com/share.php?u=<?php echo $current_url; ?>" target="_blank">Facebook</a>
						</li>
						<li>
							<a id="raf-twitter" href="http://twitter.com/home?status=<?php echo $current_url; ?>" target="_blank">Twitter</a>
						</li>
					</ul>
				</fieldset>
				<?php endif; ?>
				
			</form>
			
			<?php
			if ( $open_inviter_feature == true ) : 
			/*
			* OPENINVITER SCRIPT
			*/
			$inviter=new OpenInviter();
			$oi_services=$inviter->getPlugins( true );
			if ( isset( $_POST['provider_box'] ) ) {
				if ( isset( $oi_services['email'][$_POST['provider_box']] ) ) $plugType = 'email';
				elseif ( isset( $oi_services['social'][$_POST['provider_box']] ) ) $plugType = 'social';
				else $plugType = '';
			}
			else 
				$plugType = '';
			
			if ( !empty( $_POST['step'] ) ) $step = $_POST['step'];
			else $step = 'get_contacts';
			
			$ers = array();
			$oks = array();
			$import_ok = false;
			$done = false;
			if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' && !empty( $_POST['email_box'] ) ) {
				if ( $step == 'get_contacts' ) {
					if ( empty( $_POST['email_box'] ) )
						$ers['email'] = __( 'You need to enter an email', 'raf' );
					if ( empty( $_POST['password_box'] ) )
						$ers['password'] = __( 'You need to enter a password', 'raf' ) ;
					if ( empty( $_POST['provider_box'] ) )
						$ers['provider'] = __( 'You need to specify an email provider', 'raf' ) ;
					if ( count( $ers ) == 0 ){
						$inviter->startPlugin( $_POST['provider_box'] );
						$internal = $inviter->getInternalError();
						if ( $internal )
							$ers['inviter']=$internal;
						elseif ( !$inviter->login( $_POST['email_box'], $_POST['password_box'] ) ) {
							$internal = $inviter->getInternalError();
							$ers['login'] = ( $internal ? $internal : __( 'Unable to etablish a connection. Please check your login/password.', 'raf' ) );
						}
						elseif ( false === $contacts = $inviter->getMyContacts() )
							$ers['contacts'] = __( 'Unable to load contacts', 'raf' );
						else {
							$import_ok = true;
							$step = 'send_invites';
							$_POST['oi_session_id'] = $inviter->plugin->getSessionID();
							$_POST['message_box'] = '';
						}
					}
				}
				elseif ( $step == 'send_invites' ) {
					if ( empty( $_POST['provider_box'])) $ers['provider'] = __( 'Please choose an email provider', 'raf' );
					else {
						$inviter->startPlugin( $_POST['provider_box'] );
						$internal=$inviter->getInternalError();
						if ( $internal ) $ers['internal'] = $internal;
						else {
							if ( empty( $_POST['email_box'] ) ) $ers['inviter'] = __( 'Inviter information missing !', 'raf' ) ;
							if ( empty( $_POST['oi_session_id'] ) ) $ers['session_id'] = __( 'No active session !', 'raf' ) ;
							if ( empty( $_POST['message_box'] ) ) $ers['message_body'] = __( 'Message missing !', 'raf' ) ;
							else $_POST['message_box'] = strip_tags( $_POST['message_box'] );
							$selected_contacts = array();
							$contacts = array();
							$message = array(
								'subject' => $inviter->settings['message_subject'], 
								'body'=>$inviter->settings['message_body'],
								'attachment'=>"\n\r " . __( 'Attached message: ', 'raf' ) . "<br />".$_POST['message_box']);
							if ( $inviter->showContacts() ) {
								foreach ( $_POST as $key => $val )
									if ( strpos( $key, 'check_') !== false )
										$selected_contacts[$_POST['email_' . $val]] = $_POST['name_' . $val];
									elseif ( strpos( $key,'email_') !==false ) {
										$temp = explode( '_', $key );
										$counter=$temp[1];
										if ( is_numeric( $temp[1] ) ) $contacts[$val] = $_POST['name_'.$temp[1]];
									}
								if ( count( $selected_contacts ) == 0 ) 
									$ers['contacts'] =  __( 'Please select one or more contacts', 'raf' );
							}
							}
						}
					if ( count( $ers ) == 0 ) {
						$sendMessage = $inviter->sendMessage( $_POST['oi_session_id'], $message, $selected_contacts );
						$inviter->logout();
						if ( $sendMessage === -1 ) {
							$message_subject = $_POST['email_box'] . $message['subject'];
							$message_body = $message['body'] . '<br /><br />' . nl2br( $message['attachment'] ); 
							$headers = "From: {$_POST['email_box']}\n";
							$headers .= "MIME-version: 1.0\n";
							$headers .= "Content-type: text/html; charset= iso-8859-1\n";
							foreach ( $selected_contacts as $email => $name )
								mail( $email, $message_subject, stripslashes( $message_body ),$headers );
							$oks['mails'] = __( 'Your message has been sent', 'raf' );
						}
						elseif ( $sendMessage===false) {
							$internal = $inviter->getInternalError();
							$ers['internal'] = ( $internal ? $internal : __( 'An error occured during the mailing. Please try later.', 'raf' ) );
						}
						else $oks['internal'] = __( 'Your message has been sent', 'raf' );
						$done = true;
					}
				}
			}
			else {
				$_POST['email_box'] = '';
				$_POST['password_box'] = '';
				$_POST['provider_box'] = '';
			}

			$contents = "<form action='' method='POST' id='oi_form' name='openinviter'>". ers($ers) . oks($oks);
			
			if ( !$done )
				$contents .= "<fieldset><legend>" . __( 'Retrieve your contact from an email provider', 'raf' ) . "</legend>";
				
			if ( !$done ) {
				if ( $step=='get_contacts' ) {
					$contents .= "<table align='center' class='thTable' cellspacing='2' cellpadding='5' style='border:none;'>
						<tr class='thTableRow'><td align='right'>
						<input type='hidden' id='hidden_content_field' value='ok' name='hidden_content_field' />
						<label for='email_box'>" . __( 'Email', 'raf' ) . "</label></td><td><input class='thTextbox' type='text' name='email_box' value='{$_POST['email_box']}'></td></tr>
						<tr class='thTableRow'><td align='right'><label for='password_box'>" . __( 'Password', 'raf' ) . "</label></td><td><input class='thTextbox' type='password' name='password_box' value='{$_POST['password_box']}'></td></tr>
						<tr class='thTableRow'><td align='right'><label for='provider_box'>" . __( 'Email provider', 'raf' ) . "</label></td><td><select class='thSelect' name='provider_box'><option value=''></option>";
					foreach ( $oi_services as $type=>$providers ) {
						$contents .= "<optgroup label='{$inviter->pluginTypes[$type]}'>";
						foreach ( $providers as $provider=>$details )
							$contents .= "<option value='{$provider}'".( $_POST['provider_box'] == $provider ? ' selected' : '' ) . ">{$details['name']}</option>";
						$contents .= "</optgroup>";
					}
					$contents .= "</select></td></tr>
						<tr class='thTableImportantRow'><td colspan='2' align='center'><input class='thButton' type='submit' name='import' value='" . __( 'Import contacts', 'raf' ) . "'></td></tr>
					</table><input type='hidden' name='step' value='get_contacts'>";
					}
				else
					$contents .= "<table class='thTable' id='hidden_tab' cellspacing='0' cellpadding='0' style='border:none;'>
							<tr class='thTableRow'><td align='right' valign='top'><label for='message_box'>" . __( 'Message', 'raf' ) . "</label></td><td><textarea rows='5' cols='50' name='message_box' class='thTextArea' id='message_box' style='width:300px;'>{$_POST['message_box']}</textarea></td></tr>
							<tr class='thTableRow'><td align='center' colspan='2'><input type='submit' name='send' value='" . __( 'Send invites', 'raf' ) . "' class='thButton' ></td></tr>
						</table>";
			}
			if ( !$done ) {
				if ( $step == 'send_invites' ) {
					if ( $inviter->showContacts() ) {
						$contents.="<table class='thTable' align='center' width='100%' cellspacing='2' cellpadding='5'><tr class='thTableHeader'><td colspan='".($plugType=='email'? "3":"2")."'>Vos contacts : </td></tr>";
						if (count($contacts)==0)
							$contents .= "<tr class='thTableOddRow'><td align='center' style='padding:20px;' colspan='".( $plugType == 'email' ? "3" : "2" )."'>" . __( 'No contacts found', 'raf' ) . "</td></tr>";
						else {
							$contents .= "<tr class='thTableDesc'><td class='thTableinput'><input type='checkbox' id='toggle_all' name='toggle_all' title='Select/Deselect all' checked>" . __( 'Invite ?', 'raf' ) . "</td><td class='thTablename'>" . __( 'Name', 'raf' ) . "</td>" . ( $plugType == 'email' ? "<td class='thTableemail'>" . __( 'Email', 'raf' ) . "</td>" :"" ) . "</tr>";
							$odd = true;
							$counter = 0;
							foreach ( $contacts as $email=>$name ) {
								$name = utf8_decode( $name );
								$counter++;
								if ( $odd ) $class = 'thTableOddRow'; else $class='thTableEvenRow';
								$contents .= "<tr class='{$class}'><td class='thTableinput'><input name='check_{$counter}' value='{$counter}' type='checkbox' class='thCheckbox' checked><input type='hidden' name='email_{$counter}' value='{$email}'><input type='hidden' name='name_{$counter}' value='{$name}'></td><td>{$name}</td>".($plugType == 'email' ?"<td>{$email}</td>":"")."</tr>";
								$odd =! $odd;
							}
							$contents .= "<tr class='thTableFooter'><td colspan='" .( $plugType == 'email' ? "3" :"2" ) . "' style='padding:3px;'><input type='submit' name='send' value='" . __( 'Send invites', 'raf' ) . "' class='thButton'></td></tr>";
						}
						$contents .= "</table>";
					}
					$contents .= "<input type='hidden' name='step' value='send_invites'>
						<input type='hidden' id='hidden_content_field' value='ok' name='hidden_content_field' />
						<input type='hidden' name='provider_box' value='{$_POST['provider_box']}'>
						<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
						<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";
					}
			}
			$contents .= "</fieldset></form>";
			echo $contents; 
		endif;
		?>
		</div>
	</body>
</html>