<?php

// Namespace

namespace Zero\Services\Helpers;


/**
 *
 */

class HttpHelper
{
	// Attributes

	private $_client = null;


	/**
	 *
	 */

	public function __construct($host)
	{
		// Build the HTTP client

		$this->_client = new \GuzzleHttp\Client
		(
			[
				'base_url' => $host
			]
		);
	}


	/**
	 *
	 */

	public function call($verb, $uri, $headers = null, $query = null, $body = null, $statusCode = 200)
	{
		// Globals

		global $argv;


		// Make sure headers is an array

		if (is_array($headers) === false)
		{
			$headers = [];
		}


		// Build the request

		$request = $this->_client->createRequest
		(
			$verb,
			$uri,
			[
				'headers' => $headers,
				'query' => $query,
				'body' => $body,
				'exceptions' => false
			]
		);


		// Log the request

		if
		(
			(is_array($argv) === true) &&
			(in_array('--verbose', $argv) === true)
		)
		{
			print("\n>>> Request\n\n");
			print($request . "\n");
		}


		// Send the request

		$response = $this->_client->send($request);


		// Log the response

		if
		(
			(is_array($argv) === true) &&
			(in_array('--verbose', $argv) === true)
		)
		{
			print("\n>>> Response\n\n");
			print($response . "\n");
		}


		// Did it succeed?

		if
		(
			(is_null($statusCode) === false) &&
			((int)($statusCode) !== (int)($response->getStatusCode()))
		)
		{
			\z\e
			(
				EXCEPTION_HTTP_STATUS_CODE_NOT_VALID,
				[
					'expected' => $statusCode,
					'actual' => $response->getStatusCode()
				]
			);
		}


		// Build the result

		$result = $response->getBody();


		return $result;
	}
}

?>
