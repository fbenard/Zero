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


		// Render the exception as an error error

		$errorRenderer->renderError
		(
			$exception->getCode(),
			$exception->getMessage(),
			null,
			$exceptionFile,
			$exceptionLine,
			$exceptionContext,
			$exception->getTrace()
		);
	}
}

?>
