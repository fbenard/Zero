<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class ServiceFactory
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Factories\ServiceFactory
{
	/**
	 *
	 */
	
	public function buildService(string $serviceCode, array $definitions)
	{
		// Make sure the service has a definition

		if (array_key_exists($serviceCode, $definitions) === false)
		{
			throw new \fbenard\Zero\Exceptions\ServiceNotDefinedException
			(
				$serviceCode,
				$definitions
			);
		}


		// Get the definition

		$definition = $definitions[$serviceCode];


		// If the definition is an object
		// Return it as such

		if (is_object($definition) === true)
		{
			return $definition;
		}


		// Otherwise, it's a classname

		$className = $definition;


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


	/**
	 *
	 */

	public function loadDefinitions()
	{
		//

		$dependencies = \z\boot()->dependencies;
		
		
		//
		
		foreach ($dependencies as $dependency)
		{
			// Find services

			$fileHelper = new \fbenard\Zero\Services\Helpers\FileHelper();
			$paths = $fileHelper->listFiles($dependency . '/Config/Services', 'json');


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
