<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class JsonFactory
{
	// Traits

	use fbenard\Zero\Traits\DependantTrait;


	/**
	 *
	 */

	public function __construct()
	{
		// Define dependencies

		$this->defineDependency('helper/file', 'fbenard\Zero\Interfaces\Helpers\FileHelper');
	}


	/**
	 *
	 */
	
	public function getError()
	{
		// Get the latest JSON error

		$error = json_last_error();
		$message = json_last_error_msg();


		// Is there an error?

		if ($error !== JSON_ERROR_NONE)
		{
			return $message;
		}
	}


	/**
	 *
	 */
	
	public function decodeJson($json, $array = true)
	{
		// Decode JSON

		$result = json_decode
		(
			$json,
			$array
		);


		// Get the latest JSON error

		$error = $this->getError();


		// Check whether decoding worked

		if (is_null($error) === false)
		{
			throw new fbenard\Zero\Exceptions\JsonDecodeException
			(
				$json,
				$error
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


		// Get the latest JSON error

		$error = $this->getError();


		// Check whether encoding worked

		if (is_null($error) === false)
		{
			throw new fbenard\Zero\Exceptions\JsonEncodeException
			(
				$json,
				$error
			);
		}


		return $result;
	}

	
	/**
	 *
	 */

	public function loadJson($path, $array = true)
	{
		// Load the JSON file

		$json = $this->getDependency('helper/file')->loadFile($path);


		// Load and decode the JSON

		$result = $this->decodeJson($json, $array);


		return $result;
	}
}

?>
