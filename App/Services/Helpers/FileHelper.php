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
	
	public function loadFile($path)
	{
		// Check whether the file exists

		if (file_exists($path) === false)
		{
			throw new \fbenard\Exceptions\FileNotFoundException($path);
		}


		// Load the file

		$result = file_get_contents($path);


		return $result;
	}


	/**
	 * 
	 */
	
	public function listFiles($path, $extension = null, $recursive = false, $directories = false, $absolute = true)
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

		
		// Parse each file

		foreach ($fileIterator as $file)
		{
			// Skip if not a file / directory

			if ($directories === true)
			{
				// Not a directory?

				if ($file->isDir() === false)
				{
					continue;
				}

				
				// Is it . or ..?

				if
				(
					($file->getFilename() === '.') ||
					($file->getFilename() === '..')
				)
				{
					continue;
				}
			}
			else
			{
				// Not a file?

				if ($file->isFile() === false)
				{
					continue;
				}
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


			// Get the absolute or relative filename

			if ($absolute === true)
			{
				$fileName = $file->getRealPath();
			}
			else
			{
				$fileName = $file->getFilename();
			}


			// Store the result

			$result[] = $fileName;
		}
	
		
		return $result;
	}
}

?>
