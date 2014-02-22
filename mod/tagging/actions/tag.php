
<?php

gatekeeper();
if(isset($_POST['gids'])) {
	$arr= $_POST['gids'];
 }
if(isset($_POST['fid']))
	$fid=$_POST['fid'];

$file=get_entity($fid);

$file->friendtags=implode(",",$arr);	
$file->save();

//Send notitfication
$url = 'http://localhost:1337/notifyforme';
$fid = $file->friendtags;
$myid = $file->owner_id;
$message = "You have been tagged in a file";
$link  = "www.google.com";
if($fid!=""){

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


}




forward($_SERVER['HTTP_REFERER']);
?>
