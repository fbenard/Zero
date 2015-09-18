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
	
	public function decodeJson($json)
	{
		// Decode

		$result = json_decode
		(
			$json,
			true
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

	public function loadJson($pathToJson)
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
		$json = $this->decodeJson($rawJson);


		return $json;
	}
}

?>
