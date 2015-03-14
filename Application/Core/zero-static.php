<?php

// Namespace

namespace z;


/**
 *
 */

function render($dependencies)
{
	// There must be a type

	if (array_key_exists('type', $_GET) === false)
	{
		return;
	}


	// Send HTTP headers

	header('Content-Type: ' . $_GET['type'] . '; charset=UTF-8');
	header('Status: 200 OK');


	// Render shared dependencies

	\z\renderDependencies
	(
		'*',
		$_GET['type'],
		$dependencies
	);


	// Render dependencies for the URI

	if (array_key_exists('uri', $_GET) === true)
	{
		\z\renderDependencies
		(
			$_GET['uri'],
			$_GET['type'],
			$dependencies
		);
	}
}


/**
 *
 */

function renderDependencies($groupCode, $contentType, $dependencies)
{
	// Check whether there are dependencies

	if
	(
		(is_array($dependencies) === false) ||
		(array_key_exists($contentType, $dependencies) === false) ||
		(is_array($dependencies[$contentType]) === false) ||
		(array_key_exists($groupCode, $dependencies[$contentType]) === false) ||
		(is_array($dependencies[$contentType][$groupCode]) === false)
	)
	{
		return;
	}


	// Render each dependency

	foreach ($dependencies[$contentType][$groupCode] as $dependency)
	{
		\z\renderFile($dependency);
	}
}


/**
 *
 */

function renderFile($file)
{
	// Check whether the file exists

	if (file_exists($file) === false)
	{
		continue;
	}


	// Display the content of the file

	print(file_get_contents($file));
}

?>
