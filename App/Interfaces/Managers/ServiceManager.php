<?php

// Namespace

namespace fbenard\Zero\Interfaces\Managers;


/**
 *
 */

interface ServiceManager
{
	/**
	 *
	 */

	public function deregisterServices(array $services);


	/**
	 *
	 */
	
	public function getService(string $serviceCode, bool $clone = false);


	/**
	 *
	 */

	public function initialize();


	/**
	 *
	 */

	public function registerServices(array $services);
}

?>
