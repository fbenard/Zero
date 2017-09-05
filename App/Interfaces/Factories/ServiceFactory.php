<?php

// Namespace

namespace fbenard\Zero\Interfaces\Factories;


/**
 *
 */

interface ServiceFactory
{
	/**
	 *
	 */
	
	public function buildService(string $serviceCode, array $definitions);
}

?>
