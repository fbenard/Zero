<?php

/**
 *
 */

function render($files)
{
	// Send HTTP headers

	header('Content-Type: ' . $_GET['type'] . '; charset=UTF-8');
	header('Status: 200 OK');


	// Render each file

	foreach ($files[$_GET['type']] as $pathToFile)
	{
		// Make sure the file exists

		if (file_exists($pathToFile) === false)
		{
			continue;
		}


		// Display the content of the file

		print(file_get_contents($pathToFile));
	}
}

?>
