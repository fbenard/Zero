<?php

// Namespace

namespace fbenard\Zero\Services\Renderers;


/**
 *
 */

class ErrorRenderer
{
	/**
	 *
	 */

	public function renderError($errorCode, $errorTitle, $errorDescription, $errorFile, $errorLine, $errorContext, $errorTraces)
	{
		// Define method name

		if (php_sapi_name() === 'cli')
		{
			$methodName = 'renderErrorCli';
		}
		else
		{
			$methodName = 'renderErrorGui';
		}


		// Render the error

		$result = call_user_func_array
		(
			[
				$this,
				$methodName
			],
			func_get_args()
		);


		// Convert arrays to string

		if (is_array($result) === true)
		{
			$result = implode(null, $result);
		}


		return $result;
	}


	/**
	 *
	 */

	public function renderErrorCli($errorCode, $errorTitle, $errorDescription, $errorFile, $errorLine, $errorContext, $errorTraces)
	{
		// Build result

		$result = [];


		// Display title and description

		if (empty($errorTitle) === false)
		{
			$result[] = "\n\033[1;31m*** \033[1;31m" . $errorTitle . " (" . $errorCode . ")\n";
		}
		
		if (empty($errorDescription) === false)
		{
			$result[] = "\033[0;31m" . $errorDescription . "\n";
		}

		$result[] = "\n";

		
		// Display error location

		if (empty($errorFile) === false)
		{
			$result[] = "\033[1;37mFile:\t\033[0;0m" . $errorFile . "\n";
		}

		if (empty($errorLine) === false)
		{
			$result[] = "\033[1;37mLine:\t\033[0;0m" . $errorLine . "\n";
		}
		
		
		// Display context

		if
		(
			(is_array($errorContext) === true) &&
			(empty($errorContext) === false)
		)
		{
			$result[] = "\n\033[1;37mContext:" . "\n";
			
			foreach ($errorContext as $key => $value)
			{
				$result[] = "\033[0;0m- " . $key . ' = ';

				if (is_object($value) === true)
				{
					$result[] = "\033[0;0m" . '"' . get_class($value) . '"' . "\n";
				}
				else if (is_array($value) === true)
				{
					$result[] = "\n\033[0;0m" . print_r($value, true) . "\n";
				}
				else
				{
					$result[] = "\033[0;0m" . '"' . $value . '"' . "\n";
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
			$result[] = "\n\033[1;37mTrace:" . "\n";
			
			foreach ($errorTraces as $errorTrace)
			{
				if
				(
					(isset($errorTrace['file']) === true) &&
					(isset($errorTrace['line']) === true)
				)
				{
					$result[] = "\033[0;0m- " . basename($errorTrace['file']) . ' (' . $errorTrace['line'] . ')' . "\n";
				}
			}
		}


		// Ensure terminal is back to normal

		$result[] = "\033[0;0m" . "\n";


		return $result;
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
		
		
		// Get HTTP request headers

		$requestHeaders = apache_request_headers();
		$requestHeaders = array_change_key_case($requestHeaders, CASE_LOWER);


		// Build HTTP response headers

		http_response_code(500);

		$responseHeaders =
		[
			'cache-control' => 'private, no-cache, no-store, must-revalidate',
			'content-type' => 'text/html; charset=UTF-8'
		];

		
		// Build the result

		$result = [];

		if
		(
			(array_key_exists('accept-content', $requestHeaders) === true) &&
			($requestHeaders['accept-content'] === 'application/json')
		)
		{
			// Content-Type is application/json

			$responseHeaders['content-type'] = 'application/json; charset=UTF-8';


			// Render the error

			$result = call_user_func_array
			(
				[
					$this,
					'renderErrorJson'
				],
				func_get_args()
			);
		}
		else
		{
			$result = call_user_func_array
			(
				[
					$this,
					'renderErrorHtml'
				],
				func_get_args()
			);
		}


		// Send HTTP response headers

		if (headers_sent() === false)
		{
			foreach ($responseHeaders as $headerCode => $headerValue)
			{
				header($headerCode . ': ' . $headerValue);
			}
		}


		return $result;
	}


	/**
	 *
	 */

	private function renderErrorHtml($errorCode, $errorTitle, $errorDescription, $errorFile, $errorLine, $errorContext, $errorTraces)
	{
		// Build result

		$result = [];


		//

		$result[] = '<html>';
		$result[] = '<body>';


		//

		$result[] = '<h1>' . $errorTitle . ' (' . $errorCode . ')</h1>';
		$result[] = '<p>' . $errorDescription . '</p>';
		

		//

		$result[] = '<hr />';
		$result[] = '<p><strong>File</strong></p>';
		$result[] = '<pre>' . $errorFile . '</pre>';
		$result[] = '<p><strong>Line</strong></p>';
		$result[] = '<pre>' . $errorLine . '</pre>';
		
		
		// Display the context

		if
		(
			(is_array($errorContext) === true) &&
			(empty($errorContext) === false)
		)
		{
			$result[] = '<hr />';
			$result[] = '<h2>Context</h2>';
			
			foreach ($errorContext as $key => $value)
			{
				$result[] = '<p><strong>' . $key . '</strong></p>';
				$result[] = '<pre>' . print_r($value, true) . '</pre>';
			}
		}
		
		
		// Display the trace

		if
		(
			(is_array($errorTraces) === true) &&
			(empty($errorTraces) === false)
		)
		{
			$result[] = '<hr />';
			$result[] = '<h2>Trace</h2>';
			$result[] = '<table>';
			
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

				$result[] = '<tr>';
				$result[] = '<td valign="top"><pre>' . $errorTrace['file'] . '</pre></td>';
				$result[] = '<td valign="top"><pre>' . $errorTrace['line'] . '</pre></td>';
				$result[] = '</tr>';
			}
			
			$result[] = '</table>';
		}


		//

		$result[] = '</body>';
		$result[] = '</html>';


		return $result;
	}


	/**
	 *
	 */

	private function renderErrorJson($errorCode, $errorTitle, $errorDescription, $errorFile, $errorLine, $errorContext, $errorTraces)
	{
		// Build the result

		$result = json_encode
		(
			[
				'errorCode' => $errorCode,
				'errorDescription' => $errorDescription,
				'errorFile' => $errorFile,
				'errorLine' => $errorLine,
				'errorTitle' => $errorTitle,
				'errorTraces' => $errorTraces
			]
		);


		return $result;
	}
}

?>
