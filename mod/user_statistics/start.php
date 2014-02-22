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
			$stat_data = array();
			$stat_data["PROFILE"] = array();
			$stat_data["COUNTRY"] = array();
				
			$arrayCounter=0;
			for($i=0;$i<5;$i++){

				$stat_data["PROFILE"][$i] = array();
				$stat_data["PROFILE"][$i]["DATE"] = date('Y-m-d',strtotime("-".(4-$i)." days"));
				$stat_data["PROFILE"][$i]["COUNT"] = 0;

			}

			if(is_array($counter)){
				foreach ($counter as $key => $value) {
					if($value->owner == $myid){
						$stat_data["COUNTRY"][$value->country]++;
						
					/*$user=get_user($value->owner);
						for($i=0;$i<=$arrayCounter;$i++){
							if(!($stat_data["VISITORS"][$i]["NAME"] == $user->name)){
								$stat_data["VISITORS"][$arrayCounter]["NAME"]=$user->name;
								$stat_data["VISITORS"][$arrayCounter++]["IMG"]=$user->getIcon('small');
								break;
							}
						}*/
						$count+=1;			
						if($value->date == date('Y-m-d',strtotime("-0 days"))){
							
							
							$stat_data["PROFILE"][4]["COUNT"]++;
						}
						if($value->date  ==  date('Y-m-d',strtotime("-1 days"))){
							
							
							$stat_data["PROFILE"][3]["COUNT"]++;
						}
						if($value->date  == date('Y-m-d',strtotime("-2 days"))){
							
							
							$stat_data["PROFILE"][2]["COUNT"]++;
						}
						if($value->date  == date('Y-m-d',strtotime("-3 days"))){
							
							
							$stat_data["PROFILE"][1]["COUNT"]++;
						}
						if($value->date  == date('Y-m-d',strtotime("-4 days"))){
							
							$stat_data["PROFILE"][0]["COUNT"]++;
						}
					}
							
				}			
			}


			$messages = get_entities_from_metadata("toId", get_loggedin_user()->getGUID(), "object", "messages",$myid,999);
			$inbox_array=array();
			$inbox_array['TODAY']=0;
			$inbox_array['TWEEK']=0;
			$inbox_array['TMONTH']=0;
			$inbox_array['LWEEK']=0;
			if(is_array($messages)){
				foreach ($messages as $key => $value) {
					print $messages->title;
					$time=friendly_time($value->time_created);
					$time=explode(" ",$time);
					if((strpos($time[1],'hours') !== false) || (strpos($time[1],'now') !== false) || (strpos($time[1],'minute') !== false) || (strpos($time[1],'hour') !== false) || (strpos($time[1],'minutes') !== false)){
						$inbox_array['TODAY']+=1;
						$inbox_array['TWEEK']+=1;
						$inbox_array['TMONTH']+=1;
					}else{
						if($time[0]<'7')
							$inbox_array['TWEEK']+=1;
						else if($time[0]<'14')
							$inbox_array['LWEEK']+=1;
						
						if($time[0]<'30')
							$inbox_array['TMONTH']+=1;
					}
					

				}
			}

			$stat_data['INBOX']=$inbox_array['TMONTH'].','.$inbox_array['LWEEK'].','.$inbox_array['TWEEK'].','.$inbox_array['TODAY'];

			$sent = get_entities_from_metadata("fromId", get_loggedin_user()->getGUID(), "object", "messages",$myid,999);
			$obox_array=array();
			$obox_array['TODAY']=0;
			$obox_array['TWEEK']=0;
			$obox_array['TMONTH']=0;
			$obox_array['LWEEK']=0;
			if(is_array($sent)){
				foreach ($sent as $key => $value) {
					print $sent->title;
					$time=friendly_time($value->time_created);
					$time=explode(" ",$time);
					if((strpos($time[1],'hours') !== false) || (strpos($time[1],'now') !== false) || (strpos($time[1],'minute') !== false) || (strpos($time[1],'hour') !== false) || (strpos($time[1],'minutes') !== false)){
						$obox_array['TODAY']+=1;
						$obox_array['TWEEK']+=1;
						$obox_array['TMONTH']+=1;
					}else{
						if($time[0]<'7')
							$obox_array['TWEEK']+=1;
						else if($time[0]<'14')
							$obox_array['LWEEK']+=1;
						
						if($time[0]<'30')
							$obox_array['TMONTH']+=1;
					}
					

				}
			}
			$stat_data['OUTBOX']=$obox_array['TMONTH'].','.$obox_array['LWEEK'].','.$obox_array['TWEEK'].','.$obox_array['TODAY'];

			$stat_data['VIEWS']=$count;
			//$stat_data = array_unique($stat_data);
			print json_encode($stat_data);
		}
		else{

			return false;
		}
	}
	
	register_elgg_event_handler('init','system','user_statistics_init');	
	register_action("user_statistics/reset", true, $CONFIG->pluginspath . "user_statistics/actions/reset.php");
	

?>