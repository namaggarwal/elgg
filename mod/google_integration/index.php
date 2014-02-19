<?php

	require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
	
	gatekeeper();
	
	set_context('friends');
	set_page_owner($_SESSION['guid']);
	
	$body = elgg_view('google_integration/form');
	$body = elgg_view_layout('two_column_left_sidebar','',$body);

	echo page_draw(elgg_echo('Invite Friends'),$body);
	
?>