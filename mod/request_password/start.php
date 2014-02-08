<?php
/**
 * Request password reset or username using email
 *
 * @author Cash Costello
 * @license GPL2
 */

register_elgg_event_handler('init','system','request_password_init');

function request_password_init() {
	global $CONFIG;

	register_action('user/requestnewpassword', true, $CONFIG->pluginspath . 'request_password/actions/requestnewpassword.php', false);
	register_action('user/password_reset',true,$CONFIG->pluginspath . 'request_password/actions/password_reset.php', false);
}
?>