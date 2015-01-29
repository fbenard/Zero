<?php

// Boot Zero

$pathToZero = getcwd() . '/Components/fbenard/zero/Application/Core/zero-boot.php';

if (file_exists($pathToZero) === false)
{
	die("*** ERROR: Cannot find Zero.\n");
}

require_once($pathToZero);

?>
