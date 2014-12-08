<?php

// Namespace

namespace Zero\Services\Renderers;


/**
 *
 */

class LogRenderer
{
	// Attributes

	private $_templates = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_templates =
		[
			'log/' => "%{message}",
			'log/error' => "*** %{message}",
			'log/information' => "=== %{message}",
			'log/progress' => null,
			'log/success' => "=== %{message}",
			'print/' => "%{message}%{pads}\n",
			'print/error' => "\033[1;31m*** %{message}\033[0;0m%{pads}\n",
			'print/information' => "\033[1;36m=== %{message}\033[0;0m%{pads}\n",
			'print/progress' => "%{message}%{pads}\r",
			'print/success' => "\033[1;32m=== %{message}\033[0;0m%{pads}\n"
		];
	}


	/**
	 *
	 */

	public function formatMessage($message, $templateName)
	{
		// Does the template exist?

		if (isset($this->_templates[$templateName]) === false)
		{
			return $message;
		}


		// Get the template

		$template = $this->_templates[$templateName];


		// Format the message

		$message = str_replace
		(
			'%{message}',
			$message,
			$template
		);
		

		//

		if ($this->isTerminal() === true)
		{
			// Generate pads

			$pads = str_pad(null, @exec('tput cols') - strlen($message) - strlen('%{pads}'), ' ');
		}
		else
		{
			$pads = null;
		}


		// Format the message with pads

		$message = str_replace
		(
			'%{pads}',
			$pads,
			$message
		);


		return $message;
	}


	/**
	 *
	 */

	private function isMute()
	{
		//

		if
		(
			(\z\app()->isRunningCli() === false) ||
			($this->isTerminal() === false)
		)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	/**
	 *
	 */

	public function isTerminal()
	{
		//

		$term = trim(getenv('ENV'));

		if
		(
			(posix_isatty(STDERR) === true)  &&
			(posix_isatty(STDOUT) === true) &&
			($term !== 'dumb')
		)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	/**
	 *
	 */

	public function renderLog($message, $templateName = null)
	{
		// Format the message

		if
		(
			(is_array($message) === true) ||
			(is_object($message) === true)
		)
		{
			$message = print_r($message, true);
		}


		//

		$logMessage = $this->formatMessage($message, 'log/' . $templateName);
		$printMessage = $this->formatMessage($message, 'print/' . $templateName);


		// Print the message

		if ($this->isMute() === false)
		{
			print $printMessage;
		}
	}
}

?>
