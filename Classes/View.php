<?php

// Namespace

namespace Zero\Classes;


/**
 *
 */

class View
{
	//

	public $_variables = null;


	/**
	 *
	 */

	public function get($variableCode)
	{
		if
		(
			(is_array($this->_variables) === true) &&
			(array_key_exists($variableCode, $this->_variables) === true)
		)
		{
			return $this->_variables[$variableCode];
		}
	}


	/**
	 *
	 */

	public function render($viewCode, $viewArguments = null)
	{
		//

		$this->_variables = $viewArguments;


		//

		$pathToView = PATH_APPLICATION . 'Views/' . $viewCode;


		// Start buffering output
		
		if (\z\app()->isRunningCli() === false)
		{
			ob_start();
		}
		
		
		//

		require_once($pathToView);


		// Get output
		
		$output = null;

		if (\z\app()->isRunningCli() === false)
		{
			$output = ob_get_contents();
		}


		// Clean the buffer
		
		if (\z\app()->isRunningCli() === false)
		{
			ob_end_clean();
		}


		return $output;
	}
}

?>
