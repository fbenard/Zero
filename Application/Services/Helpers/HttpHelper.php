<?php

// Namespace

namespace fbenard\Zero\Services\Helpers;


/**
 *
 */

class HttpHelper
{
	/**
	 *
	 */

	public function call($verb, $host, $port, $uri, $headers = null, $query = null, $body = null, $statusCode = null)
	{
		// Globals

		global $argv;


		// Build the HTTP client

		$client = new \GuzzleHttp\Client
		(
			[
				'base_url' => $host
			]
		);


		// Make sure headers is an array

		if (is_array($headers) === false)
		{
			$headers = [];
		}


		// Build the request

		$request = $client->createRequest
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


		//

		$request->setPort($port);


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

		$response = $client->send($request);


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
