<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class StringManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes
	
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

	public function getString($stringCode, $stringArguments = null, $localeCode = null, $fallbackCode = null)
	{
		// Define locale and fallback
		// Support of Accept-Language header

		$localeCode = 'fr';
		$fallbackCode = 'en';

		$locales =
		[
			$localeCode,
			$fallbackCode
		];


		// Try to get the locale string

		$result = $stringCode;

		foreach ($locales as $localeCode)
		{
			if
			(
				(array_key_exists($localeCode, $this->_strings) === true) &&
				(is_array($this->_strings[$localeCode]) === true) &&
				(array_key_exists($stringCode, $this->_strings[$localeCode]) === true)
			)
			{
				//

				$result = $this->_strings[$localeCode][$stringCode];


				//

				break;
			}
		}


		//

		if (is_array($stringArguments) === true)
		{
			foreach ($stringArguments as $key => $value)
			{
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
		// Load strings

		$this->loadStrings('fr', 'en');
	}


	/**
	 *
	 */

	private function loadStrings($localeCode, $fallbackCode)
	{
		// Get the cache

		$cacheCode = 'strings_' . $localeCode . '_' . $fallbackCode;
		$cache = \z\cache()->getCache($cacheCode);

		if ($cache !== false)
		{
			$this->_strings = unserialize($cache);
			return;
		}


		//

		$locales =
		[
			$localeCode,
			$fallbackCode
		];

		foreach ($locales as $localeCode)
		{
			//

			$this->_strings[$localeCode] = [];

			
			//

			$paths = \z\service('helper/file')->listFiles(PATH_APPLICATION . 'Config/Strings/' . $localeCode . '/');
			

			//

			foreach ($paths as $path)
			{
				//

				$rawStrings = file_get_contents($path);
				$strings = json_decode($rawStrings, true);


				//

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
