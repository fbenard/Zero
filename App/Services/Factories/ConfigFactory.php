<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class ConfigFactory
extends \fbenard\Zero\Classes\AbstractService
{
	/**
	 *
	 */

	public function fixConfig($config, $defaultConfig = null)
	{
		// Make sure config and default config are arrays

		if (is_array($config) === false)
		{
			$config = [];
		}

		if (is_array($defaultConfig) === false)
		{
			$defaultConfig = [];
		}

		
		// Fix the config

		foreach ($defaultConfig as $key => $value)
		{
			// Does the default key exist already?

			if (array_key_exists($key, $config) === false)
			{
				// No it doesn't
				// Create it

				if (is_array($value) === true)
				{
					$config[$key] = [];
				}
				else
				{
					$config[$key] = $value;
				}
			}


			// Is the key an array?
			// Should we fill it in?

			if
			(
				(is_array($value) === true) &&
				(count($value) > 0) &&
				(is_array($config[$key]) === true)
			)
			{
				// Fix each existing entry with the default config
				
				foreach ($config[$key] as &$subConfig)
				{
					$subConfig = $this->fixConfig($subConfig, $value);
				}
			}
		}


		return $config;
	}


	/**
	 *
	 */

	public function loadConfig($pathToConfig, $defaultConfig = null)
	{
		// Load the config

		$config = [];

		if (file_exists($pathToConfig) === true)
		{
			$config = file_get_contents($pathToConfig);
			$config = json_decode($config, true);
		}


		// Fix the config

		$config = $this->fixConfig($config, $defaultConfig);


		return $config;
	}
}

?>
