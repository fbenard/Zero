<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class LoggerManager
{
	// Attributes

	private $_handlers = null;
	private $_loggers = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_handlers = [];
		$this->_loggers = [];
	}


	/**
	 *
	 */

	public function getLogger($loggerCode = null)
	{
		//

		if (empty($loggerCode) === true)
		{
			$loggerCode = 'app';
		}


		// Does the logger exist?

		if (array_key_exists($loggerCode, $this->_loggers) === false)
		{
			// Create a new logger

			$logger = new \Monolog\Logger($loggerCode);


			// Setup processors

			$logger->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());
			$logger->pushProcessor(new \Monolog\Processor\ProcessIdProcessor());
			$logger->pushProcessor(new \Monolog\Processor\WebProcessor());


			// In CLI mode, print log
			
			if (\z\app()->isCli() === true)
			{
				$handler = new \Monolog\Handler\StreamHandler
				(
					'php://stdout',
					\Monolog\Logger::DEBUG
				);

				$handler->setFormatter(new \fbenard\Zero\Services\Formatters\CliLogFormatter());

				$logger->pushHandler($handler);
			}


			// Parse each handler

			foreach ($this->_handlers as $handler)
			{
				// Push the handler

				$logger->pushHandler($handler);
			}

			
			// Store the logger

			$this->_loggers[$loggerCode] = $logger;
		}


		//

		$logger = $this->_loggers[$loggerCode];


		return $logger;
	}
}

?>
