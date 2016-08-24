<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class JsonFactory
{
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
		// Decode

		$result = json_decode
		(
			$json,
			$array
		);


		// Check whether JSON is valid

		if (json_last_error() !== JSON_ERROR_NONE)
		{
			\z\e
			(
				EXCEPTION_JSON_NOT_VALID,
				[
					'error' => json_last_error_msg(),
					'json' => $json
				]
			);
		}


		return $result;
	}


	/**
	 *
	 */
	
	public function encodeJson($json)
	{
		// Encode

		$result = json_encode
		(
			$json,
			JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
		);


		return $result;
	}

	
	/**
	 *
	 */

	public function loadJson($pathToJson, $array = true)
	{
		// Does the JSON exist?

		if (file_exists($pathToJson) === false)
		{
			\z\e
			(
				EXCEPTION_FILE_NOT_FOUND,
				[
					'pathToJson' => $pathToJson
				]
			);
		}


		// Load and decode the JSON

		$rawJson = file_get_contents($pathToJson);
		$json = $this->decodeJson($rawJson, $array);


		return $json;
	}
}

?>
