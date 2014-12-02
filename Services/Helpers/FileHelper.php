<?php

// Namespace

namespace Zero\Services\Helpers;


/**
 *
 */

class FileHelper
{
	/**
	 * 
	 */
	
	public function listFiles($path, $pattern = '*')
	{
		// Make sure the path ends with a slash
		
		if (substr($path, -1) != '/')
		{
			$path .= '/';
		}
		

		// Find files matching the pattern
		
		$files = glob($path . $pattern);


		//

		if (is_array($files) === false)
		{
			$files = [];
		}
		
		
		return $files;
	}
}

?>
