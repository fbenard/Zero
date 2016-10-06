<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class JsonEncodeException
extends fbenard\Zero\Classes\AbstractException
{
	/**
	 *
	 */

	public function __construct($json, $error)
	{
		// Call parent constructor

		parent::__construct($json, $error);
	}
}

?>
