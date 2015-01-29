<?php

// Namespace

namespace fbenard\Zero\Classes;


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
		// Create the instance if needed
		
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
		\z\service('manager/constant')->initialize();
		\z\service('manager/boot')->initialize();
		\z\service('manager/route')->initialize();
		\z\service('manager/controller')->initialize();
		\z\service('manager/preference')->initialize();
		\z\service('manager/session')->initialize();
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

		\z\service('manager/controller')->run();
		
		
		// Finalize the application
		
		$this->finalize();
	}
}

?>
