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
			\z\e
			(
				EXCEPTION_SERVICE_NOT_FOUND,
				[
					'serviceCode' => $serviceCode,
					'definitions' => $definitions
				]
			);
		}


		//

		$className = $definitions[$serviceCode];


		//
		
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
