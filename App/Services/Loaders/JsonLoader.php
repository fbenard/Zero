<?php

// Namespace

namespace fbenard\Zero\Services\Loaders;


/**
 *
 */

class JsonLoader
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Loaders\JsonLoader
{
	/**
	 *
	 */

	public function __construct()
	{
		// Define dependencies

		$this->defineDependency('factory/json', 'fbenard\Zero\Interfaces\Factories\JsonFactory');
		$this->defineDependency('helper/file', 'fbenard\Zero\Interfaces\Helpers\FileHelper');
	}


	/**
	 *
	 */

	public function loadJson(string $path, bool $array = true)
	{
		// Load the JSON file

		$json = $this->getDependency('helper/file')->loadFile($path);


		// Load and decode the JSON

		$result = $this->getDependency('factory/json')->decodeJson($json, $array);


		return $result;
	}
}

?>
