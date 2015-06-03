<?php

// Namespace

namespace fbenard\Zero\Services\Managers;


/**
 *
 */

class RouteManager
{
	// Traits

	use \fbenard\Zero\Traits\GetTrait;

	
	// Attributes

	private $_definitions = null;
	private $_route = null;
	private $_uri = null;
	private $_verb = null;


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
		// Do not initialize if app is embedded

		if (\z\app()->isEmbedded() === true)
		{
			return;
		}


		// Initialize

		$this->loadDefinitions();
		$this->setRoute();
	}


	/**
	 *
	 */

	private function loadDefinitions()
	{
		// Get the cache

		$cacheCode = 'routes_' . \z\boot()->environment . '_' . \z\boot()->universe;
		$cache = \z\cache()->getCache($cacheCode);

		if ($cache !== false)
		{
			$this->_definitions = unserialize($cache);
			return;
		}


		//

		$dependencies = \z\boot()->dependencies;
		
		
		//

		foreach ($dependencies as $dependency)
		{
			// Find definitions

			$paths = \z\service('helper/file')->listFiles($dependency . 'Config/Routes/', '*.json');


			// For each definitions
			
			foreach ($paths as $path)
			{
				// Load definitions

				$rawDefinitions = file_get_contents($path);
				$definitions = json_decode($rawDefinitions, true);


				// Make sure definitions is an array

				if (is_array($definitions) === false)
				{
					continue;
				}


				// For each definition

				foreach ($definitions as &$definition)
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

					foreach ($definition['verbs'] as &$verb)
					{
						// Make sure the verb is valid

						$verb = array_merge
						(
							[
								'action' => 'index',
								'controller' => null
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


		// Set the cache

		\z\cache()->setCache
		(
			$cacheCode,
			serialize($this->_definitions)
		);
	}


	/**
	 *
	 */

	public function setRoute($uri = null, $verb = null)
	{
		// Build the URI

		if (empty($uri) === true)
		{
			if (\z\app()->isCli() === true)
			{
				if (array_key_exists(1, $GLOBALS['argv']) === true)
				{
					$this->_uri = $GLOBALS['argv'][1];
				}
			}
			else
			{
				$this->_uri = explode('?', \z\request()->server('REQUEST_URI'), 2)[0];
			}			
		}

		
		// Build the verb

		if (empty($verb) === true)
		{
			if (\z\app()->isCli() === true)
			{
				$this->_verb = 'CLI';
			}
			else
			{
				$this->_verb = \z\request()->server('REQUEST_METHOD');
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


			// Remove the first match

			array_shift($matches);


			// Arguments are remaining matches

			$arguments = $matches;


			// Count arguments

			$nbArguments = count($arguments);
			$nbArgumentsDefined = count($definition['arguments']);


			// Store arguments into definition

			if
			(
				($nbArguments > 0) &&
				($nbArguments === $nbArgumentsDefined)
			)
			{
				$keys = array_keys($definition['arguments']);

				foreach ($arguments as $key => $value)
				{
					$definition['arguments'][$keys[$key]]['value'] = $value;
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
