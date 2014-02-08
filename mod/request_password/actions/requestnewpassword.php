<?php


$username = get_input('username');
$user = get_user_by_username($username);

if (is_array($user)) {
	$user = $user[0];
}

	function send_new_password_link($user_guid)
	{
		global $CONFIG;
		
		$user_guid = (int)$user_guid;
		
		$user = get_entity($user_guid);
		if ($user)
		{
			// generate code
			$code = generate_random_cleartext_password();
			//create_metadata($user_guid, 'conf_code', $code,'', 0, ACCESS_PRIVATE);
			set_private_setting($user_guid, 'passwd_conf_code', $code);
			
			// generate link
			$link = $CONFIG->site->url . "account/reset_password.php?u=$user_guid&c=$code";
			
			// generate email
			$email = sprintf(elgg_echo('email:resetreq:body'), $user->name, $_SERVER['REMOTE_ADDR'], $link);
			
			return notify_user($user->guid, $CONFIG->site->guid, elgg_echo('email:resetreq:subject'), $email, NULL, 'email');

		}
		
		return false;
	}
	
if ($user) {
	if ($user->validated) {
		if (send_new_password_link($user->guid)) {
			system_message(elgg_echo('Thank You! An email has been sent to your registered id, Please check for the further instructions for resetting your password '));
		} else {
			register_error(elgg_echo('user:password:resetreq:fail'));
		}
	} else {
		if (!trigger_plugin_hook('unvalidated_requestnewpassword', 'user', array('entity'=>$user))) {
			// if plugins have not registered an action, the default action is to
			// trigger the validation event again and assume that the validation
			// event will display an appropriate message
			trigger_elgg_event('validate', 'user', $user);
		}
	}
} else {
	register_error(sprintf(elgg_echo('user:email:notfound'), $email));
}

forward();
