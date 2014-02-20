<?php

	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


	gatekeeper();
	global $CONFIG;

	switch(get_input("action")){

		case 'invite':
					$friends = $_SESSION['user']->getFriends('', 9999);
					$area1  = elgg_view_title("Group Chat");
					$area1 .= elgg_view("textchat/inviteWindow",array('friends'=>$friends));
					$body = elgg_view_layout('one_column',$area1);
					page_draw("Announcements",$body);
					break;
		case 'join':
					$area1 = elgg_view("textchat/chatWindow");
					$body = elgg_view_layout('one_column',$area1);
					page_draw("Announcements",$body);
					break;
		case 'send': include("sendMessage.php");
					
					break;
		default:
				return false;
			
	}
	

?>