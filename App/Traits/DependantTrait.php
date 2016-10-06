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


		// Make sure dependencies is an array

		if (is_array($this->_dependencies) === false)
		{
			$this->_dependencies = [];
		}


		// Store the dependency

		$this->_dependencies[$dependencyCode] = $dependency;
	}
	}


	/**
	 *
	 */

	public function ejectDependency(string $dependencyCode)
	{
		// Check array key
		// Check interface
		//
		
		$this->_dependencies[$dependencyCode]->value = null;
	}


	/**
	 *
	 */

	public function getDependency(string $dependencyCode)
	{
		//

		if (array_key_exists($dependencyCode, $this->_dependencies) === false)
		{
			throw new \fbenard\Exceptions\DependencyNotFoundException();
		}


		//

		$dependency = $this->_dependencies[$dependencyCode];


		//

		if (is_null($dependency->value) === true)
		{
			$result = \z\service($dependencyCode);
		}
		else
		{
			$result = $dependency->value;
		}


		/*
		//

		$interfaces = class_implements($dependency->value);
		print_r($interfaces);


		//

		if (in_array($dependency->interface, $interfaces) === false)
		{
			throw new \fbenard\Exceptions\DependencyInterfaceNotValidException();
		}
		*/


		return $result;
	}


	/**
	 *
	 */

	public function injectDependency(string $dependencyCode, $dependencyValue)
	{
		// CHeck array key
		// Check interface
		//

		$this->_dependencies[$dependencyCode]->value = $dependencyValue;
	}
}

?>
