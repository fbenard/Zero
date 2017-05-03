<?php

// Namespace

namespace fbenard\Zero\Interfaces\Factories;


/**
 *
 */

interface JsonFactory
{
	/**
	 *
	 */
	
	public function checkError();


	/**
	 *
	 */
	
	public function decodeJson(string $json, bool $array = true);


	/**
	 *
	 */
	
	public function encodeJson($json);
}

?>
