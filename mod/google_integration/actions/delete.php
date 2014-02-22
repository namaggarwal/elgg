<?php

if (!isloggedin()) 
	forward();


if(isset($_POST['guid'])){
	
	delete_entity($_POST['guid'],true);
}

forward($_SERVER[HTTP_REFERER]);
?>