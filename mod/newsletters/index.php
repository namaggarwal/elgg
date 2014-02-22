<?php

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;


switch (get_input("action")) {

	case 'view':
			$news =  get_entities_from_metadata("postid", get_input('postid'), "object", "newsletter");
			if(!$news){
				register_error("The post is deleted or does not exist.");
					forward("pg/newsletters/list");
			}
			$area1  = elgg_view_title("Viewing Newsletter");
			$area1 = elgg_view("newsletters/viewnl",array("news"=>$news));
			$body = elgg_view_layout('one_column',$area1);
			page_draw("Newsletters",$body);
		break;
	case 'create':
		$area1  = elgg_view_title("Create a Newsletter");
		$area1 .= elgg_view("newsletters/compose",array());
		$body = elgg_view_layout('one_column',$area1);
		page_draw("Newsletters",$body);
		break;

	
	case 'list':
		$news = get_entities("object","newsletter");
			$letter = array();
			if(is_array($news)){
				foreach ($news as $key => $value) {
					$letter[$value->guid] = array();
					$letter[$value->guid]["GUID"]	= 	$value->guid;
					$letter[$value->guid]["TITLE"]	= 	$value->title;
					$letter[$value->guid]["DESC"]	= 	$value->description;
					$letter[$value->guid]["DATE"]	= 	$value->time_created;
					$letter[$value->guid]["NEWSTYPE"]	= 	$value->newstype;
					$letter[$value->guid]["LINK"] = get_metadata_byname($value->guid,"permlink")->value;
				}

				$area1  = elgg_view_title("Newsletters published");
				$area1 .= elgg_view("newsletters/list",array("news"=>$letter));					
				$body = elgg_view_layout('one_column',$area1);
				page_draw("Newsletters",$body);
			}
			else{
						$area1  = elgg_view_title("Newsletters published");
						$area1 .= elgg_view("newsletters/list",array("ann"=>$announces));					
						$body = elgg_view_layout('one_column',$area1);
						page_draw("Newsletters",$body);
			}
		break;

	case 'sendNewsLetter':

	
		$data = get_entities("user","",0,"",100);
		//set POST variables
		$url = 'http://localhost:1337/notifyforme';
		$myid = 2;	
		$message = "New newsletter published";
		$postobj = get_entities_from_metadata("postid", get_input('postid'), "object", "newsletter");
		if(is_array($postobj)){
			$postobj = $postobj[0];
		}else{
			return false;
		}
		$link = get_metadata_byname($postobj->guid,"permlink")->value;
		$fid = array();
		foreach($data as $key=>$user){
			
			array_push($fid, $user->guid);
			
		}

		$fid= implode(",", $fid);

		$fields = array(
								'myid' => urlencode($myid),
								'fid' => urlencode($fid),						
								'message' => urlencode($message),
								'link' => urlencode($link),

						);
		$and = "";
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { 
			$fields_string .= $and.$key.'='.$value; 
			$and = "&";
		}
		rtrim($fields_string,'&');

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);
	


		break;	
	default:
		
		break;
}

?>
