<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class DependencyNotDefinedException
extends \fbenard\Zero\Classes\AbstractException
{
	/**
	 *
	 */

	public function __construct($dependencyCode)
	{
		// Call parent constructor

		parent::__construct($dependencyCode);
	}
}

?>