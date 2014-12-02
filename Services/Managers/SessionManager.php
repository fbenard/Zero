<?php

// Namespace

namespace Zero\Services\Managers;


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
		//

		if (app()->isRunningCli() === true)
		{
			return;
		}


		//

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
		//
		
		if (app()->isRunningCli() === true)
		{
			return;
		}


		//

		session_unset();
		session_destroy();
		
		
		//

		setcookie('sessionKey', '');
	}
}

?>
