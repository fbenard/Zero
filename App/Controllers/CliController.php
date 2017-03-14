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

	public function actionCacheClear()
	{
		\z\cache()->clearCache();
	}


	/**
	 *
	 */

	public function actionMigrationApply($from = null, $to = null)
	{
		$this->getDependency('manager/migration')->applyMigration($from, $to);
	}
}

?>
