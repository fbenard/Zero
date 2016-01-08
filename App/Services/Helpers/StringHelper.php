<?php

// Namespace

namespace fbenard\Zero\Services\Helpers;


/**
 *
 */

class StringHelper
{
	/**
	 *
	 */

	public function convertCcToLc($string)
	{
		// Build the pattern

		$pattern = '/((?:^|[A-Z])[a-z]+)/';


		// Extract matches

		if (preg_match_all($pattern, $string, $matches) === false)
		{
			// No match found

			return $string;
		}


		// Build the result

		$result = implode('-', $matches[1]);
		$result = strtolower($result);


		return $result;
	}


	/**
	 *
	 */

	public function convertLcToCc($string, $full = true)
	{
		// Explode the string by - to get words

		$stringFragments = explode('-', $string);


		// Parse each fragment

		foreach ($stringFragments as $i => &$stringFragment)
		{
			// Skip the first fragment
			// If not in full mode

			if
			(
				($i === 0) &&
				($full === false)
			)
			{
				continue;
			}

			
			// Make sure word is in camel case
			// First letter is uppercase
			// Other letters are lowercase

			$stringFragment = ucfirst(strtolower($stringFragment));
		}


		// Implode words into one string

		$result = implode(null, $stringFragments);


		return $result;
	}
}

?>
