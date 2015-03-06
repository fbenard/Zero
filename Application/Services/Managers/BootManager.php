<?php
	
// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class BootManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	private $_dependencies = null;
	private $_environment = null;
	private $_universe = null;


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
				'dependencies' => [],
				'hosts' => [],
				'environment' => null,
				'universe' => null,
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
		array_push($dependencies, PATH_APPLICATION);
		

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

		$this->_dependencies = $boot['dependencies'];
		$this->_environment = $boot['environment'];
		$this->_universe = $boot['universe'];


		// Fix dependencies

		$this->_dependencies = $this->fixDependencies($this->_dependencies);


		// Are we in CLI mode?

		if (\z\app()->isCli() === true)
		{
			// Extract arguments

			$arguments = [];

			if
			(
				(array_key_exists('argv', $GLOBALS) === true) &&
				(is_array($GLOBALS['argv']) === true)
			)
			{
				// Parse each argument

				foreach ($GLOBALS['argv'] as $arg)
				{
					// Try to find the pattern --arg="value"

					$pattern = '/^\-\-([a-z]*)=(.*)$/';

					if (preg_match($pattern, $arg, $matches) !== 1)
					{
						continue;
					}


					// Store the argument

					$arguments[$matches[1]] = $matches[2];
				}
			}


			// Grab environment and universe

			if (array_key_exists('env', $arguments) === true)
			{
				$this->_environment = $arguments['env'];
			}

			if (array_key_exists('universe', $arguments) === true)
			{
				$this->_universe = $arguments['universe'];
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


			// Grab environment and universe

			if (array_key_exists('environment', $host) === true)
			{
				$this->_environment = $host['environment'];
			}

			if (array_key_exists('universe', $host) === true)
			{
				$this->_universe = $host['universe'];
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
		$pathToBoot = PATH_APPLICATION . 'Config/Boot.json';

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
