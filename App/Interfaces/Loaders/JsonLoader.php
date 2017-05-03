<?php

// Namespace

namespace fbenard\Zero\Interfaces\Loaders;


/**
 *
 */

interface JsonLoader
{
	/**
	 *
	 */

	public function loadJson(string $path, bool $array = true);
}

?>
