<?php

// Namespace

namespace fbenard\Zero\Services\Renderers;


/**
 *
 */

class ViewRenderer
{
	/**
	 *
	 */

	private function buildArguments($arguments, $indexed, $associative)
	{
		// Build result

		$result = [];

		
		// Parse each argument

		foreach ($arguments as $i => $key)
		{
			// Check whether the key is associative, indexed or none
			// And store its value

			if (array_key_exists($key, $associative) === true)
			{
				$result[$key] = $associative[$key];
			}
			else if (array_key_exists($i, $indexed))
			{
				$result[$key] = $indexed[$i];
			}
			else
			{
				$result[$key] = null;
			}
		}


		return $result;
	}


	/**
	 *
	 */

	public function renderView($viewCode, $viewContext = null, $viewRoot = null)
	{
		// Fix the view root

		if (empty($viewRoot) === true)
		{
			$viewRoot = PATH_APP . '/Views';
		}

		
		// Check whether the view exists

		$pathToView = $viewRoot . '/' . $viewCode;

		if (file_exists($pathToView) === false)
		{
			\z\e
			(
				EXCEPTION_VIEW_NOT_FOUND,
				[
					'pathToView' => $pathToView,
					'viewCode' => $viewCode,
					'viewContext' => $viewContext
				]
			);
		}


		// Load the view

		$view = file_get_contents($pathToView);


		// Compile the view

		$code = \LightnCandy::compile
		(
			$view,
			[
				'basedir' =>
				[
					PATH_APP . '/Views'
				],
				'fileext' =>
				[
					''
				],
				'flags' =>
				\LightnCandy::FLAG_ERROR_EXCEPTION |
				\LightnCandy::FLAG_HANDLEBARS |
				\LightnCandy::FLAG_RENDER_DEBUG |
				\LightnCandy::FLAG_RUNTIMEPARTIAL |
				\LightnCandy::FLAG_THIS,
				'helpers' =>
				[
					'locale' => function()
					{
						return \z\service('manager/culture')->localeCode;
					},
					'str' => function($indexed, $associative)
					{
						// Build arguments

						$arguments = $this->buildArguments
						(
							[
								'stringCode'
							],
							$indexed,
							$associative
						);


						// Get the string

						$result = \z\str($arguments['stringCode']);


						return $result;
					}
				]
			]
		);


		// Build path to code

		$pathToCode = '/tmp/' . sha1('fbenard/zero_' . $pathToView) . '.php';


		// Get the view renderer

		file_put_contents($pathToCode, $code);
		$renderer = require($pathToCode);


		// Render the view
		
		$result = $renderer($viewContext);


		return $result;
	}
}

?>
