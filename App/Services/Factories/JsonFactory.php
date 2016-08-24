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
		// Decode JSON

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
		// Encode JSON

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

	public function loadJson($path, $array = true)
	{
		// Load the JSON file

		$json = \z\service('helper/file')->loadFile($path);


		// Load and decode the JSON

		$result = $this->decodeJson($json, $array);


		return $result;
	}
}

?>
