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

	public function addFollower($eventCode, $follower)
	{
		// Build followers for this event code

		if (array_key_exists($eventCode, $this->_followers) === false)
		{
			$this->_followers[$eventCode] = [];
		}

		
		// Build the follower code

		$followerCode = $this->computeFollowerCode();


		// Add the follower

		if (array_key_exists($followerCode, $this->_followers[$eventCode]) === false)
		{
			$this->_followers[$eventCode][$followerCode] = $follower;
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

	public function removeFollower($follower)
	{
		// Remove the follower

		if
		(
			(array_key_exists($eventCode, $this->_followers) === true) &&
			(in_array($followerCode, $this->_followers[$eventCode]) === true)
		)
		{
			unset($this->_followers[$eventCode][$followerCode]);
		}
	}
}

?>
