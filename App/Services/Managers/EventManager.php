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

		if (array_key_exists($eventCode, $this->_followers) === false)
		{
			return;
		}

		
		// Get event code

		$eventCode = get_class($event);


		// Parse each follower

		foreach ($this->_followers[$eventCode] as $followerCode => $methodCode)
		{
			\z\service($followerCode)->$methodCode($event);
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
		// Get the cache

		$cacheCode = 'events_' . \z\boot()->environment;
		$cache = \z\cache()->getCache($cacheCode);

		if ($cache !== false)
		{
			$this->_followers = unserialize($cache);
			return;
		}


		// Parse each dependency

		$dependencies = \z\boot()->dependencies;

		foreach ($dependencies as $dependency)
		{
			//

			$paths = \z\service('helper/file')->listFiles($dependency . '/Config/Events', 'php');
			
			foreach ($paths as $path)
			{
				require_once($path);
			}
		}


		// Set the cache

		\z\cache()->setCache
		(
			$cacheCode,
			serialize($this->_followers)
		);
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
