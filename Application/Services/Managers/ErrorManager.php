<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ErrorManager
{
	/**
	 *
	 */
	
	public static function onError($errorCode, $errorDescription, $errorFile = null, $errorLine = null, $errorContext = null)
	{
		// Build error

		$error = new \fbenard\Zero\Classes\Error
		(
			$errorCode,
			$errorCode,
			$errorDescription,
			$errorFile,
			$errorLine,
			$errorContext,
			debug_backtrace()
		);


		// Build error renderer

		$errorRenderer = new \fbenard\Zero\Services\Renderers\ErrorRenderer();


		// Render the error

		$result = $errorRenderer->renderError($error);

		
		// Display the error

		print($result);
	}
}

?>
