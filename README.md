Zero
====

Zero is a micro-framework written in PHP, for PHP applications.

![Build status](https://circleci.com/gh/fbenard/zero/tree/master.svg?style=shield&circle-token=78096b1f781cc4fccd2d99a7d17328b79dbf73ce)


## Install

```
composer global require fbenard/zero:*
php ~/.composer/vendor/fbenard/zero/Core/zero-cli.php install
```


## Create a new application

```
zero create my-app
```


## Structure

**composer.json**

```json
{
	"config":
	{
		"vendor-dir": "Components"
	},
	"require":
	{
		"fbenard/zero": "dev-master"
	}
}
```

**index.php**

```php
<?php

require_once(getcwd() . '/Components/fbenard/zero/Core/boot.php');

?>
```

**.htaccess**

```
Options			+ExecCGI +FollowSymLinks +Includes -Indexes -Multiviews
IndexIgnore		*/*
RewriteEngine	On
RewriteBase		/
RewriteRule		.* index.php
```

**Application/Preferences/Boot.json**

```json
{
	"environment": "local"
}
```


## Authors

Zero is carefully taken care of by [Fabien BÉNARD](http://fabienbenard.com).


## License

The code for Zero is distributed under the terms of the MIT license. See [LICENSE.txt](LICENSE.txt) for the full license.
