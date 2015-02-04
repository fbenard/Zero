<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class RequestManager
{
	// Attributes

	private $_request = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_request = new \fbenard\Zero\Classes\Request();
	}


	/**
	 *
	 */

	public function getRequest()
	{
		return $this->_request;
	}
}

?>
