<?php

// Namespace

namespace fbenard\Zero\Services\Renderers;


/**
 *
 */

class ViewRenderer
{
	/**
	 *
	 */

	public function renderView($viewCode, $viewArguments = null)
	{
		
		// Build a view
		
		$this->_view = new \Zero\Classes\View();


		// Render the view

		$result = $this->_view->render($viewCode, $viewArguments);


		return $result;
	}
}

?>
