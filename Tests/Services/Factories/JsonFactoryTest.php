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
	private $_files = null;
	private $_jsonFactory = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build a JSON factory

		$this->_jsonFactory = new \fbenard\Zero\Services\Factories\JsonFactory();
	}


	/**
	 *
	 */

	public function setUp()
	{
		// Build an empty array for files

		$this->_files = [];		


		// Build test data
		// @todo: Maybe use json_encode to build object and array

		$this->_data =
		[
			'valid' =>
			[
				'string' =>
				'{
					"a": 1,
					"b": "string",
					"c": [1, 2, 3, 4],
					"d": null,
					"e": {}
				}',
				'array' =>
				[
					'a' => 1,
					'b' => 'string',
					'c' => [1, 2, 3, 4],
					'd' => null,
					'e' => new \StdClass()
				],
				'object' => new \StdClass()
			],
			'invalid' => 'Not a valid JSON'
		];
	}


	/**
	 *
	 */

	public function tearDown()
	{
		// Parse each file

		foreach ($this->_files as $path)
		{
			// If the file exists

			if (file_exists($path) === true)
			{
				// Delete the file

				unlink($path);
			}
		}
	}


	/**
	 *
	 */

	public function testGetError_valid()
	{
		// Encode the JSON

		$json = json_decode($this->_data['valid']['string']);


		// Get the error

		$error = $this->_jsonFactory->getError();


		// And as it should have worked
		// Make sure no error is returned

		$this->assertEmpty($error);
	}


	/**
	 *
	 */

	public function testGetError_invalid()
	{
		// Encode the invalid JSON

		$json = json_decode($this->_data['invalid']);


		// Get the error

		$error = $this->_jsonFactory->getError();


		// And as it should not have worked
		// Make sure an error is returned

		$this->assertNotEmpty($error);
	}

	
	/**
	 *
	 */

	public function testEncodeJson_valid()
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
				$this->_data['valid'][$format],
				$isArray
			);


			// Make sure it matches the expected JSON

			$this->assertEquals
			(
				$this->_data['valid']['string'],
				$json
			);
		}
	}
		
	
	/**
	 *
	 */

	public function testEncodeJson_invalid()
	{
		// If decoding fails because of invalid JSON
		// An exception should be thrown
		// So we need to catch it

		try
		{
			// Decode the invalid JSON

			$json = $this->_jsonFactory->encodeJson
			(
				$this->_data['invalid']
			);

			
			// If we're still here
			// It means no exception has been thrown
			// That's a failure

			$this->fail('No JsonDecodeException has been thrown');
		}
		catch (\Exception $e)
		{
			// Make sure it's a JsonDecodeException

			$this->assertEquals
			(
				'\fbenard\Exceptions\JsonDecodeException',
				get_class($e)
			);


			// Get the expected error

			$error = $this->_jsonFactory->getError();

			
			// Make sure it matches the actual error

			$this->assertEquals
			(
				$error,
				$e->context['error']
			);
		}
	}

	
	/**
	 *
	 */

	public function testDecodeJson_valid()
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
			// @todo: This will fail as pretty print is enabled

			$this->assertEquals
			(
				$this->_data['valid'][$format],
				$json
			);
		}
	}


	/**
	 *
	 */

	public function testLoadJson_found()
	{
		// Declare the file

		$path = '/tmp/found.json';
		$this->_files[] = $path;


		// Make sure the JSON file does not exist

		if (file_exists($path) === true)
		{
			unlink($path);
		}


		// Write the JSON file

		file_put_contents($path, $this->_data['valid']['string']);


		// Build formats

		$formats =
		[
			'array' => true,
			'object' => false
		];


		// Parse each format

		foreach ($formats as $format => $isArray)
		{
			// Load the JSON

			$json = $this->_jsonFactory->loadJson
			(
				$path,
				$isArray
			);


			// Make sure it matches the expected JSON
			// @todo: This will fail as pretty print is enabled

			$this->assertEquals
			(
				$this->_data['valid']['string'],
				$json
			);
		}
	}


	/**
	 *
	 */

	public function testLoadJson_notFound()
	{
		// Declare the file

		$path = '/tmp/not_found.json';
		$this->_files[] = $path;


		// Make sure the JSON file does not exist

		if (file_exists($path) === true)
		{
			unlink($path);
		}


		// If loading fails because file cannot be found
		// An exception should be thrown
		// So we need to catch it

		try
		{
			// Load the JSON

			$this->_jsonFactory->loadJson($path);


			// If we're still here
			// It means no exception has been thrown
			// That's a failure

			$this->fail('No FileNotFoundException has been thrown');
		}
		catch (\Exception $e)
		{
			// Make sure it's a FileNotFoundException

			$this->assertEquals
			(
				'\fbenard\Exceptions\FileNotFoundException',
				get_class($e)
			);
		}
	}
}

?>
