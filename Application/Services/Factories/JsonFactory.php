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
		//
		
		$result = json_encode
		(
			$json,
			JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
		);


		return $result;
	}
}

?>
