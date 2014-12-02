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
		//

		$paths =
		[
			PATH_ZERO,
			PATH_APPLICATION
		];
		
		
		//
		
		foreach ($paths as $path)
		{
			$pathToDefinitions = $path . 'Preferences/Services.json';

			if (file_exists($pathToDefinitions) === false)
			{
				continue;
			}

			$rawDefinitions = file_get_contents($pathToDefinitions);
			$definitions = json_decode($rawDefinitions, true);

			$this->_definitions = array_merge
			(
				$this->_definitions,
				$definitions
			);
		}
	}


	/**
	 *
	 */
	
	public function getService($serviceCode)
	{
		//

		if (array_key_exists($serviceCode, $this->_services) === false)
		{
			//

			if (array_key_exists($serviceCode, $this->_definitions) === false)
			{
				e(EXCEPTION_SERVICE_NOT_FOUND);
			}


			//

			$definition = $this->_definitions[$serviceCode];

			
			//

			$path = PATH_ROOT . $definition['path'] . '.php';
			$className = $definition['classname'];


			//

			if (file_exists($path) === false)
			{
				e(EXCEPTION_SERVICE_NOT_FOUND);
			}
			
			
			//
			
			require_once($path);


			// Create the service
			
			$this->_services[$serviceCode] = new $className();
		}
		
		
		return $this->_services[$serviceCode];
	}
}

?>
