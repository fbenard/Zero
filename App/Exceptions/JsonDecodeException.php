<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class JsonDecodeException
extends \fbenard\Zero\Classes\AbstractException
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
