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

	private function buildArguments($keys, $indexed, $associative)
	{
		//

		$result = [];

		
		//

		foreach ($keys as $i => $key)
		{
			//

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

	public function renderView($viewCode, $viewContext = null)
	{
		// Check whether the view exists

		$pathToView = PATH_APPLICATION . 'Views/' . $viewCode . '.handlebars';

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
					PATH_APPLICATION . 'Views/'
				],
				'fileext' =>
				[
					'.handlebars'
				],
				'flags' => \LightnCandy::FLAG_HANDLEBARS | \LightnCandy::FLAG_ERROR_EXCEPTION | \LightnCandy::FLAG_RENDER_DEBUG,
				'helpers' =>
				[
					'locale' => function()
					{
						return \z\service('manager/culture')->locale;
					},
					'pref' => function($args, $named)
					{
						return \z\pref($preferenceCode);
					},
					'request' => function()
					{
						return \z\request();
					},
					'service' => function($serviceCode)
					{
						return \z\service($serviceCode);
					},
					'str' => function($indexed, $associative)
					{
						$args = $this->buildArguments
						(
							[
								'stringCode'
							],
							$indexed,
							$associative
						);

						return \z\str($args['stringCode']);
					}
				]
			]
		);


		// Build path to code

		$pathToCode = '/tmp/' . sha1('fbenard/zero_' . $pathToView);


		// Get the view renderer

		file_put_contents($pathToCode, $code);
		$renderer = require($pathToCode);


		// Render the view
		
		$result = $renderer($viewContext);


		return $result;
	}
}

?>
