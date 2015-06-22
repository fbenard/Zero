<?php

// Namespace

namespace fbenard\Zero\Services\Factories;


/**
 *
 */

class LoggerFactory
{
	/**
	 *
	 */

	public function buildLogger($channel, $handlers = null)
	{
		// Create a new logger

		$logger = new \Monolog\Logger($channel);


		// Setup processors

		$logger->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());
		$logger->pushProcessor(new \Monolog\Processor\ProcessIdProcessor());
		$logger->pushProcessor(new \Monolog\Processor\WebProcessor());


		// In CLI mode, print log to standard output
		
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

		if (is_array($handlers) === true)
		{
			foreach ($handlers as $handler)
			{
				// Push the handler

				$logger->pushHandler($handler);
			}
		}


		return $logger;
	}
}

?>
