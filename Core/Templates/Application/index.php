<?php

// Boot Zero

$pathToZero = dirname(getcwd()) . '/Components/fbenard/zero/Core/zero-boot.php';

if (file_exists($pathToZero) === false)
{
	if (php_sapi_name() === 'cli')
	{
		print("\033[1;31m*** Cannot find Zero\033[0;0m\n");
		exit(1);
	}
	else
	{
		die("*** ERROR: Cannot find Zero.\n");
	}
}
else
{
	require_once($pathToZero);
}

?>
