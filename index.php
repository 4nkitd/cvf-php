<?php

// 
// cfv framework
// 

// Valid PHP Version?
$minPHPVersion = '7.0';
if (phpversion() < $minPHPVersion)
{
	die("Your PHP version must be {$minPHPVersion} or higher. Current version: " . phpversion());
}

// debuging true, false
define('DEBUG', TRUE);

// CHanging current dir 
chdir(__DIR__);

define('DS', DIRECTORY_SEPARATOR);

define('APPPATH', __DIR__ . DS);

date_default_timezone_set('Asia/Calcutta');

define('ROUTES',APPPATH.'app'.DS.'routes.php');

require_once APPPATH.'core'.DS.'bootstarp.php';

$app = new Bootstrap;
