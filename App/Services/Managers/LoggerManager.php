<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class LoggerManager
extends \fbenard\Zero\Classes\AbstractService
{
	// Attributes

	private $_loggers = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_loggers = [];
	}


	/**
	 *
	 */

	public function getLogger($loggerCode = null, $handlers = null)
	{
		// Use the default channel if none provided

		if (empty($loggerCode) === true)
		{
			$loggerCode = 'app';
		}


		// Does the logger exist?

		if (array_key_exists($loggerCode, $this->_loggers) === false)
		{
			// Build the logger

			$logger = $this->getDependency('factory/logger')->buildLogger($loggerCode, $handlers);

			
			// Store the logger

			$this->_loggers[$loggerCode] = $logger;
		}


		// Get the logger

		$logger = $this->_loggers[$loggerCode];


		return $logger;
	}
}

?>
