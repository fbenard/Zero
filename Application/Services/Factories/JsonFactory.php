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


		return $result;
	}
}

?>
