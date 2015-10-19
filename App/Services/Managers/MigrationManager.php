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

	public function applyMigration($origin = null, $destination = null)
	{
		/*
		Goal is to migrate from A to B
		Eventually the application will be in version B
		So we need to find migrations between A and B, and apply upgrade() for each
		*/

		$migrations = [];
		$migrations[] = new \Splio\Appforge\Migrations\Migration_0000();

		foreach ($migrations as $migration)
		{
			// Log

			\z\logger()->notice('Applying migration ' . get_class($migration) . '...');

			
			//

			$migration->upgrade();
		}
	}
}

?>
