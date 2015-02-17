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


		// Build the class name

		$className = $definitions[$serviceCode];


		// Make sure the class exists

		if (class_exists($className) === false)
		{
			\z\e
			(
				EXCEPTION_SERVICE_NOT_FOUND,
				[
					'serviceCode' => $serviceCode,
					'className' => $className
				]
			);
		}


		// Make sure the class is instantiable
		
		$reflection = new \ReflectionClass($className);

		if ($reflection->isInstantiable() === false)
		{
			\z\e
			(
				EXCEPTION_SERVICE_NOT_INSTANTIABLE,
				[
					'serviceCode' => $serviceCode,
					'className' => $className
				]
			);
		}


		// Create the service
		
		$service = new $className();


		return $service;
	}
}

?>
