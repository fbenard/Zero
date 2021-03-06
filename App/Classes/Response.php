<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Response
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;
	use \fbenard\Zero\Traits\SetTrait;


	// Attributes

	private $_body = null;
	private $_headers = null;
	private $_statusCode = null;


	/**
	 *
	 */

	public function __construct($statusCode = 200, $headers = null, $body = null)
	{
		// Build attributes

		$this->_body = $body;
		$this->_headers = $headers;
		$this->_statusCode = $statusCode;
	}


	/**
	 *
	 */

	public function push()
	{
		// Send headers

		$this->sendHeaders();


		// Print body

		if (is_array($this->_body) === true)
		{
			print(implode(null, $this->_body));
		}
		else
		{
			print($this->_body);
		}
	}


	/**
	 *
	 */

	public function redirect($url)
	{
		header('Location: ' . $url);
		\z\app()->quit();
	}


	/**
	 *
	 */

	private function sendHeaders()
	{
		// Have HTTP response headers already been sent?

		if (headers_sent() === true)
		{
			return;
		}


		// Set the status code

		http_response_code($this->_statusCode);

		

		// Parse each header

		if (is_array($this->_headers) === true)
		{
			foreach ($this->_headers as $headerCode => $headerValues)
			{
				// Set the header

				if (is_array($headerValues) === true)
				{
					foreach ($headerValues as $headerValue)
					{
						header($headerCode . ': ' . $headerValue);
					}
				}
				else
				{
					header($headerCode . ': ' . $headerValues);
				}
			}
		}
	}


	/**
	 *
	 */

	public function setHeader($headerCode, $headerValue = null)
	{
		if (count(func_get_args()) === 1)
		{
			if (array_key_exists($headerCode, $this->_headers) === true)
			{
				unset($this->_headers[$headerCode]);
			}
		}
		else
		{
			$this->_headers[$headerCode] = $headerValue;
		}
	}
}

?>
