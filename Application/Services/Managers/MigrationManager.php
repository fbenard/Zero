<?php
	
// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class MigrationManager
{
	/**
	 *
	 */

	public function applyMigration($from = null, $to = null)
	{
		/*
		Goal is to migrate from A to B
		Eventually the application will be in version B
		So we need to find migrations between A and B, and apply upgrade() for each
		*/

		$migrations = [];
		$migrations[] = new \Splio\Goloboard\Migrations\Migration_0000();

		foreach ($migrations as $migration)
		{
			$migration->upgrade();
		}
	}
}

?>
