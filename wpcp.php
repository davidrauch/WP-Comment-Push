<?php
/*
Plugin Name: WP Comment Push
Plugin URI: http://daver.at/wp-comment-push/
Description: Sends a push Notification via Boxcar when a Comment is posted
Version: 1.0
Author: David Rauch
Author URI: http://daver.at
License: LGPL2
*/
        
function wpcp_send($id)
{
	$username = get_option('wpcp_username');
	$password = get_option('wpcp_password');
	$comment = get_comment($id);
	if($comment->comment_approved == 1) {
		$gravatar = 'http://www.gravatar.com/avatar/'.md5(strtolower($comment->comment_author_email));
		
		if(!class_exists('WP_Http')) {
			include_once( ABSPATH . WPINC. '/class-http.php' );
		}

		$body = array('notification[from_screen_name]' => get_bloginfo('name'), 'notification[message]' => $comment->comment_author.': "'.$comment->comment_content.'"', 'notification[icon_url]' => $gravatar);
		$headers = array( 'Authorization' => 'Basic '.base64_encode("$username:$password"));
		$request = new WP_Http;
		$result = $request->request('https://boxcar.io/notifications', array('method'=>'POST','body'=>$body,'headers'=>$headers));
	}
		
	return $id;
}
	
function wpcp_admin() {
	include('wpcp_admin.php');
}
	
function wpcp_admin_actions() {
	add_options_page('WP Comment Push', 'WP Comment Push', 1, 'wp_comment_push', 'wpcp_admin');
}

add_action('comment_post', 'wpcp_send');
add_action('admin_menu', 'wpcp_admin_actions');

?>