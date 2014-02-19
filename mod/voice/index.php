<?php

	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");


	gatekeeper();
	global $CONFIG;

	switch(get_input("action")){

		case 'invite':
					$friends = $_SESSION['user']->getFriends('', 9999);
					$area1  = elgg_view_title("Phone a friend");
					$area1 .= elgg_view("voice/inviteWindow",array('friends'=>$friends));
					$body = elgg_view_layout('one_column',$area1);
					page_draw("Announcements",$body);
					break;
		case 'join':
					$area1 = elgg_view("voice/chatWindow");
					$body = elgg_view_layout('one_column',$area1);
					page_draw("Announcements",$body);
					break;
		default:
				return false;
			
	}
	



?>