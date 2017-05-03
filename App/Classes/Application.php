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
	use \fbenard\Zero\Traits\DependantTrait;

	
	// Attributes
	
	private static $_instance = null;
	
	
	/**
	 *
	 */
	
	private function __construct()
	{
		// Define dependencies

		$this->defineDependency('manager/boot', 'fbenard\Zero\Interfaces\Managers\BootManager');
		$this->defineDependency('manager/cache', 'fbenard\Zero\Interfaces\Managers\CacheManager');
		$this->defineDependency('manager/controller', 'fbenard\Zero\Interfaces\Managers\ControllerManager');
		$this->defineDependency('manager/culture', 'fbenard\Zero\Interfaces\Managers\CultureManager');
		$this->defineDependency('manager/event', 'fbenard\Zero\Interfaces\Managers\EventManager');
		$this->defineDependency('manager/preference', 'fbenard\Zero\Interfaces\Managers\PreferenceManager');
		$this->defineDependency('manager/route', 'fbenard\Zero\Interfaces\Managers\RouteManager');
		$this->defineDependency('manager/service', 'fbenard\Zero\Interfaces\Managers\ServiceManager');
		$this->defineDependency('manager/session', 'fbenard\Zero\Interfaces\Managers\SessionManager');

		
		// Inject dependencies

		$this->injectDependency
		(
			'manager/boot',
			new \fbenard\Zero\Services\Managers\BootManager()
		);

		$this->injectDependency
		(
			'manager/cache',
			new \fbenard\Zero\Services\Managers\CacheManager()
		);

		$this->injectDependency
		(
			'manager/service',
			new \fbenard\Zero\Services\Managers\ServiceManager()
		);
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
	
	public function initialize()
	{
		// Initialize managers

		$this->getDependency('manager/boot')->initialize($this->isCli());
		$this->getDependency('manager/service')->initialize();
		$this->getDependency('manager/constant')->initialize();
		$this->getDependency('manager/event')->initialize();
		$this->getDependency('manager/preference')->initialize();
		$this->getDependency('manager/session')->initialize();
		$this->getDependency('manager/culture')->initialize();
		$this->getDependency('manager/route')->initialize();
		$this->getDependency('manager/controller')->initialize();


		// Dispatch AppInit event

		$this->getDependency('manager/event')->dispatchEvent
		(
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

		$this->getDependency('manager/controller')->run();


		// Quit the application

		$this->quit();
	}
}

?>
