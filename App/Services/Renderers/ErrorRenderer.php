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

	public function renderError(\fbenard\Zero\Classes\Error $error)
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

		$result = $this->$methodName($error);


		// Convert arrays to string

		if (is_array($result) === true)
		{
			$result = implode(null, $result);
		}

		
		// Set the HTTP status code to 500

		http_response_code(500);


		// Display the result

		print($result);


		// Exit

		exit(1);
	}


	/**
	 *
	 */

	public function renderErrorCli(\fbenard\Zero\Classes\Error $error)
	{
		// Build result

		$result = [];


		// Display title and description

		$result[] = "\n\033[1;31m*** \033[1;31m" . $error->title . " (" . $error->code . ")\n";
		$result[] = "\033[0;31m" . $error->description . "\n";
		$result[] = "\n";

		
		// Display error location

		$result[] = "\033[1;37mFile:\t\033[0;0m" . str_replace(getcwd(), null, $error->file) . "\n";
		$result[] = "\033[1;37mLine:\t\033[0;0m" . $error->line . "\n";
		
		
		// Display context

		$result[] = "\n\033[1;37mContext:" . "\n";
		
		foreach ($error->context as $key => $value)
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
		
		
		// Display trace

		$result[] = "\n\033[1;37mTrace:" . "\n";
		
		foreach ($error->traces as $errorTrace)
		{
			if
			(
				(isset($errorTrace['file']) === true) &&
				(isset($errorTrace['line']) === true)
			)
			{
				$result[] = "\033[0;0m- " . str_replace(getcwd(), null, $errorTrace['file']) . ' (' . $errorTrace['line'] . ')' . "\n";
			}
		}


		// Ensure terminal is back to normal

		$result[] = "\033[0;0m" . "\n";


		return $result;
	}


	/**
	 *
	 */

	public function renderErrorGui(\fbenard\Zero\Classes\Error $error)
	{
		// Clean the buffer
		
		$handlers = ob_list_handlers();
		
		while (empty($handlers) === false)
		{
			ob_end_clean();
			$handlers = ob_list_handlers();
		}
		
		
		// Get HTTP request headers

		$requestHeaders = apache_request_headers();
		$requestHeaders = array_change_key_case($requestHeaders, CASE_LOWER);


		// Build HTTP response headers

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

			$result = $this->renderErrorJson($error);
		}
		else
		{
			$result = $this->renderErrorHtml($error);
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

	private function renderErrorHtml(\fbenard\Zero\Classes\Error $error)
	{
		// Build result

		$result = [];


		// Render the header

		$result[] = '<html>';
		$result[] = '<body>';


		// Render the title and description

		$result[] = '<h1>' . $error->title . ' (' . $error->code . ')</h1>';
		$result[] = '<p>' . $error->description . '</p>';
		

		// Render the location

		$result[] = '<hr />';
		$result[] = '<p><strong>File</strong></p>';
		$result[] = '<pre>' . str_replace(getcwd(), null, $error->file) . '</pre>';
		$result[] = '<p><strong>Line</strong></p>';
		$result[] = '<pre>' . $error->line . '</pre>';
		

		// Render the context

		$result[] = '<hr />';
		$result[] = '<h2>Context</h2>';
		
		if (is_array($error->context) === true)
		{			
			foreach ($error->context as $key => $value)
			{
				$result[] = '<p><strong>' . $key . '</strong></p>';
				$result[] = '<pre>' . print_r($value, true) . '</pre>';
			}
		}
		
		
		// Render the trace

		$result[] = '<hr />';
		$result[] = '<h2>Trace</h2>';
		$result[] = '<table>';
		
		if (is_array($error->traces) === true)
		{
			foreach ($error->traces as $errorTrace)
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
				$result[] = '<td valign="top"><pre>' . str_replace(getcwd(), null, $errorTrace['file']) . '</pre></td>';
				$result[] = '<td valign="top"><pre>' . $errorTrace['line'] . '</pre></td>';
				$result[] = '</tr>';
			}
		}
			
		$result[] = '</table>';


		//

		$result[] = '</body>';
		$result[] = '</html>';


		return $result;
	}


	/**
	 *
	 */

	private function renderErrorJson(\fbenard\Zero\Classes\Error $error)
	{
		// Build the result

		$result = json_encode
		(
			[
				'code' => $error->code,
				'context' => $error->context,
				'description' => $error->description,
				'file' => $error->file,
				'line' => $error->line,
				'title' => $error->title,
				'traces' => $error->traces
			]
		);


		return $result;
	}
}

?>
