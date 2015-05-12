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


		// Send HTTP headers

		http_response_code($this->_statusCode);

		if (is_array($this->_headers) === true)
		{
			foreach ($this->_headers as $headerCode => $headerValues)
			{
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

	public function setBody($body)
	{
		$this->_body = $body;
	}


	/**
	 *
	 */

	public function setHeaders($headers)
	{
		$this->_headers = $headers;
	}


	/**
	 *
	 */

	public function setStatusCode($statusCode)
	{
		$this->_statusCode = $statusCode;
	}
}

?>
