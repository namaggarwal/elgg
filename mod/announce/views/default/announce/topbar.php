<?php	
	//need to be logged in to see your feed
	gatekeeper();

?>	
	<a href="<?php echo $vars['url']; ?>pg/announce/" class="announceLink">Announce</a>
	<a href="<?php echo $vars['url']; ?>pg/announce/list/rss" class="announcerss"></a>

