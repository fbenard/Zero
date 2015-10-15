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


		// Are we in CLI/verbose mode?
		
		if
		(
			(\z\app()->isCli() === true) &&
			(\z\app()->isVerbose() === true)
		)
		{
			// Redirect to standard output

			$handler = new \Monolog\Handler\StreamHandler
			(
				'php://stdout',
				\Monolog\Logger::DEBUG
			);


			// Format for CLI

			$handler->setFormatter(new \fbenard\Zero\Services\Formatters\CliLogFormatter());
		}
		else
		{
			// Redirect to log.txt

			$handler = new \Monolog\Handler\StreamHandler
			(
				'log.txt',
				\Monolog\Logger::DEBUG
			);
		}

		
		// Push the handler

		$logger->pushHandler($handler);


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
