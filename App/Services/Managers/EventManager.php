<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

/*
TODO
- try/catch around followers
- order followers
- define local callback
- plug with oompa loompa
*/

class EventManager
extends \fbenard\Zero\Classes\AbstractService
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes

	private $_followers = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_followers = [];
	}


	/**
	 *
	 */

	public function addFollower($eventCode, $followerCode, $methodCode)
	{
		// Build followers for this event code

		if (array_key_exists($eventCode, $this->_followers) === false)
		{
			$this->_followers[$eventCode] = [];
		}

		
		// Add the follower

		if (array_key_exists($followerCode, $this->_followers[$eventCode]) === false)
		{
			$this->_followers[$eventCode][$followerCode] = $methodCode;
		}
	}


	/**
	 *
	 */

	public function dispatchEvent($event)
	{
		// Check whether there are any followers

		if (array_key_exists($event->code, $this->_followers) === false)
		{
			return;
		}

		
		// Parse each follower

		foreach ($this->_followers[$event->code] as $followerCode => $methodCode)
		{
			$this->getDependency($followerCode)->$methodCode($event);
		}
	}
	
	
	/**
	 *
	 */
	
	public function initialize()
	{
		// Load preferences

		$this->loadConfig();
	}


	/**
	 *
	 */

	private function loadConfig()
	{
		// Parse each dependency

		$dependencies = \z\boot()->dependencies;

		foreach ($dependencies as $dependency)
		{
			//

			$paths = $this->getDependency('helper/file')->listFiles($dependency . '/Config/Events', 'php');
			
			foreach ($paths as $path)
			{
				require_once($path);
			}
		}
	}


	/**
	 *
	 */

	public function removeFollower($eventCode, $followerCode)
	{
		// Remove the follower

		if
		(
			(array_key_exists($eventCode, $this->_followers) === true) &&
			(array_key_exists($followerCode, $this->_followers[$eventCode]) === true)
		)
		{
			unset($this->_followers[$eventCode][$followerCode]);
		}
	}
}

?>
