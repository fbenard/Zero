<?php
	
// Namespace

namespace fbenard\Zero\Services\Loaders;


/**
 *
 */

class BootLoader
extends \fbenard\Zero\Classes\AbstractService
implements \fbenard\Zero\Interfaces\Loaders\BootLoader
{
	/**
	 *
	 */
	
	public function __construct()
	{
		// Define dependencies

		$this->defineDependency('factory/boot', 'fbenard\Zero\Interfaces\Factories\BootFactory');


		// Inject dependencies

		$this->injectDependency
		(
			'factory/boot',
			new \fbenard\Zero\Services\Factories\BootFactory()
		);
	}


	/**
	 *
	 */

	public function loadBoot()
	{
		// Load Boot.json

		$result = null;
		$pathToBoot = PATH_APP . '/Config/Boot.json';

		if (file_exists($pathToBoot) === true)
		{
			// Decode Boot.json

			$rawResult = file_get_contents($pathToBoot);
			$result = json_decode($rawBoot, true);
		}


		// Fix boot

		$result = $this->getDependency('factory/boot')->fixBoot($result);


		return $result;
	}
}

?>
