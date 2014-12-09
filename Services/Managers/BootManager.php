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

		$this->_environment = 'prod';
		$this->_universe = null;


		
		// Get boot from Boot.json

		$pathToBoot = PATH_APPLICATION . 'Preferences/Boot.json';

		if (file_exists($pathToBoot) === true)
		{
			// Decode Boot.json

			$rawJson = file_get_contents($pathToBoot);
			$json = json_decode($rawJson, true);

			
			// Grab environment and universe

			if (array_key_exists('environment', $json) === true)
			{
				$this->_environment = $json['environment'];
			}

			if (array_key_exists('universe', $json) === true)
			{
				$this->_universe = $json['universe'];
			}
		}

		
		// Get boot from CLI

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


		// Make sure boot is valid

		if (empty($this->_environment) === true)
		{
			\z\e(EXCEPTION_ENVIRONMENT_NOT_VALID);
		}
	}
}


?>