<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class PreferenceManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes
	
	private $_preferences = null;
		
	
	/**
	 *
	 */
	
	public function __construct()
	{
		$this->_preferences = [];
	}
	
	
	/**
	 *
	 */
	
	public function getPreference($preferenceCode)
	{
		//

		if
		(
			(array_key_exists($preferenceCode, $this->_preferences) === false) ||
			(is_array($this->_preferences[$preferenceCode]) === false) ||
			(array_key_exists('value', $this->_preferences[$preferenceCode]) === false)
		)
		{
			return;
		}
		
		
		//

		$result = $this->_preferences[$preferenceCode]['value'];


		return $result;
	}
	
	
	/**
	 *
	 */
	
	public function initialize()
	{
		// Load preferences

		$this->loadPreferences();
	}


	/**
	 *
	 */

	private function loadPreferences()
	{
		// Get the cache

		$cacheCode = 'preferences_' . \z\boot()->environment . '_' . \z\boot()->universe;
		$cache = \z\cache()->getCache($cacheCode);

		if ($cache !== false)
		{
			$this->_preferences = unserialize($cache);
			return;
		}


		// Define the number of passes
		
		$dependencies = \z\boot()->dependencies;
		$nbPasses = count($dependencies) - 1;


		// Perform n passes
		
		for ($i = 0; $i < $nbPasses; $i++)
		{
			foreach ($dependencies as $dependency)
			{
				// Prepare global path

				$path = $dependency . 'Config/Preferences/Preferences';


				// Build paths
			
				$paths =
				[
					$path . '.php',
					$path . '.' . \z\boot()->environment . '.php',
					$path . '.' . \z\boot()->universe . '.php',
					$path . '.' . \z\boot()->environment . '.' . \z\boot()->universe . '.php'
				];

				
				// Load each path

				foreach ($paths as $path)
				{
					if (file_exists($path) === true)
					{
						require($path);
					}
				}
			}
			
			
			// End of pass, remove the first extension
			
			array_shift($dependencies);
		}


		// Set the cache

		\z\cache()->setCache
		(
			$cacheCode,
			serialize($this->_preferences)
		);
	}
	
	
	/**
	 *
	 */
	
	public function setPreference($preferenceCode, $preferenceValue, $isLocked = false)
	{
		//

		if
		(
			(array_key_exists($preferenceCode, $this->_preferences) === true) &&
			(is_array($this->_preferences[$preferenceCode]) === true) &&
			(array_key_exists('isLocked', $this->_preferences[$preferenceCode]) === true) &&
			($this->_preferences[$preferenceCode]['isLocked'] === true)
		)
		{
			return;
		}


		// Handle PRE special cases

		if ($preferenceCode === 'fbenard/zero/localization/language')
		{
			setlocale(LC_ALL, $preferenceValue);
		}
		else if ($preferenceCode === 'fbenard/zero/localization/timezone')
		{
			date_default_timezone_set($preferenceValue);
		}

		
		// Set the preference
		
		$this->_preferences[$preferenceCode] =
		[
			'value' => $preferenceValue,
			'isLocked' => $isLocked
		];
	}
}

?>
