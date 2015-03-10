<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Application
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes
	
	private static $_instance = null;
	private $_bootManager = null;
	private $_cacheManager = null;
	private $_serviceManager = null;
	
	
	/**
	 *
	 */
	
	private function __construct()
	{
		//

		$this->_bootManager = new \fbenard\Zero\Services\Managers\BootManager();
		$this->_cacheManager = new \fbenard\Zero\Services\Managers\CacheManager();
		$this->_serviceManager = new \fbenard\Zero\Services\Managers\ServiceManager();
	}

	
	/**
	 *
	 */
	
	public static function getInstance()
	{
		// Create the instance if needed
		
		if (is_null(Application::$_instance) === true)
		{
			\fbenard\Zero\Classes\Application::$_instance = new \fbenard\Zero\Classes\Application();
		}
		
		
		return \fbenard\Zero\Classes\Application::$_instance;
	}

	
	/**
	 *
	 */
	
	private function initialize()
	{
		//

		$this->_bootManager->initialize();
		$this->_serviceManager->initialize();


		//

		\z\service('manager/constant')->initialize();
		\z\service('manager/event')->initialize();
		\z\service('manager/preference')->initialize();
		\z\service('manager/route')->initialize();
		\z\service('manager/string')->initialize();
		\z\service('manager/controller')->initialize();
		\z\service('manager/session')->initialize();
	}
	
	
	/**
	 *
	 */
	
	public function isCli()
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

	public function quit()
	{
		exit();
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
	}
}

?>
