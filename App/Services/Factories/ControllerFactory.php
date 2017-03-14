<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class ControllerFactory
extends \fbenard\Zero\Classes\AbstractService
{
	/**
	 *
	 */
	
	public function buildController($controllerCode)
	{
		// Build the class name

		$className = $controllerCode;


		// Make sure the class exists

		if (class_exists($className) === false)
		{
			// Throw a ControllerNotFound exception

			throw new \fbenard\Zero\Exceptions\ControllerNotFoundException
			(
				$controllerCode
			);
		}


		// Make sure the class is instantiable
		
		$reflection = new \ReflectionClass($className);

		if ($reflection->isInstantiable() === false)
		{
			// Throw a ControllerNotInstantiable exception
			
			throw new \fbenard\Zero\Exceptions\ControllerNotInstantiableException
			(
				$controllerCode
			);
		}


		// Create the controller
		
		$controller = new $className();


		return $controller;
	}
}

?>
