<?php

	//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	//Hire a watchman to check if administrator

	// if(!isadminloggedin()){
	// 	forward("pg/dashboard");
	// }


	//Set the base path
	$base_path = parse_url($CONFIG->url)["path"];

	//Start saving in the Database
	$title = get_input('ad_title');
	$link = get_input('ad_link');
	$content = get_input('ad_content');
	$description = get_input('ad_description');
	$access = 2; // public access
	$now = time();
	//Start saving to database

	//Initialize Elgg object
	$advert  = new ElggObject();
	//Tell the fucker elgg that it is a advertisement
	$advert->subtype = "advertisement";

	//The owner of this advert is the logged in user
	$announcement->owner_guid = $_SESSION['user']->getGUID();

	//Set other attributes
	$advert->date = $date;
	$advert->title = $title;
	$advert->content = $content;
	$advert->description = $description;
	$advert->link = $link;
	$advert->access_id = $access;
	$advert->postid = $now;

	$advert->permlink = "pg/ads/".$guid;


	//Go put this crap in the database
	$advert->save();

	system_message("Advertisement has been successfully posted.");
	forward("pg/ads/publish");

?>
