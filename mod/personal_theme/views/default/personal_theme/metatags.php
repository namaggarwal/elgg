<?php
 
 global $CONFIG;

 if (function_exists('get_loggedin_user'))
    $user = get_loggedin_user();
  else
    $user = $_SESSION['user'];
	
  $myguid=get_loggedin_userid();

  $theme = get_entities("object","theme",$myguid);
  
  if(is_array($theme)){
  	
  	$link=$CONFIG->url."mod/personal_theme/themes/".$theme[0]->title."/".$theme[0]->title.".css";
  	print '<link href="'.$link.'" data-css="external" type="text/css" rel="stylesheet"/>';
  }
?>