
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
forward($_SERVER['HTTP_REFERER']);
?>
