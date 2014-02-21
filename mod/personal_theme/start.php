<?php

/* 
  Function to populate the list with available themes in the theme folder.
  Note - Theme name is the theme folder name.
*/
function themeswitcher_set_theme_list()
  {
    global $CONFIG;
    
    $themes_dir  = $CONFIG->pluginspath . 'personal_theme/themes/';
    $themes_list = array(); 
    if ($handle = opendir($themes_dir)) 
    {
      while (false !== ($file = readdir($handle))) 
      {
        if (!in_array($file, array('.','..')) && is_dir($themes_dir . $file))
        {
          $themes_list[] = $file;
        }
      }
    }
    sort($themes_list);
    
    $CONFIG->themelist = $themes_list;
  }

  /*
    Intitialise the plugin.
  */
	function theme_init() {	

    // Extend the elgg topbar
		extend_view('navigation/topbar_tools','personal_theme/topbar');
    extend_view('metatags','personal_theme/metatags');
    // Register a page handler, so we can have nice URLs
    register_page_handler('personal_theme','theme_page_handler');
		themeswitcher_set_theme_list();		
	}
	


  function theme_page_handler($page){

      if(isset($page[0]) && $page[0] == "change" && isset($page[1])){
          changetheme($page[1]);
          return true;  
      }else{
        return false;
      }
  }

  function changetheme($theme){

  global $CONFIG;
  if (function_exists('get_loggedin_user'))
    $user = get_loggedin_user();
  else
    $user = $_SESSION['user'];
    
  $myguid=get_loggedin_userid();
  
  $curr_theme = get_entities("object","theme",$myguid);
  
  if($curr_theme){

    //write some change code
    $prev_theme=$curr_theme[0]->title;
    $curr_theme[0]->title = $theme;
    $curr_theme[0]->save();
  }else{
    $curr_theme = new ElggObject();
    $curr_theme->subtype = "theme";
    $curr_theme->owner_guid = $myguid;
    $curr_theme->access_id = ACCESS_PRIVATE;
    $curr_theme->title = $theme;
    $curr_theme->save();
  }

  
   print "http://$_SERVER[HTTP_HOST]"."/elgg/mod/personal_theme/themes/".$theme."/".$theme.".css";
  }


	// register for the init, system event when our plugin start.php is loaded
	register_elgg_event_handler('init', 'system', 'theme_init');

	
?>