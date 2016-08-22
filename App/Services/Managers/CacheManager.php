<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class CacheManager
{
	// Attributes

	private $_redis = null;


	/**
	 *
	 */

	public function __construct()
	{
		// Build a Redis client
		
		$this->_redis = new \Predis\Client();
	}


	/**
	 *
	 */

	public function clearCache()
	{
		// Flush the whole database
		
		$this->_redis->flushdb();
	}


	/**
	 *
	 */

	public function getCache($cacheCode)
	{
		// Is cache enabled?

		if ($this->isCacheEnabled() === false)
		{
			return false;
		}


		// Does the cache exist?

		if ($this->_redis->exists($cacheCode) === false)
		{
			return false;
		}


		// Get the cache

		$result = $this->_redis->get($cacheCode);


		return $result;
	}


	/**
	 *
	 */

	private function isCacheEnabled()
	{
		if (in_array(\z\boot()->environment, \z\boot()->cache) === true)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	/**
	 *
	 */

	public function setCache($cacheCode, $cacheValue)
	{
		// Set the cache

		$this->_redis->set($cacheCode, $cacheValue);
	}
}

?>
