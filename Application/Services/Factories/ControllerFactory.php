<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class ControllerFactory
{
	/**
	 *
	 */
	
	public function buildController($controllerCode)
	{
		// Build the classname

		$className = $controllerCode;


		// Make sure the controller is instantiable
		
		$reflection = new \ReflectionClass($className);

		if ($reflection->isInstantiable() === false)
		{
			\z\e
			(
				EXCEPTION_CONTROLLER_NOT_INSTANTIABLE,
				[
					'controllerCode' => $controllerCode
				]
			);
		}


		// Create the controller
		
		$controller = new $className();


		return $controller;
	}
}

?>
