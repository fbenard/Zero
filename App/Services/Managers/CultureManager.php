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

	public function getStrings()
	{
		// Merge strings

		$result = array_merge
		(
			$this->_strings[$this->_fallbackCode],
			$this->_strings[$this->_localeCode]
		);


		return $result;
	}


	/**
	 *
	 */

	public function initialize()
	{
		// Define locale (first from session, then from HTTP header)

		$this->_localeCode = \z\request()->session('culture/locale');

		if (empty($this->_localeCode) === true)
		{
			$this->_localeCode = locale_accept_from_http(\z\request()->header('Accept-Language'));
		}

		if (empty($this->_localeCode) === true)
		{
			$this->_localeCode = \z\pref('culture/locale');
		}


		// Define fallback

		$this->_fallbackCode = \z\pref('culture/fallback');


		// Canonicalize locales

		$this->_localeCode = locale_canonicalize($this->_localeCode);
		$this->_fallbackCode = locale_canonicalize($this->_fallbackCode);


		// List locales available

		$locales = \z\service('helper/file')->listFiles
		(
			PATH_APP . '/Config/Strings',
			null,
			false,
			true,
			false
		);


		// Is the locale available?

		if (in_array($this->_localeCode, $locales) === false)
		{
			// Grab the parent code (e.g. en for en_US)

			$primaryCode = locale_get_primary_language($this->_localeCode);

			
			// Find locales belonging to this parent

			$locales = array_filter
			(
				$locales,
				function($key) use ($primaryCode)
				{
					return strpos($key, $primaryCode) === 0;
				}
			);


			// Sort locales A-Z

			sort($locales);

			
			// Grab the very first locale

			$this->_localeCode = array_shift($locales);
		}


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
				PATH_APP . '/Config/Strings/' . $localeCode,
				'json'
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

		\z\request()->session('culture/locale', $localeCode);


		// Re-initialize the culture manager

		$this->initialize();
	}
}

?>
