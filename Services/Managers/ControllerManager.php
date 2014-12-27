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

		$route = \z\service('manager/route')->_route;

		
		//

		$this->_controller = \z\service('factory/controller')->buildController($route['controller']);


		//

		$this->_action = 'action_' . $route['action'];

		if (method_exists($this->_controller, $this->_action) === false)
		{
			\z\e(EXCEPTION_CONTROLLER_ACTION_NOT_FOUND);
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
		//

		$route = \z\service('manager/route')->_route;


		//

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

		$result = call_user_func_array
		(
			[
				$this->_controller,
				$this->_action
			],
			$this->_arguments
		);


		//

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
		
		//$this->_controller->response->push($output);
	}
}

?>
