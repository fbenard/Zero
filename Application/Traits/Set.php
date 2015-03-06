<?php

// Namespace

namespace fbenard\Zero\Traits;


/**
 *
 */

trait Set
{
	/**
	 *
	 */

	public function __set($attributeCode, $attributeValue)
	{
		// Build attribute code

		$attributeCode = '_' . $attributeCode;


		// Set the attribute

		$this->$attributeCode = $attributeValue;
	}
}

?>
