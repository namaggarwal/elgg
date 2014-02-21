<?php


	//Starting the elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	global $CONFIG;


	switch(get_input("action")){
			
		//If any other actions are needed, code them here.
		case 'publish':
			//This block takes care of publishing new advertisements

			$area1  = elgg_view_title("Create an advertisement");
			$area1 .= elgg_view("ads/forms/publish",array());
			$body = elgg_view_layout('one_column',$area1);
			page_draw("ads",$body);
					
		break;
	}

?>
