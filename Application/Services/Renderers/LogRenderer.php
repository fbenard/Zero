<?php

// Namespace

namespace fbenard\Zero\Services\Renderers;


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
			null => "%{message}%{pads}\n",
			'error' => "\033[1;31m*** %{message}\033[0;0m%{pads}\n",
			'information' => "\033[1;36m=== %{message}\033[0;0m%{pads}\n",
			'progress' => "%{message}%{pads}\r",
			'prompt' => "\033[1;33m*** %{message}\033[0;0m",
			'success' => "\033[1;32m=== %{message}\033[0;0m%{pads}\n"
		];
	}


	/**
	 *
	 */

	public function formatMessage($message, $templateCode)
	{
		// Does the template exist?

		if (isset($this->_templates[$templateCode]) === false)
		{
			return $message;
		}


		// Get the template

		$template = $this->_templates[$templateCode];


		// Format the message

		$message = str_replace
		(
			'%{message}',
			$message,
			$template
		);
		

		// Generate pads

		$pads = str_pad(null, @exec('tput cols') - strlen($message) - strlen('%{pads}'), ' ');


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

		if (\z\app()->isCli() === true)
		{
			return false;
		}
		else
		{
			return true;
		}
	}


	/**
	 *
	 */

	public function renderLog($message, $templateCode = null)
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


		// Format the output

		$output = $this->formatMessage($message, $templateCode);


		// Print the output

		if ($this->isMute() === false)
		{
			print $output;
		}
	}
}

?>
