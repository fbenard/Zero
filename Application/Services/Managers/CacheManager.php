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
		$this->_redis = new \fbenard\Zero\Services\Drivers\RedisDriver();
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

	public function setCache($cacheCode, $cacheValue)
	{
		// Set the cache

		$this->_redis->set($cacheCode, $cacheValue);
	}
}

?>
