<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class DependencyInterfaceNotValidException
extends \fbenard\Zero\Classes\AbstractException
{
	/**
	 *
	 */

	public function __construct($dependencyInterface, $dependencyValue)
	{
		// Call parent constructor

		parent::__construct($dependencyInterface, $dependencyValue);
	}
}

?>
