<?php

// Namespace

namespace fbenard\Zero\Exceptions;


/**
 *
 */

class ServiceNotDefinedException
extends \fbenard\Zero\Classes\AbstractException
{
	/**
	 *
	 */

	public function __construct($serviceCode, $definitions)
	{
		// Call parent constructor

		parent::__construct($serviceCode, $definitions);
	}
}

?>
