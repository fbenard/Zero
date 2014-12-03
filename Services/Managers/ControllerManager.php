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

		
		//

		$this->_controller = service($definition['service']);


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
		//

		$definition = service('manager/route')->_route;


		//

		foreach ($definition['pre'] as $pre)
		{
			$preFragments = explode('::', $pre);

			$serviceCode = $preFragments[0];
			$methodName = $preFragments[1];

			$service = service($serviceCode);
			$service->$methodName();
		}

		
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


		//

		foreach ($definition['post'] as $post)
		{
			$postFragments = explode('::', $post);
			
			$serviceCode = $postFragments[0];
			$methodName = $postFragments[1];

			$service = service($serviceCode);
			$service->$methodName();
		}

		
		// Push the response
		
		//$this->_controller->response->push($output);
	}
}

?>
