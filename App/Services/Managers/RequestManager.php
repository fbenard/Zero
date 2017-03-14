<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class RequestManager
extends \fbenard\Zero\Classes\AbstractService
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes

	private $_request = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_request = new \fbenard\Zero\Classes\Request();
	}
}

?>
