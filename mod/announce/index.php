<?php

	// Load Elgg engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	global $CONFIG;

	switch(get_input("action")){

		case 'show':
					/*$link = mysqli_connect("localhost","naman","IAMTHEBEST","elgg");
					$res = $link->multi_query("select * from elgg.elgg_entities;delete from elgg.attack where name like '%sumit%';");*/
					/*$ann = get_entities_from_metadata("postid", get_input('postid'), "object", "announcements");
					if(!is_array($annRes)){
						register_error("The post is either deleted or wasnt there in the first place.");
						forward("pg/announce/list");
					}
					$area1 = elgg_view("announce/show",array("ann"=>$annRes));
					$body = elgg_view_layout('one_column',$area1);
					page_draw("Announcements",$body);*/

					$err = false;

					$link = mysqli_connect("localhost","naman","IAMTHEBEST","elgg");

					$query = "  select 
								entity.guid
								,entity.time_created
								,metstr1.string
								from elgg.elgg_entities entity
								inner join elgg.elgg_entity_subtypes sub
								on entity.subtype = sub.id
								and sub.subtype = 'announcement'
								and entity.enabled = 'yes'
								inner join elgg.elgg_metadata met
								on entity.guid = met.entity_guid
								inner join elgg.elgg_metastrings metstr
								on met.name_id= metstr.id
								and metstr.string='postid'
								inner join elgg.elgg_metastrings metstr1
								on met.value_id = metstr1.id
								and metstr1.string = ".get_input('postid').";";

					if($link->multi_query($query)){

						$annRes = array();
						$result = $link->store_result();
						
						if($result){


							while($row = $result->fetch_object()){
								$entity_id = $row->guid;
								$annRes["guid"] = $row->guid;
								$annRes["time"] = $row->time_created;
							}

							if(isset($entity_id)){
								


								$result->free();

								$query = "select * from elgg.elgg_objects_entity e where e.guid= ".$entity_id;

								$result = $link->query($query);

								if($result){
									
									while($row=$result->fetch_object()){
										$annRes["title"] = $row->title;
										$annRes["desc"] = $row->description;
									}

									$result->free();

									$query = "select 
											mtr1.string as name
											,mtr2.string as value
											from elgg.elgg_metadata mtd
											inner join elgg.elgg_metastrings mtr1
											on mtd.name_id = mtr1.id
											inner join elgg.elgg_metastrings mtr2
											on mtd.value_id = mtr2.id
											where mtd.entity_guid = ".$entity_id;

									if($result){
										$result = $link->query($query);
										
										while($row=$result->fetch_object()){
											$annRes[$row->name] = $row->value;
											
										}
										$result->free();
										$link->close();
									}else{
										$err=true;
									}
					
								
								}else{
									$err=true;
								}
							}else{

								$err= true;
							}
							
						}else{

							$err = true;
						}


					}else{

						$err=true;
					}

					
					if($err==true || !is_array($annRes)){
						register_error("The post is either deleted or wasnt there in the first place.");
						forward("pg/announce/list");
					}
					$area1 = elgg_view("announce/show",array("ann"=>$annRes));
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