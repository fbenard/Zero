<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class SessionManager
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


		// Extend duration of session to a week

		$duration = 7 * 24 * 60 * 60;

		ini_set('session.gc_maxlifetime', $duration);
		ini_set('session.cookie_lifetime', $duration);


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
