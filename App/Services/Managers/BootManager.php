<?php
	
// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class BootManager
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Managers\BootManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes

	private $_cache = null;
	private $_dependencies = null;
	private $_environment = null;


	/**
	 *
	 */
	
	public function __construct()
	{
		// Define dependencies

		$this->defineDependency('factory/boot', 'fbenard\Zero\Interfaces\Factories\BootFactory');
	}


	/**
	 *
	 */

	public function initialize()
	{
		// Load boot

		$boot = $this->getDependency('factory/boot')->loadBoot();


		// Build attributes

		$this->_cache = $boot['cache'];
		$this->_dependencies = $boot['dependencies'];
		$this->_environment = $boot['environment'];


		// Fix dependencies

		$this->_dependencies = $this->getDependency('factory/boot')->fixDependencies($this->_dependencies);


		// Are we in CLI mode?

		if (\z\app()->isCli() === true)
		{
			// Grab environment
			
			$request = new \fbenard\Zero\Classes\Request();

			$environment = $request->argument('env');


			// Store environment

			if (empty($environment) === false)
			{
				$this->_environment = $environment;
			}
		}
		else if
		(
			(array_key_exists('hosts', $boot) === true) &&
			(array_key_exists($_SERVER['SERVER_NAME'], $boot['hosts']) === true)
		)
		{
			// Grab the host

			$host = $boot['hosts'][$_SERVER['SERVER_NAME']];


			// Grab environment

			if (array_key_exists('environment', $host) === true)
			{
				$this->_environment = $host['environment'];
			}
		}
	}
}

?>
