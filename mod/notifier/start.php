<?php

	function notifier_init() {		
    	    	
	   // Extend the elgg topbar
		extend_view('elgg_topbar/extend','notifier/topbar');
		extend_view('footer/analytics','notifier/notificationbar');
		extend_view('css','notifier/css');	

		register_page_handler("notifier","notifier_page_handler");
	}	


	/**
	 * myfeed page handler; allows the use of fancy URLs
	 *
	 * @param array $page From the page_handler function
	 * @return true|false Depending on success
	 */
	function notifier_page_handler($page) {

		if($_SERVER['REQUEST_METHOD'] == "POST"){

			include(dirname(__FILE__) . "/index.php");
			return true;	

		}else{

			return false;
		}

		
		
	}
	 

	// register for the init, system event when our plugin start.php is loaded
	register_elgg_event_handler('init', 'system', 'notifier_init');

?>