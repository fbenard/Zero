<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class ConfigFactory
{
	/**
	 *
	 */

	public function fixConfig($config, $defaultConfig = null, $mapping = null)
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

		$config = array_merge($defaultConfig, $config);


		// Map the config

		$config = $this->mapConfig($config, $mapping);


		return $config;
	}


	/**
	 *
	 */

	public function loadConfig($pathToConfig, $defaultConfig = null, $mapping = null)
	{
		// Load the config

		$config = [];

		if (file_exists($pathToConfig) === true)
		{
			$config = file_get_contents($pathToConfig);
			$config = json_decode($config, true);
		}


		// Fix the config

		$config = $this->fixConfig($config, $defaultConfig, $mapping);


		return $config;
	}


	/**
	 *
	 */

	public function mapConfig($config, $mapping)
	{
		// Make sure mapping is an array

		if (is_array($mapping) === false)
		{
			$mapping = [];
		}
		

		// Build the result

		$result = [];

		
		// Parse each config

		foreach ($config as $key => $value)
		{
			// Map the config
			
			if (array_key_exists($key, $mapping) === true)
			{
				$result[$mapping[$key]] = $value;
			}
			else
			{
				$result[$key] = $value;
			}
		}


		return $result;
	}
}

?>
