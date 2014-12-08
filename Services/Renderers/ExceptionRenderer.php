<?php

// Namespace

namespace Zero\Services\Renderers;


/**
 *
 */

class ExceptionRenderer
{
	/**
	 *
	 */
	
	public function renderException($exception)
	{
		// Build an error renderer
		
		$errorRenderer = new \Zero\Services\Renderers\ErrorRenderer();

		
		// Try to get the context

		$exceptionContext = [];

		if (method_exists($exception, 'getContext') === true)
		{
			$exceptionContext = $exception->getContext();
		}


		// Render the exception as an error error

		$errorRenderer->renderError
		(
			$exception->getCode(),
			$exception->getMessage(),
			null,
			$exception->getFile(),
			$exception->getLine(),
			$exceptionContext,
			$exception->getTrace()
		);
	}
}

?>
