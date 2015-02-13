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
		// Build attribute code

		$attributeCode = '_' . $attributeCode;


		// If attribute exists, return it

		if (isset($this->$attributeCode) === true)
		{
			return $this->$attributeCode;
		}
	}
}

?>
