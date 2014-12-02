<?php

// Namespace

namespace Zero\Services\Managers;


// Dependencies

require_once(PATH_ZERO . 'Services/Renderers/ExceptionRenderer.php');


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
		//

		$exceptionRenderer = new \Zero\Services\Renderers\ExceptionRenderer();

		
		// Render the exception

		$exceptionRenderer->renderException($exception);


		return true;
	}
}

?>
