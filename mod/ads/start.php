<?php

	function ads_init() {		
    	
		// Extend system CSS with our own styles, which are defined in the shouts/css view
		extend_view('css','ads/css');

		// Register a page handler, so we can have nice URLs
		register_page_handler('ads','ads_handler');

		//Setting up page
		global $CONFIG;
		// if requested admin area by logged admin
		if ( get_context() == 'admin' && isadminloggedin() ){
			add_submenu_item( elgg_echo('Ads'), $CONFIG->wwwroot . 'pg/ads/publish/');
		}
	}


	/**
	 * myfeed page handler; allows the use of fancy URLs
	 *
	 * @param array $page From the page_handler function
	 * @return true|false Depending on success
	 */
	function ads_handler($page) {

		if (isset($page[0]) && $page[0]!="") {

			switch($page[0]){
				

				case 'publish':
							if(!isadminloggedin()){
								return false;
							}else{
								set_input('action',$page[0]);
							}
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
	 
	global $CONFIG;	
	register_action("ads/publishad",false,$CONFIG->pluginspath . "ads/actions/publishad.php",true);
	// register for the init, system event when our plugin start.php is loaded
	register_elgg_event_handler('init', 'system', 'ads_init',9999);

?>