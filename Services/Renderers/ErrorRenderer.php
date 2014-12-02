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
		
		if (app()->isRunningCli() === true)
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
		
		
		// Display trace

		if
		(
			(is_array($errorTraces) === true) &&
			(empty($errorTraces) === false)
		)
		{
			print("\033[1;37mTrace:" . "\n");
			
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


			// Display public information
			
			print('<h1>' . $errorTitle . '</h1>');
			
			if (empty($errorDescription) === false)
			{
				print('<p>' . $errorDescription . '</p>');
			}

			print('<h2>Code</h2>');
			print('<p>' . $errorCode . '</p>');


			// Display location

			print('<h2>Location</h2>');
			print('<p>' . $errorFile . ' (' . $errorLine . ')</p>');
			
			
			// If there are traces, display each

			if
			(
				(is_array($errorTraces) === true) &&
				(empty($errorTraces) === false)
			)
			{
				print('<h2>Trace</h2>');
				print('<table>');
				print('<thead>');
				print('<tr>');
				print('<th colspan="2">Location</th>');
				print('<th>Class</th>');
				print('<th>Function</th>');
				print('</tr>');
				print('</thead>');
				print('</tbody>');
				
				foreach ($errorTraces as $errorTrace)
				{
					print('<tr>');
					print('<td>');
					
					if (isset($errorTrace['file']) === true)
					{
						print($errorTrace['file']);
					}
					
					print('</td>');
					print('<td>');
					
					if (isset($errorTrace['line']) === true)
					{
						print($errorTrace['line']);
					}
					
					print('</td>');
					print('<td>');
					
					if (isset($errorTrace['class']) === true)
					{
						print($errorTrace['class']);
					}
					
					print('</td>');
					print('<td>');
					
					if (isset($errorTrace['function']) === true)
					{
						print($errorTrace['function']);
					}
					
					print('</td>');
					print('</tr>');
				}
				
				print('</tr>');
				print('</tbody>');
				print('</table>');
			}


			//

			print('</body>');
			print('</html>');
		}


		// Make sure we quit the application

		die();
	}
}

?>
