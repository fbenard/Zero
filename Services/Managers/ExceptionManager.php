<?php

// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class ExceptionManager
{
	/**
	 *
	 */
	
	public static function onException($exception)
	{
		// Build an exception renderer

		$exceptionRenderer = new \Zero\Services\Renderers\ExceptionRenderer();

		
		// Render the exception

		$exceptionRenderer->renderException($exception);


		return true;
	}
}

?>
