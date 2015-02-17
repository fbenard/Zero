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


	/**
	 *
	 */

	public function action_migration_apply($from, $to)
	{
		\z\service('manager/migration')->apply($from, $to);
	}
}

?>
