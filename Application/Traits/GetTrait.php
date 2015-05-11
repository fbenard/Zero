<?php

// Namespace

namespace fbenard\Zero\Traits;


/**
 *
 */

trait GetTrait
{
	/**
	 *
	 */

	public function __get($attributeCode)
	{
		// Build attribute code

		$attributeCode = '_' . $attributeCode;

		if (property_exists($this, $attributeCode) === true)
		{
			return $this->$attributeCode;		
		}
		else
		{
			return;
		}
	}
}

?>
