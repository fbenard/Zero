<?php

// Namespace

namespace Zero\Services\Managers;


/**
 *
 */

class RouteManager
{
	// Attributes

	private $_definitions = null;
	public $_route = null;
	public $_uri = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_definitions = [];
	}


	/**
	 *
	 */

	public function initialize()
	{
		// Define paths

		$paths =
		[
			PATH_ZERO,
			PATH_APPLICATION
		];
		
		
		// For each path
		
		foreach ($paths as $path)
		{
			// Find routes

			$pathToRoutes = \z\service('helper/file')->listFiles($path . 'Preferences/Routes/', '*.json');


			// For each route
			
			foreach ($pathToRoutes as $pathToRoute)
			{
				// Load definitions

				$rawDefinitions = file_get_contents($pathToRoute);
				$definitions = json_decode($rawDefinitions, true);


				// For each route

				foreach ($definitions as $uri => &$definition)
				{
					// Make sure the route definition is valid

					$definition = array_merge
					(
						[
							'action' => 'index',
							'arguments' => [],
							'post' => [],
							'pre' => [],
							'service' => null
						],
						$definition
					);


					//

					$uriFragments = explode('/', $uri);

					foreach ($uriFragments as $key => &$uriFragment)
					{
						//

						if (empty($uriFragment) === true)
						{
							unset($uriFragments[$key]);
							continue;
						}


						//

						if (preg_match('/\{([a-zA-Z0-9]+)\}/', $uriFragment, $matches) === 1)
						{
							$uriFragment = '(' . $definition['arguments'][$matches[1]]['pattern'] . ')';
						}
					}


					//

					$newUri = '/' . implode('/', $uriFragments);
					
					if ($newUri != $uri)
					{
						//

						unset($definitions[$uri]);


						//

						$definitions[$newUri] = $definition;
					}
				}


				// Store definitions

				$this->_definitions = array_merge
				(
					$this->_definitions,
					$definitions
				);
			}
		}


		// Build the URI

		if (\z\app()->isRunningCli() === true)
		{
			global $argv;

			$this->_uri = '/cli/';

			if (array_key_exists(1, $argv) === true)
			{
				$this->_uri .= $argv[1];
			}
		}
		else
		{
			$this->_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
		}


		// Remove empty URI fragments

		$uriFragments = explode('/', $this->_uri);

		foreach ($uriFragments as $key => &$uriFragment)
		{
			//

			if (empty($uriFragment) === true)
			{
				unset($uriFragments[$key]);
				continue;
			}
		}


		//

		foreach ($this->_definitions as $uri => &$definition)
		{
			//

			$pattern = '/^' . str_replace('/', '\/', $uri) . '\/?$/';


			//

			if (preg_match($pattern, '/' . implode('/', $uriFragments), $matches) !== 1)
			{
				continue;
			}


			//

			array_shift($matches);


			//

			$nbMatches = count($matches);
			$nbArguments = count($definition['arguments']);


			//

			if
			(
				($nbMatches > 0) &&
				($nbMatches === $nbArguments)
			)
			{
				//

				$arguments = array_keys($definition['arguments']);

				foreach ($matches as $key => $value)
				{
					$definition['arguments'][$arguments[$key]]['value'] = $value;
				}
			}


			//

			$this->_route = $definition;
			break;
		}


		//

		if (is_null($this->_route) === true)
		{
			\z\e
			(
				EXCEPTION_ROUTE_NOT_FOUND,
				[
					'uri' => $this->_uri,
					'route' => $this->_route,
					'definitions' => array_keys($this->_definitions)
				]
			);
		}
	}
}

?>
