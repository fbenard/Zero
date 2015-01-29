<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

abstract class AbstractController
{
	// Attributes

	protected $_contentType = null;
	protected $_statusCode = null;
	protected $_view = null;


	/**
	 *
	 */

	public function __construct()
	{
		//

		$this->_contentType = 'text/html';
		$this->_statusCode = 200;
		$this->_view = new \Zero\Classes\View();


		//

		if (\z\app()->isRunningCli() === false)
		{
			$headers = apache_request_headers();
			
			if (array_key_exists('Accept', $headers) === true)
			{
				$this->_contentType = $headers['Accept'];
			}
		}
	}


	/**
	 *
	 */

	protected function redirect($url)
	{
		\z\redirect($url);
	}


	/**
	 *
	 */

	protected function renderView($viewCode, $viewArguments = null)
	{
		$output = $this->_view->render($viewCode, $viewArguments);
		$this->sendHeaders();
		print $output;
	}


	/**
	 *
	 */

	protected function renderJson($data = null)
	{
		$json = json_encode($data);
		$this->sendHeaders();
		print $json;
	}
	
	
	/**
	 *
	 */
	
	public function sendHeaders()
	{
		//
		
		if (headers_sent() === true)
		{
			return;
		}


		// Send HTTP headers

		http_response_code($this->_statusCode);

		header('Content-Type: ' . $this->_contentType . '; charset=UTF-8');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');
	}
}

?>
