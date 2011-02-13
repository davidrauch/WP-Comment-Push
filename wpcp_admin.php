<?php 
	if($_POST['wpcp_hidden'] == 'Y') {
		$username = $_POST['wpcp_username'];
		update_option('wpcp_username', $username);
		
		$password = $_POST['wpcp_password'];
		update_option('wpcp_password', $password);

		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else {
		$username = get_option('wpcp_username');
		$password = get_option('wpcp_password');
	}
?>

<div class="wrap">
	<h2>WP Comment Push Options</h2>
	<form name="wpcp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="wpcp_hidden" value="Y">
		<h4>Boxcar settings</h4>
		<p>Username <input type="text" name="wpcp_username" value="<?php echo $username; ?>" size="20"></p>
		<p>Password <input type="password" name="wpcp_password" value="<?php echo $password; ?>" size="20"></p>
		<p class="submit"><input type="submit" name="Submit" value="Save" /></p>
	</form>
</div>
	