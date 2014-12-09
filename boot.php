<?php

// Setup error reporting

error_reporting(E_ALL | E_STRICT);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 'on');


// Build paths

define('PATH_ROOT', getcwd() . '/');

define('PATH_APPLICATION', PATH_ROOT . 'Application/');
define('PATH_COMPONENTS', PATH_ROOT . 'Components/');
define('PATH_TEMPORARY', PATH_ROOT . 'Temporary/');
define('PATH_ZERO', PATH_COMPONENTS . 'fbenard/zero/');


// Dependencies

require_once(PATH_COMPONENTS . 'autoload.php');
require_once(PATH_ZERO . 'Shortcuts.php');


// Setup error/exception handlers

set_error_handler('\\Zero\\Services\\Managers\\ErrorManager::onError', E_ALL | E_STRICT);
set_exception_handler('\\Zero\\Services\\Managers\\ExceptionManager::onException');


// Start the application

\z\app()->run();

?>