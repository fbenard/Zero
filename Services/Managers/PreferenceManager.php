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

	public function addPreferenceValue($preferenceCode, $preferenceValue, $isAppended = true, $isLocked = false)
	{
		//

		$currentPreferenceValue = $this->getPreferenceValue($preferenceCode);

		
		//

		if (is_null($currentPreferenceValue) === true)
		{
			$currentPreferenceValue = array();
		}


		//

		if (is_array($currentPreferenceValue) === false)
		{
			e
			(
				EXCEPTION_PREFERENCE_NOT_AN_ARRAY,
				array
				(
					'preferenceCode' => $preferenceCode,
					'preferenceValue' => $currentPreferenceValue
				)
			);
		}


		//

		if (in_array($preferenceValue, $currentPreferenceValue) === true)
		{
			return;
		}


		//

		if ($isAppended === true)
		{
			array_push($currentPreferenceValue, $preferenceValue);
		}
		else
		{
			array_unshift($currentPreferenceValue, $preferenceValue);
		}


		//

		$this->setPreferenceValue($preferenceCode, $currentPreferenceValue, $isLocked);
	}
	
	
	/**
	 *
	 */
	
	private function getPreference($preferenceCode)
	{
		// Have we defined this preference?
		
		if (array_key_exists($preferenceCode, $this->_preferences) === false)
		{
			return;
		}
		
		
		// Get a reference to the preference
		
		$preference = &$this->_preferences[$preferenceCode];
		
		
		return $preference;
	}
	
	
	/**
	 *
	 */
	
	public function getPreferenceValue($preferenceCode)
	{
		// Have we defined this preference?
		
		$preference = $this->getPreference($preferenceCode);
		
		
		//

		if
		(
			(is_array($preference) === false) ||
			(array_key_exists('value', $preference) === false)
		)
		{
			return;
		}
		
		
		return $preference['value'];
	}
	
	
	/**
	 * Initializes the preference manager
	 *
	 * @param	array	$pathsToExtensions 	Paths to extensions
	 */
	
	public function initialize()
	{
		//

		$pathsToExtensions =
		[
			PATH_ZERO,
			PATH_APPLICATION
		];
		
		
		// Define the number of passes
		
		$nbPasses = count($pathsToExtensions) - 1;


		// Perform n passes
		
		for ($i = 0; $i < $nbPasses; $i++)
		{
			// Load main preferences first
			
			foreach ($pathsToExtensions as $pathToExtension)
			{
				$this->loadPreferences($pathToExtension, false);
			}
			
			
			// Parse all extensions for environment-specific preferences
			
			foreach ($pathsToExtensions as $pathToExtension)
			{
				$this->loadPreferences($pathToExtension, true);
			}
			
			
			// Make sure we remove the first extension, this ensures we progressively eliminate extensions as passes go
			
			array_shift($pathsToExtensions);
		}
	}
	

	/**
	 *
	 */

	public function loadPreferences($pathToExtension, $useEnvironmentName = false)
	{
		// Prepare standard path

		$pathToPreference = $pathToExtension . 'Preferences/Preferences';


		// Add environment if necessary

		if ($useEnvironmentName === true)
		{
			$pathToPreference .= '.' . service('manager/environment')->_environment;
		}


		// Add universe, if any

		$universe = service('manager/universe')->_universe;

		if (empty($universe) === false)
		{
			// Load Preferences.Environment.Universe.php
			
			if (file_exists($pathToPreference . '.' . $universe . '.php') === true)
			{
				require($pathToPreference . '.' . $universe . '.php');
			}
		}
		
		
		// Load Preferences.Environment.php
	
		if (file_exists($pathToPreference . '.php') === true)
		{
			require($pathToPreference . '.php');
		}
	}
	
	
	/**
	 *
	 */
	
	public function setPreferenceValue($preferenceCode, $preferenceValue, $isLocked = false)
	{
		//
		
		$preference = $this->getPreference($preferenceCode);
		
		

		//

		if
		(
			(is_array($preference) === true) &&
			(array_key_exists('isLocked', $preference) === true) &&
			($preference['isLocked'] === true)
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

		
		// Set the preference value
		
		$this->_preferences[$preferenceCode] = array();
		$this->_preferences[$preferenceCode]['value'] = $preferenceValue;
		$this->_preferences[$preferenceCode]['isLocked'] = $isLocked;
	}
}

?>
