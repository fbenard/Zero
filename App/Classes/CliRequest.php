<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class CliRequest
extends \fbenard\Zero\Classes\AbstractRequest
{
	// Attributes

	private $_argument = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build attributes

		$this->_argument = [];


		// Extract arguments

		if
		(
			(array_key_exists('argv', $GLOBALS) === true) &&
			(is_array($GLOBALS['argv']) === true)
		)
		{
			// Parse each argument

			foreach ($GLOBALS['argv'] as $arg)
			{
				// Try to find the pattern --arg="value"

				$pattern = '/^\-\-([a-z]*)=(.*)$/';

				if (preg_match($pattern, $arg, $matches) !== 1)
				{
					continue;
				}


				// Store the argument

				$this->_argument[$matches[1]] = $matches[2];
			}
		}
	}
}

?>
