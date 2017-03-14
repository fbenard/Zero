<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ExceptionManager
extends \fbenard\Zero\Classes\AbstractService
{
	/**
	 *
	 */
	
	public static function onException(\Exception $exception)
	{
		// Try to get the context

		$exceptionContext = [];

		if (method_exists($exception, 'getContext') === true)
		{
			$exceptionContext = $exception->getContext();
		}


		// Build error

		$error = new \fbenard\Zero\Classes\Error
		(
			$exception->getMessage(),
			$exception->getMessage(),
			$exception->getFile(),
			$exception->getLine(),
			$exceptionContext,
			$exception->getTrace()
		);


		// Build error renderer

		$errorRenderer = new \fbenard\Zero\Services\Renderers\ErrorRenderer();


		// Render the error

		$errorRenderer->renderError($error);
	}
}

?>
