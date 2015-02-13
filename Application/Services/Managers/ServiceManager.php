<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ServiceManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	private $_definitions = null;
	private $_factory = null;
	private $_services = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_definitions = [];
		$this->_factory = new \fbenard\Zero\Services\Factories\ServiceFactory();
		$this->_services = [];
	}


	/**
	 *
	 */

	public function initialize()
	{
		//

		$dependencies = \z\boot()->dependencies;
		
		
		//
		
		foreach ($dependencies as $dependency)
		{
			// Find services

			$fileHelper = new \fbenard\Zero\Services\Helpers\FileHelper();
			$paths = $fileHelper->listFiles($dependency . 'Config/Services/', '*.json');


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


	/**
	 *
	 */
	
	public function getService($serviceCode = null)
	{
		// If no service code given, return service manager

		if (empty($serviceCode) === true)
		{
			return $this;
		}


		// Has the service been retrieved already?

		if (array_key_exists($serviceCode, $this->_services) === false)
		{
			// Build the service

			$service = $this->_factory->buildService
			(
				$serviceCode,
				$this->_definitions
			);


			// Store the service

			$this->_services[$serviceCode] = $service;
		}
		
		
		// Get the service

		$service = $this->_services[$serviceCode];


		return $service;
	}


	/**
	 *
	 */

	public function registerServices($services)
	{
		// Register each service provided

		foreach ($services as $serviceCode => $serviceClassName)
		{
			$this->_definitions[$serviceCode] = $serviceClassName;
		}
	}
}

?>
