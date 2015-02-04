<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Request
{
	// Attributes

	private $_get = null;
	private $_post = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_get = $_GET;
		$this->_post = $_POST;
	}


	/**
	 *
	 */

	public function __call($methodCode, $methodArguments)
	{
		//

		$attributeCode = '_' . $methodCode;

		
		//

		if
		(
			(isset($this->$attributeCode) === true) &&
			(is_array($this->$attributeCode) === true)
		)
		{
			//

			$attribute = $this->$attributeCode;

			
			//

			if
			(
				(array_key_exists(0, $methodArguments) === true) &&
				(array_key_exists($methodArguments[0], $attribute) === true)
			)
			{
				return $attribute[$methodArguments[0]];
			}
			else
			{
				return $attribute;
			}
		}
	}
}

?>
