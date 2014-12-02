<?php

// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class LogManager
{
	/**
	 *
	 */

	public function log($message)
	{
		service('renderer/log')->renderLog
		(
			$message
		);
	}


	/**
	 *
	 */

	public function logError($message)
	{
		service('renderer/log')->renderLog
		(
			$message,
			'error'
		);
	}


	/**
	 *
	 */

	public function logInformation($message)
	{
		service('renderer/log')->renderLog
		(
			$message,
			'information'
		);
	}


	/**
	 *
	 */

	public function logProgress($nbItemsCompleted, $nbItems, &$timeOfStart, $message = null)
	{
		//

		if ($nbItems === 0)
		{
			$nbItems = 1;
		}

		$progress = $nbItemsCompleted / $nbItems;


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

		$outputFragments = array
		(
			"\033[1;32m",
			str_pad(null, round($progress / 10, 0), '='),
			"\033[1;31m",
			str_pad(null, 10 - (round($progress / 10, 0)), '='),
			"\033[0;0m ",
			round($progress * 100, 2) . '%',
			' --- ',
			$nbItemsCompleted . '/' . $nbItems
		);


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

		service('renderer/log')->renderLog
		(
			$message,
			'progress'
		);
	}


	/**
	 *
	 */

	public function logSuccess($message)
	{
		service('renderer/log')->renderLog
		(
			$message,
			'success'
		);
	}
}

?>