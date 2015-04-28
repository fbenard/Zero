<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class CultureManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes
	
	private $_fallback = null;
	private $_locale = null;
	private $_strings = null;
		
	
	/**
	 *
	 */
	
	public function __construct()
	{
		$this->_strings = [];
	}
	
	
	/**
	 *
	 */

	public function getString($stringCode, $stringArguments = null)
	{
		// Build locales

		$locales =
		[
			$this->_locale,
			$this->_fallback
		];


		// Try to get the locale string

		$result = $stringCode;

		foreach ($locales as $localeCode)
		{
			// Does the locale have a string?

			if
			(
				(array_key_exists($localeCode, $this->_strings) === true) &&
				(is_array($this->_strings[$localeCode]) === true) &&
				(array_key_exists($stringCode, $this->_strings[$localeCode]) === true)
			)
			{
				// Yes, grab the string

				$result = $this->_strings[$localeCode][$stringCode];


				// We're done

				break;
			}
		}


		// Parse each string argument

		if (is_array($stringArguments) === true)
		{
			foreach ($stringArguments as $key => $value)
			{
				// Inject the argument value

				str_replace('{' . $key . '}', $value, $result);
			}
		}


		return $result;
	}


	/**
	 *
	 */

	public function initialize()
	{
		// Define locale and fallback

		$this->_locale = locale_accept_from_http(\z\request()->header('Accept-Language'));
		$this->_fallback = \z\pref('fbenard/zero/culture/locale/fallback');


		// Load strings

		$this->loadStrings();
	}


	/**
	 *
	 */

	private function loadStrings()
	{
		// Get the cache

		$cacheCode = 'strings_' . $this->_locale . '_' . $this->_fallback;
		$cache = \z\cache()->getCache($cacheCode);

		if ($cache !== false)
		{
			$this->_strings = unserialize($cache);
			return;
		}


		// Build locales

		$locales =
		[
			$this->_locale,
			$this->_fallback
		];

		
		// Parse each locale

		foreach ($locales as $localeCode)
		{
			// Build an array for the locale

			$this->_strings[$localeCode] = [];

			
			// List string files for this locale

			$paths = \z\service('helper/file')->listFiles(PATH_APPLICATION . 'Config/Strings/' . $localeCode . '/');
			

			// Parse each string file

			foreach ($paths as $path)
			{
				// Load the string file

				$rawStrings = file_get_contents($path);
				$strings = json_decode($rawStrings, true);


				// Store the strings

				$this->_strings[$localeCode] = array_merge
				(
					$this->_strings[$localeCode],
					$strings
				);
			}
		}


		// Set the cache

		\z\cache()->setCache
		(
			$cacheCode,
			serialize($this->_strings)
		);
	}
}

?>
