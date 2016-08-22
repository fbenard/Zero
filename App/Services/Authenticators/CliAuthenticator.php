<?php 

// namespace

namespace fbenard\Zero\Services\Authenticators;


/**
 *
 */

class CliAuthenticator
{
	/**
	 *
	 */

	public function check()
	{
		// If the app is not in CLI mode
		// Then permission is not granted
		
		if (\z\app()->isCli() === false)
		{
			\z\e
			(
				EXCEPTION_PERMISSION_NOT_GRANTED
			);
		}
	}
}

?>
