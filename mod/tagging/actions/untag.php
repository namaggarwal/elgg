<?php

gatekeeper();
if(isset($_POST['gids'])) {
	$arr= $_POST['gids'];
 }

	
if(isset($_POST['fid']))
	$fid=$_POST['fid'];

$file=get_entity($fid);

$prev_tags=$file->friendtags;
$new_array=array();
$count=0;
 if(is_array($prev_tags)){
	foreach($prev_tags as $key => $value){
		if(!(in_array($value,$arr))
			$new_array[$count++]=$value;
	}
}
$file->friendtags->$new_array;
$file->save();

forward($_SERVER['HTTP_REFERER']);
?>
