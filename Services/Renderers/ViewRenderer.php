<?php

// Namespace

namespace Zero\Services\Renderers;


/**
 *
 */

class ViewRenderer
{
	// Attributes

	private $_view = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_view = new \Zero\Classes\View();
	}


	/**
	 *
	 */

	public function renderView($viewCode, $viewArguments = null)
	{
		// Render the view
		
		$result = $this->_view->render($viewCode, $viewArguments);


		return $result;
	}
}

?>
