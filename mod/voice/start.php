<?php

	function voice_init() {		
    	
		// Extend system CSS with our own styles, which are defined in the shouts/css view
		extend_view('css','voice/css');	

	   // Extend the elgg topbar
		extend_view('elgg_topbar/extend','voice/topbar');


		// Register a page handler, so we can have nice URLs
		register_page_handler('voice','voice_page_handler');		


	}


	/**
	 * myfeed page handler; allows the use of fancy URLs
	 *
	 * @param array $page From the page_handler function
	 * @return true|false Depending on success
	 */
	function voice_page_handler($page) {

		if (isset($page[0]) && $page[0]!="") {

			switch($page[0]){

				
				case 'invite':
							set_input('action','invite');
							break;							
				case 'join':					
							if(isset($page[1]) && isset($page[2]) && isset($page[3])){
								set_input('action','join');
								set_input('myid',$page[2]);
								set_input('perid',$page[3]);
								set_input('room',$page[1]);
							}else{
								return false;
							}
							break;
				
				default:
						return false;
			}
			

		}else{
			
			set_input('action','invite');
		}			
		
		include(dirname(__FILE__) . "/index.php");
		return true;	
		
	}
	 
	
	// register for the init, system event when our plugin start.php is loaded
	register_elgg_event_handler('init', 'system', 'voice_init');

	// Register actions
	global $CONFIG;
	
?>