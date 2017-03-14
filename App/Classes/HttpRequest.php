<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class HttpRequest
extends \fbenard\Zero\Classes\AbstractRequest
{
	// Attributes

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

		$this->_env = $_ENV;
		$this->_file = $_FILES;
		$this->_get = $_GET;
		$this->_header = [];
		$this->_post = $_POST;
		$this->_server = $_SERVER;


		// Inject HTTP headers

		$this->_header = $this->getHeaders();
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

		if
		(
			(isset($_SESSION) === false) ||
			(is_array($_SESSION) === false)
		)
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


	/**
	 *
	 */

	public function getHeaders()
	{
		//

		$result = [];
		$pattern = '/\AHTTP_/';
		
		
		// Parse each $_SERVER variable

		foreach ($_SERVER as $key => $value)
		{
			//

			if (preg_match($pattern, $key) !== 1)
			{
				continue;
			}


			//

			$result_key = preg_replace($pattern, '', $key);
			$rx_matches = [];
			$rx_matches = explode('_', $result_key);

			
			//

			if (count($rx_matches) > 0 and strlen($result_key) > 2 )
			{
				//

				foreach ($rx_matches as $ak_key => $ak_val)
				{
					$rx_matches[$ak_key] = ucfirst($ak_val);
				}

				
				//

				$result_key = implode('-', $rx_matches);
			}
			

			//

			$result[$result_key] = $value;
		}

		return($result);
	}
}

?>
