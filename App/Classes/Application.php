<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Application
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
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
		// Build low-level managers

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
		// Initialize core managers

		$this->_bootManager->initialize();
		$this->_serviceManager->initialize();


		// Initialize managers

		\z\service('manager/constant')->initialize();
		\z\service('manager/event')->initialize();
		\z\service('manager/preference')->initialize();
		\z\service('manager/session')->initialize();
		\z\service('manager/culture')->initialize();
		\z\service('manager/route')->initialize();
		\z\service('manager/controller')->initialize();


		// Dispatch EVENT_APP_INIT event

		\z\dispatch
		(
			EVENT_APP_INIT,
			new \fbenard\Zero\Events\AppInitEvent($this)
		);
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

	public function isEmbedded()
	{
		// Get the environment variable

		$isEmbedded = (bool)(intval(getenv('ZERO_EMBEDDED')));


		// Is the app embedded?

		if ($isEmbedded === true)
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

	public function isVerbose()
	{
		if
		(
			(array_key_exists('argv', $GLOBALS) === true) &&
			(in_array('--verbose', $GLOBALS['argv']) === true)
		)
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
		// Exit the process
		// Do not exit if app is embedded

		if (\z\app()->isEmbedded() === true)
		{
			return;
		}
		else
		{
			exit();
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


		// Quit the application

		$this->quit();
	}
}

?>
