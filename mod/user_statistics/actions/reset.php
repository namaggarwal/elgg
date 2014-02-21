<?php
	
	gatekeeper();
	// Make sure action is secure
	action_gatekeeper();
	
	delete_entities	("object","userstats");
	forward($_SERVER['HTTP_REFERER']);
?>