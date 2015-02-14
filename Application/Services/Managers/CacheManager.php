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
