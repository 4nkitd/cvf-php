<?php

if (! defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

if (! defined('APPPATH'))
{
	define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR);
}


require_once APPPATH.'core'.DS.'err.php';
require_once APPPATH.'core'.DS.'cvf.php';
require_once APPPATH.'core'.DS.'bootstarp.php';
require_once APPPATH.'core'.DS.'helpers.php';
require_once APPPATH.'core'.DS.'controller.php';
require_once APPPATH.'core'.DS.'view.php';

$composer = APPPATH.'vendor'.DS.'autoload.php';

if (file_exists($composer)) {
	require_once $composer;
} 

$app = new Bootstrap;
