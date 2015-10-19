<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ControllerManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes

	private $_action = null;
	private $_arguments = null;
	private $_controller = null;


	/**
	 *
	 */

	public function initialize()
	{
		// Get the current route

		$route = \z\service('manager/route')->route;


		// Do we have a route?

		if (is_null($route) === true)
		{
			return;
		}

		
		// Build the controller for this route

		$this->_controller = \z\service('factory/controller')->buildController($route['controller']);


		// Check whether the action is supported by the controller

		$this->_action = 'action' . ucfirst($route['action']);

		if (method_exists($this->_controller, $this->_action) === false)
		{
			\z\e
			(
				EXCEPTION_CONTROLLER_ACTION_NOT_FOUND,
				[
					'action' => $route['action']
				]
			);
		}


		// Define controller arguments
		
		$this->_arguments = [];

		foreach ($route['arguments'] as $argumentCode => $argument)
		{
			$this->_arguments[$argumentCode] = $argument['value'];
		}
	}


	/**
	 *
	 */

	public function run()
	{
		// Get the current route

		$route = \z\service('manager/route')->route;


		// Do we have a route?

		if (is_null($route) === true)
		{
			return;
		}

		
		// Execute pre actions

		$this->runActions($route['pre']);

		
		// Clear buffer

		\z\service('manager/buffer')->clearBuffer();


		// Run the controller

		call_user_func_array
		(
			[
				$this->_controller,
				$this->_action
			],
			$this->_arguments
		);


		// Execute post actions

		$this->runActions($route['post']);

		
		// Push the response
		
		$this->_controller->push();
	}


	/**
	 *
	 */

	private function runActions($actions)
	{
		// Execute each post action

		foreach ($actions as $action)
		{
			// Fix the definition

			$action = array_merge
			(
				[
					'method' => null,
					'service' => null
				],
				$action
			);

			
			// Call the post action

			call_user_func_array
			(
				[
					\z\service($action['service']),
					$action['method']
				],
				$this->_arguments
			);
		}
	}
}

?>
