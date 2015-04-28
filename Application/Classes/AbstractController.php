<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

abstract class AbstractController
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	protected $_output = null;
	protected $_response = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build attributes

		$this->_response = new \fbenard\Zero\Classes\Response
		(
			200,
			[
				'Content-Language' => \z\culture()->locale,
				'Content-Type' => 'text/html; charset=UTF-8',
				'Cache-Control' => 'private, no-cache, no-store, must-revalidate'
			]
		);
	}


	/**
	 *
	 */

	public function pushResponse()
	{
		$this->_response->setBody($this->_output);
		$this->_response->push();
	}


	/**
	 *
	 */

	protected function redirect($url)
	{
		$this->_response->setHeaders
		(
			[
				'Location' => $url
			]
		);
	}


	/**
	 *
	 */

	protected function renderView($viewCode, $viewArguments = null)
	{
		$this->setOutput(\z\service('renderer/view')->renderView($viewCode, $viewArguments));
	}


	/**
	 *
	 */

	protected function setOutput($output)
	{
		$this->_output = $output;
	}
}

?>
