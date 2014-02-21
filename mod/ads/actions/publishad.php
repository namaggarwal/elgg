<?php

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
	$access = 2; // public access


	$err;

	if(empty($title)){
		$err = "<div>Please enter a title for your ad</div>";
	}

	if(empty($link)){
		$err .= "<div>Please provide a link for your advertisement.</div>";
	}

	if(empty($content)){
		$err .= "<div>Content cannot be empty.</div>";
	}

	if(empty($newstype)){
		$err .= "<div>Content cannot be empty.</div>";
		return false;
	}

	if(!empty($err)){
		register_error($err);
		forward("pg/advertisements/publish");
	}

	//Start saving to database

	//Initialize Elgg object
	$newsletter  = new ElggObject();

	//Tell the fucker elgg that it is a newsletter
	$newsletter->subtype = "advertisement";

	//The owner of this newsletter is the logged in user
	$announcement->owner_guid = $_SESSION['user']->getGUID();

	//Set other attributes
	$newsletter->date = $date;
	$newsletter->title = $title;
	$newsletter->description = $content;
	$newsletter->link = $link;
	$newsletter->access_id = $access;
	$newsletter->postid = $now;

	$newsletter->permlink = "pg/advertisements/".$guid;


	//Go put this crap in the database
	$newsletter->save();

	echo $newsletter->postid;
	exit();

?>