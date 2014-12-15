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

		$this->_controller = \z\service($route['service']);


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
			$preFragments = explode('::', $pre);

			$serviceCode = $preFragments[0];
			$methodName = $preFragments[1];

			$service = \z\service($serviceCode);
			$service->$methodName();
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
			$postFragments = explode('::', $post);
			
			$serviceCode = $postFragments[0];
			$methodName = $postFragments[1];

			$service = \z\service($serviceCode);
			$service->$methodName();
		}

		
		// Push the response
		
		//$this->_controller->response->push($output);
	}
}

?>
