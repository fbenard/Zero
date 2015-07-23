<?php

// Namespace

namespace fbenard\Zero\Services\Helpers;


/**
 *
 */

class FileHelper
{
	/**
	 * 
	 */
	
	public function listFiles($path, $extension = null, $recursive = false)
	{
		// Build the result

		$result = [];

		
		// Is the path an actual directory?

		if (is_dir($path) === false)
		{
			return $result;
		}


		// Build iterators

		if ($recursive === true)
		{
			$directoryIterator = new \RecursiveDirectoryIterator($path);
			$fileIterator = new \RecursiveIteratorIterator
			(
				$directoryIterator,
				\RecursiveIteratorIterator::SELF_FIRST
			);
		}
		else
		{
			$directoryIterator = new \DirectoryIterator($path);
			$fileIterator = new \IteratorIterator($directoryIterator);
		}

		
		//

		foreach ($fileIterator as $file)
		{
			// Skip if not a file

			if ($file->isFile() === false)
			{
				continue;
			}


			// Skip if not the right extension

			if
			(
				(empty($extension) === false) &&
				($file->getExtension() !== $extension)
			)
			{
				continue;
			}


			// Store the file

			$result[] = $file->getRealPath();
		}
	
		
		return $result;
	}
}

?>
