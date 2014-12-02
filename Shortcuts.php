<?php

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
	return service('manager/constant')->setConstant($constantName, $constantValue);
}


/**
 *
 */

function dlog($message)
{
	service('manager/log')->log($message);
}


/**
 *
 */

function dloge($message)
{
	service('manager/log')->logError($message);
}


/**
 *
 */

function dlogi($message)
{
	service('manager/log')->logInformation($message);
}


/**
 *
 */

function dlogp($nbItemsRemaining, $nbItems, &$timeOfStart, $message = null)
{
	service('manager/log')->logProgress($nbItemsRemaining, $nbItems, $timeOfStart, $message);
}


/**
 *
 */

function dlogs($message)
{
	service('manager/log')->logSuccess($message);
}


/**
 *
 */

function e($exceptionCode)
{
	throw new \Exception($exceptionCode);
}


/**
 *
 */

function pref($preferenceCode, $preferenceValue = null, $isLocked = false)
{
	if (func_num_args() === 1)
	{
		return service('manager/preference')->getPreferenceValue($preferenceCode);
	}
	else
	{
		service('manager/preference')->setPreferenceValue($preferenceCode, $preferenceValue, $isLocked);
	}
}


/**
 *
 */

function render($viewCode, $viewArguments = null)
{
	require_once(PATH_ZERO . 'Classes/View.php');
	$view = new \Zero\Classes\View();
	print $view->render($viewCode, $viewArguments);
}


/**
 *
 */

function service($serviceCode)
{
	return app()->_serviceManager->getService($serviceCode);
}

?>
