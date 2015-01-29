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
	
	public static function onException($exception)
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

		$error =
		[
			$exception->getCode(),
			$exception->getMessage(),
			null,
			$exceptionFile,
			$exceptionLine,
			$exceptionContext,
			$exception->getTrace()
		];


		// Build error renderer

		$errorRenderer = new \fbenard\Zero\Services\Renderers\ErrorRenderer();


		// Render the error

		$output = call_user_func_array
		(
			[
				$errorRenderer,
				'renderError'
			],
			$error
		);

		
		// Display the output

		print($output);


		// Exit

		if (is_int($exception->getCode()) === true)
		{
			exit($exception->getCode());
		}
		else
		{
			exit(1);
		}
	}
}

?>
