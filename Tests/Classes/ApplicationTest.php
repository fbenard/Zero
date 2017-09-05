<?php

// Namespace

namespace fbenard\Zero\Tests\Classes;


/**
 *
 */

class ApplicationTest
extends \PHPUnit\Framework\TestCase
{
	/**
	 *
	 */

	public function testRun()
	{
		try
		{
			require_once(getcwd() . '/App/Core/zero-boot.php');
		}
		catch (\Exception $e)
		{
			print_r($e->getContext());
			throw $e;
		}
	}
}

?>
