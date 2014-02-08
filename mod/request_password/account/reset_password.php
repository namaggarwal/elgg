<?php
	require_once(dirname(dirname(__FILE__)) . "/engine/start.php");
	
	$body = elgg_view_title(elgg_echo('Ralston-overridden Password Reset Page')) . elgg_view("account/forms/passwordreset");
		
		page_draw(elgg_echo('user:password:lost'), elgg_view_layout("one_column", $body));
		
?>