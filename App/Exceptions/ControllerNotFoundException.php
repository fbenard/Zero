<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class ControllerNotFoundException
extends \fbenard\Zero\Classes\AbstractException
{
	// Attributes

	private $_controllerCode = $controllerCode;

	
	/**
	 *
	 */

	public function __construct($controllerCode)
	{
		$this->_controllerCode = $controllerCode;
	}
}

?>
