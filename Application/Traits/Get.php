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


		// Get the attribute

		return $this->$attributeCode;
	}
}

?>
