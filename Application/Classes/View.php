<?php

// Namespace

namespace fbenard\Zero\Classes;


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
		// Store variables

		$this->_variables = $viewArguments;


		// Build the path to the view

		$pathToView = PATH_APPLICATION . 'Views/' . $viewCode;

		
		// Make sure the view exists

		if (file_exists($pathToView) === false)
		{
			\z\e
			(
				EXCEPTION_VIEW_NOT_FOUND,
				[
					'viewCode' => $viewCode,
					'viewArguments' => $viewArguments
				]
			);
		}


		// Start buffering output
		
		if (\z\app()->isRunningCli() === false)
		{
			ob_start();
		}
		
		
		// Render the view

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
