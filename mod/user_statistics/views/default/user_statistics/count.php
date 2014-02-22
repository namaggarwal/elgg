<?php
	$page_owner = page_owner_entity();
	
	if(isloggedin()){
		if(!(get_loggedin_user()->getGUID() == $page_owner->getGUID())){
				// dont count own profile visits
				//$_SERVER["REMOTE_ADDR"]="180.174.255.88";
				//$_SERVER["REMOTE_ADDR"]="207.183.232.242";
			    //require_once('geoplugin.class.php');
				//$geoplugin = new geoPlugin();
				//$geoplugin->locate();
				
				$myguid=$page_owner->guid;

				$json = file_get_contents('http://www.geoplugin.net/json.gp?ip='.$_SERVER["REMOTE_ADDR"]); // this WILL do an http request for you
				$data = json_decode($json);
				
				$stats = new ElggObject();
				
				$stats->subtype = "userstats";
			    
			    $stats->owner_guid = get_loggedin_user()->getGUID();
			    $stats->container_guid = get_loggedin_user()->getGUID();
			    
			    $stats->access_id = ACCESS_PUBLIC;
			    
				// Set its description appropriately
			    $stats->country= $data->{'geoplugin_countryName'};	
			    $stats->owner = $myguid;
			    $stats->visitor = get_loggedin_user()->getGUID();
			    $stats->date = date('Y-m-d');
			    $stats->save();
		}
	}
    
   
?>