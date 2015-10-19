<?php

// Namespace

namespace fbenard\Zero\Services\Formatters;


/**
 *
 */

class CliLogFormatter
implements \Monolog\Formatter\FormatterInterface
{
	// Attributes

	private $_templates = null;


	/**
	 *
	 */

	public function __construct()
	{
		$this->_templates =
		[
			\Monolog\Logger::ERROR => "\033[1;31m*** %{message}\033[0;0m\n",
			\Monolog\Logger::INFO => "%{message}\n",
			\Monolog\Logger::NOTICE => "\033[1;36m=== %{message}\033[0;0m\n",
			\Monolog\Logger::WARNING => "\033[1;33m*** %{message}\033[0;0m\n"
		];
	}


    /**
     *
     */

    public function format(array $record)
    {
    	//

		$result = "${record['message']}\n";


		// Does the template exist?
		
		if (array_key_exists($record['level'], $this->_templates) === true)
		{
			// Get the template

			$template = $this->_templates[$record['level']];


			// Format the message

			$result = str_replace
			(
				'%{message}',
				$record['message'],
				$template
			);
		}


		return $result;
    }


    /**
     *
     */

    public function formatBatch(array $records)
    {
    	foreach ($records as $record)
    	{
    		$this->format($record);
    	}
    }
}

?>
