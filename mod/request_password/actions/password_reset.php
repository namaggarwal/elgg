<?php
$user_guid = get_input('u');
$conf_code = get_input('c');
$password = get_input('password');
$password2 = get_input('password2');
	/**
	 * Low level function to reset a given user's password. 
	 * 
	 * This can only be called from execute_new_password_request().
	 * 
	 * @param int $user_guid The user.
	 * @param string $password password text (which will then be converted into a hash and stored)
	 */
	 
	function force_password_reset($user_guid, $password)
	{
		global $CONFIG;
		
		//if (call_gatekeeper('execute_new_password_request', __FILE__))
		//{
			$user = get_entity($user_guid);
			
			if ($user)
			{
				$salt = generate_random_cleartext_password(); // Reset the salt
				$user->salt = $salt;
				
				$hash = generate_user_password($user, $password);
				
				return update_data("UPDATE {$CONFIG->dbprefix}users_entity set password='$hash', salt='$salt' where guid=$user_guid");
			}
		//}
		
		return false;
	}
	
	/**
	 * Validate and execute a password reset for a user.
	 *
	 * @param int $user_guid The user id
	 * @param string $conf_code Confirmation code as sent in the request email.
	 */
	function execute_password_request($user_guid, $conf_code,$password)
	{
		global $CONFIG;
		//global $password;
		
		$user_guid = (int)$user_guid;
		
		$user = get_entity($user_guid);
		if (($user) && (get_private_setting($user_guid, 'passwd_conf_code') == $conf_code))
		{
			
			echo "inside execute";
			if (force_password_reset($user_guid, $password))
			{
				//remove_metadata($user_guid, 'conf_code');
				remove_private_setting($user_guid, 'passwd_conf_code');
				
				$email = sprintf(elgg_echo('Congratulations!! Your password has been successfully reset,Please verify'), $user->name, $password);
				
				return notify_user($user->guid, $CONFIG->site->guid, elgg_echo('email:resetpassword:subject'), $email, NULL, 'email');
			}
		}
		
		return false;
	}

		
		if (strlen($password)>=6)
		{
			if ($password == $password2)
			{
			 if (execute_password_request($user_guid, $conf_code,$password)) {
					system_message(elgg_echo('user:password:success'));
					forward();
					}
				else
					register_error(elgg_echo('user:password:fail'));
			}
			else
				register_error(elgg_echo('user:password:fail:notsame'));
		}
		else
			register_error(elgg_echo('registration:passwordtooshort'));
			
			forward($_SERVER['HTTP_REFERER']);
		
?>