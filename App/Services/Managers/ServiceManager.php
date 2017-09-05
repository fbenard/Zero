<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ServiceManager
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Managers\ServiceManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes

	private $_definitions = null;
	private $_services = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build attributes

		$this->_definitions = [];
		$this->_services = [];

		
		// Define dependencies

		$this->defineDependency('manager/boot', 'fbenard\Zero\Interfaces\Managers\BootManager');
		$this->defineDependency('factory/service', 'fbenard\Zero\Interfaces\Factories\ServiceFactory');


		// Inject dependencies

		$this->injectDependency
		(
			'factory/service',
			new \fbenard\Zero\Services\Factories\ServiceFactory()
		);
	}


	/**
	 *
	 */

	public function deregisterServices(array $services)
	{
		// Fix services

		if (is_array($services) === false)
		{
			$services = [];
		}

		
		// Parse each service

		foreach ($services as $serviceCode)
		{
			// Is the service registered?

			if (array_key_exists($serviceCode, $this->_definitions) === true)
			{
				// De-register the service

				unset($this->_definitions[$serviceCode]);
			}
		}
	}


	/**
	 *
	 */
	
	public function getService(string $serviceCode, bool $clone = false)
	{
		// Clone the service

		if ($clone === true)
		{
			// Build the service

			$service = $this->getDependency('factory/service')->buildService
			(
				$serviceCode,
				$this->_definitions
			);


			// Return the service
			// Without storing it

			return $service;
		}

		
		// Does the service need to be built?

		if (array_key_exists($serviceCode, $this->_services) === false)
		{
			// Build the service

			$service = $this->getDependency('factory/service')->buildService
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

	public function initialize()
	{
		// Load services

		$this->_definitions = $this->getDependency('loader/service')->loadServices();
	}


	/**
	 *
	 */

	public function registerServices(array $services)
	{
		// Fix services

		if (is_array($services) === false)
		{
			$services = [];
		}

		
		// Parse each service

		foreach ($services as $serviceCode => $serviceClassName)
		{
			// Register the service

			$this->_definitions[$serviceCode] = $serviceClassName;
		}
	}
}

?>
