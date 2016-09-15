<?php

// Namespace

namespace fbenard\Zero\Interfaces\Helpers;


/**
 *
 */

interface FileHelper
{
	/**
	 * 
	 */
	
	public function loadFile($path);


	/**
	 * 
	 */
	
	public function listFiles($path, $extension = null, $recursive = false, $directories = false, $absolute = true);
}

?>
