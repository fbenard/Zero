<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

abstract class AbstractController
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;
	use \fbenard\Zero\Traits\DependantTrait;


	// Attributes

	protected $_response = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build the response

		$this->_response = new \fbenard\Zero\Classes\Response
		(
			200,
			[
				'Accept-Language' => $this->getDependency('manager/culture')->localeCode,
				'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
				'Content-Language' => $this->getDependency('manager/culture')->localeCode,
				'Content-Type' => 'text/html; charset=UTF-8'
			]
		);
	}


	/**
	 *
	 */

	public function push()
	{
		$this->_response->push();
	}


	/**
	 *
	 */

	protected function redirect($url)
	{
		$this->_response->headers =
		[
			'Location' => $url
		];
	}


	/**
	 *
	 */

	protected function renderView($viewCode, $viewContext = null, $viewRoot = null)
	{
		$this->setOutput
		(
			$this->getDependency('renderer/view')->renderView
			(
				$viewCode,
				$viewContext,
				$viewRoot
			)
		);
	}


	/**
	 *
	 */

	protected function setOutput($output)
	{
		$this->_response->body = $output;
	}


	/**
	 *
	 */

	protected function setStatusCode($statusCode)
	{
		$this->_response->statusCode = $statusCode;
	}


	/**
	 *
	 */

	protected function setHeader($headerCode, $headerValue = null)
	{
		$this->_response->setHeader($headerCode, $headerValue);
	}
}

?>
