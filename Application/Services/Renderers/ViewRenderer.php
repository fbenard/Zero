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
		$this->_mustache = new \Mustache_Engine
		(
			[
				'loader' => new \Mustache_Loader_FilesystemLoader(PATH_APPLICATION . 'Views/'),
				'partials_loader' => new \Mustache_Loader_FilesystemLoader(PATH_APPLICATION . 'Views/')
   			]
		);
	}


	/**
	 *
	 */

	public function renderView($viewCode, $viewArguments = null)
	{
		// Render the view

		$result = $this->_mustache->render($viewCode, $viewArguments);


		return $result;
	}
}

?>
