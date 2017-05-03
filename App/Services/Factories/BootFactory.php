<?php
	
// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class BootFactory
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Factories\BootFactory
{
	/**
	 *
	 */

	public function fixBoot($boot)
	{
		// Ensure boot is an array

		if (is_array($boot) === false)
		{
			$boot = [];
		}


		// Ensure boot has the expected structure

		$boot = array_merge
		(
			[
				'cache' => [],
				'dependencies' => [],
				'hosts' => [],
				'environment' => null
			],
			$boot
		);


		return $boot;
	}


	/**
	 *
	 */

	public function fixDependencies($dependencies)
	{
		// Ensure dependencies is an array

		if (is_array($dependencies) === false)
		{
			$dependencies = [];
		}


		//

		foreach ($dependencies as &$dependency)
		{
			$dependency = PATH_COMPONENTS . $dependency;
		}


		// Inject Zero and the application

		array_unshift($dependencies, PATH_ZERO);
		array_push($dependencies, PATH_APP);
		

		// De-duplicate dependencies

		$dependencies = array_unique($dependencies);


		return $dependencies;
	}
}

?>
