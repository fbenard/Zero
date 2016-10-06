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
		
		if (\z\app()->isCli() === true)
		{
			// Define the level

			if (\z\app()->isVerbose() === true)
			{
				$level = \Monolog\Logger::DEBUG;
			}
			else
			{
				$level = \Monolog\Logger::INFO;
			}


			// Redirect to standard output

			$handler = new \Monolog\Handler\StreamHandler
			(
				'php://stdout',
				$level
			);


			// Format for CLI

			$handler->setFormatter(new fbenard\Zero\Services\Formatters\CliLogFormatter());
		}
		else
		{
			// Redirect to /dev/null
			
			$handler = new \Monolog\Handler\NullHandler();
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
