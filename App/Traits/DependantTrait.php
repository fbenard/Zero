<?php

// Namespace

namespace fbenard\Zero\Traits;


/**
 *
 */

trait DependantTrait
{
	// Attributes

	private $_dependencies = [];


	/**
	 *
	 */

	public function defineDependency(string $dependencyCode, string $interfaceCode)
	{
		// Create the dependency

		$dependency = new \fbenard\Zero\Classes\Dependency($interfaceCode);


		// Store the dependency

		$this->_dependencies[$dependencyCode] = $dependency;
	}


	/**
	 *
	 */

	public function checkDependencyCode(string $dependencyCode)
	{	
		// Check whether dependency code exists

		if (array_key_exists($dependencyCode, $this->_dependencies) === false)
		{
			throw new \fbenard\Zero\Exceptions\DependencyNotFoundException
			(
				$dependencyCode
			);
		}
	}


	/**
	 *
	 */

	public function checkDependencyValue(string $dependencyInterface, $dependencyValue)
	{	
		// Get interfaces implemented by the dependency

		$interfaces = class_implements($dependencyValue);


		// Check whether the interface is indeed implemented

		if (in_array($dependencyInterface, $interfaces) === false)
		{
			throw new \fbenard\Zero\Exceptions\DependencyInterfaceNotValidException
			(
				$dependencyInterface,
				$dependencyValue
			);
		}
	}


	/**
	 *
	 */

	public function ejectDependency(string $dependencyCode)
	{
		// Check dependency code

		$this->checkDependencyCode($dependencyCode);


		// Free the dependency
		
		$this->_dependencies[$dependencyCode]->value = null;
	}


	/**
	 *
	 */

	public function getDependency(string $dependencyCode)
	{
		// Check dependency code

		$this->checkDependencyCode($dependencyCode);


		// Get the dependency

		$dependency = $this->_dependencies[$dependencyCode];


		// Does the dependency have a value?

		if (is_null($dependency->value) === true)
		{
			// No, use the corresponding global service

			$result = \z\service($dependencyCode);
		}
		else
		{
			// Yes, use the dependency value

			$result = $dependency->value;
		}


		return $result;
	}


	/**
	 *
	 */

	public function injectDependency(string $dependencyCode, $dependencyValue)
	{
		// Check dependency code

		$this->checkDependencyCode($dependencyCode);


		// Get the dependency

		$dependency = $this->_dependencies[$dependencyCode];


		// Check dependency value

		$this->checkDependencyValue($dependency->interface, $dependencyValue);


		// Store the dependency value

		$dependency->value = $dependencyValue;


		// Store the dependency

		$this->_dependencies[$dependencyCode] = $dependency;
	}
}

?>
