<?php

// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class EventManager
{
	// Attributes

	public $_listeners = null;


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
