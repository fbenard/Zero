<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class JsonNotValidException
extends \fbenard\Zero\Classes\AbstractException
{
	/**
	 *
	 */

	public function __construct(int $error, string $message)
	{
		// Call parent constructor

		parent::__construct($error, $message);
	}
}

?>
