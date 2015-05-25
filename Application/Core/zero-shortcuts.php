<?php

// Namespace

namespace z;


/**
 *
 */

function app()
{
	return \fbenard\Zero\Classes\Application::getInstance();
}


/**
 *
 */

function boot()
{
	return \z\app()->bootManager;
}


/**
 *
 */

function cache()
{
	return \z\app()->cacheManager;
}


/**
 *
 */

function conf($config, $defaultConfig = null)
{
	return \z\service('factory/config')->fixConfig($config, $defaultConfig);
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

function dispatch($eventCode, $event)
{
	return \z\service('manager/event')->dispatchEvent($eventCode, $event);
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
	throw new \fbenard\Zero\Classes\Exception($exceptionCode, $exceptionContext);
}


/**
 *
 */

function follow($eventCode, $followerCode, $methodCode)
{
	return \z\service('manager/event')->addFollower($eventCode, $followerCode, $methodCode);
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
	$response = new \fbenard\Zero\Classes\Response();
	$response->redirect($url);
}


/**
 *
 */

function render($viewCode, $viewContext = null, $print = true)
{
	// Render the view

	$output = \z\service('renderer/view')->renderView($viewCode, $viewContext);


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

function request()
{
	return \z\service('manager/request')->request;
}


/**
 *
 */

function service($serviceCode = null, $clone = false)
{
	if (empty($serviceCode) === true)
	{
		return \z\app()->serviceManager;
	}
	else
	{
		return \z\app()->serviceManager->getService($serviceCode, $clone);
	}
}


/**
 *
 */

function str($stringCode, $stringArguments = null)
{
	return \z\service('manager/culture')->getString($stringCode, $stringArguments);
}


/**
 *
 */

function unfollow($eventCode, $followerCode)
{
	return \z\service('manager/event')->removeFollower($eventCode, $followerCode);
}

?>
