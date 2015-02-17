<?php

// Namespace

namespace fbenard\Zero\Classes;


/**
 *
 */

abstract class AbstractMigration
{
	abstract public function downgrade();
	abstract public function upgrade();
}

?>
