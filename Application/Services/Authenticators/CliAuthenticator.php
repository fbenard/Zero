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
