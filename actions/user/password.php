<?php
	/**
	 * Action for changing a user's password
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @author Curverider Ltd
	 * @link http://elgg.org/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	global $CONFIG;

	gatekeeper();
	
	$password = get_input('password');
	$password2 = get_input('password2');
	$user_id = get_input('guid');
	$user = "";
	
	if (!$user_id)
		$user = $_SESSION['user'];
	else
		$user = get_entity($user_id);
		
	if (($user) && ($password!=""))
	{
		if (strlen($password)>=4)
		{
			if ($password == $password2)
			{
				$user->salt = generate_random_cleartext_password(); // Reset the salt
				$user->password = generate_user_password($user, $password);
				if ($user->save())
				{
					system_message(elgg_echo('user:password:success'));
				$email = sprintf(elgg_echo('Your Password has been updated successfully'), $user->name, $password);	
				
				return notify_user($user->guid, $CONFIG->site->guid, elgg_echo('email:resetpassword:subject'), $email, NULL, 'email');
				}	
				else
					register_error(elgg_echo('user:password:fail'));
			}
			else
				register_error(elgg_echo('user:password:fail:notsame'));
		}
		else
			register_error(elgg_echo('user:password:fail:tooshort'));
	}
	
	//forward($_SERVER['HTTP_REFERER']);
	//exit;
?>