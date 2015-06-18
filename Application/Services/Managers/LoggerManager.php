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


			// Parse each handler

			//$logger->pushFormatter(new \fbenard\Zero\Services\Formatters\CliLogFormatter());

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


	/**
	 *
	 */

	public function progress($nbItemsCompleted, $nbItems, &$timeOfStart, $message = null)
	{
		//

		if ($nbItems === 0)
		{
			$nbItems = 1;
		}

		$progress = round($nbItemsCompleted / $nbItems * 100, 0);


		//

		$remainingDuration = null;

		if (is_null($timeOfStart) === true)
		{
			$timeOfStart = microtime(true);
		}
		else if ($progress > 0)
		{
			//

			$timeSpent = microtime(true) - $timeOfStart;
			$timeRemaining = round(($timeSpent / ($progress / 100)) - $timeSpent);

			
			//

			$remainingDuration = $timeRemaining;
		}


		//

		$outputFragments =
		[
			"\033[1;32m",
			str_pad(null, round($progress / 10, 0), '='),
			"\033[1;31m",
			str_pad(null, 10 - (round($progress / 10, 0)), '='),
			"\033[0;0m ",
			$progress . '%',
			' --- ',
			$nbItemsCompleted . '/' . $nbItems
		];


		//

		if (is_array($remainingDuration) === true)
		{
			$outputFragments[] = ' --- ';
			$outputFragments[] = $remainingDuration['value'] . $remainingDuration['metric'];
		}

		
		//

		if (empty($message) === false)
		{
			$outputFragments[] = ' --- ';
			$outputFragments[] = $message;
		}


		// Ensure print message takes whole horizontal space

		$message = implode(null, $outputFragments);


		//

		\z\service('renderer/log')->renderLog
		(
			$message,
			'progress'
		);
	}
}

?>
