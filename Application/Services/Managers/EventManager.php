<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class EventManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	private $_listeners = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_listeners = [];
	}


	/**
	 *
	 */

	public function addListener($eventCode, $listener)
	{
	}


	/**
	 *
	 */

	public function dispatchEvent($eventCode, $event, $sender)
	{
	}


	/**
	 *
	 */

	public function initialize()
	{
	}


	/**
	 *
	 */

	public function removeListener()
	{
	}
}

?>
