<?php

// Make sure Zero exists

$pathToZero = dirname(getcwd()) . '/Components/fbenard/zero/Application/Core/zero-static.php';

if (file_exists($pathToZero) === false)
{
	header('Status: 500 Internal Server Error');
	return;
}


// Load Zero

require_once($pathToZero);


// Render static files

\z\render
(
	[
		'text/css' =>
		[
		],
		'text/javascript' =>
		[
		]
	]
);

?>
