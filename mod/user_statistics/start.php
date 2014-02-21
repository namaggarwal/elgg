<?php

	function user_statistics_init()	{
		global $CONFIG;
		
		// Extend profile to keep track of count
		extend_view('profile/userdetails','user_statistics/count',999);
		
		// Extend statistics to show current count
		extend_view('usersettings/statistics','user_statistics/stats',999);
		
	}
	
	register_elgg_event_handler('init','system','user_statistics_init');	
	register_action("user_statistics/reset", true, $CONFIG->pluginspath . "user_statistics/actions/reset.php");
	

?>