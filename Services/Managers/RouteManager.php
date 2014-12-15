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
	public $_verb = null;


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
		$this->loadDefinitions();
		$this->setRoute();
	}


	/**
	 *
	 */

	private function loadDefinitions()
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
			// Find definitions

			$pathToDefinitions = \z\service('helper/file')->listFiles($path . 'Preferences/Routes/', '*.json');


			// For each definitions
			
			foreach ($pathToDefinitions as $pathToDefinition)
			{
				// Load definitions

				$rawDefinitions = file_get_contents($pathToDefinition);
				$definitions = json_decode($rawDefinitions, true);


				// For each definition

				foreach ($definitions as $uri => &$definition)
				{
					// Make sure the definition is valid

					$definition = array_merge
					(
						[
							'arguments' => [],
							'verbs' => [],
							'post' => [],
							'pre' => []
						],
						$definition
					);


					// For each verb

					foreach ($definition['verbs'] as $verbCode => &$verb)
					{
						// Make sure the verb is valid

						$verb = array_merge
						(
							[
								'action' => 'index',
								'service' => null
							],
							$verb
						);
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
	}


	/**
	 *
	 */

	public function setRoute($uri = null, $verb = null)
	{
		// Build the URI

		if (empty($uri) === true)
		{
			if (\z\app()->isRunningCli() === true)
			{
				global $argv;

				if (array_key_exists(1, $argv) === true)
				{
					$this->_uri = $argv[1];
				}
			}
			else
			{
				$this->_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
			}			
		}

		
		// Build the verb

		if (empty($verb) === true)
		{
			if (\z\app()->isRunningCli() === true)
			{
				$this->_verb = 'CLI';
			}
			else
			{
				$this->_verb = $_SERVER['REQUEST_METHOD'];
			}
		}


		// Try to find the URI/verb in definitions

		foreach ($this->_definitions as $uri => $definition)
		{
			// Is the verb supported?

			if (array_key_exists($this->_verb, $definition['verbs']) === false)
			{
				continue;
			}

			
			// Get the verb

			$verb = $definition['verbs'][$this->_verb];


			// Replace URI arguments by their pattern

			$uriFragments = explode('/', $uri);

			foreach ($uriFragments as $key => &$uriFragment)
			{
				if (preg_match('/\{([a-zA-Z0-9]+)\}/', $uriFragment, $matches) === 1)
				{
					$uriFragment = '(' . $definition['arguments'][$matches[1]]['pattern'] . ')';
				}
			}


			// Does the URI match?

			$pattern = '/^' . str_replace('/', '\/', implode('/', $uriFragments)) . '\/?$/';

			if (preg_match($pattern, $this->_uri, $matches) !== 1)
			{
				continue;
			}


			// Count matches vs arguments

			array_shift($matches);

			$nbMatches = count($matches);
			$nbArguments = count($definition['arguments']);


			// Extract arguments

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


			// This is the route!

			$this->_route = array_merge
			(
				$verb,
				[
					'arguments' => $definition['arguments'],
					'post' => $definition['post'],
					'pre' => $definition['pre']
				]
			);

			break;
		}


		// Do we have a route?

		if (is_null($this->_route) === true)
		{
			\z\e
			(
				EXCEPTION_ROUTE_NOT_FOUND,
				[
					'uri' => $this->_uri,
					'verb' => $this->_verb,
					'definitions' => array_keys($this->_definitions)
				]
			);
		}
	}
}

?>
