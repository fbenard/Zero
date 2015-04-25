<?php

// Namespace

namespace fbenard\Zero\Services\Renderers;


/**
 *
 */

class ViewRenderer
{
	// Attributes

	private $_mustache = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_mustache = new Mustache_Engine();
	}


	/**
	 *
	 */

	public function renderView($viewCode, $viewArguments = null)
	{
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


		// Load the view

		$view = file_get_contents($pathToView);


		// Render the view

		$result = $this->_mustache->render($view, $viewArguments);


		return $result;
	}
}

?>
