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
		// Parent constructor

		parent::__construct();


		// Build attributes

		$this->_response->setHeaders
		(
			[
				'Content-Type' => 'application/json; charset=UTF-8',
				'Cache-Control' => 'private, no-cache, no-store, must-revalidate'
			]
		);

		$this->_output = json_encode(null);
	}


	/**
	 *
	 */

	protected function setOutput($output)
	{
		$this->_output = json_encode($output);
	}
}

?>
