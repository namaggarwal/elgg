<?php

	function textchat_init() {		
    	
		// Extend system CSS with our own styles, which are defined in the shouts/css view
		extend_view('css','textchat/css');	

		// Register a page handler, so we can have nice URLs
		register_page_handler('textchat','textchat_page_handler');		

		global $CONFIG;

		// Set up menu for logged in users
		if (isloggedin()) 
		{
			add_menu(elgg_echo('Group chat'), $CONFIG->wwwroot . "pg/textchat/");
		}
		
	}


	/**
	 * myfeed page handler; allows the use of fancy URLs
	 *
	 * @param array $page From the page_handler function
	 * @return true|false Depending on success
	 */
	function textchat_page_handler($page) {

		if (isset($page[0]) && $page[0]!="") {

			switch($page[0]){

				
				case 'invite':
							set_input('action','invite');
							break;	
				case 'send':if(!(isset($_POST["guid"]) && isset($_POST["room"]) && isset($_POST["message"]))){
								return false;
							}
							set_input('action','send');
							break;
				case 'join':					
							if(isset($page[1]) && isset($page[2])){
								set_input('action','join');
								//my or friend id
								set_input('mfid',$page[2]);
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
	register_elgg_event_handler('init', 'system', 'textchat_init');

	// Register actions
	global $CONFIG;
	
?>