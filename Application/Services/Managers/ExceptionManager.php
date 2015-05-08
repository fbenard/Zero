<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ExceptionManager
{
	/**
	 *
	 */
	
	public static function onException(\Exception $exception)
	{
		// Try to get the file

		$exceptionFile = $exception->getFile();

		if (method_exists($exception, 'computeFile') === true)
		{
			$exceptionFile = $exception->computeFile();
		}


		// Try to get the line

		$exceptionLine = $exception->getLine();

		if (method_exists($exception, 'computeLine') === true)
		{
			$exceptionLine = $exception->computeLine();
		}


		// Try to get the context

		$exceptionContext = [];

		if (method_exists($exception, 'getContext') === true)
		{
			$exceptionContext = $exception->getContext();
		}


		// Build error

		$error = new \fbenard\Zero\Classes\Error
		(
			$exception->getCode(),
			$exception->getMessage(),
			$exceptionFile,
			$exceptionLine,
			$exceptionContext,
			$exception->getTrace()
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
