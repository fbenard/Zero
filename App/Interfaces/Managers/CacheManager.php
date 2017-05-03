<?php

// Namespace

namespace fbenard\Zero\Interfaces\Managers;


/**
 *
 */

interface CacheManager
{
	/**
	 *
	 */

	public function clearCache();


	/**
	 *
	 */

	public function getCache($cacheCode);


	/**
	 *
	 */

	public function isCacheEnabled();


	/**
	 *
	 */

	public function setCache($cacheCode, $cacheValue);
}

?>
