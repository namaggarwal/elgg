<?php

	global $CONFIG;
	function newsletters_init()
	{	
		extend_view('css','newsletters/css');	
		extend_view('elgg_topbar/extend','newsletters/topbar');
		register_page_handler('newsletters','newsletters_page_handler');
		register_action('newsletters/delete', false, $CONFIG->pluginspath . 'actions/delete.php');
	}


	/**
	 * handler function for newsletters
	 *
	 * @return void
	 * @author Shantanu Alshi
	 **/
	function newsletters_page_handler($page)
	{	
		$period=minute;
		register_plugin_hook('cron', $period, 'logrotate_cron');

		//TODO  : Set actions for other pages such as add and modify newsletters here.

		switch ($page[0]) {
		 	case 'view':
			if(isset($page[1])){								
						set_input('action',$page[0]);
						set_input('postid',$page[1]);
				}else{
					return false;
				}
				break;
			case 'create':
				set_input('action',$page[0]);
				break;
			
			case 'delete':
				set_input('id',$page[1]);
				set_input('action',$page[0]);
				break;


			default:
				set_input('action','list');
				break;
		}

		include(dirname(__FILE__) . "/index.php");
		return true;	
	}

	function logrotate_cron($hook, $entity_type, $returnvalue, $params){
		print('Executing cron');
		$resulttext = elgg_echo("Executing!!");
	}

	register_elgg_event_handler('init', 'system', 'newsletters_init');

	//Register action for dispatching the newsletters
	register_action("newsletters/dispatch",false,$CONFIG->pluginspath . "newsletters/actions/dispatch.php",true);
?>