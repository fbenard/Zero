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

	public function addFollower($eventCode, $followerCode)
	{
		// Build followers for this event code

		if (array_key_exists($eventCode, $this->_followers) === false)
		{
			$this->_followers[$eventCode] = [];
		}

		
		// Add the follower

		if (array_key_exists($followerCode, $this->_followers[$eventCode]) === false)
		{
			$this->_followers[$eventCode][$followerCode] = $followerCode;
		}
	}


	/**
	 *
	 */

	private function computeFollowerCode($follower)
	{
		//

		$followerCode = sha1(serialize($follower));


		return $followerCode;
	}


	/**
	 *
	 */

	public function dispatchEvent($eventCode, $eventContext, $sender)
	{
		// Check whether there are any followers

		if (array_key_exists($eventCode, $this->_followers) === false)
		{
			return;
		}

		
		// Parse each follower

		foreach ($this->_followers[$eventCode] as $followerCode)
		{
			service($followerCode)->onEvent($eventCode, $eventContext, $sender);
		}
	}


	/**
	 *
	 */

	public function initialize()
	{
		// TODO add followers to cache
		//

		$dependencies = \z\boot()->dependencies;
		
		
		//

		foreach ($dependencies as $dependency)
		{
			$paths = \z\service('helper/file')->listFiles($dependency . 'Events/', '*.php');
			
			foreach ($paths as $path)
			{
				require_once($path);
			}
		}
	}


	/**
	 *
	 */

	public function removeFollower($eventCode, $follower)
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
