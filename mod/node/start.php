<?php

	function node_init() {		
    	

    	extend_view('metatags','node/metatags');
	   // Extend the elgg topbar
		extend_view('elgg_topbar/extend','node/topbar');

	}	
	// register for the init, system event when our plugin start.php is loaded
	register_elgg_event_handler('init', 'system', 'node_init');

?>