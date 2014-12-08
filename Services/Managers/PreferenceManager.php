<?php

// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class PreferenceManager
{
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
		//

		$pathToExtensions =
		[
			PATH_ZERO,
			PATH_APPLICATION
		];

		
		// Define the number of passes
		
		$nbPasses = count($pathToExtensions) - 1;


		// Perform n passes
		
		for ($i = 0; $i < $nbPasses; $i++)
		{
			foreach ($pathToExtensions as $pathToExtension)
			{
				// Prepare global path

				$path = $pathToExtension . 'Preferences/Preferences';


				// Build paths
			
				$paths =
				[
					$path . '.php',
					$path . '.' . \z\service('manager/environment')->_environment . '.php',
					$path . '.' . \z\service('manager/universe')->_universe . '.php',
					$path . '.' . \z\service('manager/environment')->_environment . '.' . \z\service('manager/universe')->_universe . '.php'
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
			
			array_shift($pathToExtensions);
		}
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
