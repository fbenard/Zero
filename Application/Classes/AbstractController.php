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
	use \fbenard\Zero\Traits\SetTrait;


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
				'Accept-Language' => \z\service('manager/culture')->localeCode,
				'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
				'Content-Language' => \z\service('manager/culture')->localeCode,
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
		$this->_output = \z\service('renderer/view')->renderView
		(
			$viewCode,
			$viewContext,
			$viewRoot
		);
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
