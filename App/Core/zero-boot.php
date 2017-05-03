<?php

// Display all errors

ini_set('display_errors', 1); 
error_reporting(E_ALL | E_STRICT);


// Build paths

define('PATH_ROOT', getcwd());

define('PATH_APP', PATH_ROOT . '/App');
define('PATH_COMPONENTS', PATH_ROOT . '/Components');
define('PATH_ZERO', PATH_COMPONENTS . '/fbenard/zero/App');


// Dependencies

require_once(PATH_COMPONENTS . '/autoload.php');


// Setup error/exception handlers

set_error_handler('\fbenard\\Zero\\Services\\Managers\\ErrorManager::onError', E_ALL | E_STRICT);
set_exception_handler('\fbenard\\Zero\\Services\\Managers\\ExceptionManager::onException');


// Start the application

\z\app()->run();

?>
