<?php

// Namespace

namespace fbenard\Zero\Traits;


/**
 *
 */

trait Get
{
	/**
	 *
	 */

	public function __get($attributeCode)
	{
		//

		$attributeCode = '_' . $attributeCode;

		
		//

		if (isset($this->$attributeCode) === true)
		{
			return $this->$attributeCode;
		}
	}
}

?>
