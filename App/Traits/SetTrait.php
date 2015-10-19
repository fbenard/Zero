<?php

// Namespace

namespace fbenard\Zero\Traits;


/**
 *
 */

trait SetTrait
{
	/**
	 *
	 */

	public function __set($attributeCode, $attributeValue)
	{
		// Build attribute code

		$attributeCode = '_' . $attributeCode;


		// Set the attribute

		if (property_exists($this, $attributeCode) === true)
		{
			$this->$attributeCode = $attributeValue;
		}
	}
}

?>
