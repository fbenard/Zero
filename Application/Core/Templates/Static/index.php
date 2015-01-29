<?php

// Make sure Zero exists

$pathToZero = dirname(getcwd()) . '/Components/fbenard/zero/Application/Core/zero-static.php';

if (file_exists($pathToZero) === false)
{
	header('Status: 500 Internal Server Error');
	die();
}

require_once($pathToZero);


// Render static files

render
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
