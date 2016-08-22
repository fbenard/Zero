<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class AbstractException
extends \Exception
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;


	// Attributes

	private $_context = null;

	
	/**
	 *
	 */

	public function __construct()
	{
		// Call parent constructor

		parent::__construct(get_class($this));


		// Build the context

		$this->_context = func_get_args();
	}


	/**
	 *
	 */

	public function getContext()
	{
		return $this->_context;
	}
}

?>
