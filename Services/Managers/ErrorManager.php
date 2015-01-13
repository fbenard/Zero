<?php

// Namespace

namespace Zero\Services\Managers;


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
		// Build error renderer

		$errorRenderer = new \Zero\Services\Renderers\ErrorRenderer();

		
		// Render the error

		$errorRenderer->renderError
		(
			$errorCode,
			'Error #' . $errorCode,
			$errorDescription,
			$errorFile,
			$errorLine,
			$errorContext,
			debug_backtrace()
		);


		return true;
	}
}

?>
