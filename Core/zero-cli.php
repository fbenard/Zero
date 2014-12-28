#!/usr/bin/env php
<?php

/**
 *
 */

function install()
{
	// Log

	display('Installing Zero CLI...', 'info');

	
	// Install zero-cli and zero-app

	$pathToZero = __DIR__ . '/';

	execute
	(
		[
			'rm -f /usr/local/bin/zero',
			'rm -f /usr/local/bin/app',
			'ln -s ' . $pathToZero . 'zero-cli.php /usr/local/bin/zero',
			'ln -s ' . $pathToZero . 'zero-app.php /usr/local/bin/app',
			'sudo chmod 755 /usr/local/bin/zero',
			'sudo chmod 755 /usr/local/bin/app'
		]
	);
	

	// Log

	display('Zero CLI successfully installed!', 'success');
}


/**
 *
 */

function create()
{
	/*
	- Application
		- Preferences
			- Boot.json
	- index.php
	- .htaccess
	*/
}


/**
 *
 */

function display($message, $templateCode = null)
{
	// Build templates

	$templates =
	[
		null => "\033[0;37m%{message}\033[0;0m\n",
		'error' => "\033[1;31m*** %{message}\033[0;0m\n",
		'info' => "\033[1;36m=== %{message}\033[0;0m\n",
		'progress' => "%{message}\r",
		'prompt' => "\033[1;33m*** %{message}\033[0;0m",
		'success' => "\033[1;32m=== %{message}\033[0;0m\n"
	];


	// Does the template exist?

	if (isset($templates[$templateCode]) === false)
	{
		print $message;
	}


	// Get the template

	$template = $templates[$templateCode];


	// Format the output

	$output = str_replace
	(
		'%{message}',
		$message,
		$template
	);


	// Print the output

	print($output);
}


/**
 *
 */

function execute($commands)
{
	foreach ($commands as $command)
	{
		if (verbose() === true)
		{
			display($command);
		}

		exec($command);
	}
}


/**
 *
 */

function help()
{
	display('Zero CLI', 'info');
	display('Usage: zero [action]');
	display('Commands:');
	display("\t" . 'help' . "\t\t" . 'Displays this help');
	display("\t" . 'install' . "\t\t" . 'Installs Zero CLI');
	display("\t" . 'create' . "\t\t" . 'Creates a new application');
}


/**
 *
 */

function main()
{
	// Globals

	global $argv;
	

	//

	if (array_key_exists(1, $argv) === true)
	{
		$action = $argv[1];
	}


	//

	if (function_exists($action) === false)
	{
		help();
	}


	//

	$action();
}


/**
 *
 */

function verbose()
{
	// Globals

	global $argv;

	
	//

	if (in_array('--verbose', $argv) === true)
	{
		return true;
	}
	else
	{
		return false;
	}
}


//

main();

?>
