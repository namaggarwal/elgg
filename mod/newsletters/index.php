<?php

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;


switch (get_input("action")) {

	case 'view':
			$news = get_entity(get_input("postid"));
			if(!$news){
				register_error("The post is deleted or does not exist.");
					forward("pg/newsletters/list");
			}
			$area1  = elgg_view_title("Viewing Newsletter".get_input("postid"));
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
					$letter[$value->guid]["LINK"] = $CONFIG->url.get_metadata_byname($value->guid,"permLink")->value;
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
	default:
		
		break;
}

?>