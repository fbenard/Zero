<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class CacheManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	private $_predis = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_predis = new \Predis\Client();
	}


	/**
	 *
	 */

	public function clear()
	{
		// Flush the whole database
		
		$this->_predis->flushdb();
	}


	/**
	 *
	 */

	public function getCache($cacheCode)
	{
		// Does the cache exist?

		if ($this->_predis->exists($cacheCode) === false)
		{
			return false;
		}


		// Get the cache

		$result = $this->_predis->get($cacheCode);


		return $result;
	}


	/**
	 *
	 */

	public function setCache($cacheCode, $cacheValue)
	{
		// Set the cache

		$this->_predis->set($cacheCode, $cacheValue);
	}
}

?>
