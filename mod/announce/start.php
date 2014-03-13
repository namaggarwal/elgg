<?php

	function announce_init() {		
    	
		// Extend system CSS with our own styles, which are defined in the shouts/css view
		extend_view('css','announce/css');	

	   // Extend the elgg topbar
		extend_view('elgg_topbar/extend','announce/topbar');		

		// Register a page handler, so we can have nice URLs
		register_page_handler('announce','announce_page_handler');


	}


	/**
	 * myfeed page handler; allows the use of fancy URLs
	 *
	 * @param array $page From the page_handler function
	 * @return true|false Depending on success
	 */
	function announce_page_handler($page) {
	
		if (isset($page[0]) && $page[0]!="") {

			switch($page[0]){

				
				case 'show':
							
							if(isset($page[1])){								
								set_input('action',$page[0]);
								set_input('postid',$page[1]);
							}else{
								return false;
							}
							break;
				case 'create':
							/*if(!isadminloggedin()){
								return false;
							}else{
								set_input('action',$page[0]);
							}*/
							set_input('action',$page[0]);
							break;
				case 'list':if(isset($page[1])){
								if($page[1]!="rss"){
									return false;
								}else{
									set_input('rss',true);		
								}
							}
							set_input('action',$page[0]);
							break;
				default:
						return false;
			}
			

		}else{
			
			set_input('action','list');
		}			
		
		include(dirname(__FILE__) . "/index.php");
		return true;	
		
	}
	 
	
	// register for the init, system event when our plugin start.php is loaded
	register_elgg_event_handler('init', 'system', 'announce_init');

	// Register actions
	global $CONFIG;
	register_action("announce/send",false,$CONFIG->pluginspath . "announce/actions/send.php",false);
?>