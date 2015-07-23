<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ServiceManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
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
		// Load definitions

		$this->loadDefinitions();
	}


	/**
	 *
	 */

	private function loadDefinitions()
	{
		// Get the cache

		$cacheCode = 'services_' . \z\boot()->environment . '_' . \z\boot()->universe;
		$cache = \z\cache()->getCache($cacheCode);

		if ($cache !== false)
		{
			$this->_definitions = unserialize($cache);
			return;
		}


		//

		$dependencies = \z\boot()->dependencies;
		
		
		//
		
		foreach ($dependencies as $dependency)
		{
			// Find services

			$fileHelper = new \fbenard\Zero\Services\Helpers\FileHelper();
			$paths = $fileHelper->listFiles($dependency . '/Config/Services', 'json');
			print_r($paths);


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


		// Set the cache

		\z\cache()->setCache
		(
			$cacheCode,
			serialize($this->_definitions)
		);
	}


	/**
	 *
	 */
	
	public function getService($serviceCode, $clone = false)
	{
		// Clone the service

		if ($clone === true)
		{
			return $this->_factory->buildService
			(
				$serviceCode,
				$this->_definitions
			);
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
		// Ensure services is an array

		if (is_array($services) === false)
		{
			$services = [];
		}

		
		// Register each service provided

		foreach ($services as $serviceCode => $serviceClassName)
		{
			$this->_definitions[$serviceCode] = $serviceClassName;
		}
	}
}

?>
