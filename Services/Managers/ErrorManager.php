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
		//
		
		$errorRenderer = new \Zero\Services\Renderers\ErrorRenderer();

		
		// Render the error

		$errorRenderer->renderError
		(
			$errorCode,
			'Error #' . $errorCode,
			$errorDescription,
			$errorFile,
			$errorLine,
			debug_backtrace(),
			$errorContext
		);


		return true;
	}
}

?>
