<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Request
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	private $_argument = null;
	private $_env = null;
	private $_file = null;
	private $_get = null;
	private $_header = null;
	private $_post = null;
	private $_server = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build attributes

		$this->_argument = [];
		$this->_env = $_ENV;
		$this->_file = $_FILES;
		$this->_get = $_GET;
		$this->_header = [];
		$this->_post = $_POST;
		$this->_server = $_SERVER;


		// Inject HTTP headers and CLI options

		if (\z\app()->isCli() === true)
		{
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
		else
		{
			$this->_header = apache_request_headers();
		}
	}


	/**
	 *
	 */

	public function __call($methodCode, $methodArguments)
	{
		//

		$attributeCode = '_' . $methodCode;

		
		//

		if
		(
			(isset($this->$attributeCode) === true) &&
			(is_array($this->$attributeCode) === true)
		)
		{
			//

			$attribute = $this->$attributeCode;

			
			//

			if
			(
				(array_key_exists(0, $methodArguments) === true) &&
				(array_key_exists($methodArguments[0], $attribute) === true)
			)
			{
				return $attribute[$methodArguments[0]];
			}
			else
			{
				return $attribute;
			}
		}
	}


	/**
	 *
	 */

	public function cookie($variableCode, $variableValue = null, $expire = null, $path = null, $domain = null, $secure = null, $httpOnly = null)
	{
		//

		if (is_array($_COOKIE) === false)
		{
			return;
		}


		//

		if (func_num_args() === 1)
		{
			//

			if (array_key_exists($variableCode, $_COOKIE) === true)
			{
				return $_COOKIE[$variableCode];
			}
		}
		else
		{
			//

			if (is_null($variableValue) === true)
			{
				setcookie($variableCode, false);
			}
			else
			{
				//

				if (is_bool($variableValue) === true)
				{
					$variableValue = intval($variableValue);
				}


				//

				setcookie($variableCode, $variableValue, $expire, $path, $domain, $secure, $httpOnly);
			}
		}
	}


	/**
	 *
	 */

	public function session($variableCode, $variableValue = null)
	{
		//

		if (is_array($_SESSION) === false)
		{
			return;
		}


		//

		if (func_num_args() === 1)
		{
			//

			if
			(
				(is_array($_SESSION) === true) &&
				(array_key_exists($variableCode, $_SESSION) === true)
			)
			{
				return $_SESSION[$variableCode];
			}			
		}
		else
		{
			//

			if (is_null($variableValue) === true)
			{
				unset($_SESSION[$variableCode]);
			}
			else
			{
				$_SESSION[$variableCode] = $variableValue;
			}
		}
	}
}

?>
