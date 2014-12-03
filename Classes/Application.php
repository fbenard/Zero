<?php

// Namespace

namespace Zero\Classes;


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
	}
	
	
	/**
	 *
	 */
	
	public function isRunningCli()
	{
		if (php_sapi_name() === 'cli')
		{
			return true;
		}
		else
		{
			return false;
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
		
		
		// Finalize the application
		
		$this->finalize();
	}
}

?>
