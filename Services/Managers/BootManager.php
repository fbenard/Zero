<?php
	
// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class BootManager
{
	// Attributes

	public $_environment = null;
	public $_universe = null;


	/**
	 *
	 */

	public function initialize()
	{
		// Default boot

		$this->_environment = null;
		$this->_universe = null;

		
		// Get boot from Boot.json

		$pathToBoot = PATH_APPLICATION . 'Preferences/Boot.json';
		$boot = [];

		if (file_exists($pathToBoot) === true)
		{
			// Decode Boot.json

			$rawBoot = file_get_contents($pathToBoot);
			$boot = json_decode($rawBoot, true);

			
			// Grab environment and universe

			if (array_key_exists('environment', $boot) === true)
			{
				$this->_environment = $boot['environment'];
			}

			if (array_key_exists('universe', $boot) === true)
			{
				$this->_universe = $boot['universe'];
			}
		}


		// Are we in CLI mode?

		if (\z\app()->isRunningCli() === true)
		{
			// Extract arguments

			global $argv;
			$options = [];

			foreach ($argv as $arg)
			{
				//

				$pattern = '/^\-\-([a-z]*)=(.*)$/';

				if (preg_match($pattern, $arg, $matches) !== 1)
				{
					continue;
				}

				
				//

				$options[$matches[1]] = $matches[2];
			}


			// Grab environment and universe

			if (array_key_exists('environment', $options) === true)
			{
				$this->_environment = $options['environment'];
			}

			if (array_key_exists('universe', $options) === true)
			{
				$this->_universe = $options['universe'];
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
}


?>