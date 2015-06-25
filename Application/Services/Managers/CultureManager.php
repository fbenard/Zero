<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class CultureManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes
	
	private $_fallbackCode = null;
	private $_localeCode = null;
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
			$this->_localeCode,
			$this->_fallbackCode
		];


		// Try to get the locale string

		$result = $stringCode;

		foreach ($locales as $localeCode)
		{
			// Fix the locale code

			$localeCode = strval($localeCode);


			// Does the locale have a string?

			if
			(
				(array_key_exists($localeCode, $this->_strings) === true) &&
				(is_array($this->_strings[$localeCode]) === true) &&
				(array_key_exists($stringCode, $this->_strings[$localeCode]) === true) &&
				(empty($this->_strings[$localeCode][$stringCode]) === false)
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
		// Define locale (first from session, then from HTTP header)

		$this->_localeCode = \z\request()->session('fbenard/zero/culture/locale');

		if (empty($this->_localeCode) === true)
		{
			$this->_localeCode = locale_accept_from_http(\z\request()->header('Accept-Language'));
		}


		// Define fallback

		$this->_fallbackCode = \z\pref('fbenard/zero/culture/locale/fallback');


		// Load strings

		$this->loadStrings();
	}


	/**
	 *
	 */

	private function loadStrings()
	{
		// Get the cache

		$cacheCode = 'strings_' . $this->_localeCode . '_' . $this->_fallbackCode;
		$cache = \z\cache()->getCache($cacheCode);

		if ($cache !== false)
		{
			$this->_strings = unserialize($cache);
			return;
		}


		// Build locales

		$locales =
		[
			$this->_localeCode,
			$this->_fallbackCode
		];

		
		// Parse each locale

		foreach ($locales as $localeCode)
		{
			// Build an array for the locale

			$this->_strings[$localeCode] = [];

			
			// List string files for this locale

			$paths = \z\service('helper/file')->listFiles
			(
				PATH_APPLICATION . 'Config/Strings/' . $localeCode . '/',
				'*.json'
			);


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


	/**
	 *
	 */

	public function setLocale($localeCode)
	{
		// Store the locale in session

		\z\request()->session('fbenard/zero/culture/locale', $localeCode);


		// Re-initialize the culture manager

		$this->initialize();
	}
}

?>
