<?php

// Boot Zero

$pathToZero = getcwd() . '/Components/fbenard/zero/App/Core/zero-boot.php';

if (file_exists($pathToZero) === false)
{
	print("Cannot find Zero.\n");
	trigger_error(null, E_USER_ERROR);
}


// Load Zero

require_once($pathToZero);

?>
