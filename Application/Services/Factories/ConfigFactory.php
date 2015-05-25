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

		$config = array_merge($defaultConfig, $config);


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
