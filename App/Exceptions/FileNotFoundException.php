<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class FileNotFoundException
extends fbenard\Zero\Classes\AbstractException
{
	/**
	 *
	 */

	public function __construct($path)
	{
		// Call parent constructor

		parent::__construct($path);
	}
}

?>
