<?php

// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class ServiceManager
{
	// Attributes

	private $_definitions = null;
	private $_services = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_definitions = [];
		$this->_services = [];
	}


	/**
	 *
	 */

	public function initialize()
	{
		// Define paths

		$paths =
		[
			PATH_ZERO,
			PATH_APPLICATION
		];
		
		
		// For each path
		
		foreach ($paths as $path)
		{
			// Find services

			$fileHelper = new \Zero\Services\Helpers\FileHelper();
			$pathToServices = $fileHelper->listFiles($path . 'Preferences/Services/', '*.json');


			// For each service

			foreach ($pathToServices as $pathToService)
			{
				// Load definitions

				$rawDefinitions = file_get_contents($pathToService);
				$definitions = json_decode($rawDefinitions, true);

				
				// Store definitions

				$this->_definitions = array_merge
				(
					$this->_definitions,
					$definitions
				);
			}
		}
	}


	/**
	 *
	 */
	
	public function getService($serviceCode = null)
	{
		//

		if (array_key_exists($serviceCode, $this->_services) === false)
		{
			//

			$factory = new \Zero\Services\Factories\ServiceFactory();


			//

			$this->_services[$serviceCode] = $factory->buildService
			(
				$serviceCode,
				$this->_definitions
			);
		}
		
		
		return $this->_services[$serviceCode];
	}


	/**
	 *
	 */

	public function registerServices($services)
	{
		foreach ($services as $serviceCode => $serviceClassName)
		{
			$this->_definitions[$serviceCode] = $serviceClassName;
		}
	}
}

?>
