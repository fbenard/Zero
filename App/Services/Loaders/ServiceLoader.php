<?php

// Namespace

namespace fbenard\Zero\Services\Loaders;


/**
 *
 */

class ServiceLoader
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Loaders\ServiceLoader
{
	/**
	 *
	 */

	public function loadServices(array $dependencies)
	{
		// Parse each dependency
		
		foreach ($dependencies as $dependency)
		{
			// Find services

			$paths = $this->getDependency('helper/file')->listFiles($dependency . '/Config/Services', 'json');


			// For each service

			foreach ($paths as $path)
			{
				// Load definitions

				$rawDefinitions = file_get_contents($path);
				$definitions = json_decode($rawDefinitions, true);


				// Register services

				$this->registerServices($definitions);
			}
		}
	}
}

?>
