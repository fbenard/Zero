<?php
	
// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class BootManager
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Managers\BootManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes

	private $_cache = null;
	private $_dependencies = null;
	private $_environment = null;


	/**
	 *
	 */

	private function fixBoot($boot)
	{
		// Ensure boot is an array

		if (is_array($boot) === false)
		{
			$boot = [];
		}


		// Ensure boot has the expected structure

		$boot = array_merge
		(
			[
				'cache' => [],
				'dependencies' => [],
				'hosts' => [],
				'environment' => null
			],
			$boot
		);


		return $boot;
	}


	/**
	 *
	 */

	private function fixDependencies($dependencies)
	{
		// Ensure dependencies is an array

		if (is_array($dependencies) === false)
		{
			$dependencies = [];
		}


		//

		foreach ($dependencies as &$dependency)
		{
			$dependency = PATH_COMPONENTS . $dependency;
		}


		// Inject Zero and the application

		array_unshift($dependencies, PATH_ZERO);
		array_push($dependencies, PATH_APP);
		

		// De-duplicate dependencies

		$dependencies = array_unique($dependencies);


		return $dependencies;
	}


	/**
	 *
	 */

	public function initialize()
	{
		// Load boot

		$boot = $this->loadBoot();


		// Build attributes

		$this->_cache = $boot['cache'];
		$this->_dependencies = $boot['dependencies'];
		$this->_environment = $boot['environment'];


		// Fix dependencies

		$this->_dependencies = $this->fixDependencies($this->_dependencies);


		// Are we in CLI mode?

		if (\z\app()->isCli() === true)
		{
			// Grab environment
			
			$request = new \fbenard\Zero\Classes\Request();

			$environment = $request->argument('env');


			// Store environment

			if (empty($environment) === false)
			{
				$this->_environment = $environment;
			}
		}
		else if
		(
			(array_key_exists('hosts', $boot) === true) &&
			(array_key_exists($_SERVER['SERVER_NAME'], $boot['hosts']) === true)
		)
		{
			// Grab the host

			$host = $boot['hosts'][$_SERVER['SERVER_NAME']];


			// Grab environment

			if (array_key_exists('environment', $host) === true)
			{
				$this->_environment = $host['environment'];
			}
		}
	}


	/**
	 *
	 */

	private function loadBoot()
	{
		// Load Boot.json

		$boot = null;
		$pathToBoot = PATH_APP . '/Config/Boot.json';

		if (file_exists($pathToBoot) === true)
		{
			// Decode Boot.json

			$rawBoot = file_get_contents($pathToBoot);
			$boot = json_decode($rawBoot, true);
		}


		// Fix boot

		$boot = $this->fixBoot($boot);


		return $boot;
	}
}

?>
