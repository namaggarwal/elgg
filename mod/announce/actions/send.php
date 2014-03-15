<?php
	
	// Make sure we're logged in (send us to the front page if not)
	if (!isloggedin()) forward();	

	$myguid = (int) get_loggedin_user()->guid;
	$now = date('dmYhis');
	$title = get_input("ann_title");
	$desc = get_input("ann_desc");
	$content = get_input("ann_content");
	$code=get_input("_elggToken");
	$dummy=base64_decode($code);
	$q=explode('_', $dummy);

	
	if(($q[0]==$myguid)&&($q[1]==$_SERVER['REMOTE_ADDR']))
	{
		
	//save for the future
	$_SERVER["ann_title"] = $title;
	$_SERVER["ann_desc"] = $desc;
	$_SERVER["ann_content"] = $content;


	$err;


	if(empty($title)){

		$err = "<div>Title cannot be empty.</div>";
	}

	if(empty($desc)){

		$err .= "<div>Description cannot be empty.</div>";
	}

	if(empty($content)){

		$err .= "<div>Content cannot be empty.</div>";
	}

	if(!empty($err)){
		
		register_error($err);
		forward("pg/announce/create");
	}


// Initialise a new ElggObject
	$post = new ElggObject();	
// Tell the system it's a message
	$post->subtype = "announcement";
	
// Set its owner to the current user

	$post->owner_guid = $myguid;
	$post->container_guid = $myguid;
	
	$post->access_id = ACCESS_PUBLIC;
	
// Set its description appropriately
	$post->title = $title;
	$post->description = $desc;
	$post->annContent = $content;
	$post->postid = $now;
	
	$post->permLink = "pg/announce/show/".$now;

	$post->save();

	// Future no longer needs this
	unset($_SERVER["ann_title"]);
	unset($_SERVER["ann_desc"]);
	unset($_SERVER["ann_content"]);


	system_message("Announcement has been successfully posted.");
	forward("pg/announce/list");

}
else
{

	register_error("Bad token");
}


?>
