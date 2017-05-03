<?php

// Namespace

namespace fbenard\Zero\Tests\Services\Factories;


/**
 *
 */

class JsonFactoryTest
extends \PHPUnit\Framework\TestCase
{
	// Attributes

	private $_data = null;
	private $_jsonFactory = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build a JSON factory

		$this->_jsonFactory = new \fbenard\Zero\Services\Factories\JsonFactory();
		

		// Load the raw JSON

		$path = getcwd() . '/Tests/Test.json';
		$rawJson = file_get_contents($path);


		// Build test data

		$this->_data =
		[
			'valid' =>
			[
				'string' => $rawJson,
				'array' => json_decode($rawJson, true),
				'object' => json_decode($rawJson, false)
			],
			'invalid' => 'Not a valid JSON'
		];
	}


	/**
	 *
	 */

	public function testCheckError_valid()
	{
		// Decode a valid JSON

		$json = json_decode($this->_data['valid']['string']);


		// Check the error
		// There should be no exception

		$this->_jsonFactory->checkError();
	}


	/**
	 *
	 */

	public function testCheckError_invalid()
	{
		// Decode an invalid JSON

		$json = json_decode($this->_data['invalid']);


		// There should be an exception

		$this->expectException('fbenard\Zero\Exceptions\JsonNotValidException');


		// Check the error

		$this->_jsonFactory->checkError();
	}

	
	/**
	 *
	 */

	public function testDecodeJson()
	{
		// Build formats

		$formats =
		[
			'array' => true,
			'object' => false
		];


		// Parse each format

		foreach ($formats as $format => $isArray)
		{
			// Encode the JSON

			$json = $this->_jsonFactory->decodeJson
			(
				$this->_data['valid']['string'],
				$isArray
			);


			// Make sure it matches the expected JSON

			$this->assertEquals
			(
				serialize($this->_data['valid'][$format]),
				serialize($json)
			);
		}
	}

	
	/**
	 *
	 */

	public function testEncodeJson()
	{
		// Build formats

		$formats =
		[
			'array' => true,
			'object' => false
		];


		// Parse each format

		foreach ($formats as $format => $isArray)
		{
			// Encode the JSON

			$json = $this->_jsonFactory->encodeJson
			(
				$this->_data['valid'][$format]
			);


			// Make sure it matches the expected JSON

			$this->assertEquals
			(
				json_encode($this->_data['valid'][$format], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
				$json
			);
		}
	}
}

?>
