<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

abstract class AbstractRequest
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;


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

			if (array_key_exists(0, $methodArguments) === true)
			{
				if (array_key_exists($methodArguments[0], $attribute) === true)
				{
					return $attribute[$methodArguments[0]];
				}
			}
			else
			{
				return $attribute;
			}
		}
	}


	/**
	 *
	 */

	public function input()
	{
		// Get input

		$input = file_get_contents('php://input');


		return $input;
	}
}

?>
