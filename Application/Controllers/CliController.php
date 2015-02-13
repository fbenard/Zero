<?php

// Namespace

namespace fbenard\Zero\Controllers;


/**
 *
 */

class CliController
extends \fbenard\Zero\Classes\AbstractController
{
	/**
	 *
	 */

	public function action_cache_clear()
	{
		\z\cache()->clear();
	}
}

?>
