#!/usr/bin/env php
<?php

// Namespace

namespace z;


/**
 *
 */

function install()
{
	// Log

	\z\display('Installing Zero CLI...', 'info');

	
	// Install zero-cli and zero-app

	$pathToZero = __DIR__ . '/';

	\z\execute
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

	\z\display('Zero CLI successfully installed!', 'success');
}


/**
 *
 */

function create()
{
	// Log

	\z\display('Creating a new application...', 'info');


	// Get the application code

	do
	{
		\z\display('App code: ', 'prompt');
		$applicationCode = readline();
	}
	while (empty($applicationCode) === true);

	
	// Create the application

	$pathToZero = __DIR__ . '/';
	$pathToApplication = getcwd() . '/';// . $applicationCode . '/';

	\z\execute
	(
		[
			'mkdir -p ' . $pathToApplication,
			'mkdir -p ' . $pathToApplication . 'Application',
			'mkdir -p ' . $pathToApplication . 'Static',
			'cp -R ' . $pathToZero . 'Templates/index.php ' . $pathToApplication . 'index.php',
			'cp ' . $pathToZero . 'Templates/_.gitignore ' . $pathToApplication . '.gitignore',
			'cp ' . $pathToZero . 'Templates/_.htaccess ' . $pathToApplication . '.htaccess',
			'cp ' . $pathToZero . 'Templates/composer.json ' . $pathToApplication . 'composer.json'
		]
	);


	// Log

	\z\display('Application successfully created!', 'success');
}


/**
 *
 */

function display($message = null, $templateCode = null)
{
	// Build templates

	$templates =
	[
		null => "\033[0;37m%{message}\033[0;0m\n",
		'error' => "\033[1;31m*** %{message}\033[0;0m\n",
		'info' => "\033[1;36m=== %{message}\033[0;0m\n",
		'progress' => "%{message}\r",
		'prompt' => "\033[1;33m=== %{message}\033[0;0m",
		'success' => "\033[1;32m=== %{message}\033[0;0m\n"
	];


	// Does the template exist?

	if (array_key_exists($templateCode, $templates) === false)
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
	// For each command

	foreach ($commands as $command)
	{
		// Display it if --verbose

		if (\z\verbose() === true)
		{
			\z\display($command);
		}

		
		// Execute the command

		exec($command);
	}
}


/**
 *
 */

function help()
{
	\z\display('Zero CLI', 'info');
	\z\display('Usage: zero [action]');
	\z\display('Commands:');
	\z\display("\t" . 'create' . "\t\t" . 'Creates a new application');
	\z\display("\t" . 'help' . "\t\t" . 'Displays this help');
	\z\display("\t" . 'install' . "\t\t" . 'Installs Zero CLI');
	\z\display("\t" . 'update' . "\t\t" . 'Updates an existing application');
}


/**
 *
 */

function main()
{
	// Define the action

	$action = 'help';

	if (array_key_exists(1, $GLOBALS['argv']) === true)
	{
		$action = '\\z\\' . $GLOBALS['argv'][1];
	}


	// Execute the action

	$action();
}


/**
 *
 */

function update()
{
	// Log

	\z\display('Updating application...', 'info');

	
	// Update the application

	$pathToZero = __DIR__ . '/';
	$pathToApplication = getcwd() . '/';

	\z\execute
	(
		[
			'mkdir -p ' . $pathToApplication,
			'mkdir -p ' . $pathToApplication . 'Application',
			'mkdir -p ' . $pathToApplication . 'Temporary',
			'cp ' . $pathToZero . 'Templates/index.php ' . $pathToApplication . 'index.php',
			'cp ' . $pathToZero . 'Templates/_.htaccess ' . $pathToApplication . '.htaccess',
			'chmod -R 755 ' . $pathToApplication . 'Temporary'
		]
	);


	// Log

	\z\display('Application successfully updated!', 'success');
}


/**
 *
 */

function verbose()
{
	//

	if (in_array('--verbose', $GLOBALS['argv']) === true)
	{
		return true;
	}
	else
	{
		return false;
	}
}


//

\z\main();

?>
