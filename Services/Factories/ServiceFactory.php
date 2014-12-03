<?php

// Namespace

namespace Zero\Services\Factories;


/**
 *
 */

class ServiceFactory
{
	/**
	 *
	 */
	
	public function buildService($serviceCode, $definitions)
	{
		//

		if (array_key_exists($serviceCode, $definitions) === false)
		{
			e(EXCEPTION_SERVICE_NOT_FOUND);
		}


		//

		$definition = $definitions[$serviceCode];

		
		//

		$path = PATH_ROOT . $definition['path'] . '.php';
		$className = $definition['classname'];


		//
		
		$reflection = new \ReflectionClass($className);

		if ($reflection->isInstantiable() === false)
		{
			e(EXCEPTION_SERVICE_NOT_FOUND);
		}


		// Create the service
		
		$service = new $className();


		return $service;
	}
}

?>
