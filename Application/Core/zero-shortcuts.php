<?php

// Namespace

namespace z;


/**
 *
 */

function app()
{
	return \Zero\Classes\Application::getInstance();
}


/**
 *
 */

function cons($constantName, $constantValue = null)
{
	return \z\service('manager/constant')->setConstant($constantName, $constantValue);
}


/**
 *
 */

function dispatch($eventCode, $event, $sender)
{
	return \z\service('manager/event')->dispatch($eventCode, $event, $sender);
}


/**
 *
 */

function dlog($message)
{
	return \z\service('manager/log')->log($message);
}


/**
 *
 */

function dloge($message)
{
	return \z\service('manager/log')->logError($message);
}


/**
 *
 */

function dlogi($message)
{
	return \z\service('manager/log')->logInformation($message);
}


/**
 *
 */

function dlogp($nbItemsRemaining, $nbItems, &$timeOfStart, $message = null)
{
	return \z\service('manager/log')->logProgress($nbItemsRemaining, $nbItems, $timeOfStart, $message);
}


/**
 *
 */

function dlogs($message)
{
	return \z\service('manager/log')->logSuccess($message);
}


/**
 *
 */

function e($exceptionCode, $exceptionContext = null)
{
	throw new \Zero\Classes\Exception($exceptionCode, $exceptionContext);
}


/**
 *
 */

function listen($eventCode, $listener)
{
	return \z\service('manager/event')->listen($eventCode, $listener);
}


/**
 *
 */

function pref($preferenceCode, $preferenceValue = null, $isLocked = false)
{
	if (func_num_args() === 1)
	{
		return \z\service('manager/preference')->getPreference($preferenceCode);
	}
	else
	{
		return \z\service('manager/preference')->setPreference($preferenceCode, $preferenceValue, $isLocked);
	}
}


/**
 *
 */

function redirect($url)
{
	header('Location: ' . $url);
	die();
}


/**
 *
 */

function render($viewCode, $viewArguments = null, $print = true)
{
	// Render the view

	$output = \z\service('renderer/view')->renderView($viewCode, $viewArguments);


	// Print it

	if ($print === true)
	{
		print $output;
	}


	return $output;
}


/**
 *
 */

function service($serviceCode = null)
{
	return \z\app()->_serviceManager->getService($serviceCode);
}

?>
