<?php

// Namespace

namespace fbenard\Zero\Interfaces;


/**
 *
 */

interface EventFollowerInterface
{
	/**
	 *
	 */

	public function onEvent($eventCode, $eventContext, $sender);
}

?>
