<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

class Exception
extends \Exception
{
	// Traits

	use \fbenard\Zero\Traits\Get;

	
	// Attributes

	private $_context = null;


	/**
	 *
	 */

	public function __construct($exceptionCode, $exceptionContext = null)
	{
		// Call parent constructor

		parent::__construct($exceptionCode);


		// Store the context

		if (is_array($exceptionContext) === false)
		{
			$exceptionContext = [];
		}

		$this->_context = $exceptionContext;
	}


	/**
	 *
	 */

	public function computeFile()
	{
		//

		$trace = $this->getTrace();
		$traceItem = array_shift($trace);


		//

		$result = $traceItem['file'];

		
		return $result;
	}


	/**
	 *
	 */

	public function computeLine()
	{
		//

		$trace = $this->getTrace();
		$traceItem = array_shift($trace);


		//

		$result = $traceItem['line'];


		return $result;
	}


	/**
	 *
	 */

	public function getContext()
	{
		return $this->_context;
	}
}

?>
