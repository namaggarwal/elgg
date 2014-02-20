<?php

	gatekeeper();
	
	$guid = $_POST["guid"];

	if($guid != get_loggedin_user()->guid){

		throw "Invalid id";
	}
	extract($_POST);
	//set POST variables
	$url = 'http://localhost:1337/sendChat';
	$fields = array(
							'myid' => urlencode($guid),
							'room' => urlencode($room),
							'name' => urlencode(get_loggedin_user()->name),
							'message' => urlencode($message)
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

	print $result;


?>