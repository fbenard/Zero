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
		// Build error

		$error =
		[
			$errorCode,
			$errorCode,
			$errorDescription,
			$errorFile,
			$errorLine,
			$errorContext,
			debug_backtrace()
		];


		// Build error renderer

		$errorRenderer = new \Zero\Services\Renderers\ErrorRenderer();


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

		if (is_int($errorCode) === true)
		{
			exit($errorCode);
		}
		else
		{
			exit(1);
		}
	}
}

?>
