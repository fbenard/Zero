<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class SessionManager
extends \fbenard\Zero\Classes\AbstractService
{
	/**
	 *
	 */
	
	public function initialize()
	{
		// No session in CLI

		if (\z\app()->isCli() === true)
		{
			return;
		}


		// Start the session
		
		session_start();
	}
	
	
	/**
	 *
	 */
	
	public function reset()
	{
		// No session in CLI

		if (\z\app()->isCli() === true)
		{
			return;
		}


		// Destroy the session

		session_unset();
		session_destroy();
		
		
		// Destroy the cookie

		setcookie('sessionKey', '');
	}
}

?>
