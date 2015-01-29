<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


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
		// Make sure the service has a definition

		if (array_key_exists($serviceCode, $definitions) === false)
		{
			\z\e
			(
				EXCEPTION_SERVICE_NOT_FOUND,
				[
					'serviceCode' => $serviceCode,
					'definitions' => $definitions
				]
			);
		}


		// Build the classname

		$className = $definitions[$serviceCode];


		// Make sure the service is instantiable
		
		$reflection = new \ReflectionClass($className);

		if ($reflection->isInstantiable() === false)
		{
			\z\e
			(
				EXCEPTION_SERVICE_NOT_INSTANTIABLE,
				[
					'serviceCode' => $serviceCode,
					'definitions' => $definitions
				]
			);
		}


		// Create the service
		
		$service = new $className();


		return $service;
	}
}

?>
