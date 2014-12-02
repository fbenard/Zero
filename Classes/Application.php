<?php

// Namespace

namespace Zero\Classes;


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

require_once(PATH_ZERO . 'Services/Managers/ErrorManager.php');
require_once(PATH_ZERO . 'Services/Managers/ExceptionManager.php');
require_once(PATH_ZERO . 'Services/Managers/ServiceManager.php');
require_once(PATH_ZERO . 'Shortcuts.php');


// Setup error/exception handlers

set_error_handler('\\Zero\\Services\\Managers\\ErrorManager::onError', E_ALL | E_STRICT);
set_exception_handler('\\Zero\\Services\\Managers\\ExceptionManager::onException');


/**
 *
 */

class Application
{
	// Attributes
	
	private static $_instance = null;
	public $_serviceManager = null;
	
	
	/**
	 *
	 */
	
	private function __construct()
	{
		$this->_serviceManager = new \Zero\Services\Managers\ServiceManager();
		$this->_serviceManager->initialize();
	}
	
	
	/**
	 *
	 */
	
	private function finalize()
	{
		// If in CLI mode, exit with 0

		if ($this->isRunningCli() === true)
		{
			exit(0);
		}
	}

	
	/**
	 *
	 */
	
	public static function getInstance()
	{
		// Create the application if needed
		
		if (is_null(Application::$_instance) === true)
		{
			\Zero\Classes\Application::$_instance = new \Zero\Classes\Application();
		}
		
		
		return \Zero\Classes\Application::$_instance;
	}

	
	/**
	 *
	 */
	
	private function initialize()
	{
		// Initialize CLI

		if ($this->isRunningCli() === true)
		{
			ini_set('memory_limit', '-1');
		}


		// Initialize managers

		service('manager/constant')->initialize();
		service('manager/universe')->initialize();
		service('manager/environment')->initialize();
		service('manager/route')->initialize();
		service('manager/controller')->initialize();
		service('manager/preference')->initialize();
		service('manager/session')->initialize();
		//service('manager/user')->initialize();
	}
	
	
	/**
	 *
	 */
	
	public function isRunningCli()
	{
		if
		(
			(array_key_exists('HTTP_HOST', $_SERVER) === true) &&
			(empty($_SERVER['HTTP_HOST']) === false)
		)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
	/**
	 *
	 */
	
	public function run()
	{
		// Initialize the application

		$this->initialize();
		
		
		// Run the controller manager

		service('manager/controller')->run();
		
		
		// FInalize the application
		
		$this->finalize();
	}
}

?>
