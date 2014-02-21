<?php

	function user_statistics_init()	{
		global $CONFIG;
		
		// Extend profile to keep track of count
		extend_view('profile/userdetails','user_statistics/count',999);
		
		// Extend statistics to show current count
		extend_view('usersettings/statistics','user_statistics/stats',999);

		// Register a page handler, so we can have nice URLs
		register_page_handler('user_statistics','userstats_page_handler');		
		
	}


	function userstats_page_handler($page){

		
		if (isset($page[0]) && $page[0]=="getstat") {

			//Only logged in here
			gatekeeper();

			$counter = get_entities("object","userstats");
			$myid=get_loggedin_user()->guid;
			$last_days = array();
			$last_days["PROFILE"] = array();

			for($i=0;$i<5;$i++){

				$last_days["PROFILE"][$i] = array();
				$last_days["PROFILE"][$i]["DATE"] = date('Y-m-d',strtotime("-".(4-$i)." days"));
				$last_days["PROFILE"][$i]["COUNT"] = 0;

			}

			if(is_array($counter)){
				foreach ($counter as $key => $value) {
					if($value->owner == $myid){
						
						if($value->date == date('Y-m-d',strtotime("-0 days"))){
							
							
							$last_days["PROFILE"][4]["COUNT"]++;
						}
						if($value->date  ==  date('Y-m-d',strtotime("-1 days"))){
							
							
							$last_days["PROFILE"][3]["COUNT"]++;
						}
						if($value->date == date('Y-m-d',strtotime("-2 days"))){
							
							
							$last_days["PROFILE"][2]["COUNT"]++;
						}
						if($value->date  == date('Y-m-d',strtotime("-3 days"))){
							
							
							$last_days["PROFILE"][1]["COUNT"]++;
						}
						if($value->date == date('Y-m-d',strtotime("-4 days"))){
							
							$last_days["PROFILE"][0]["COUNT"]++;
						}
					}
							
				}			
			}

			
			print json_encode($last_days);
		}
		else{

			return false;
		}
	}
	
	register_elgg_event_handler('init','system','user_statistics_init');	
	register_action("user_statistics/reset", true, $CONFIG->pluginspath . "user_statistics/actions/reset.php");
	

?>