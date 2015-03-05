<?php

// Namespace

namespace fbenard\Zero\Services\Helpers;


/**
 *
 */

class DirectoryHelper
{
	/**
	 *
	 */
	
	public function deleteDirectory($path)
	{
		//
		
		if (file_exists($path) === false)
		{
			return;
		}
		
		
		
		//
		
		$filenames = scandir($path);
		
		foreach ($filenames as $filename)
		{
			$pathToFile = $path . $filename;
			
			if
			(
				($filename === '.') ||
				($filename === '..')
			)
			{
				continue;
			}
			else if (is_dir($pathToFile) === true)
			{
				self::deleteDirectory($pathToFile . '/');
			}
			else
			{
				unlink($pathToFile);
			}
		}
		
		rmdir($path);
	}
}

?>
