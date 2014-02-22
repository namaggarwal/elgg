<?php
/**
 * Request password reset or username using email
 *
 * @author Cash Costello
 * @license GPL2
 */

register_elgg_event_handler('init','system','tagging_init');

function tagging_init() {
	global $CONFIG;

	register_action('file/tag',true,$CONFIG->pluginspath . 'tagging/actions/tag.php', false);

}
?>