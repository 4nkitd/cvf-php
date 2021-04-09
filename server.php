<?php

define('APP_DIR',__DIR__.DIRECTORY_SEPARATOR);

require_once(__DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');


use App\Lib\App;
use App\Lib\Router;
use App\Lib\Request;
use App\Lib\Response;


App::run();