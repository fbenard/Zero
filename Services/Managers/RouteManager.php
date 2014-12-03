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
		//

		$rawDefinitions = file_get_contents(PATH_APPLICATION . 'Preferences/Routes.json');
		$this->_definitions = json_decode($rawDefinitions, true);


		//

		foreach ($this->_definitions as $uri => &$definition)
		{
			//

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

				unset($this->_definitions[$uri]);


				//

				$this->_definitions[$newUri] = $definition;
			}
		}


		//

		if (app()->isRunningCli() === true)
		{
			global $argv;
			$this->_uri = '/cli/' . $argv[1];
		}
		else
		{
			$this->_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
		}


		//

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
			e(EXCEPTION_ROUTE_NOT_FOUND);
		}
	}
}

?>
