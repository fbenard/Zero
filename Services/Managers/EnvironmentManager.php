<?php
	
// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class EnvironmentManager
{
	// Attributes

	public $_environment = null;


	/**
	 *
	 */

	public function initialize()
	{
		//

		$environment = 'Prod';
		
		if (app()->isRunningCli() === true)
		{
			global $argv;
			
			if (array_key_exists('env', $argv) === true)
			{
				$environment = $argv('env');
			}
		}
		else
		{
			//

			$hostFragments = explode('.', $_SERVER['SERVER_NAME']);
			
			$environments =
			[
				'local'
			];

			if
			(
				(array_key_exists(0, $hostFragments) === true) &&
				(in_array($hostFragments[0], $environments) === true)
			)
			{
				$environment = ucfirst($hostFragments[0]);
			}			
		}

		
		//

		if (empty($environment) === false)
		{
			$this->_environment = $environment;
		}
	}
}


?>