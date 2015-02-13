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

	public function initialize()
	{
		// Create a Redis driver

		$this->_predis = new \Predis\Client
		(
			array
			(
				/*
				'host' => \z\pref('fbenard/zero/redis/host'),
				'port' => \z\pref('fbenard/zero/redis/port'),
				'database' => \z\pref('fbenard/zero/redis/database')
				*/
				'host' => '127.0.0.1',
				'port' => 6379,
				'database' => 1
			)
		);
	}


	/**
	 *
	 */

	public function clear()
	{
		$this->_predis->flushdb();
	}


	/**
	 *
	 */

	public function getCache($cacheCode)
	{
		//

		if ($this->_predis->exists($cacheCode) === false)
		{
			return false;
		}


		//

		$result = $this->_predis->get($cacheCode);


		return $result;
	}


	/**
	 *
	 */

	public function setCache($cacheCode, $cacheValue)
	{
		$this->_predis->set($cacheCode, $cacheValue);
	}
}

?>
