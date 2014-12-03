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
		//
		
		$errorRenderer = new \Zero\Services\Renderers\ErrorRenderer();

		
		// Render the error

		$errorRenderer->renderError
		(
			$exception->getCode(),
			$exception->getMessage(),
			null,
			$exception->getFile(),
			$exception->getLine(),
			null,
			$exception->getTrace()
		);
	}
}

?>
