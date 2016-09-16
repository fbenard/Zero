<?php

// Namespace

namespace fbenard\Zero\Traits;


/**
 *
 */

trait DependantTrait
{
	// Attributes

	private $_dependencies = null;


	/**
	 *
	 */

	public function defineDependencies(array $dependencies = null)
	{
		//

		$this->_dependencies = [];


		//

		foreach ($dependencies as $dependencyCode => $interfaceCode)
		{
			$this->_dependencies[$dependencyCode] = new \fbenard\Zero\Classes\Dependency
			(
				$interfaceCode
			);
		}
	}


	/**
	 *
	 */

	public function ejectDependency(string $dependencyCode)
	{
		// CHeck array key
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
