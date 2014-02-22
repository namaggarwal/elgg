<?php

	function google_integration_pagesetup() {
		
		// Menu options
			global $CONFIG;
			if (get_context() == "friends" || 
				get_context() == "friendsof" || 
				get_context() == "collections") {
					add_submenu_item(elgg_echo('Invite Friends'),$CONFIG->wwwroot."mod/google_integration/",'google');
			}
			
			
			if (isloggedin()) {
			add_menu(elgg_echo('Events'), $CONFIG->wwwroot . "mod/google_integration/events/");
			}
		
	}

	global $CONFIG;
	register_action('google_integration/invite', false, $CONFIG->pluginspath . 'google_integration/actions/invite.php');
	register_elgg_event_handler('pagesetup','system','google_integration_pagesetup',1000);
	register_action('google_integration/add', false, $CONFIG->pluginspath . 'google_integration/actions/add.php');
	

?>