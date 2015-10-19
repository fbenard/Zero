<?php

// Setup error reporting

error_reporting(E_ALL | E_STRICT);


// Build paths

define('PATH_ROOT', getcwd());

define('PATH_APPLICATION', PATH_ROOT . '/App');
define('PATH_COMPONENTS', PATH_ROOT . '/Components');
define('PATH_ZERO', PATH_COMPONENTS . '/fbenard/zero/App');


// Dependencies

$dependencies =
[
	PATH_COMPONENTS . '/autoload.php',
	PATH_ZERO . '/Core/zero-shortcuts.php'
];

foreach ($dependencies as $dependency)
{
	if (file_exists($dependency) === false)
	{
		print("Cannot find dependency.\n");
		trigger_error(null, E_USER_ERROR);
	}

	require_once($dependency);
}


// Setup error/exception handlers

set_error_handler('\\fbenard\\Zero\\Services\\Managers\\ErrorManager::onError', E_ALL | E_STRICT);
set_exception_handler('\\fbenard\\Zero\\Services\\Managers\\ExceptionManager::onException');


// Start the application

\z\app()->run();

?>
