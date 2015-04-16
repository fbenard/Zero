<?php

// Namespace

namespace fbenard\Zero\Services\Drivers;


/**
 *
 */

class RedisDriver
{
	// Attributes

	private $_client = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_client = new \Predis\Client();
	}


	/**
	 *
	 */

	public function __call($methodCode, $methodArguments)
	{
		//

		$result = call_user_func_array
		(
			[
				$this->_client,
				$methodCode
			],
			$methodArguments
		);


		return $result;
	}
}

?>
