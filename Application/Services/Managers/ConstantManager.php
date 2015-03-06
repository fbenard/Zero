<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class ConstantManager
{
	/**
	 *
	 */
	
	public function initialize()
	{
		//

		$dependencies = \z\boot()->dependencies;
		
		
		//

		foreach ($dependencies as $dependency)
		{
			$paths = \z\service('helper/file')->listFiles($dependency . 'Constants/', '*.php');
			
			foreach ($paths as $path)
			{
				require_once($path);
			}
		}
	}
	
	
	/**
	 *
	 */
	
	public function setConstant($constantCode, $constantValue = null)
	{
		// Has the constant already been defined?
		
		if (defined($constantCode) === false)
		{
			// Gets the number of arguments to the function

			if (func_num_args() === 2)
			{
				// No, so let's define the constant
				
				if (is_null($constantValue) === true)
				{
					// No value given, use the constant name for the value
					
					define($constantCode, $constantCode);
				}
				else
				{
					define($constantCode, $constantValue);
				}	
			}			
		}
	}
}

?>
