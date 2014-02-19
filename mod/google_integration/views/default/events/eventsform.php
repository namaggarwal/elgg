<?php
	
	echo elgg_view('input/form', array(
									'action' => $vars['url'] . 'action/google_integration/add',
									'body' => elgg_view('events/eventsformitems'),
									'method' => 'post'
								)
							);

?>