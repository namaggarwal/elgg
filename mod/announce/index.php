<?php

	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	global $CONFIG;

	switch(get_input("action")){

		case 'show':
					$ann = get_entities_from_metadata("postid", get_input('postid'), "object", "announcements");
					if(!is_array($ann)){
						register_error("The post is either deleted or wasnt there in the first place.");
						forward("pg/announce/list");
					}
					$area1 = elgg_view("announce/show",array("ann"=>$ann));
					$body = elgg_view_layout('one_column',$area1);
					page_draw("Announcements",$body);
					break;
		case 'list':					
					$ann = get_entities("object","announcement");
					if(is_array($ann)){
						foreach ($ann as $key => $value) {
							$announces[$value->guid] = array();
							$announces[$value->guid]["GUID"]     = $value->guid;
							$announces[$value->guid]["TITLE"]    = $value->title;
							$announces[$value->guid]["DESC"]     = $value->description;
							$announces[$value->guid]["CONTENT"]  = get_metadata_byname($value->guid,"annContent")->value;
							$announces[$value->guid]["DATE"]     = $value->time_created;
							$announces[$value->guid]["LINK"]     = $CONFIG->url.get_metadata_byname($value->guid,"permLink")->value;
						}	
					}
					if(get_input("rss")){						
						echo elgg_view("announce/rss",array("ann"=>$announces));


					}else{
						
						extend_view('metatags','announce/metatags');
			
						$area1  = elgg_view_title("List of Announcements<a href='".$vars['url']."list/rss' class='announcerss rssbig'></a>");
						$area1 .= elgg_view("announce/list",array("ann"=>$announces));					
						$body = elgg_view_layout('one_column',$area1);
						page_draw("Announcements",$body);

					}
					
					break;
		case 'create':
					$area1  = elgg_view_title("Make an announcement");
					$area1 .= elgg_view("announce/forms/create",array());
					$body = elgg_view_layout('one_column',$area1);
					page_draw("Announcements",$body);
					break;
			
	}
	



?>