<?php

// Namespace

namespace fbenard\Zero\Tests\Services\Loaders;


/**
 *
 */

class JsonLoaderTest
extends \PHPUnit\Framework\TestCase
{
	// Attributes

	private $_jsonLoader = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build a JSON factory

		$this->_jsonLoader = new \fbenard\Zero\Services\Loaders\JsonLoader();
		

		// Inject dependencies

		$this->_jsonLoader->injectDependency
		(
			'factory/json',
			new \fbenard\Zero\Services\Factories\JsonFactory()
		);

		$this->_jsonLoader->injectDependency
		(
			'helper/file',
			new \fbenard\Zero\Services\Helpers\FileHelper()
		);
	}


	/**
	 *
	 */

	public function testLoadJson()
	{
		// Load the raw JSON

		$path = getcwd() . '/Tests/Test.json';
		$rawJson = file_get_contents($path);


		// Define formats

		$formats =
		[
			'array' => true,
			'object' => false
		];


		// Parse each format

		foreach ($formats as $format => $isArray)
		{
			// Load the JSON

			$json = $this->_jsonLoader->loadJson
			(
				$path,
				$isArray
			);


			// Make sure it matches the expected JSON
			// @todo: This will fail as pretty print is enabled

			$this->assertEquals
			(
				json_decode($rawJson, $isArray),
				$json
			);
		}
	}
}

?>
