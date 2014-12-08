<?php
	
// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class UniverseManager
{
	// Attributes
	
	public $_universe = null;


	/**
	 *
	 */

	public function initialize()
	{
		//

		$universe = 'splio';
		
		if (\z\app()->isRunningCli() === true)
		{
			global $argv;

			if (array_key_exists('universe', $argv) === true)
			{
				$universe = $argv('universe');
			}
		}


		//

		if (empty($universe) === false)
		{
			$this->_universe = $universe;
		}
	}
}


?>