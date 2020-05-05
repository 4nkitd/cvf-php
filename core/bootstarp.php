<?php

require_once APPPATH.'core'.DS.'cvf.php';
require_once APPPATH.'core'.DS.'err.php';
require_once APPPATH.'core'.DS.'helpers.php';
require_once APPPATH.'core'.DS.'controller.php';
require_once APPPATH.'core'.DS.'view.php';

$composer = APPPATH.'vendor'.DS.'autoload.php';

if (file_exists($composer)) {
	require_once $composer;
} 

class Bootstrap extends cvf
{
    protected  $router;

    function __construct()
    {
        $this->_init_handler();
    }

    function _init_handler()
    {
        require_once APPPATH.'core'.DS.'router.php';
        
        $this->router = new Router();
        
    }
}
