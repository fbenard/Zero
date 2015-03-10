<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

abstract class AbstractEvent
{
	// Traits

	use \fbenard\Zero\Traits\Get;


	// Attributes

	private $_sender = null;


	/**
	 *
	 */

	public function __construct($sender)
	{
		$this->_sender = $sender;
	}
}

?>
