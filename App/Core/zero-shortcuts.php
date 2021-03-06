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

function dispatch($event)
{
	return \z\service('manager/event')->dispatchEvent($event);
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

function logger($loggerCode = null, $handlers = null)
{
	return \z\service('manager/logger')->getLogger($loggerCode, $handlers);
}


/**
 *
 */

function pref($preferenceCode, $preferenceValue = null)
{
	if (func_num_args() === 1)
	{
		return \z\service('manager/preference')->getPreference($preferenceCode);
	}
	else
	{
		return \z\service('manager/preference')->setPreference($preferenceCode, $preferenceValue);
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

function render($viewCode, $viewContext = null, $viewRoot = null, $print = true)
{
	// Render the view

	$output = \z\service('renderer/view')->renderView($viewCode, $viewContext, $viewRoot);


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
