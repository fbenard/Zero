<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class PreferenceManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
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

		if (array_key_exists($preferenceCode, $this->_preferences) === false)
		{
			return;
		}
		
		
		//

		$result = $this->_preferences[$preferenceCode];


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

		$cacheCode = 'preferences_' . \z\boot()->environment;
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
				// List preferences

				$paths = array_merge
				(
					\z\service('helper/file')->listFiles($dependency . '/Config/Preferences', 'json'),
					\z\service('helper/file')->listFiles($dependency . '/Config/Preferences/' . \z\boot()->environment, 'json')
				);

				
				// Parse each path

				foreach ($paths as $path)
				{
					// Build the preference code

					$parentPreferenceCode = strtolower(basename($path, '.json'));


					// Load preferences

					$preferences = \z\service('factory/json')->loadJson($path);


					// Store preferences

					foreach ($preferences as $preferenceCode => $preferenceValue)
					{
						// Build the new preference code

						$preferenceCode = $parentPreferenceCode . '/' . $preferenceCode;


						// Get the previous preference value

						$oldPreferenceValue = \z\pref($preferenceCode);


						// Is it an array?

						if (is_array($oldPreferenceValue) === true)
						{
							// Merge the old + the new

							$preferenceValue = array_merge
							(
								$oldPreferenceValue,
								$preferenceValue
							);
						}


						// Set the preference

						\z\pref
						(
							$preferenceCode,
							$preferenceValue
						);
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
	
	public function setPreference($preferenceCode, $preferenceValue)
	{
		// Handle PRE special cases

		if ($preferenceCode === 'culture/locale')
		{
			setlocale(LC_ALL, $preferenceValue);
		}
		else if ($preferenceCode === 'culture/timezone')
		{
			date_default_timezone_set($preferenceValue);
		}

		
		// Set the preference
		
		$this->_preferences[$preferenceCode] = $preferenceValue;
	}
}

?>
