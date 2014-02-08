<?php

	global $CONFIG;
	
	
	$form_body .= "<label>" . elgg_echo('Enter Password') . "<br />" . elgg_view('input/password', array('internalname' => 'password', 'class' => 'login-textarea')) . "</label><br />";
	$form_body .= "<br />";
	$form_body .= "<label>" . elgg_echo('Confirm Password') . "<br />" . elgg_view('input/password', array('internalname' => 'password2', 'class' => 'login-textarea')) . "</label><br />";
	
	
	$form_body .= "<p>" . elgg_view('input/submit', array('value' => elgg_echo('submit'))) . "</p>";
	
	
?>
	
	<div class="contentWrapper">
		<?php 
		$c=get_input('c');
		$u=get_input('u');
		echo elgg_view('input/form', array('action' => "{$vars['url']}action/user/password_reset?c={$c}&u={$u}", 'body' => $form_body)); ?>
	</div>
	