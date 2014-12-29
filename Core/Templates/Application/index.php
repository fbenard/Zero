<?php

// Boot Zero

$pathToZero = dirname(getcwd()) . '/Components/fbenard/zero/Core/zero-boot.php';

if (file_exists($pathToZero) === false)
{
	die('*** ERROR: Cannot find Zero.');
}
else
{
	require_once($pathToZero);
}

?>
