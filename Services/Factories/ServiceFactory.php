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
			\z\e(EXCEPTION_SERVICE_NOT_FOUND);
		}


		//

		$className = $definitions[$serviceCode];


		//
		
		$reflection = new \ReflectionClass($className);

		if ($reflection->isInstantiable() === false)
		{
			\z\e(EXCEPTION_SERVICE_NOT_FOUND);
		}


		// Create the service
		
		$service = new $className();


		return $service;
	}
}

?>
