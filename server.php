<?php

require_once('config.php');

// Valid PHP Version?
if ((int)phpversion() < (int)MIN_PHP_VERSION)
{
    $msg = "Your PHP version must be "
    . MIN_PHP_VERSION ." or higher."
    ." Current version: " . phpversion();
	
    die($msg);
}


require_once(SRC_PATH. 'bootstarp.php');

$app = new Bootstrap;
