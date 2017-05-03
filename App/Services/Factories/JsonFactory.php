<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class JsonFactory
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Factories\JsonFactory
{
	/**
	 *
	 */
	
	public function checkError()
	{
		// Get the latest JSON error

		$error = json_last_error();
		$message = json_last_error_msg();


		// Is there an error?

		if ($error !== JSON_ERROR_NONE)
		{
			throw new \fbenard\Zero\Exceptions\JsonNotValidException
			(
				$error,
				$message
			);
		}
	}


	/**
	 *
	 */
	
	public function decodeJson(string $json, bool $array = true)
	{
		// Decode JSON

		$result = json_decode
		(
			$json,
			$array
		);


		// Check whether JSON decode worked

		try
		{
			$this->checkError();
		}
		catch (\Exception $e)
		{
			throw new \fbenard\Zero\Exceptions\JsonDecodeException
			(
				$json,
				$e->getContext()[0],
				$e->getContext()[1]
			);
		}


		return $result;
	}


	/**
	 *
	 */
	
	public function encodeJson($json)
	{
		// Encode JSON

		$result = json_encode
		(
			$json,
			JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		);


		// Check whether JSON decode worked

		try
		{
			$this->checkError();
		}
		catch (\Exception $e)
		{
			throw new \fbenard\Zero\Exceptions\JsonEncodeException
			(
				$json,
				$e->getContext()[0],
				$e->getContext()[1]
			);
		}


		return $result;
	}
}

?>
