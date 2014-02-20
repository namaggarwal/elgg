<?php

gatekeeper();

// Call notifier

//extract data from the post
extract($_POST);


if(is_array($fid)){

	//Check here... all should be my friends
	$fid = implode(",",$fid);

}else if ($fid == "all") {

	//check if admin 

}else if($fid == "friends"){

	//Create comma separated friend list
}else{

	return false;
}

//set POST variables
$url = 'http://localhost:1337/notifyforme';
$fields = array(
						'myid' => urlencode($myid),
						'fid' => urlencode($fid),						
						'message' => urlencode($message),
						'link' => urlencode($link),
						'notType' => urlencode($notType),
						'delay' => urlencode($delay),
						'callback' => urlencode($callback),
						'otherData' => urlencode($otherData),

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

?>