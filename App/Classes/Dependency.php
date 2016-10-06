<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Dependency
{
	// Traits

	use fbenard\Zero\Traits\GetTrait;
	use fbenard\Zero\Traits\SetTrait;

	
	// Attributes

	private $_interface = null;
	private $_value = null;


	/**
	 *
	 */

	public function __construct(string $interfaceCode)
	{
		// Set attributes

		$this->_interface = $interfaceCode;
	}
}

?>
