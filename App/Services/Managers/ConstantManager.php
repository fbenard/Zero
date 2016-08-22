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
		// Get dependencies

		$dependencies = \z\boot()->dependencies;
		
		
		// Parse each dependency

		foreach ($dependencies as $dependency)
		{
			// List constants of dependency

			$files = \z\service('helper/file')->listFiles($dependency . '/Constants', 'php');
			
			
			// Parse each file

			foreach ($files as $file)
			{
				// Execute the file

				require_once($file);
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
