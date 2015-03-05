<?php

// Boot Zero

$pathToZero = getcwd() . '/Components/fbenard/zero/Application/Core/zero-boot.php';

if (file_exists($pathToZero) === false)
{
	print("Cannot find Zero.\n");
	trigger_error(null, E_USER_ERROR);
}

require_once($pathToZero);

?>
