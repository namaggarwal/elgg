<?php
	
	echo elgg_view('input/form', array(
									'action' => $vars['url'] . 'action/google_integration/invite',
									'body' => elgg_view('google_integration/formitems'),
									'method' => 'post'
								)
							);

?>