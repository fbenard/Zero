<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ControllerManager
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
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

		$route = \z\service('manager/route')->_route;

		
		// Build the controller for this route

		$this->_controller = \z\service('factory/controller')->buildController($route['controller']);


		// Check whether the action is supported by the controller

		$this->_action = 'action_' . $route['action'];

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

		$route = \z\service('manager/route')->_route;


		// Execute each pre action

		foreach ($route['pre'] as $pre)
		{
			$pre = array_merge
			(
				[
					'method' => null,
					'service' => null
				],
				$pre
			);

			\z\service($pre['service'])->$pre['method']();
		}

		
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


		// Execute each post action

		foreach ($route['post'] as $post)
		{
			$post = array_merge
			(
				[
					'method' => null,
					'service' => null
				],
				$post
			);

			\z\service($post['service'])->$post['method']();
		}

		
		// Push the response
		
		$this->_controller->pushResponse();
	}
}

?>
