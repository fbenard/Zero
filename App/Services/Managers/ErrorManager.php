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
	
	public static function onError($errorCode, $errorDescription, $errorFile = null, $errorLine = null, $errorContext = null, $errorTraces = null)
	{
		// Build error

		$error = new fbenard\Zero\Classes\Error
		(
			$errorCode,
			$errorDescription,
			$errorFile,
			$errorLine,
			$errorContext,
			$errorTraces
		);


		// Build error renderer

		$errorRenderer = new fbenard\Zero\Services\Renderers\ErrorRenderer();


		// Render the error

		$errorRenderer->renderError($error);
	}
}

?>
