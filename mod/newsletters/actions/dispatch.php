<?php

	//Hire a watchman to check if administrator

	if(!isadminloggedin()){
		forward("pg/newsletters/list");
	}

	//Set the base path
	$base_path = parse_url($CONFIG->url)["path"];

	//Get the current time
	$now = time();

	//Start saving in the Database

	$date = mysql_real_escape_string(htmlspecialchars(get_input('news_date')));
	$title = mysql_real_escape_string(htmlspecialchars(get_input('news_title')));
	$content = mysql_real_escape_string(htmlspecialchars(get_input('news_body')));
	$newstype = mysql_real_escape_string(htmlspecialchars(get_input('news_type')));
	$access = 2; // public access


	$err;

	if(empty($title)){
		$err = "<div>Title cannot be empty.</div>";
	}

	if(empty($date)){
		$err .= "<div>Description cannot be empty.</div>";
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
		forward("pg/newsletters/create");
	}

	//Start saving to database

	//Initialize Elgg object
	$newsletter  = new ElggObject();

	//Tell the fucker elgg that it is a newsletter
	$newsletter->subtype = "newsletter";

	//The owner of this newsletter is the logged in user
	$announcement->owner_guid = $_SESSION['user']->getGUID();

	//Set other attributes
	$newsletter->date = $date;
	$newsletter->title = $title;
	$newsletter->description = $content;
	$newsletter->newstype = $newstype;
	$newsletter->access_id = $access;
	$newsletter->postid = $now;

	$newsletter->permlink = "pg/newsletters/".$guid;


	//Go put this crap in the database
	$newsletter->save();

	echo $newsletter->postid;
	exit();

?>