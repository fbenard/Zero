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

	public function renderView($viewCode, $viewContext = null)
	{
		$code = \LightnCandy::compile
		(
			$viewCode,
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
					'pref' => function($preferenceCode)
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
					'str' => function($stringCode)
					{
						return \z\str($stringCode);
					}
				]
			]
		);


		//

		$renderer = \LightnCandy::prepare($code);


		// Render the view
		
		$result = $renderer($viewContext);


		return $result;
	}
}

?>
