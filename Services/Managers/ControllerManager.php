<?php

// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class ControllerManager
{
	// Attributes

	public $_action = null;
	public $_arguments = null;
	public $_controller = null;


	/**
	 *
	 */

	public function initialize()
	{
		//

		$definition = service('manager/route')->_route;

		$path = PATH_ROOT . $definition['controller'] . '.php';
		$className = str_replace
		(
			[
				'/Application/',
				'/'
			],
			[
				'\\Goloboard\\',
				'\\'
			],
			$definition['controller']
		);


		//

		if (file_exists($path) === false)
		{
			e(EXCEPTION_CONTROLLER_NOT_FOUND);
		}


		//

		require_once($path);


		//
		
		$reflection = new \ReflectionClass($className);

		if ($reflection->isInstantiable() === false)
		{
			e(EXCEPTION_CONTROLLER_NOT_FOUND);
		}


		//

		$this->_controller = new $className();


		//

		$this->_action = 'action_' . $definition['action'];

		if (method_exists($this->_controller, $this->_action) === false)
		{
			e(EXCEPTION_CONTROLLER_ACTION_NOT_FOUND);
		}


		// Define controller arguments
		
		$this->_arguments = [];

		foreach ($definition['arguments'] as $argumentCode => $argument)
		{
			$this->_arguments[$argumentCode] = $argument['value'];
		}
	}


	/**
	 *
	 */

	public function run()
	{
		// Clear buffer

		service('manager/buffer')->clearBuffer();


		// Run the controller

		$result = call_user_func_array
		(
			[
				$this->_controller,
				$this->_action
			],
			$this->_arguments
		);


		// Push the response
		
		//$this->_controller->response->push($output);
	}
}

?>
