<?php 

// namespace

namespace Zero\Services\Managers;


// Dependencies

require_once(PATH_APPLICATION . 'Services/Drivers/GitHub3Driver.php');


/**
 *
 */

class UserManager
{
	/**
	 *
	 */

	public function initialize()
	{
		// No need to initialize in CLI

		if (app()->isRunningCli() === true)
		{
			return;
		}
		

		//

		$uri = app()->getPathHelper()->getCurrentUrl(false, false, false, true, false);
		
		$uris =
		[
			'/' . pref('[Goloboard]/gitHub/oauth/callback'),
			'/action/UserManager.signOut',
			'/en/page/home/'
		];

		$accessKey = v('SESSION::auth_accessKey');

		
		// Do we need to authenticate?

		if
		(
			(empty($accessKey) === true) &&
			(in_array($uri, $uris) === false)
		)
		{
			// APIs cannot authenticate

			$headers = apache_request_headers();

			if
			(
				(array_key_exists('Accept', $headers) === true) &&
				($headers['Accept'] === 'application/json')
			)
			{
				e(EXCEPTION_PERMISSION_NOT_GRANTED);
			}


			// Store the current URL for later redirection

			v('SESSION::previousUrl', app()->getPathHelper()->getCurrentUrl());

			
			// Authenticate with GitHub

			$gitHubDriver = new \Goloboard\Drivers\GitHub3Driver();
			$gitHubDriver->startConnection();
		}
	}
}

?>
