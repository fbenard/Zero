<?php

// Namespace

namespace Zero\Classes;


// Dependencies

require_once(PATH_ZERO . 'Traits/GetSet.php');


/**
 *
 */

class Request
{
	// Traits

	use \Zero\Traits\GetSet;


	// Attributes

	private $_GET = null;
	private $_POST = null;
	private $_SERVER = null;
}

?>
