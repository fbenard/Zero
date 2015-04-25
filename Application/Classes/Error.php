<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Error
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	private $_code;
	private $_context;
	private $_description;
	private $_file;
	private $_line;
	private $_title;
	private $_traces;


	/**
	 *
	 */

	public function __construct($errorCode, $errorDescription, $errorFile = null, $errorLine = null, $errorContext = null)
	{
		// Store attributes

		$this->_code = $errorCode;
		$this->_description = $errorDescription;
		$this->_file = $errorFile;
		$this->_line = $errorLine;
		$this->_context = $errorContext;
		$this->_traces = $errorTraces;


		// Makes context and traces are arrays

		if (is_array($this->_context) === false)
		{
			$this->_context = [];
		}

		if (is_array($this->_traces) === false)
		{
			$this->_traces = [];
		}
	}
}

?>
