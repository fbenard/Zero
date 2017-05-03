<?php

// Namespace

namespace fbenard\Zero\Tests\Classes;


/**
 *
 */

class ApplicationTest
extends \PHPUnit\Framework\TestCase
{
	// Attributes

	private $_data = null;
	private $_application = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build an application

		$this->_application = \fbenard\Zero\Classes\Application::getInstance();
		

		/*
		// Inject dependencies

		$this->_application->injectDependency
		(
			'helper/file',
			new \fbenard\Zero\Services\Helpers\FileHelper()
		);

		
		// Build test data

		$this->_data =
		[
			'valid' =>
			[
				'array' =>
				[
					'a' => 1,
					'b' => 'string',
					'c' => [1, 2, 3, 4],
					'd' => null
				]
			],
			'invalid' => 'Not a valid JSON'
		];


		// Encode the string version

		$this->_data['valid']['string'] = json_encode($this->_data['valid']['array'], true);
		

		// Encode the object version

		$this->_data['valid']['object'] = json_decode($this->_data['valid']['string']);
		*/
	}
	
	
	/**
	 *
	 */

	public function testInitialize()
	{
		$this->_application->initialize();
	}
}

?>
