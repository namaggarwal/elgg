<?php

gatekeeper();
global $CONFIG;
if (function_exists('get_loggedin_user'))
    $user = get_loggedin_user()->username;
  else
    $user = $_SESSION['user']->username;

if(isset($_POST['gids'])) {
	$arr= $_POST['gids'];
 	foreach ($arr as $value) {
    	//$email = sprintf(elgg_echo('email:resetreq:body'), $user, $_SERVER['REMOTE_ADDR'], $link);
    $from = $user; // sender
    $subject = $user.' requests you to connect with Elgg';
    $message = "Hi... <br><br> I would like to connect with you on this awesome social network named Elgg.... Click on the below link to connect with me";
    $message .= "<br><br><a href='http://" . $_SERVER['HTTP_HOST']."/elgg/pg/profile/".$user."'>Click to Connect</a><br><br>Thanks & Regards";
    
   
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    mail($value,$subject,$message,$headers);
	}
    system_message(elgg_echo('Invites have been sent successfully'));
    

}else{
    register_error(elgg_echo('No invites have been sent.. Please choose atleast one person to send an invite'));
}

?>