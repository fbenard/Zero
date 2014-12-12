<?php

// Namespace

namespace Zero\Services\Renderers;


/**
 *
 */

class ErrorRenderer
{
	/**
	 *
	 */
	
	public function renderError($errorCode, $errorTitle, $errorDescription = null, $errorFile = null, $errorLine = null, $errorContext = null, $errorTraces = null)
	{
		// Rendering the error (GUI / CLI)
		
		if (\z\app()->isRunningCli() === true)
		{
			self::renderErrorCli
			(
				$errorCode,
				$errorTitle,
				$errorDescription,
				$errorFile,
				$errorLine,
				$errorContext,
				$errorTraces
			);
		}
		else
		{
			self::renderErrorGui
			(
				$errorCode,
				$errorTitle,
				$errorDescription,
				$errorFile,
				$errorLine,
				$errorContext,
				$errorTraces
			);
		}
	}


	/**
	 *
	 */

	public function renderErrorCli($errorCode, $errorTitle, $errorDescription, $errorFile, $errorLine, $errorContext, $errorTraces)
	{
		// Display title and description

		if (empty($errorTitle) === false)
		{
			print("\n\033[1;31m*** \033[1;31m" . $errorTitle . "\n");
		}
		
		if (empty($errorDescription) === false)
		{
			print("\033[0;31m" . $errorDescription . "\n");
		}

		print("\n");

		
		// Display error code and location

		if (empty($errorCode) === false)
		{
			print("\033[1;37mCode:\t\033[0;0m" . $errorCode . "\n");
		}

		if (empty($errorFile) === false)
		{
			print("\033[1;37mFile:\t\033[0;0m" . $errorFile . "\n");
		}

		if (empty($errorLine) === false)
		{
			print("\033[1;37mLine:\t\033[0;0m" . $errorLine . "\n");
		}
		
		
		// Display context

		if
		(
			(is_array($errorContext) === true) &&
			(empty($errorContext) === false)
		)
		{
			print("\n\033[1;37mContext:" . "\n");
			
			foreach ($errorContext as $key => $value)
			{
				print("\033[0;0m- " . $key . ' = ');

				if (is_object($value) === true)
				{
					print("\033[0;0m" . '"' . get_class($value) . '"' . "\n");
				}
				else if (is_array($value) === true)
				{
					print("\n\033[0;0m" . print_r($value, true) . "\n");
				}
				else
				{
					print("\033[0;0m" . '"' . $value . '"' . "\n");
				}
			}
		}
		
		
		// Display trace

		if
		(
			(is_array($errorTraces) === true) &&
			(empty($errorTraces) === false)
		)
		{
			print("\n\033[1;37mTrace:" . "\n");
			
			foreach ($errorTraces as $errorTrace)
			{
				if
				(
					(isset($errorTrace['file']) === true) &&
					(isset($errorTrace['line']) === true)
				)
				{
					print("\033[0;0m- " . basename($errorTrace['file']) . ' (' . $errorTrace['line'] . ')' . "\n");
				}
			}
		}
		
		
		// Ensure terminal is back to normal

		print("\033[0;0m" . "\n");
		

		// Always exit with an error code

		if (is_int($errorCode) === true)
		{
			exit($errorCode);
		}
		else
		{
			exit(1);	
		}
	}


	/**
	 *
	 */

	public function renderErrorGui($errorCode, $errorTitle, $errorDescription, $errorFile, $errorLine, $errorContext, $errorTraces)
	{
		// Clean the buffer
		
		$handlers = ob_list_handlers();
		
		while (empty($handlers) == false)
		{
			ob_end_clean();
			$handlers = ob_list_handlers();
		}
		
		
		//

		$headers = apache_request_headers();

		
		//

		header('Status: 500 Internal Server Error');
		header('Cache-Control: private, no-cache, no-store, must-revalidate');


		//

		if
		(
			(array_key_exists('Accept', $headers) === true) &&
			($headers['Accept'] === 'application/json')
		)
		{
			//

			header('Content-Type: application/json; charset=UTF-8');


			//

			print
			(
				json_encode
				(
					[
						'errorCode' => $errorCode,
						'errorDescription' => $errorDescription,
						'errorFile' => $errorFile,
						'errorLine' => $errorLine,
						'errorTitle' => $errorTitle,
						'errorTraces' => $errorTraces
					]
				)
			);
		}
		else
		{
			//

			header('Content-Type: text/html; charset=UTF-8');


			//

			print('<html>');
			print('<body>');


			//

			print('<h1>' . $errorTitle . '</h1>');
			print('<p>' . $errorDescription . '</p>');
			

			//

			print('<hr />');
			print('<p><strong>Code</strong></p>');
			print('<pre>' . $errorCode . '</pre>');
			print('<p><strong>File</strong></p>');
			print('<pre>' . $errorFile . '</pre>');
			print('<p><strong>Line</strong></p>');
			print('<pre>' . $errorLine . '</pre>');
			
			
			// Display the context

			if
			(
				(is_array($errorContext) === true) &&
				(empty($errorContext) === false)
			)
			{
				print('<hr />');
				print('<h2>Context</h2>');
				
				foreach ($errorContext as $key => $value)
				{
					print('<p><strong>' . $key . '</strong></p>');
					print('<pre>' . print_r($value, true) . '</pre>');
				}
			}
			
			
			// Display the trace

			if
			(
				(is_array($errorTraces) === true) &&
				(empty($errorTraces) === false)
			)
			{
				print('<hr />');
				print('<h2>Trace</h2>');
				print('<table>');
				
				foreach ($errorTraces as $errorTrace)
				{
					$errorTrace = array_merge
					(
						[
							'file' => null,
							'line' => null,
							'class' => null,
							'function' => null,
							'type' => '::',
							'args' => null
						],
						$errorTrace
					);

					print('<tr>');
					print('<td valign="top"><pre>' . $errorTrace['file'] . '</pre></td>');
					print('<td valign="top"><pre>' . $errorTrace['line'] . '</pre></td>');
					print('<td valign="top"><pre>' . $errorTrace['class'] . '::' . $errorTrace['function'] . '</pre></td>');
					print('<td valign="top"><pre>' . print_r($errorTrace['args'], true) . '</pre></td>');
					print('</tr>');
				}
				
				print('</table>');
			}


			//

			print('</body>');
			print('</html>');
		}


		// Quit the application

		die();
	}
}

?>
