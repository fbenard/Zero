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
		// Fix headers, query and body

		$headers = \z\conf($headers);
		$query = \z\conf($query);

		if (is_null($body) === true)
		{
			$body = '';
		}


		// Body must be a string

		if (is_string($body) === false)
		{
			\z\e
			(
				EXCEPTION_HTTP_BODY_NOT_VALID,
				[
					'body' => json_encode($body, true),
					'type' => gettype($body)
				]
			);
		}



		// Build the HTTP client

		$client = new \GuzzleHttp\Client
		(
			[
				'base_url' => $host
			]
		);


		// Build the request

		$request = $client->createRequest
		(
			$verb,
			$uri,
			[
				'exceptions' => false
			]
		);


		// Setup the request

		$request->setPort($port);
		$request->setHeaders($headers);
		$request->setQuery($query);
		$request->setBody(\GuzzleHttp\Stream\Stream::factory($body));


		// Log

		\z\logger()->notice('HTTP Request');
		\z\logger()->info($request);


		// Send the request

		$response = $client->send($request);


		// Log

		\z\logger()->notice('HTTP Response');
		\z\logger()->info($response);


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
					'actual' => $response->getStatusCode(),
					'request' => $request->__toString(),
					'response' => $response->__toString()
				]
			);
		}


		// Build the result

		$result = $response->getBody();


		return $result;
	}
}

?>
