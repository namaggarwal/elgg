<?php

	/**
	 * Elgg .htaccess not found message
	 * Is saved to the errors register when the main .htaccess cannot be found
	 * 
	 * @package Elgg
	 * @subpackage Core

	 * @author Curverider Ltd

	 * @link http://elgg.org/
	 */

	echo autop(elgg_echo('installation:error:htaccess'));
?>
<textarea cols="120" rows="30"><?php echo $vars['.htaccess']; ?></textarea>