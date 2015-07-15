<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

abstract class AbstractApiController
extends \fbenard\Zero\Classes\AbstractController
{
	/**
	 *
	 */

	public function __construct()
	{
		// Call the parent constructor

		parent::__construct();


		// Set the Content-Type header

		$this->setHeader('Content-Type', 'application/json; charset=UTF-8');

		
		// Set a null output

		$this->setOutput(null);
	}


	/**
	 *
	 */

	protected function setOutput($output)
	{
		// Encode the output as JSON

		$output = json_encode($output, JSON_PRETTY_PRINT);


		// Set the output
		
		parent::setOutput($output);
	}
}

?>
